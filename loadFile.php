<?php
class loadFile{
    public static function loadFile($fileName){
        $addres = $fileName . '.php';
        if (!file_exists($addres)) {
            $addres = '404.php';
        }
        include($addres);
    }
}