<?php

namespace core\api;

interface generator {
    public function generate(object $data): string;
}