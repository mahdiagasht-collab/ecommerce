<?php
if (Category::where(['category_id' , " '" . $GLOBALS['urlArray'][3] . "' "]) -> update($_POST) -> get()) {
    echo '👍';
}