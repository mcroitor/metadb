<?php

namespace core;

/**
 * Description of structure
 *
 * @author XiaomiPRO
 */
class structure implements analyzer {

    /**
     * 
     * @var \core\database
     */
    private $db;

    public function __construct(object $options) {
        $this->db = new database($options);
    }

    public function do() {
        $tables = $this->get_tables();

        // foreach table create description
        foreach ($tables as $table) {
            $meta = new meta($table, $this->get_fields($table));
            $meta->create(self::$outputdir);
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

}
