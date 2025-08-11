<?php

$result = product::category()-> get();


// die();
// $result = product::join(['typeJoin' => 'LEFT' , 'tableName' => 'category']) -> get();



// die();
// $result = product::with(['category' => ['title']] , 'product_category');
// $result = product::select() -> makeSubQuery('category' , [['select' => ['title']] , ['where' => ['product.category' , 'category.id']]] , 'product_category') -> get();


$az = 0;
$go = '';
$pageRows = 10;
$ofset = 0;
$limit = 10;
if ($result -> num_rows < 10) {
    $pageRows = $result -> num_rows;
}
$numRows = $result -> num_rows / 10;
$pageInIt = 'pageInIt';
$columnInQuestion = '';
$sortingType = '';

// var_dump($GLOBALS['urlArray']);
for ($i=3; $i < count($GLOBALS['urlArray']); $i++) { 
    $arraysInUrl = explode(',', $GLOBALS['urlArray'][$i]);
    // var_dump($arraysInUrl);
    // pageInIt ------------------------------------------------------------------------
    if ($arraysInUrl[0] == 'pageInIt') {
        $result = product::limit([ 0 + $arraysInUrl[1] , 10 + $arraysInUrl[1] ]) -> join(['typeJoin' => 'LEFT' , 'tableName' => 'category']) -> get();
        // $result = product::category(["title"])-> get();

        $numRows = $arraysInUrl[2];
        if ($result -> num_rows < 10) {
            $pageRows = $result -> num_rows;
        }
    }
    // pageInItPrice ----------------------------------------------------------------------
    if ($arraysInUrl[0] == 'pageInItPrice') {
        echo '🤨';
        $restrictionsAppliedBar[$i - 3] = $arraysInUrl[0];
        if (!empty($_POST)) {
            
            $basicValue = $result = product::pageInItPrice($_POST);
            
            $request = $_POST;
            
            $columnInQuestion = $_POST['columnInQuestion'];
            $sortingType = $_POST['sortingType'];
            
            $pageInIt = 'pageInItPrice';
            
        }else {
            $pageInIt = 'pageInItPrice';
            // $columnInQuestion = '';
            // $sortingType = '';
            if (empty($arraysInUrl[3])) {
                $columnInQuestion = '';
                $sortingType = '';
            }else {
                $columnInQuestion = $arraysInUrl[3];
                $sortingType = $arraysInUrl[4];
            }
            $data = ['columnInQuestion' => $columnInQuestion , 'sortingType' => $sortingType];
            $basicValue = $result = product::pageInItPrice($data);
            $az = $arraysInUrl[1] + 0;
            $numRows = $arraysInUrl[2];
            if (count($result) - $arraysInUrl[1] < 10) {
                $pageRows = count($result);
            }else {
                $pageRows = 10;
            }
        }

        $ta = count($result);

    }
    // serchPageInIt =---------------------------------------------------------------------
    if ($arraysInUrl[0] == 'serchPageInIt') {
        $pageInIt = 'serchPageInIt';
        $restrictionsAppliedBar[$i - 3] = $arraysInUrl[0];
        if (!empty($_POST)) {
            $result = product::limit($_POST) -> join(['typeJoin' => 'LEFT' , 'tableName' => 'category']) -> get();

            // $value1 = $_POST[0];
            // $value2 = $_POST[1];
            echo '😤';
            echo $numRows = $result -> num_rows / 10;
            // $pageRows = $result -> num_rows;
            if ($result -> num_rows < 10) {
                $pageRows = $result -> num_rows;
            }
            // die();
        }else {
            $result = product::limit([$arraysInUrl[1] + 0,$arraysInUrl[1] + 10]) -> join(['typeJoin' => 'LEFT' , 'tableName' => 'category']) -> get();
            // echo '🚩';
            
            // $value1 = $arraysInUrl[1];
            // $value2 = $arraysInUrl[2];
            
            $numRows = $arraysInUrl[2];

            if ($result -> num_rows < 10) {
                $pageRows = $result -> num_rows;
            }
        }
        $go = '1';
    }
    // searchByColumns =---------------------------------------------------------------------
    if ($arraysInUrl[0] == 'searchByColumns') {

        $pageInIt = 'searchByColumns';
        $restrictionsAppliedBar[$i - 3] = $arraysInUrl[0];

        if (empty($_POST)) {
            
            $columnInQuestion = $arraysInUrl[3];
            $sortingType = urldecode($arraysInUrl[4]);

            $result = product::from(['product' , 'category']) -> where(['product.category' , 'category.id']) -> where([ $arraysInUrl[3] , " '" . urldecode($arraysInUrl[4]) . "' "]) -> limit([ 0 + $arraysInUrl[1] , 10 + $arraysInUrl[1] ]) -> with(['category' => ['title']] , 'product_category');

            $numRows = $arraysInUrl[2];

        }else {
            
            $columnInQuestion = $_POST['columnInQuestion'];
            $sortingType = $_POST['textInQuestion'];

            $result = product::from(['product' , 'category']) -> where(['product.category' , 'category.id']) -> where([ $columnInQuestion , " '" . $sortingType . "' "]) -> with(['category' => ['title']] , 'product_category');

            $numRows = $result -> num_rows / 10;

        }

        if ($result -> num_rows < 10) { $pageRows = $result -> num_rows; }

    }
}
?>



<!-- Restrictions applied bar : نوار محدودیت های اعمال شده -------- -->
<?php if (isset($restrictionsAppliedBar)) { ?>
    <div style="background-color: bisque;margin: 10px;border-radius: 10px;display: flex;flex-direction: column;align-items: flex-start;width: 97%;">
        <?php for ($i=0; $i < count($restrictionsAppliedBar); $i++) { ?>
            <div style="background-color: azure;margin: 10px;padding: 10px;border-radius: 10px;display: flex;justify-content: space-around;">
                <a href="http://localhost/ecommerce/listProduct" style="text-decoration: none;" title="حذف این سرویس">✗</a><?= '&nbsp' . $restrictionsAppliedBar[$i] . ' &nbsp ✓ '?> 
            </div>
        <?php } ?>
    </div>
<?php } ?>

<div style = "display: flex;flex-direction: row-reverse;justify-content: center;width: 100%;">
    <!-- pageInItPrice ---------------------------------------------------------- -->
    <div style="background-color: bisque;padding: 10px;margin: 10px;border-radius: 10px;display: flex;flex-direction: column;align-items: center;width: 20%;">
        <form action="http://localhost/ecommerce/listProduct/pageInItPrice" method = "post" style ="background-color: bisque;padding: 10px;margin: 10px;border-radius: 10px;display: flex;flex-direction: row-reverse;align-items: center;width: 100%;">
            <select name="columnInQuestion" style="margin: 10px;padding: 5px;border-radius: 10px;border: none;text-align: center;width: 90%;">
                <option value="price">price</option>
                <option value="id">id</option>
            </select>
            <select name="sortingType" style="margin: 10px;padding: 5px;border-radius: 10px;border: none;text-align: center;width: 90%;">
                <option value="decs">decs</option>
                <option value="acs">acs</option>
            </select>
            <button style="margin: 10px;padding: 5px;border-radius: 10px;border: none;background: none;">send</button>
        </form>
        ----------------------------------------
        <br>
        <!-- limitOfset serch -------------------------------------------------------- -->
        <form action="http://localhost/ecommerce/listProduct/serchPageInIt" method="post" style ="background-color: bisque;padding: 10px;margin: 10px;border-radius: 10px;display: flex;flex-direction: row-reverse;align-items: center;width: 100%;">
            <input name="0" placeholder="<?php if(!empty($value1)){ echo $value1; } ?>" style="margin: 10px;padding: 5px;border-radius: 10px;border: none;text-align: center;width: 90%;">
            <input name="1" placeholder="<?php if(!empty($value2)){ echo $value2; } ?>" style="margin: 10px;padding: 5px;border-radius: 10px;border: none;text-align: center;width: 90%;">
            <button style="margin: 10px;padding: 5px;border-radius: 10px;border: none;background: none;">send</button>
        </form>
        ----------------------------------------
        <br>
        <!-- searchByColumns -------------------------------------------------------- -->
        <form action="http://localhost/ecommerce/listProduct/searchByColumns" method="post" style ="background-color: bisque;padding: 10px;margin: 10px;border-radius: 10px;display: flex;flex-direction: row-reverse;align-items: center;width: 100%;">
            <select name='columnInQuestion' style="margin: 10px;padding: 5px;border-radius: 10px;border: none;text-align: center;width: 90%;">
                <option value="product.id">id</option>
                <option value="product.name">name</option>
                <option value="product.price">price</option>
                <option value="category.title">category</option>
                <option value="product.description">description</option>
            </select>
            <input name="textInQuestion" placeholder="<?php if(!empty($value1)){ echo $value1; } ?>" style="margin: 10px;padding: 5px;border-radius: 10px;border: none;text-align: center;width: 90%;">
            <button style="margin: 10px;padding: 5px;border-radius: 10px;border: none;background: none;">send</button>
        </form>
        ----------------------------------------
    </div>
    <div style="background-color: bisque;padding: 10px;margin: 10px;border-radius: 10px;display: flex;flex-direction: column;align-items: center;width: 80%;">
        <?php for ($i=$az; $i < $pageRows ; $i++) { if (!empty($basicValue)){ $value = $basicValue[$i]; }else{ $value = $result -> fetch_assoc();} ?>
            <div style="background-color: azure;margin: 10px;padding: 10px;border-radius: 10px;width: 96%;display: flex;justify-content: space-around;align-items: center;">
                <div>
                    <?= $value['product_id'] ?>
                </div>
                <div style="width: 200px;display: flex;justify-content: center;">
                    <?= $value['name'] ?>
                </div>
                <div style="width: 100px;display: flex;justify-content: center;">
                    <?= $value['price'] ?>
                </div>
                <div style="width: 100px;display: flex;justify-content: center;">
                    <?= $value['product_category'] ?>
                </div>
                <div style="width: 300px;display: flex;justify-content: center;">
                    <?= $value['description'] ?>
                </div>
                <a href="http://localhost/ecommerce/singleProduct/<?= $value['product_id'] ?>">نمایش</a>
                <a href="http://localhost/ecommerce/editeProduct/<?= $value['product_id'] ?>">ویرایش</a>
                <a href="http://localhost/ecommerce/deleteProduct/<?= $value['product_id'] ?>">حذف</a>
            </div>
        <?php } ?>
        
        <!-- pageInIt-------------------------------------------------------------- -->
        <div style="display: flex;justify-content: center;">
            <?php
            for ($i=0; $i < $numRows; $i++) { 
                ?>
                <a href="http://localhost/ecommerce/listProduct/<?= $pageInIt ?>,<?= $i . 0 ?>,<?= $numRows ?>,<?= $columnInQuestion ?>,<?= $sortingType ?>" style="background-color: bisque;margin: 10px;padding: 10px;border-radius: 10px;text-decoration: none;"><?= $i + 1 ?></a>
                <?php
            }
            ?>
        </div>
    </div>
</div>





<!-- ----------------------------------- -->
