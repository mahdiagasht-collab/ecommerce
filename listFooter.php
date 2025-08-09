<?php
echo '👍';
$result = footer::all();
// var_dump($result);

?>
<div style="background-color: bisque;padding: 10px;margin: 10px;border-radius: 10px;display: flex;flex-direction: column;align-items: center;">
    <?php
    while ($value = $result -> fetch_assoc()) {
        ?>
        <div style="background-color: azure;margin: 10px;padding: 10px;border-radius: 10px;width: 96%;display: flex;justify-content: space-around;align-items: center;">
            <div>
                <?= $value['id'] ?>
            </div>
            <div style="width: 100px;display: flex;justify-content: center;">
                <?= $value['copyRight'] ?>
            </div>
            <div style="width: 100px;display: flex;justify-content: center;">
                <?= $value['nameDesigner'] ?>
            </div>
            <a href="http://localhost/ecommerce/editeFooter/<?= $value['id'] ?>">ویرایش</a>
            <a href="http://localhost/ecommerce/deleteFooter/<?= $value['id'] ?>">حذف</a>
        </div>
    <?php
    }
    ?>
</div>