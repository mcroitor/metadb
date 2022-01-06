<?php

namespace core;

interface meta {
    public function create(string $table, array $fields): string;
}