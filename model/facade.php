<?php
class facade extends mainDB{
    public static function __callStatic($name, $arguments){
        return (new Static) -> $name($arguments);
    }
    public function __call($name, $arguments){
        // $this;
        return $this -> $name($arguments);
    }
}