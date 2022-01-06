<?php

include_once __DIR__ . '/config.php';

$short_options = null; //"d:u::p::";

$long_options = [
    "dsn:",
    "user::",
    "password::"
];

$options = getopt($short_options, $long_options);

if(count($options) === 0) {
    exit("usage: php " . str_replace(__DIR__, "", __FILE__) . "--dsn=<DSN> [--user=<USER> --password=<PASSWORD>]");
}

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
$generator->set_output_dir(config::root_dir . "meta" . DIRECTORY_SEPARATOR);

if (!file_exists($generator->get_output_dir())) {
    if (!mkdir($generator->get_output_dir())) {
        exit("cant create directory {$generator->get_output_dir()}" . PHP_EOL);
    }
}
echo "created successfully {$generator->get_output_dir()} directory" . PHP_EOL;

$generator->do(new core\meta_structure());