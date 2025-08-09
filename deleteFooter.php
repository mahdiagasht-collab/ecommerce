<?php
if (footer::where($GLOBALS['urlArray'][3]) -> delete() -> get()) {
    echo '👍';
}