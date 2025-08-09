<?php

class router{
    public static function parsUrl(){
        return explode('/' , $_SERVER['REQUEST_URI']);
    }
}