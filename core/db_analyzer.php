<?php

namespace core;

/**
 * Description of db_analyzer
 *
 * @author XiaomiPRO
 */
class db_analyzer implements \core\api\analyzer{
    private $db;
    public function analyze(db\options $data): db\db_description {
        $this->db = new db\database($data);
    }
    protected function get_tables(string $database): array {
        $tables = [];
    }
}
