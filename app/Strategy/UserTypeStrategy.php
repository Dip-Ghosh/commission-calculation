<?php

namespace App\Strategy;

use App\Repository\BusinessCommissionCalculation;
use App\Repository\PrivateCommissionCalculation;

class UserTypeStrategy
{

    public function getUserType($userType)
    {
        $type =  config('commission.user_type');

        if ($userType === $type[0]) {
            return new PrivateCommissionCalculation();
        }
        else {
            return new BusinessCommissionCalculation();
        }
    }

}
