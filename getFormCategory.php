<?php
$result = category::create($_POST) -> get();
if($result){ 
    ?>
     <div>
        <?= '👍' ?>
    </div>
    <?php
}