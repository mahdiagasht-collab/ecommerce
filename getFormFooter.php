<?php
$result = footer::createOrUpdate($_POST) -> get();
if($result){ 
    ?>
     <div>
        <?= '👍' ?>
    </div>
    <?php
}