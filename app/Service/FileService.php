<?php

namespace App\Service;

use App\Http\Traits\DepositTrait;
use App\Strategy\CommissionStrategy;
use App\Strategy\UserTypeStrategy;

class FileService
{
    use DepositTrait;

    private $userStrategy;

    public function __construct(UserTypeStrategy $userStrategy)
    {
        $this->userStrategy = $userStrategy;
    }

    /**
     * @details This function will process the file and return the data
     *
     * @param $file
     * @return array
     */
    public function getFileContent($file): array
    {

        $fileContent = [];

        if (($handle = fopen($file, "r")) !== FALSE) {

            while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {

                $fileContent[] = $data;
            }

            fclose($handle);
        }

        return $fileContent;
    }


    public function processParams($fileContents)
    {
        $data = [];

        if (!empty($fileContents)) {
            foreach ($fileContents as $fileContent) {
                $date = date_format(date_create($fileContent[0]), "Y-m-d");
                $userId = $fileContent[1];
                $UserType = $fileContent[2];
                $commissionType = $fileContent[3];
                $amount = $fileContent[4];
                $currency = $fileContent[5];
                $year = explode('-', $date)[0];
                $isJanuary = (date("m", strtotime($date)) === '01');

                $user = $this->userStrategy->getUserType($UserType);
                $OperationType = config('commission.operation_type');

                if ($commissionType === $OperationType[0]) {
                    $data [] = $user->calculateWithdrawCommission($amount);

                } else {
                    $data [] = $this->getDepositCommission($amount);
                }

            }
        }

        return $data;

    }
}
