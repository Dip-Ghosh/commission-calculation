<?php

namespace App\Repository;

class BusinessCommissionCalculation
{

    public function calculateWithdrawCommission($amount): float
    {
        return  $amount * 0.5 / 100;
    }
}
