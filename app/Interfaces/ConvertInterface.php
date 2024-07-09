<?php

namespace App\Interfaces;

interface ConvertInterface
{
    public function toUnit($distance, $unit);
    public function toDecimals($distance, $decimals);
}
