<?php
$result = product::create($_POST) -> get();
if($result){ 
    ?>
     <div>
        <?= '👍' ?>
    </div>
    <?php
}