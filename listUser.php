<?php
$result = user::all();



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
        $result = user::select() -> limit([ 0 + $arraysInUrl[1] , 10 + $arraysInUrl[1] ]) -> get();
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
            
            $basicValue = $result = user::pageInItPrice($_POST);
            
            $request = $_POST;
            
            $columnInQuestion = $_POST['columnInQuestion'];
            $sortingType = $_POST['sortingType'];
            
            $pageInIt = 'pageInItPrice';
            
        }else {
            $pageInIt = 'pageInItPrice';
            if (empty($arraysInUrl[3])) {
                $columnInQuestion = '';
                $sortingType = '';
            }else {
                $columnInQuestion = $arraysInUrl[3];
                $sortingType = $arraysInUrl[4];
            }
            $data = ['columnInQuestion' => $columnInQuestion , 'sortingType' => $sortingType];
            $basicValue = $result = user::pageInItPrice($data);
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
    // serchPageInIt ------------------------------------------------------------------------
    if ($arraysInUrl[0] == 'serchPageInIt') {
        $restrictionsAppliedBar[$i - 3] = $arraysInUrl[0];
        if (!empty($_POST)) {
            $result = user::select() -> limit($_POST) -> get();

            $value1 = $_POST[0];
            $value2 = $_POST[1];
            echo '😤';
            $numRows = $result -> num_rows / 10;
            if ($result -> num_rows < 10) {
                $pageRows = $result -> num_rows;
            }
        }else {
            $result = user::select() -> limit([$arraysInUrl[1] + ($arraysInUrl[3] . 0),$arraysInUrl[2]]) -> get();
            echo '😤';
            
            $value1 = $arraysInUrl[1];
            $value2 = $arraysInUrl[2];
            
            $numRows = $arraysInUrl[4];

            if ($result -> num_rows < 10) {
                $pageRows = $result -> num_rows;
            }
        }
        $go = '1';
    }
    // searchByColumns =---------------------------------------------------------------------
    if ($arraysInUrl[0] == 'searchByColumns') {
        $result = user::select() -> where( [" '" . $_POST['textInQuestion'] . "' " , $_POST['columnInQuestion']]) -> get();            
        $numRows = $result -> num_rows / 10;
        if ($result -> num_rows < 10) {
            $pageRows = $result -> num_rows;
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
<!-- serchPageInIt --------------------------------------------------------- -->
<div style="display: flex;justify-content: center;">
    <?php
    if ($go == '1') {
        for ($i=0; $i < $numRows; $i++) { 
            ?>
            <a href="http://localhost/ecommerce/listUser/serchPageInIt,<?= $value1 ?>,<?= $value2 ?>,<?= $i ?>,<?= $numRows ?>" style="background-color: bisque;margin: 10px;padding: 10px;border-radius: 10px;text-decoration: none;"><?= $i + 1 ?></a>
            <?php 
        }
    }
    ?>
</div>
<div style = "display: flex;flex-direction: row-reverse;justify-content: center;width: 100%;">
    <!-- pageInItPrice ---------------------------------------------------------- -->
    <div style="background-color: bisque;padding: 10px;margin: 10px;border-radius: 10px;display: flex;flex-direction: column;align-items: center;width: 20%;">
        <form action="http://localhost/ecommerce/listUser/pageInItPrice" method = "post" style ="background-color: bisque;padding: 10px;margin: 10px;border-radius: 10px;display: flex;flex-direction: row-reverse;align-items: center;width: 100%;">
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
        <form action="http://localhost/ecommerce/listUser/serchPageInIt" method="post" style ="background-color: bisque;padding: 10px;margin: 10px;border-radius: 10px;display: flex;flex-direction: row-reverse;align-items: center;width: 100%;">
            <input name="0" value ="<?php if(!empty($value1)){ echo $value1; } ?>" style="margin: 10px;padding: 5px;border-radius: 10px;border: none;text-align: center;width: 90%;">
            <input name="1" value ="<?php if(!empty($value2)){ echo $value2; } ?>" style="margin: 10px;padding: 5px;border-radius: 10px;border: none;text-align: center;width: 90%;">
            <button style="margin: 10px;padding: 5px;border-radius: 10px;border: none;background: none;">send</button>
        </form>
        ----------------------------------------
        <br>
        <!-- searchByColumns -------------------------------------------------------- -->
        <form action="http://localhost/ecommerce/listUser/searchByColumns" method="post" style ="background-color: bisque;padding: 10px;margin: 10px;border-radius: 10px;display: flex;flex-direction: row-reverse;align-items: center;width: 100%;">
            <select name='columnInQuestion' style="margin: 10px;padding: 5px;border-radius: 10px;border: none;text-align: center;width: 90%;">
                <option value="user.id">id</option>
                <option value="user.name">name</option>
                <option value="user.family">family</option>
                <option value="user.phonNumber">phonNumber</option>
            </select>
            <input name="textInQuestion" placeholder="<?php if(!empty($value1)){ echo $value1; } ?>" style="margin: 10px;padding: 5px;border-radius: 10px;border: none;text-align: center;width: 90%;">
            <button style="margin: 10px;padding: 5px;border-radius: 10px;border: none;background: none;">send</button>
        </form>
        ----------------------------------------
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
                <a href="http://localhost/ecommerce/singleUser/<?= $value['id'] ?>">نمایش</a>
                <a href="http://localhost/ecommerce/editeUser/<?= $value['id'] ?>">ویرایش</a>
                <a href="http://localhost/ecommerce/deleteUser/<?= $value['id'] ?>">حذف</a>
            </div>
        <?php } ?>
    </div>
</div>