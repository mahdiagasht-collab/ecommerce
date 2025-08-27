<?php

// echo implode('<br>' , category::frist());

// factory::factory('product') -> category();


$result = category::withProductCount('product') -> getSQL() -> get();


// $result = category::
//     case(' point ' , '=' , " 0 " , 'امتیازی برای این دسته بندی ثبت نشده است') 
// ->  case(' point ' , '=' , " 1 " , 'خیلی بد') 
// ->  case(' point ' , '=' , " 2 " , 'بد') 
// ->  case(' point ' , '=' , " 3 " , 'متوسط') 
// ->  case(' point ' , '=' , " 4 " , 'خوب') 
// ->  case(' point ' , '=' , " 5 " , 'خیلی خوب') 
// ->  caseELSEAndENDAndAlies('point' , 'point') 
// ->  location('base') 
// ->  withProductCount('product') 
// ->  getSQL() 
// ->  get();




// foreach ($result as $value) {
//     echo '<br>';
//     echo '<br>'; 
//     echo 'category_id :      ';
//     echo $value['category_id'];
//     echo '<br>';
//     echo 'title :      ';
//     echo $value['title'];
//     echo '<br>';
//     echo 'description :      ';
//     echo $value['category_description'];
//     echo '<br>';
//     echo 'point :      ';
//     echo $value['point'];
//     echo '<br>';
// }
// -----------------------------------------------------------

// $result = category::if(' point ' , '=' , " 0 " , 'امتیازی برای این دسته بندی ثبت نشده است' , 'point' , 'point')
// ->  location('base') 
// ->  withProductCount('product') 
// ->  getSQL() 
// ->  get();




// foreach ($result as $value) {
//     echo '<br>';
//     echo '<br>'; 
//     echo 'category_id :      ';
//     echo $value['category_id'];
//     echo '<br>';
//     echo 'title :      ';
//     echo $value['title'];
//     echo '<br>';
//     echo 'description :      ';
//     echo $value['category_description'];
//     echo '<br>';
//     echo 'point :      ';
//     echo $value['point'];
//     echo '<br>';
// }
    
// -----------------------------------------------------------
    
// $result = category::ifNull(' point ' , '=' , " 0 " , 'امتیازی برای این دسته بندی ثبت نشده است' , 'point')
// ->  location('base') 
// ->  withProductCount('product') 
// ->  getSQL() 
// ->  get();
    

// foreach ($result as $value) {
//     echo '<br>';
//     echo '<br>'; 
//     echo 'category_id :      ';
//     echo $value['category_id'];
//     echo '<br>';
//     echo 'title :      ';
//     echo $value['title'];
//     echo '<br>';
//     echo 'description :      ';
//     echo $value['category_description'];
//     echo '<br>';
//     echo 'point :      ';
//     echo $value['point'];
//     echo '<br>';
// }

// -----------------------------------------------------------


// $result = category::coalesce(' point ')
// ->  coalesceAlies('point')
// ->  location('base') 
// ->  withProductCount('product') 
// ->  getSQL() 
// ->  get();


// foreach ($result as $value) {
//     echo '<br>';
//     echo '<br>'; 
//     echo 'category_id :      ';
//     echo $value['category_id'];
//     echo '<br>';
//     echo 'title :      ';
//     echo $value['title'];
//     echo '<br>';
//     echo 'description :      ';
//     echo $value['category_description'];
//     echo '<br>';
//     echo 'point :      ';
//     echo $value['point'];
//     echo '<br>';
// }

// -----------------------------------------------------------






// die();

$az = 0;
$pageRows = 10;
$ofset = 0;
$limit = 10;
$pageInIt = 'pageInIt';
$columnInQuestion = '';
$sortingType = '';


if ($result -> num_rows < 10) {
    $pageRows = $result -> num_rows;
}
$numRows = $result -> num_rows / 10;

    for ($i=3; $i < count($GLOBALS['urlArray']); $i++) { 
        $arraysInUrl = explode(',', $GLOBALS['urlArray'][$i]);
        // pageInIt ------------------------------------------------------------------------
        if ($arraysInUrl[0] == 'pageInIt') {
        $result = category::limit([ 0 + $arraysInUrl[1] , 10 + $arraysInUrl[1] ]) -> select() -> from(['category']) -> withProductCount('product') -> getSQL() -> get();
        if ($result -> num_rows < 10) {
            $pageRows = $result -> num_rows;
        }
    }
    // sort ----------------------------------------------------------------------
    if ($arraysInUrl[0] == 'sort') {
        echo '🤨';
        $pageInIt = 'sort';
        $restrictionsAppliedBar[$i - 3] = $arraysInUrl[0];
        if (!empty($_POST)) {
            
            $result = category::sort($_POST) -> withProductCount('product') -> getSQL() -> get();
            
            $columnInQuestion = $_POST['columnInQuestion'];
            $sortingType = $_POST['sortingType'];
            
            
        }else {
            $columnInQuestion = $arraysInUrl[3];
            $sortingType = $arraysInUrl[4];
            $data = ['columnInQuestion' => $columnInQuestion , 'sortingType' => $sortingType];
            $result = category::sort($data) -> withProductCount('product') -> limit([ 0 + $arraysInUrl[1] , 10 + $arraysInUrl[1] ]) -> getSQL() -> get();
            $az = $arraysInUrl[1] + 0;
            echo $numRows = $arraysInUrl[2];
            if ($result -> num_rows < 10) {
                $pageRows = $result -> num_rows + $az;
            }else {
                $pageRows = $az + 10;
            }
        }
    }
    // serchPageInIt ------------------------------------------------------------------------
    if ($arraysInUrl[0] == 'serchPageInIt') {
        $restrictionsAppliedBar[$i - 3] = $arraysInUrl[0];
        if (!empty($_POST)) {
            $result = category::limit($_POST) -> withProductCount('product') -> getSQL() -> get();

            $value1 = $_POST[0];
            $value2 = $_POST[1];
            echo '😤';
            $numRows = $result -> num_rows / 10;
            if ($result -> num_rows < 10) {
                $pageRows = $result -> num_rows;
            }
        }else {
            $result = category::limit([$arraysInUrl[1] + ($arraysInUrl[3] . 0),$arraysInUrl[2]]) -> withProductCount('product') -> getSQL() -> get();
            echo '😤';
            
            $value1 = $arraysInUrl[1];
            $value2 = $arraysInUrl[2];
            
            $numRows = $arraysInUrl[4];

            if ($result -> num_rows < 10) {
                $pageRows = $result -> num_rows;
            }
        }
    }
    // searchByColumns =---------------------------------------------------------------------
    if ($arraysInUrl[0] == 'searchByColumns') {

        $pageInIt = 'searchByColumns';
        $restrictionsAppliedBar[$i - 3] = $arraysInUrl[0];
        
        if (empty($_POST)) {
            
            $columnInQuestion = $arraysInUrl[3];
            $sortingType = urldecode($arraysInUrl[4]);
            
            $result = category::where( [$columnInQuestion , " '" . $sortingType . "' "]) -> limit([ 0 + $arraysInUrl[1] , 10 + $arraysInUrl[1] ]) -> withProductCount('product') -> getSQL() -> get();
            
            
            $az = $arraysInUrl[1] + 0;
            echo $numRows = $arraysInUrl[2];
        }else {
            
            $columnInQuestion = $_POST['columnInQuestion'];
            $sortingType = urldecode($_POST['textInQuestion']);
            
            $result = category::where([$columnInQuestion , " '" . $sortingType . "' "]) -> withProductCount('product') -> getSQL() -> get();

            echo $numRows = $result -> num_rows / 10;
            
        }

            
        if ($result -> num_rows < 10) {
            $pageRows = $result -> num_rows + $az;
        }else {
            $pageRows = $az + 10;
        }
    }
    // havingAndNotHaving =---------------------------------------------------------------------
    if ($arraysInUrl[0] == 'havingAndNotHaving') {

        $pageInIt = 'havingAndNotHaving';
        $restrictionsAppliedBar[$i - 3] = $arraysInUrl[0];
        
        if (empty($_POST)) {
            
            $columnInQuestion = $arraysInUrl[3];
            
            // $result = category::where( [$columnInQuestion , " '" . $sortingType . "' "]) -> limit([ 0 + $arraysInUrl[1] , 10 + $arraysInUrl[1] ]) -> withProductCount('product') -> getSQL() -> get();
            
            $result = category::withProductCount('product') -> having($columnInQuestion) -> limit([ 0 + $arraysInUrl[1] , 10 + $arraysInUrl[1] ]) -> getSQL() -> get();
            
            $az = $arraysInUrl[1] + 0;
            echo $numRows = $arraysInUrl[2];
        }else {
            
            $columnInQuestion = $_POST['textRequestion'];
            
            $result = category::withProductCount('product') -> having($columnInQuestion) -> getSQL() -> get();

            echo $numRows = $result -> num_rows / 10;
            
        }

            
        if ($result -> num_rows < 10) {
            $pageRows = $result -> num_rows + $az;
        }else {
            $pageRows = $az + 10;
        }
    }

}



// $result = category::getReturnedOBJ();
// if ($result -> num_rows < 10) {
//     $pageRows = $result -> num_rows;
// }
// $numRows = $result -> num_rows / 10;

    ?>

<!-- Restrictions applied bar : نوار محدودیت های اعمال شده -------- -->
<?php if (isset($restrictionsAppliedBar)) { ?>
    <div style="background-color: bisque;margin: 10px;border-radius: 10px;display: flex;flex-direction: column;align-items: flex-start;width: 97%;">
        <?php for ($i=0; $i < count($restrictionsAppliedBar); $i++) { ?>
            <div style="background-color: azure;margin: 10px;padding: 10px;border-radius: 10px;display: flex;justify-content: space-around;">
                <a href="http://localhost/ecommerce/listCategory" style="text-decoration: none;" title="حذف این سرویس">✗</a><?= '&nbsp' . $restrictionsAppliedBar[$i] . ' &nbsp ✓ '?> 
            </div>
        <?php } ?>
    </div>
<?php } ?>

<div style = "display: flex;flex-direction: row-reverse;justify-content: center;width: 100%;">
    <!-- sort ---------------------------------------------------------- -->
    <div style="background-color: bisque;padding: 10px;margin: 10px;border-radius: 10px;display: flex;flex-direction: column;align-items: center;width: 20%;">
        <form action="http://localhost/ecommerce/listCategory/sort" method = "post" style ="background-color: bisque;padding: 10px;margin: 10px;border-radius: 10px;display: flex;flex-direction: row-reverse;align-items: center;width: 100%;">
            <select name="columnInQuestion" style="margin: 10px;padding: 5px;border-radius: 10px;border: none;text-align: center;width: 90%;">
                <option value="category_id">id</option>
            </select>
            <select name="sortingType" style="margin: 10px;padding: 5px;border-radius: 10px;border: none;text-align: center;width: 90%;">
                <option value="DESC">DESC</option>
                <option value="ASC">ASC</option>
            </select>
            <button style="margin: 10px;padding: 5px;border-radius: 10px;border: none;background: none;">send</button>
        </form>
        ----------------------------------------
        <br>
        <!-- limitOfset serch -------------------------------------------------------- -->
        <form action="http://localhost/ecommerce/listCategory/serchPageInIt" method="post" style ="background-color: bisque;padding: 10px;margin: 10px;border-radius: 10px;display: flex;flex-direction: row-reverse;align-items: center;width: 100%;">
            <input name="0" value ="<?php if(!empty($value1)){ echo $value1; } ?>" style="margin: 10px;padding: 5px;border-radius: 10px;border: none;text-align: center;width: 90%;">
            <input name="1" value ="<?php if(!empty($value2)){ echo $value2; } ?>" style="margin: 10px;padding: 5px;border-radius: 10px;border: none;text-align: center;width: 90%;">
            <button style="margin: 10px;padding: 5px;border-radius: 10px;border: none;background: none;">send</button>
        </form>
        ----------------------------------------
        <br>
        <!-- searchByColumns -------------------------------------------------------- -->
        <form action="http://localhost/ecommerce/listCategory/searchByColumns" method="post" style ="background-color: bisque;padding: 10px;margin: 10px;border-radius: 10px;display: flex;flex-direction: row-reverse;align-items: center;width: 100%;">
            <select name='columnInQuestion' style="margin: 10px;padding: 5px;border-radius: 10px;border: none;text-align: center;width: 90%;">
                <option value="category.category_id">id</option>
                <option value="category.title">title</option>
                <option value="category_description">description</option>
            </select>
            <input name="textInQuestion" value="<?php if(!empty($value1)){ echo $value1; } ?>" style="margin: 10px;padding: 5px;border-radius: 10px;border: none;text-align: center;width: 90%;">
            <button style="margin: 10px;padding: 5px;border-radius: 10px;border: none;background: none;">send</button>
        </form>
        ----------------------------------------
        <br>
        <!-- havingAndNotHaving -------------------------------------------------------- -->
        <form action="http://localhost/ecommerce/listCategory/havingAndNotHaving" method="post" style ="background-color: bisque;padding: 10px;margin: 10px;border-radius: 10px;display: flex;flex-direction: row-reverse;align-items: center;width: 100%;">
            <select name='textRequestion' style="margin: 10px;padding: 5px;border-radius: 10px;border: none;text-align: center;width: 90%;">
                <option value="having"      <?php if ($columnInQuestion == 'having')    { echo 'selected'; } ?>>having</option>
                <option value="notHaving"   <?php if ($columnInQuestion == 'notHaving') { echo 'selected'; } ?>>notHaving</option>
            </select>
            <button style="margin: 10px;padding: 5px;border-radius: 10px;border: none;background: none;">send</button>
        </form>
        <!-- ---------------------------------------- -->
    </div>
    <div style="background-color: bisque;padding: 10px;margin: 10px;border-radius: 10px;display: flex;flex-direction: column;align-items: center;width: 80%;">
        <?php 
        for ($i=$az; $i < $pageRows ; $i++) { if (!empty($basicValue)){ $value = $basicValue[$i]; } else { $value = $result -> fetch_assoc(); } ?>
            <div style="background-color: azure;margin: 10px;padding: 10px;border-radius: 10px;width: 96%;display: flex;justify-content: space-around;align-items: center;">
                <div>
                    <?= $value['category_id'] ?>
                </div>
                <div style="width: 200px;display: flex;justify-content: center;">
                    <?= $value['title'] ?>
                </div>
                <div style="width: 300px;display: flex;justify-content: center;">
                    <?= $value['category_description'] ?>
                </div>
                <div style="width: 300px;display: flex;justify-content: center;">
                    <?= $value['categoryProductCount'] ?>
                </div>
                <a href="http://localhost/ecommerce/singleCategory/<?= $value['category_id'] ?>" target="_blank">نمایش</a>
                <a href="http://localhost/ecommerce/editeCategory/<?= $value['category_id'] ?>" target="_blank">ویرایش</a>
                <a href="http://localhost/ecommerce/deleteCategory/<?= $value['category_id'] ?>" target="_blank">حذف</a>
            </div>
        <?php } ?>
    </div>
</div>

<!-- pageInIt-------------------------------------------------------------- -->
<div style="display: flex;justify-content: center;">
    <?php
        for ($i=0; $i < $numRows; $i++) { 
            ?>
            <a href="http://localhost/ecommerce/listCategory/<?= $pageInIt ?>,<?= $i . 0 ?>,<?= $numRows ?>,<?= $columnInQuestion ?>,<?= $sortingType ?>" style="background-color: bisque;margin: 10px;padding: 10px;border-radius: 10px;text-decoration: none;"><?= $i + 1 ?></a>
            <?php

        }
    ?>
</div>

