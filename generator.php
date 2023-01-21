<?php

include_once __DIR__ . "/config.php";

$short_options = ""; //"d:u::p::";

$long_options = [
    "dsn:",
    "user::",
    "password::",
    "output::",
];

$options = getopt($short_options, $long_options);

if (empty($options)) {
    exit("usage: php " . str_replace(__DIR__, "", __FILE__) . "--dsn=<DSN> [--user=<USER> --password=<PASSWORD>]");
}

if (empty($options["dsn"])) {
    exit("dsn string is not specified, exit.");
}

$config = (object) [
    "dsn" => $options["dsn"],
    "user" => $options["user"] ?? null,
    "password" => $options["password"] ?? null,
];

echo create_meta_info($config, $options["output"] ?? __DIR__ . "/output/");
