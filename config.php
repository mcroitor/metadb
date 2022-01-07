<?php
class config {

    public const root_dir = __DIR__ . DIRECTORY_SEPARATOR;
    public const lib_dir = self::root_dir . "core" . DIRECTORY_SEPARATOR;
    public const api_dir = self::lib_dir . "api" . DIRECTORY_SEPARATOR;
    private const api = [
        "analyzer",
        "generator",
        "meta",
    ];
    private const lib = [
        "db\\database",
        "meta_structure",
        "meta_class",
        "generator",
    ];

    public static function include_api() {
        foreach (self::api as $interface_name) {
            //echo "include_once '" . self::api_dir . "{$interface_name}.php'" . PHP_EOL;
            include_once self::api_dir . "{$interface_name}.php";
        }
    }
    public static function include_lib() {
        foreach (self::lib as $class_name) {
            include_once self::lib_dir . "{$class_name}.php";
        }
    }

}

config::include_api();
config::include_lib();