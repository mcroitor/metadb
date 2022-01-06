<?php

/*
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/PHPClass.php to edit this template
 */

namespace core\db;

/**
 * Description of db_description
 *
 * @author XiaomiPRO
 */
class db_description {

    private $tables;
    
    public function __construct() {
        $this->tables = [];
    }
    
    public function add_table(string $table_name, array $rows): void {
        $this->tables[$table_name] = $rows;
    }
    
    public function get_tables(): array {
        return $this->tables;
    }
    
    public function get_table(string $table_name): array {
        return $this->tables[$table_name] ?? [];
    }
}
