<?php
/**
 * Class create image with the input text
 *
 * @package Fact
 * @license    http://opensource.org/licenses/gpl-license.php  GNU Public
 * @author fghorbannezhad@gmail.com
 */

namespace Ghorbannezhad\Fact;

use App\Http\Controllers\Controller;
use Ghorbannezhad\Fact\FileNotFoundException;
use Ghorbannezhad\Fact\Vendor\fagd;

class FactController extends Controller
{
    protected $logo;
    protected $font;
    protected $config;
    protected $image_format = ['jpg','jpeg','png'];
    protected $image;
    protected $text;
    protected $lang;
    protected $save_path;

    //Style
    protected $margin_top;
    protected $margin_bottom;
    protected $margin_right;
    protected $margin_left;
    protected $font_size;
    protected $line_height;
    protected $logo_from_bottom;
    protected $image_width;
    protected $image_height;

    const LANGUAGE = ['en','fa'];


    public function __construct()
    {
        $this->config = json_decode(json_encode(config('fact')), FALSE);
        $this->setFont();
        $this->setLang();
        $this->setLogo();
        $this->setSavePath();

    }

    /**
     * Create image
     *
     * @param string $image
     * @param array|string $text
     * @return mixed
     */

    public function create($image,$text){

        $this->text = $text;

        ini_set("error_reporting","E_ALL & ~E_NOTICE & ~E_STRICT");

        $this->image_width =imagesx(imagecreatefromstring(file_get_contents($image)));
        $this->image_height =imagesy(imagecreatefromstring(file_get_contents($image)));

        $this->margin_top = $this->image_height * $this->config->style->margin_top/100;
        $this->margin_right = $this->image_width * $this->config->style->margin_right/100;
        $this->margin_left = $this->image_width * $this->config->style->margin_left/100;
        $this->font_size = $this->config->style->font_size;
        $this->line_height = $this->config->style->line_height;
        $this->logo_from_bottom = $this->image_height*$this->config->style->logo_from_bottom/100;

        $this->image = $this->overlayImages($image);

        $font = $this->config->style->font;
        $image = $this->image;
        $string = $this->text;
        $color = imagecolorallocate($image, 0, 0, 0);

        $allowed_width = $this->image_width - ($this->margin_left + $this->margin_right);
        $allowed_height = $this->image_height - ($this->logo_from_bottom + $this->margin_top);

        $text_bound = imagettfbbox($this->font_size,0,$this->font,$this->text);

        $text_width = $text_bound[2] - $text_bound[0];

        if($this->config->lang == 'fa') {
            $fag = new fagd();
        }
        $parts = $this->text;

        $top = $this->image_height/2-$this->line_height/2;

        if($text_width > $allowed_width){

            if(count($parts) == 1){
                $parts = explode("\n", wordwrap($string, 60, "\n"));
            }

            $overall_height = count($parts)*$this->line_height;
            $top = ($this->image_height/2)-($overall_height/2);

            if($this->line_height*count($parts) > $allowed_height){
                $response='Text should between 70-120 characters';
                return $response;
            }else{
                $i=1;
                foreach($parts as $part){
                    if($this->config->lang) {
                        $part = $fag->fagd($part,'fa','normal');
                    }

                    $text_bound= imagettfbbox($this->font_size,0,$font,$part);
                    $text_width = $text_bound[2] - $text_bound[0];

                    if($i==1){
                        $height=$top;
                    }else{
                        $height=$top+ ($i-1)*($this->line_height);
                    }

                    $x_pos = $this->cal_xposition($allowed_width,$text_width);
                    imagettftext($image, $this->font_size, 0, $x_pos, $height, $color, $font, $part);
                    $i++;
                }
            }
        }else{
            $part = $string;
            if($this->config->lang == 'fa') {
                $part = $fag->fagd($string,'fa','normal');
            }
            $text_bound= imagettfbbox($this->font_size,0,$font,$part);
            $text_width = $text_bound[2] - $text_bound[0];

            $x_pos= $this->cal_xposition($text_width);

            imagettftext($image, $this->font_size, 0, $x_pos, $top, $color, $font, $part);
        }

        if($this->save_path){
            $this->saveImage($image);
        }
        imagedestroy($image);
    }

    /**
     * Calculate x position for text
     *
     * @param $text_width
     * @return float|int
     */

    private function cal_xposition($text_width){

        if($this->config->style->text_align == 'center') {
            $margin = $this->image_width/2;
            $x_pos = $margin - ($text_width/2);

        }elseif($this->config->style->text_align == 'right'){
            $x_pos = $this->image_width -$this->margin_right - $text_width;
        }elseif ($this->config->style->text_align == 'left'){
            $x_pos = $this->margin_left;
        }
        return $x_pos;
    }

    /**
     * Create new image with logo and first image
     *
     * @param string $image
     * @return mixed resource
     */
    private function overlayImages($image){
        $fact_image = imagecreatefromstring(file_get_contents($image));

        if(is_file($this->logo)){
            $logo = imagecreatefrompng($this->logo);
            imagealphablending($fact_image, true);
            imagesavealpha($fact_image, true);

            $logo_width = imagesx($logo);
            $logo_height = imagesy($logo);

            if($this->config->lang == 'fa'){
                $destin_x = $this->image_width - $this->margin_right;
            }else{
                $destin_x = $this->margin_left;
            }
            $logo_from_top = $this->image_height - $this->logo_from_bottom;

            imagecopy($fact_image, $logo, $destin_x, $logo_from_top, 0, 0, $logo_width, $logo_height);
        }

        return $fact_image;
    }

    /**
     * Save image in directory
     *
     * @param $image
     */

    private function saveImage($image){
        $name = time().'-'.rand(1000,9999);
        imagepng($image,$this->save_path.$name.'.png');
    }

    /**
     * Set font
     *
     * @param null $font
     * @throws ValidationException
     */
    public function setFont($font=null){
        if(is_file($font)){
            $this->font = $font;
        }elseif(is_file($this->config->style->font)){
            $this->font = $this->config->style->font;
        }else{
            throw new ValidationException('Font is not accessible');
        }
    }

    /**
     * Set logo
     *
     * @param null $logo
     */
    public function setLogo($logo=null){
        if(file_exists($logo)){
            $this->logo = $logo;
        }elseif(file_exists($this->config->logo)){
            $this->logo= $this->config->logo;
        }
    }

    /**
     * Set language
     *
     * @param null $lang
     * @throws ValidationException
     */
    public function setLang($lang=null){
        if(isset($lang)&& in_array($lang,self::LANGUAGE)){
            $this->lang = $lang;
        }elseif(in_array($this->config->lang,self::LANGUAGE)){
            $this->lang = $this->config->lang;
        }else{
            throw new ValidationException('Language is not valid');
        }
    }

    /**
     * Set save path
     *
     * @param null $path
     * @throws \Ghorbannezhad\Fact\FileNotFoundException
     *
     */
    public function setSavePath($path=null){
        if(is_dir($path)){
            $this->save_path = $path;
        }elseif(is_dir($this->config->save_path)){
            $this->save_path = $this->config->save_path;
        }else{
            throw new FileNotFoundException('Save path is not directory');
        }
    }


}