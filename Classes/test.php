<?php
echo "<br>Test";
function autoload($className) {
    set_include_path('./Classes/');
    spl_autoload($className); //replaces include/require
}
spl_autoload_extensions('.php');
spl_autoload_register('autoload');
echo "<br>Будем подключаться";
$access=new ToBase();
echo "Подключились к ToBase";