<?php
$result = user::all();



$az = 0;
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
        $result = user::limit([ 0 + $arraysInUrl[1] , 10 + $arraysInUrl[1] ]) -> all();
        $numRows = $arraysInUrl[2];
        if ($result -> num_rows < 10) {
            $pageRows = $result -> num_rows;
        }
    }
    // pageInItPrice ----------------------------------------------------------------------
    if ($arraysInUrl[0] == 'pageInItPrice') {
        echo '🤨';
        $pageInIt = 'pageInItPrice';
        $restrictionsAppliedBar[$i - 3] = $arraysInUrl[0];
        if (!empty($_POST)) {
            
            $basicValue = $result = user::pageInItPrice($_POST);
            
            $request = $_POST;
            
            $columnInQuestion = $_POST['columnInQuestion'];
            $sortingType = $_POST['sortingType'];

            
        }else {
            $columnInQuestion = $arraysInUrl[3];
            $sortingType = $arraysInUrl[4];
            $data = ['columnInQuestion' => $columnInQuestion , 'sortingType' => $sortingType];
            $basicValue = $result = user::pageInItPrice($data);
            $az = $arraysInUrl[1] + 0;
            $numRows = $arraysInUrl[2];
            if (count($result) - $az < 10) {
                $pageRows = count($result);
            }else {
                $pageRows = $az + 10;
            }
        }

        $ta = count($result);

    }
    // serchPageInIt ------------------------------------------------------------------------
    if ($arraysInUrl[0] == 'serchPageInIt') {
        $pageInIt = 'serchPageInIt';
        $restrictionsAppliedBar[$i - 3] = $arraysInUrl[0];
        if (!empty($_POST)) {
            $result = user::limit($_POST) -> all();

            echo '😤';
            $numRows = $result -> num_rows / 10;
            var_dump($numRows);
            if ($result -> num_rows < 10) {
                $pageRows = $result -> num_rows;
            }
        }else {
            $result = user::limit([$arraysInUrl[1] + 0 , $arraysInUrl[1] + 10]) -> all();
            echo '😤';
            
            $numRows = $arraysInUrl[2];
            
            var_dump($numRows);
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
            
            $result = user::where([$columnInQuestion , " '" . $sortingType . "' "]) -> limit([ 0 + $arraysInUrl[1] , 10 + $arraysInUrl[1] ]) -> all();            
            
            $az = $arraysInUrl[1] + 0;
            $numRows = $arraysInUrl[2];
        }else {
            
            $columnInQuestion = $_POST['columnInQuestion'];
            $sortingType = urldecode($_POST['textInQuestion']);
            
            $result = user::where([$columnInQuestion , " '" . $sortingType . "' "]) -> all();

            echo $numRows = $result -> num_rows / 10;
            
        }


        if ($result -> num_rows < 10) {
            $pageRows = $result -> num_rows + $az;
        }else {
            $pageRows = $az + 10;
        }
    }

}
?>





<!-- Restrictions applied bar : نوار محدودیت های اعمال شده -------- -->
<?php if (isset($restrictionsAppliedBar)) { ?>
    <div style="background-color: bisque;margin: 10px;border-radius: 10px;display: flex;flex-direction: column;align-items: flex-start;width: 97%;">
        <?php for ($i=0; $i < count($restrictionsAppliedBar); $i++) { ?>
            <div style="background-color: azure;margin: 10px;padding: 10px;border-radius: 10px;display: flex;justify-content: space-around;">
                <?= $restrictionsAppliedBar[$i] . ' &nbsp ✓ '?> 
            </div>
        <?php } ?>
    </div>
<?php } ?>
<div style = "display: flex;flex-direction: row-reverse;justify-content: center;width: 100%;">
    <!-- pageInItPrice ---------------------------------------------------------- -->
    <div style="background-color: bisque;padding: 10px;margin: 10px;border-radius: 10px;display: flex;flex-direction: column;align-items: center;width: 20%;">
        <form action="http://localhost/ecommerceBuilderAndFacade/listUser/pageInItPrice" method = "post" style ="background-color: bisque;padding: 10px;margin: 10px;border-radius: 10px;display: flex;flex-direction: row-reverse;align-items: center;width: 100%;">
            <select name="columnInQuestion" style="margin: 10px;padding: 5px;border-radius: 10px;border: none;text-align: center;width: 90%;">
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
        <form action="http://localhost/ecommerceBuilderAndFacade/listUser/serchPageInIt" method="post" style ="background-color: bisque;padding: 10px;margin: 10px;border-radius: 10px;display: flex;flex-direction: row-reverse;align-items: center;width: 100%;">
            <input name="0" value ="<?php if(!empty($value1)){ echo $value1; } ?>" style="margin: 10px;padding: 5px;border-radius: 10px;border: none;text-align: center;width: 90%;">
            <input name="1" value ="<?php if(!empty($value2)){ echo $value2; } ?>" style="margin: 10px;padding: 5px;border-radius: 10px;border: none;text-align: center;width: 90%;">
            <button style="margin: 10px;padding: 5px;border-radius: 10px;border: none;background: none;">send</button>
        </form>
        ----------------------------------------
        <br>
        <!-- searchByColumns -------------------------------------------------------- -->
        <form action="http://localhost/ecommerceBuilderAndFacade/listUser/searchByColumns" method="post" style ="background-color: bisque;padding: 10px;margin: 10px;border-radius: 10px;display: flex;flex-direction: row-reverse;align-items: center;width: 100%;">
            <select name='columnInQuestion' style="margin: 10px;padding: 5px;border-radius: 10px;border: none;text-align: center;width: 90%;">
                <option value="user.id">id</option>
                <option value="user.name">name</option>
                <option value="user.family">family</option>
                <option value="user.phonNumber">phonNumber</option>
            </select>
            <input name="textInQuestion" placeholder="<?php if(!empty($value1)){ echo $value1; } ?>" style="margin: 10px;padding: 5px;border-radius: 10px;border: none;text-align: center;width: 90%;">
            <button style="margin: 10px;padding: 5px;border-radius: 10px;border: none;background: none;">send</button>
        </form>
        <!-- ---------------------------------------- -->
    </div>
    <div style="background-color: bisque;padding: 10px;margin: 10px;border-radius: 10px;display: flex;flex-direction: column;align-items: center;width: 80%;">
        <?php for ($i=$az; $i < $pageRows ; $i++) { if (!empty($basicValue)){ $value = $basicValue[$i]; } else { $value = $result -> fetch_assoc(); } ?>
            <div style="background-color: azure;margin: 10px;padding: 10px;border-radius: 10px;width: 96%;display: flex;justify-content: space-around;align-items: center;">
                <div>
                    <?= $value['id'] ?>
                </div>
                <div style="width: 200px;display: flex;justify-content: center;">
                    <?= $value['name'] ?>
                </div>
                <div style="width: 300px;display: flex;justify-content: center;">
                    <?= $value['family'] ?>
                </div>
                <div style="width: 300px;display: flex;justify-content: center;">
                    <?= $value['phonNumber'] ?>
                </div>
                <a href="http://localhost/ecommerceBuilderAndFacade/singleUser/<?= $value['id'] ?>">نمایش</a>
                <a href="http://localhost/ecommerceBuilderAndFacade/editeUser/<?= $value['id'] ?>">ویرایش</a>
                <a href="http://localhost/ecommerceBuilderAndFacade/deleteUser/<?= $value['id'] ?>">حذف</a>
            </div>
        <?php } ?>
    </div>
</div>

<!-- pageInIt-------------------------------------------------------------- -->
<div style="display: flex;justify-content: center;">
    <?php
        for ($i=0; $i < $numRows; $i++) { 
            ?>
            <a href="http://localhost/ecommerceBuilderAndFacade/listUser/<?= $pageInIt ?>,<?= $i . 0 ?>,<?= $numRows ?>,<?= $columnInQuestion ?>,<?= $sortingType ?>" style="background-color: bisque;margin: 10px;padding: 10px;border-radius: 10px;text-decoration: none;"><?= $i + 1 ?></a>
            <?php

        }
    ?>
</div>
