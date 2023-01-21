<?php
class config
{

    /* path definitions */
    public const root_dir = __DIR__ . DIRECTORY_SEPARATOR;
    public const lib_dir = self::root_dir . "core" . DIRECTORY_SEPARATOR;
    public const api_dir = self::lib_dir . "api" . DIRECTORY_SEPARATOR;

    /* interfaces */
    private const api = [
        "meta",
    ];
    /* library files */
    private const lib = [
        "db\\database",
        "meta_structure",
        "meta_class",
        "generator",
        "lib"
    ];

    /**
     * include API
     */
    public static function include_api()
    {
        foreach (self::api as $interface_name) {
            include_once self::api_dir . "{$interface_name}.php";
        }
    }
    /**
     * include libraries
     */
    public static function include_lib()
    {
        foreach (self::lib as $class_name) {
            include_once self::lib_dir . "{$class_name}.php";
        }
    }
}

config::include_api();
config::include_lib();
