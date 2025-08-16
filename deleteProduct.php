<?php
if (product::where(['product_id' , " '" . $GLOBALS['urlArray'][3] . "' "]) -> delete() -> get()) {
    echo '👍';
}