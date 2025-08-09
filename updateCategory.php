<?php
if (Category::where($GLOBALS['urlArray'][3]) -> update($_POST) -> get()) {
    echo '👍';
}