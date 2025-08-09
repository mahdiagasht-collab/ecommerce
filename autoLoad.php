<?php
class autoLoad{
    public function autoLoad($className){
        $fileName = 'model/' . $className . '.php';
        if(!file_exists($fileName)){
            $fileName = $className . '.php';
        }
        // echo '👍-------------';
        include($fileName);
    }
}
$autoLoad = new autoLoad;
spl_autoload_register([ $autoLoad , 'autoLoad']);