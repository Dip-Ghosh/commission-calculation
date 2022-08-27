<?php

namespace App\Service;

use App\Http\Traits\DepositTrait;
use App\Strategy\CommissionStrategy;
use App\Strategy\UserTypeStrategy;

class FileService
{
    use DepositTrait;
    private $userStrategy;

    public function __construct( UserTypeStrategy $userStrategy )
    {
        $this->userStrategy       = $userStrategy;
    }

    /**
     * @details This function will process the file and return the data
     *
     * @param $file
     * @return array
     */
    public function  getFileContent($file): array
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

        if (!empty($fileContents))
        {
            foreach ($fileContents as  $fileContent)
            {
                $date                = date_format( date_create( $fileContent[0] ) ,"Y-m-d");
                $userId              = $fileContent[1];
                $UserType            = $fileContent[2];
                $commissionType      = $fileContent[3];
                $amount              = $fileContent[4];
                $currency            = $fileContent[5];
                $year                = explode( '-', $date )[0];
                $isJanuary           = ( date("m", strtotime( $date ) ) === '01' );

                $user                = $this->userStrategy->getUserType($UserType);
                $OperationType       =  config('commission.operation_type');

                if ($commissionType === $OperationType[0])
                {
                    $data [] = $user->calculateWithdrawCommission($amount);

            }
                else {
                    $data [] = $this->getDepositCommission($amount);
                }

            }
        }

        return $data;





            $commissionFee = 0;
//            $user = new UserController( $userId );
//            if ( $kindOfUser === 'private' && $kindOfCommissionFee === 'withdraw' ) {
//                // setWithdrawInWeekForPrivateUserByDate
//                $commisionFee->setWithdrawInWeekForPrivateUserByDate( $userId, $date, $value, $currency );
//                $withdrawInWeekForPrivateUser = $commisionFee->getWithdrawInWeekForPrivateUserByDate( $userId, $date );
//                $lastWithdrawInWeekForPrivateUser = $withdrawInWeekForPrivateUser[ count( $withdrawInWeekForPrivateUser ) - 1 ];
//                $exceeded1000 = $lastWithdrawInWeekForPrivateUser["exceeded1000"];
//                $firstWeekOnDecemberFromBeforeYearValueInEuro = $commisionFee->getWeekOnDecemberFromBeforeYearValueInEuro( $userId, $year - 1 );
//
//                if ( $user->isFreeWithdraw( $withdrawInWeekForPrivateUser ) ) {
//                    $commissionFee = $value * 0.3 / 100;
//                } else if ( $isJanuary && $exceeded1000 <= 1000 && $firstWeekOnDecemberFromBeforeYearValueInEuro > 1000 ) {
//                    $commissionFee = $value * 0.3 / 100;
//                } else if ( $exceeded1000 > 0 ) {
//                    // $commissionFee = 222222222;
//                    $commissionFee = $exceeded1000 * 0.3 / 100;
//                }
//            } else if( $kindOfCommissionFee === 'deposit' ) {
//                $commissionFee = $value * 0.03 / 100;
//            } else if( $kindOfUser === 'business' ) {
//                $commissionFee = $value * 0.5 / 100;
//            }

//            echo '<pre>';
//            // var_dump( $row );
//            var_dump( round( $commissionFee, 2 ) );
//            echo '</pre>';

    }
}
