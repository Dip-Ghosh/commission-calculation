<?php

namespace App\Http\Traits;

trait DepositTrait
{

    public function getDepositCommission($amount): float
    {

        return $amount * 0.03 / 100;
    }

}
