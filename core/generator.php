<?php

namespace core;

use core\db\database;
use core\api\meta;

class generator {

    private const SQLITE = "sqlite";
    private const MYSQL = "mysql";

    private $db;
    private $outputdir =  "." . DIRECTORY_SEPARATOR;

    public function __construct(object $options) {
        $this->db = new database($options);
    }
    
    public function set_output_dir(string $output_dir) {
        $this->outputdir = $output_dir;
    }
    public function get_output_dir(): string {
        return $this->outputdir;
    }

    public function do(meta $meta) {
        $tables = $this->get_tables();

        // foreach table create description
        foreach ($tables as $table) {
            file_put_contents($this->outputdir . "{$table}.php", $meta->create($table, $this->get_fields($table)));
        }
        // create include script
        $result = "<?php" . PHP_EOL . PHP_EOL;
        foreach ($tables as $table){
            $result .= "include_once __DIR__ . '/{$table}.php';" . PHP_EOL;
        }
        file_put_contents("{$this->outputdir}include_meta.php", $result);
    }

    private function get_tables(): array {
        $db_type = $this->db->get_type();
        switch ($db_type) {
            case self::SQLITE:
                return $this->sqlite_get_tables();
            case self::MYSQL:
                return $this->mysql_get_tables();
            default:
                exit("database '{$db_type}' is not supported");
        }
    }

    public function get_fields(string $table): array {
        $column_names = [];

        //$select = $this->db->query_sql("DESCRIBE TABLE {$table}");
        $select = $this->db->query_sql("PRAGMA table_info({$table})");
        foreach ($select as $field_description) {
            $column_names[] = $field_description["name"];
        }
        return $column_names;
    }

    private function sqlite_get_tables(): array {
        return $this->db->select_column("sqlite_master", "name");
    }

    private function mysql_get_tables(): array {
        $tmp = $this->db->query_sql("SHOW TABLES");
        $result = [];
        foreach ($tmp as $value) {
            $result[] = reset($value);
        }
        return $result;
    }

}
