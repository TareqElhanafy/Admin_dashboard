<?php

use App\Language;
use Illuminate\Support\Facades\Config;

function get_default_lang(){
    return Config::get('app.locale');
}

function get_Languages()
{
    return Language::active()->select()->get();
}
