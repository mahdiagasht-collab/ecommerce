<?php
$value = product::where($GLOBALS['urlArray'][3]) -> get() -> fetch_assoc();

?>
<div style="background-color: bisque;padding: 10px;margin: 10px;border-radius: 10px;display: flex;flex-direction: column;align-items: center;">
    <div style="background-color: azure;margin: 10px;padding: 10px;border-radius: 10px;width: 96%;display: flex;justify-content: space-around;align-items: center;">
            <div>
                <?= $value['id'] ?>
            </div>
            <div style="">
                <?= $value['name'] ?>
            </div>
            <div style="">
                <?= $value['price'] ?>
            </div>
            <div style="">
                <?= category::where($value['category']) -> select(['title']) -> get() -> fetch_assoc()['title'] ?>
            </div>
            <div style="">
                <?= $value['description'] ?>
            </div>
    </div>
</div>