<?php
if (product::where($GLOBALS['urlArray'][3]) -> delete() -> get()) {
    echo '👍';
}