<?php
#http://persiangd.berlios.de
#Copyright (C) 2007  Milad Rastian (miladmovie[_at_]gmail)
#thanks to Bagram Siadat (info[_at_]gnudownload[_dot_]org) (bug fix and new developer)
#tahanks to Ramin Farmani (bug fix)
#
#This program is free software; you can redistribute it and/or
#modify it under the terms of the GNU General Public License
#as published by the Free Software Foundation; either version 2
#of the License, or (at your option) any later version.
#
#This program is distributed in the hope that it will be useful,
#but WITHOUT ANY WARRANTY; without even the implied warranty of
#MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
#GNU General Public License for more details.
#
#You should have received a copy of the GNU General Public License
#along with this program; if not, write to the Free Software
#Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA  02110-1301, USA.
namespace Ghorbannezhad\Fact\Vendor;

class fagd{
	function utf8_strlen($str) {
		return preg_match_all('/[\x00-\x7F\xC0-\xFD]/', $str, $dummy);
	}
	private $p_chars = array (
			'آ' => array ('ﺂ', 'ﺂ', 'آ'),
			'ا' => array ('ﺎ', 'ﺎ', 'ا'),
			'ب' => array ('ﺐ', 'ﺒ', 'ﺑ'),
			'پ' => array ('ﭗ', 'ﭙ', 'ﭘ'),
			'ت' => array ('ﺖ', 'ﺘ', 'ﺗ'),
			'ث' => array ('ﺚ', 'ﺜ', 'ﺛ'),
			'ج' => array ('ﺞ', 'ﺠ', 'ﺟ'),
			'چ' => array ('ﭻ', 'ﭽ', 'ﭼ'),
			'ح' => array ('ﺢ', 'ﺤ', 'ﺣ'),
			'خ' => array ('ﺦ', 'ﺨ', 'ﺧ'),
			'د' => array ('ﺪ', 'ﺪ', 'ﺩ'),
			'ذ' => array ('ﺬ', 'ﺬ', 'ﺫ'),
			'ر' => array ('ﺮ', 'ﺮ', 'ﺭ'),
			'ز' => array ('ﺰ', 'ﺰ', 'ﺯ'),
			'ژ' => array ('ﮋ', 'ﮋ', 'ﮊ'),
			'س' => array ('ﺲ', 'ﺴ', 'ﺳ'),
			'ش' => array ('ﺶ', 'ﺸ', 'ﺷ'),
			'ص' => array ('ﺺ', 'ﺼ', 'ﺻ'),
			'ض' => array ('ﺾ', 'ﻀ', 'ﺿ'),
			'ط' => array ('ﻂ', 'ﻄ', 'ﻃ'),
			'ظ' => array ('ﻆ', 'ﻈ', 'ﻇ'),
			'ع' => array ('ﻊ', 'ﻌ', 'ﻋ'),
			'غ' => array ('ﻎ', 'ﻐ', 'ﻏ'),
			'ف' => array ('ﻒ', 'ﻔ', 'ﻓ'),
			'ق' => array ('ﻖ', 'ﻘ', 'ﻗ'),
			'ک' => array ('ﻚ', 'ﻜ', 'ﻛ'),
			'گ' => array ('ﮓ', 'ﮕ', 'ﮔ'),
			'ل' => array ('ﻞ', 'ﻠ', 'ﻟ'),
			'م' => array ('ﻢ', 'ﻤ', 'ﻣ'),
			'ن' => array ('ﻦ', 'ﻨ', 'ﻧ'),
			'و' => array ('ﻮ', 'ﻮ', 'ﻭ'),
			'ی' => array ('ﯽ', 'ﯿ', 'ﯾ'),
			'ك' => array ('ﻚ', 'ﻜ', 'ﻛ'),
			'ي' => array ('ﻲ', 'ﻴ', 'ﻳ'),
			'أ' => array ('ﺄ', 'ﺄ', 'ﺃ'),
			'ؤ' => array ('ﺆ', 'ﺆ', 'ﺅ'),
			'إ' => array ('ﺈ', 'ﺈ', 'ﺇ'),
			'ئ' => array ('ﺊ', 'ﺌ', 'ﺋ'),
			'ة' => array ('ﺔ', 'ﺘ', 'ﺗ')
	);
	private $nastaligh = array(
			'ه' => array ('ﮫ', 'ﮭ', 'ﮬ')
	);
	private $normal    = array(
			'ه' => array ('ﻪ', 'ﻬ', 'ﻫ')
	);
	private $mp_chars = array ('آ', 'ا', 'د', 'ذ', 'ر', 'ز', 'ژ', 'و', 'أ', 'إ', 'ؤ');
	private $ignorelist = array('','ٌ','ٍ','ً','ُ','ِ','َ','ّ','ٓ','ٰ','ٔ','ﹶ','ﹺ','ﹸ','ﹼ','ﹾ','ﹴ','ﹰ','ﱞ','ﱟ','ﱠ','ﱡ','ﱢ','ﱣ',);
///
	public function fagd($str,$z="",$method='normal'){
		if($method == 'nastaligh'){
			$this->p_chars = array_merge($this->p_chars,$this->nastaligh);
		}else{
			$this->p_chars = array_merge($this->p_chars,$this->normal);
		}
		$str_len=$this->utf8_strlen($str);
		preg_match_all("/./u", $str, $ar);
		for ($i=0; $i<$str_len; $i++){
			$str1=$ar[0][$i];
			if(in_array($ar[0][$i+1],$this->ignorelist)){
				$str_next=$ar[0][$i+2];
				if ($i == 2) $str_back=$ar[0][$i-2];
				if ($i != 2) $str_back=$ar[0][$i-1];
			}elseif(!in_array($ar[0][$i-1],$this->ignorelist)){
				$str_next=$ar[0][$i+1];
				if ($i != 0) $str_back=$ar[0][$i-1];

			}else{
				if(isset($ar[0][$i+1]) && !empty($ar[0][$i+1])){
					$str_next=$ar[0][$i+1];
				}else{
					$str_next=$ar[0][$i-1];
				}
				if ($i != 0) $str_back=$ar[0][$i-2];
			}
			if(!in_array($str1,$this->ignorelist)){
				if (array_key_exists($str1,$this->p_chars)){
					if(!$str_back or $str_back==" " or !array_key_exists($str_back,$this->p_chars)){
						if(!array_key_exists($str_back,$this->p_chars) and !array_key_exists($str_next,$this->p_chars)) $output=$str1.$output;
						else $output=$this->p_chars[$str1][2].$output;
						continue;
					}elseif (array_key_exists($str_next,$this->p_chars) and array_key_exists($str_back,$this->p_chars)){
						if(in_array($str_back,$this->mp_chars) and array_key_exists($str_next,$this->p_chars)){
							$output=$this->p_chars[$str1][2].$output;
						}else{
							$output=$this->p_chars[$str1][1].$output;
						}
						continue;
					}elseif(array_key_exists($str_back,$this->p_chars) and !array_key_exists($str_next,$this->p_chars)){
						if(in_array($str_back,$this->mp_chars)){
							$output=$str1.$output;
						}else{
							$output=$this->p_chars[$str1][0].$output;
						}
						continue;
					}

				}elseif($z=="fa"){

					$number =array("٠","١","٢","٣","٤","٥","٦","٧","٨","٩","۴","۵","۶","0","1","2","3","4","5","6","7","8","9");
					switch ($str1){
						case ")" : $str1="("; break;
						case "(" : $str1=")"; break;
						case "}" : $str1="{"; break;
						case "{" : $str1="}"; break;
						case "]" : $str1="["; break;
						case "[" : $str1="]"; break;
						case ">" : $str1="<"; break;
						case "<" : $str1=">"; break;
					}
					if(in_array($str1,$number)){
						$num.=$str1;
						$str1="";
					}
					if (!in_array($str_next,$number)){
						$str1.=$num;
						$num="";
					}
					$output=$str1.$output;
				}else{
					if(($str1=="،") or ($str1=="؟") or ($str1=="ء") or (array_key_exists($str_next,$this->p_chars) and array_key_exists($str_back,$this->p_chars)) or
							($str1==" " and array_key_exists($str_back,$this->p_chars)) or ($str1==" " and array_key_exists($str_next,$this->p_chars)))
					{
						if($e_output){
							$output=$e_output.$output;
							$e_output="";
						}
						$output=$str1.$output;
					}
					else{
						$e_output.=$str1;
						if(array_key_exists($str_next,$this->p_chars) or $str_next==""){
							$output=$e_output.$output;
							$e_output="";
						}
					}
				}
			}else{
				$output=$str1.$output;
			}
			$str_next = null;
			$str_back = null;
		}
		return  $output;
	}
}


?>