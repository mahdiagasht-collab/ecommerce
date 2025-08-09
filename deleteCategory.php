<?php
if (category::where($GLOBALS['urlArray'][3]) -> delete() -> get()) {
    echo '👍';
}