<?php
$result = footer::create($_POST) -> get();
if($result){ 
    ?>
     <div>
        <?= '👍' ?>
    </div>
    <?php
}