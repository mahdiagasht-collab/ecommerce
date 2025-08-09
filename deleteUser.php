<?php
if (user::where($GLOBALS['urlArray'][3]) -> delete() -> get()) {
    echo '👍';
}