<?php

include_once './core/database.php';
include_once './core/meta.php';
include_once './core/generator.php';

$short_options = null; //"d:u::p::";

$long_options = [
    "dsn:",
    "user::",
    "password::"
];

$options = getopt($short_options, $long_options);

if(empty($options["dsn"])){
    exit("dsn string is not specified, exit.");
}

$config = (object) [
        "dsn" => $options["dsn"],
        "user" => $options["user"] ?? null,
        "password" => $options["password"] ?? null,
];

$generator = new \core\generator($config);

// create folder for output
if (!file_exists($generator::$outputdir)) {
    if (!mkdir($generator::$outputdir)) {
        exit("cant create directory {$generator::$outputdir}" . PHP_EOL);
    }
}
echo "created successfully {$generator::$outputdir} directory" . PHP_EOL;

$generator->do();