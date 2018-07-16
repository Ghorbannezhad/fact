<?php
$logo = __DIR__.'/../images/input/asoone-facts-logo.png';
$font =  __DIR__.'/../assets/fonts/Tahoma.ttf';
$save_path = __DIR__.'/../images';

return [
    'logo'=>$logo,
    'style'=>[
        'margin_top'=>10,        //in percent
        'margin_left'=>10,      //in percent
        'margin_bottom'=>10,   //in percent
        'margin_right'=>10,   //in percent
        'font_size'=>24,
        'line_height'=>50,
        'logo_from_bottom'=> 10,  //in percent
        'font'=>$font,
        'text_align'=>'center' //supported: center|right|left
    ],
    'lang'=>'fa', //supported: fa | en
    'save_path'=>$save_path,

];