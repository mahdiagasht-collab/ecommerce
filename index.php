<?php
include('autoLoad.php');
$urlArray = router::parsUrl();
loadFile::loadFile('header');
loadFile::loadFile($urlArray[2]);
loadFile::loadFile('footer');