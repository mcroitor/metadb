<?php

namespace core;

use core\database;
use core\meta;

class generator implements analyzer {

    private const SQLITE = "sqlite";
    private const MYSQL = "mysql";

    private $db;
    public static $outputdir = __DIR__ . DIRECTORY_SEPARATOR . "meta" . DIRECTORY_SEPARATOR;

    public function __construct(object $options) {
        $this->db = new database($options);
    }

    public function do(meta $meta) {
        $tables = $this->get_tables();

        // foreach table create description
        foreach ($tables as $table) {
            file_put_contents(self::$outputdir . "{$table}.php", $meta->create($table, $this->get_fields($table)));
        }
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

        $select = $this->db->query_sql("DESCRIBE TABLE {$table}");
        $row = $select[0];
        foreach ($row as $column_name => $value) {
            $column_names[] = $column_name;
        }
        return $column_names;
    }

    private function sqlite_get_tables(): array {
        return $this->db->select_column("sqlite_sequence", "name");
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
