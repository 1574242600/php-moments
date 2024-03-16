<?php

namespace Utils\Interface;

interface View
{
    public static function render(array $params): string;
}
