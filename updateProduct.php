<?php
// user::update($_POST) -> where($GLOBALS['urlArray'][3]) -> get();
if (product::where($GLOBALS['urlArray'][3]) -> update($_POST) -> get()) {
    echo '👍';
}