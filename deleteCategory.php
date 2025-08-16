<?php
if (category::where(['category_id' , " '" . $GLOBALS['urlArray'][3] . "' "]) -> delete() -> get()) {
    echo '👍';
}