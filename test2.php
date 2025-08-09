<?php
$result = product::all();

$az = 0;
$go = '';
$pageRows = 10;
$ofset = 0;
$limit = 10;
class madiator{
    // private static $typesOfRequests = null;
    private static $OBJ = null;
    // public function connection(){}
    private function __construct(){
        // $this -> typesOfRequests = [model => ['select', 'find' , 'delete' , 'update', 'create' , 'all' , 'count' , 'frist' , 'sort' , 'pageInItPrice' , 'where' , 'limit' , 'get']]
    }
    private static function makeOBJ(){
        if (self::$OBJ === null) {
            return self::$OBJ = new pageInIt;
        }
        return self::$OBJ;
    }
    public static function madiator(array $request, array $requestedValues){
        return self::makeOBJ() -> get($request , $requestedValues);

    }
    private function get(array $request, array $requestedValues){
        foreach ($request as $key => $value) {
            if (in_array($key , ['product' , 'footer' , 'category' , 'user'])) {
                return $this -> model($key , $value , $requestedValues);
            }
        }
    }
    public function model($key , $value , $requestedValues){
        if ($requestedValues == []) {
            return $key::$value();
        }else {
            return $key::$value($requestedValues);
        }

    }
    public function calling(){

    }
    public function pageInIt(){
        
    }
    public function pageInItPrice(){
        
    }
    public function serchPageInIt(){
        
    }
}

interface request{

}
class pageInIt implements request{
    private static $OBJ = null;
    private static function makeOBJ(){
        if (self::$OBJ === null) {
            return self::$OBJ = new pageInIt;
        }
        return self::$OBJ;
    }
    public static function pageInIt(array $requestedValues){
        // abstraction(self::makeOBJ() , $requestedValues) -> get();
        
        self::makeOBJ() -> get($requestedValues);
        $this -> limit = 0 + $requestedValues[1];
        $this -> ofset = 10 + $requestedValues[1];
        // $result = product::select() -> limit([ 0 + $arraysInUrl[1] , 10 + $arraysInUrl[1] ]) -> get();
        // $numRows = $arraysInUrl[2];
        // $az = $arraysInUrl[1] + 0;
        // if ($result -> num_rows < 10) {
            //     $pageRows = $result -> num_rows;
            // }
    }
    private function get(Array $requestedValues){
        $this -> select();
        // abstraction($this , [['product' => 'select'] , ['limit' , 'limit' => $this ->limit , 'ofset' -> $this -> ofset], ['get']]) -> get();

    }
    private function select(array $fields=['*']){
        abstraction($this , ['product' => 'select']);
    }
    // public function select
}
class pageInItPrice implements request{
    public function pageInItPrice(){
        $basicValue = $result = product::pageInItPrice();
        $numRows = $arraysInUrl[2];
        if (count($result) - $arraysInUrl[1] < 10) {
            $pageRows = count($result);
            $az = $arraysInUrl[1];
        }else {
            $pageRows = 10;
        }

        $ta = count($result);
    }
}
class serchPageInIt implements request{
    public function serchPageInIt(){
        if (!empty($_POST)) {
            $result = product::select() -> limit($_POST) -> get();

            $value1 = $_POST[0];
            $value2 = $_POST[1];
            if($value1 < $value2){ $az = $value1 + 0; }else { $az = $value2 + 0; }
            echo '😤';
            $numRows = $result -> num_rows / 10;
            $pageRows = $result -> num_rows;
        }else {
            $result = product::select() -> limit([$arraysInUrl[1] + ($arraysInUrl[3] . 0),$arraysInUrl[2]]) -> get();
            echo '😤';
            
            $value1 = $arraysInUrl[1];
            $value2 = $arraysInUrl[2];
            if($value1 < $value2){ $az = $value1 + 0; }else { $az = $value2 + 0; }
            
            $numRows = $arraysInUrl[4];

            if ($result -> num_rows < 10) {
                $pageRows = $result -> num_rows;
            }
        }
        $go = '1';
    }
}
class URLChecker{
    public static function parseUrl(){
    for ($i=3; $i < count($GLOBALS['urlArray']); $i++) { 
        $arraysInUrl = explode(',', $GLOBALS['urlArray'][$i]);
        if ($arraysInUrl[0] == 'pageInIt') {
            pageInIt::pageInIt($arraysInUrl);
        }
    }
    }
}
function abstraction(request $requestingObject ,array $request, array $requestedValues = []){
    // static $madiator;
    // if (isset($madiator)) {$madiator = new madiator();}
    return madiator::madiator($request , $requestedValues);

}
function clientCode(){
    URLChecker::parseUrl();
    // $madiator -> notify($requestingObject , $methodName);
    // $madiator -> connection();
    // $a = 3;
    // while ($arraysInUrl = explode(',', $GLOBALS['urlArray'][$a])) {
    //     if ($arraysInUrl[0] == 'pageInIt') {
            
    //     }
    // }

}
// if ($result -> num_rows < 10) {
//     $pageRows = $result -> num_rows;
// }
// $numRows = $result -> num_rows / 10;
// for ($i=3; $i < count($GLOBALS['urlArray']); $i++) { 
//     $arraysInUrl = explode(',', $GLOBALS['urlArray'][$i]);
    // pageInIt ------------------------------------------------------------------------
    // if ($arraysInUrl[0] == 'pageInIt') {
    //     $result = product::select() -> limit([ 0 + $arraysInUrl[1] , 10 + $arraysInUrl[1] ]) -> get();
    //     $numRows = $arraysInUrl[2];
    //     $az = $arraysInUrl[1] + 0;
    //     if ($result -> num_rows < 10) {
    //         $pageRows = $result -> num_rows;
    //     }
    // }
    // pageInItPrice ----------------------------------------------------------------------
    // if ($arraysInUrl[0] == 'pageInItPrice') {
    //     $basicValue = $result = product::pageInItPrice();
    //     $numRows = $arraysInUrl[2];
    //     if (count($result) - $arraysInUrl[1] < 10) {
    //         $pageRows = count($result);
    //         $az = $arraysInUrl[1];
    //     }else {
    //         $pageRows = 10;
    //     }

    //     $ta = count($result);

    // }
    // serchPageInIt =---------------------------------------------------------------------
    // if ($arraysInUrl[0] == 'serchPageInIt') {
    //     if (!empty($_POST)) {
    //         $result = product::select() -> limit($_POST) -> get();

    //         $value1 = $_POST[0];
    //         $value2 = $_POST[1];
    //         if($value1 < $value2){ $az = $value1 + 0; }else { $az = $value2 + 0; }
    //         echo '😤';
    //         $numRows = $result -> num_rows / 10;
    //         $pageRows = $result -> num_rows;
    //     }else {
    //         $result = product::select() -> limit([$arraysInUrl[1] + ($arraysInUrl[3] . 0),$arraysInUrl[2]]) -> get();
    //         echo '😤';
            
    //         $value1 = $arraysInUrl[1];
    //         $value2 = $arraysInUrl[2];
    //         if($value1 < $value2){ $az = $value1 + 0; }else { $az = $value2 + 0; }
            
    //         $numRows = $arraysInUrl[4];

    //         if ($result -> num_rows < 10) {
    //             $pageRows = $result -> num_rows;
    //         }
    //     }
    //     $go = '1';
    // }

// }
?>
<!-- limitOfset serch -------------------------------------------------------- -->
<!-- <div style="display: flex;justify-content: center;align-items: center;">
    <form action="http://localhost/ecommerce/test2/serchPageInIt" method="post">
        <input name="0" placeholder="<?php /*if(!empty($value1)){ echo $value1; }*/ ?>">
        <input name="1" placeholder="<?php /*if(!empty($value2)){ echo $value2; } */?>">
        <button>send</button>
    </form>
</div> -->
<!-- serchPageInIt --------------------------------------------------------- -->
<!-- 
<div style="display: flex;justify-content: center;">
    <?php /*
    if ($go == '1') {
        for ($i=0; $i < $numRows; $i++) { 
            ?>
            <a href="http://localhost/ecommerce/test2/serchPageInIt,<?= $value1 ?>,<?= $value2 ?>,<?= $i ?>,<?= $numRows ?>" style="background-color: bisque;margin: 10px;padding: 10px;border-radius: 10px;text-decoration: none;"><?= $i + 1 ?></a>
            <?php

        }
    } */
    ?>
</div> -->
<div style="background-color: bisque;padding: 10px;margin: 10px;border-radius: 10px;display: flex;flex-direction: column;align-items: center;">
    <?php /* for ($i=0; $i < $pageRows ; $i++) { $value = $result -> fetch_assoc();  echo $pageRows;*/?>
    <?php if (empty($basicValue)) {$basicValue = product::pageInItPrice();}
    for ($i=$az; $i < $pageRows ; $i++) { $value = $basicValue[$i]; ?>
        <div style="background-color: azure;margin: 10px;padding: 10px;border-radius: 10px;width: 96%;display: flex;justify-content: space-around;align-items: center;">
            <div>
                <?= $value['id'] ?>
            </div>
            <div style="width: 200px;display: flex;justify-content: center;">
                <?= $value['name'] ?>
            </div>
            <div style="width: 100px;display: flex;justify-content: center;">
                <?= $value['price'] ?>
            </div>
            <div style="width: 100px;display: flex;justify-content: center;">
                <?= category::where($value['category']) -> select(['title']) -> get() -> fetch_assoc()['title'] ?>
            </div>
            <div style="width: 300px;display: flex;justify-content: center;">
                <?= $value['description'] ?>
            </div>
            <a href="http://localhost/ecommerce/singleProduct/<?= $value['id'] ?>">نمایش</a>
            <a href="http://localhost/ecommerce/editeProduct/<?= $value['id'] ?>">ویرایش</a>
            <a href="http://localhost/ecommerce/deleteProduct/<?= $value['id'] ?>">حذف</a>
        </div>
    <?php } ?>
</div>


<!-- pageInItPrice -------------------------------------------------------------- -->
<!-- <div style="display: flex;justify-content: center;">
    <?php /*
        for ($i=0; $i < $numRows; $i++) { 
            ?>
            <a href="http://localhost/ecommerce/test2/pageInItPrice,<?= $i . 0 ?>,<?= $numRows ?>" style="background-color: bisque;margin: 10px;padding: 10px;border-radius: 10px;text-decoration: none;"><?= $i + 1 ?></a>
            <?php

        } */
    ?>
</div> -->





<!-- ----------------------------------- -->
