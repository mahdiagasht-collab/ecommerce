<?php
$result = user::create($_POST) -> get();
if($result){ 
    ?>
     <div>
        <?= '👍' ?>
    </div>
    <?php
}