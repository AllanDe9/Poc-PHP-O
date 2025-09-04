<?php

define ('ROOT', str_replace('index.php', '', $_SERVER['SCRIPT_FILENAME']));
session_start();

echo "Root : ".ROOT."<br>";


