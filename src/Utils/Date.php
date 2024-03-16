<?php
namespace Utils;

class Date {
    static public function strToTimestamp(string $str): int {
        return (new \DateTime($str))->getTimestamp();
    }
}