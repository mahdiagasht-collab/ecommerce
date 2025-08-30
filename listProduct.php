<?php
$result = product::category() -> get();
// die();
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

for ($i=3; $i < count($GLOBALS['urlArray']); $i++) { 
    $arraysInUrl = explode(',', $GLOBALS['urlArray'][$i]);
    // pageInIt ------------------------------------------------------------------------
    if ($arraysInUrl[0] == 'pageInIt') {
        $result = product::limit([ 0 + $arraysInUrl[1] , 10 + $arraysInUrl[1] ]) -> category() -> get();

        // $numRows = $arraysInUrl[2];
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
            
            $result = product::category() -> sort($_POST) -> get();
            
            $request = $_POST;
            
            $columnInQuestion = $_POST['columnInQuestion'];
            $sortingType = $_POST['sortingType'];
            
            
        }else {

            $columnInQuestion = $arraysInUrl[3];
            $sortingType = $arraysInUrl[4];

            $data = ['columnInQuestion' => $columnInQuestion , 'sortingType' => $sortingType];
            $result = product::category() -> sort($data) -> get();
            $az = $arraysInUrl[1] + 0;
            $numRows = $arraysInUrl[2];
            if (count($result) - $az < 10) {
                $pageRows = count($result);
            }else {
                $pageRows = $az + 10;
            }
        }

        $ta = $result -> num_rows;

    }
    // serchPageInIt =---------------------------------------------------------------------
    if ($arraysInUrl[0] == 'serchPageInIt') {
        $pageInIt = 'serchPageInIt';
        $restrictionsAppliedBar[$i - 3] = $arraysInUrl[0];
        if (!empty($_POST)) {
            $result = product::limit($_POST) -> category() -> get();

            $numRows = $result -> num_rows / 10;
            if ($result -> num_rows < 10) {
                $pageRows = $result -> num_rows;
            }
        }else {
            // $result = product::limit([$arraysInUrl[1] + 0,$arraysInUrl[1] + 10]) -> category();
            $result = product::limit([$arraysInUrl[1] + 0,$arraysInUrl[1] + 10]) -> category() -> get();
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

            $result = product::select() -> from(['product' , 'category']) -> where() -> where([ $arraysInUrl[3] , " '" . urldecode($arraysInUrl[4]) . "' "]) -> limit([ 0 + $arraysInUrl[1] , 10 + $arraysInUrl[1] ])  -> get();

            $numRows = $arraysInUrl[2];

        }else {
            
            $columnInQuestion = $_POST['columnInQuestion'];
            $sortingType = $_POST['textInQuestion'];

            $result = product::from(['product' , 'category']) -> where([ $columnInQuestion , " '" . $sortingType . "' "]) -> get();

            $numRows = $result -> num_rows / 10;

        }

        if ($result -> num_rows < 10) { $pageRows = $result -> num_rows; }

    }
    // groupBy =---------------------------------------------------------------------
    if ($arraysInUrl[0] == 'groupBy') {

        $pageInIt = 'groupBy';
        $restrictionsAppliedBar[$i - 3] = $arraysInUrl[0];
        
        if (!empty($_POST)) {
            $columnInQuestion = $_POST['columnInQuestion'];
            
            // $result = product::groupBy($columnInQuestion) -> category() -> get();
            // echo '🤨🤨🤨😢';
            $result = product::category() -> groupBy($columnInQuestion) -> get();
            
            $numRows = $result -> num_rows / 10;

            
        }
        
        if ($result -> num_rows < 10) { $pageRows = $result -> num_rows; }
    }
}
// echo '🤨🤨🤨😢';
?>



<!-- Restrictions applied bar : نوار محدودیت های اعمال شده -------- -->
<?php if (isset($restrictionsAppliedBar)) { ?>
    <div style="background-color: bisque;margin: 10px;border-radius: 10px;display: flex;flex-direction: column;align-items: flex-start;width: 97%;">
        <?php for ($i=0; $i < count($restrictionsAppliedBar); $i++) { ?>
            <div style="background-color: azure;margin: 10px;padding: 10px;border-radius: 10px;display: flex;justify-content: space-around;">
                <a href="http://localhost/ecommerceBuilderAndFacade/listProduct" style="text-decoration: none;" title="حذف این سرویس">✗</a><?= '&nbsp' . $restrictionsAppliedBar[$i] . ' &nbsp ✓ '?> 
            </div>
        <?php } ?>
    </div>
<?php } ?>

<div style = "display: flex;flex-direction: row-reverse;justify-content: center;width: 100%;">
    <!-- sort ---------------------------------------------------------- -->
    <div style="background-color: bisque;padding: 10px;margin: 10px;border-radius: 10px;display: flex;flex-direction: column;align-items: center;width: 20%;">
        <form action="http://localhost/ecommerceBuilderAndFacade/listProduct/sort" method = "post" style ="background-color: bisque;padding: 10px;margin: 10px;border-radius: 10px;display: flex;flex-direction: row-reverse;align-items: center;width: 100%;">
            <select name="columnInQuestion" style="margin: 10px;padding: 5px;border-radius: 10px;border: none;text-align: center;width: 90%;">
                <option value="price">price</option>
                <option value="product_id">id</option>
            </select>
            <select name="sortingType" style="margin: 10px;padding: 5px;border-radius: 10px;border: none;text-align: center;width: 90%;">
                <option value="DESC">desc</option>
                <option value="ASC">asc</option>
            </select>
            <button style="margin: 10px;padding: 5px;border-radius: 10px;border: none;background: none;">send</button>
        </form>
        ----------------------------------------
        <br>
        <!-- limitOfset serch -------------------------------------------------------- -->
        <form action="http://localhost/ecommerceBuilderAndFacade/listProduct/serchPageInIt" method="post" style ="background-color: bisque;padding: 10px;margin: 10px;border-radius: 10px;display: flex;flex-direction: row-reverse;align-items: center;width: 100%;">
            <input name="0" placeholder="<?php if(!empty($value1)){ echo $value1; } ?>" style="margin: 10px;padding: 5px;border-radius: 10px;border: none;text-align: center;width: 90%;">
            <input name="1" placeholder="<?php if(!empty($value2)){ echo $value2; } ?>" style="margin: 10px;padding: 5px;border-radius: 10px;border: none;text-align: center;width: 90%;">
            <button style="margin: 10px;padding: 5px;border-radius: 10px;border: none;background: none;">send</button>
        </form>
        ----------------------------------------
        <br>
        <!-- searchByColumns -------------------------------------------------------- -->
        <form action="http://localhost/ecommerceBuilderAndFacade/listProduct/searchByColumns" method="post" style ="background-color: bisque;padding: 10px;margin: 10px;border-radius: 10px;display: flex;flex-direction: row-reverse;align-items: center;width: 100%;">
            <select name='columnInQuestion' style="margin: 10px;padding: 5px;border-radius: 10px;border: none;text-align: center;width: 90%;">
                <option value="product.product_id">id</option>
                <option value="product.name">name</option>
                <option value="product.price">price</option>
                <option value="category.title">category</option>
                <option value="product_description">description</option>
            </select>
            <input name="textInQuestion" placeholder="<?php if(!empty($value1)){ echo $value1; } ?>" style="margin: 10px;padding: 5px;border-radius: 10px;border: none;text-align: center;width: 90%;">
            <button style="margin: 10px;padding: 5px;border-radius: 10px;border: none;background: none;">send</button>
        </form>
        ----------------------------------------
        <br>
        <!-- groupBy -------------------------------------------------------- -->
        <form action="http://localhost/ecommerceBuilderAndFacade/listProduct/groupBy" method="post" style ="background-color: bisque;padding: 10px;margin: 10px;border-radius: 10px;display: flex;flex-direction: row-reverse;align-items: center;width: 100%;">
            <select name='columnInQuestion' style="margin: 10px;padding: 5px;border-radius: 10px;border: none;text-align: center;width: 90%;">
                <option value="product.product_id">id</option>
                <option value="product.name">name</option>
                <option value="product.price">price</option>
                <option value="product_category">category</option>
                <option value="product_description">description</option>
            </select>
            <button style="margin: 10px;padding: 5px;border-radius: 10px;border: none;background: none;">send</button>
        </form>
        <!-- ---------------------------------------- -->
    </div>
    <div style="background-color: bisque;padding: 10px;margin: 10px;border-radius: 10px;display: flex;flex-direction: column;align-items: center;width: 80%;">
        <?php 
        for ($i=$az; $i < $pageRows ; $i++) {$value = $result -> fetch_assoc(); ?>
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
                    <?= $value['title'] ?>
                </div>
                <div style="width: 300px;display: flex;justify-content: center;">
                    <?= $value['product_description'] ?>
                </div>
                <a href="http://localhost/ecommerceBuilderAndFacade/singleProduct/<?= $value['product_id'] ?>" target="_blank">نمایش</a>
                <a href="http://localhost/ecommerceBuilderAndFacade/editeProduct/<?= $value['product_id'] ?>" target="_blank">ویرایش</a>
                <a href="http://localhost/ecommerceBuilderAndFacade/deleteProduct/<?= $value['product_id'] ?>" target="_blank">حذف</a>
            </div>
        <?php } ?>
        
        <!-- pageInIt-------------------------------------------------------------- -->
        <div style="display: flex;justify-content: center;">
            <?php
            for ($i=0; $i < $numRows; $i++) { 
                ?>
                <a href="http://localhost/ecommerceBuilderAndFacade/listProduct/<?= $pageInIt ?>,<?= $i . 0 ?>,<?= $numRows ?>,<?= $columnInQuestion ?>,<?= $sortingType ?>" style="background-color: bisque;margin: 10px;padding: 10px;border-radius: 10px;text-decoration: none;"><?= $i + 1 ?></a>
                <?php
            }
            ?>
        </div>
    </div>
</div>





<!-- ----------------------------------- -->
