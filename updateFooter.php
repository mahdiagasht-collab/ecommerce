<?php
if (footer::where($GLOBALS['urlArray'][3]) -> update($_POST) -> get()) {
    echo '👍';
}