<?php

Route::group(['prefix'=>'fact'],function (){
    Route::get('create','Ghorbannezhad\Fact\FactController@create');
});