<?php

namespace core\api;

interface analyzer {
    public function analyze(object $data): object;
}