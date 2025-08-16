<?php
if (footer::where(['id' , " '" . $GLOBALS['urlArray'][3] . "' "]) -> delete() -> get()) {
    echo '👍';
}