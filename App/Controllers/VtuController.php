<?php
namespace Hitek\Slimez\App\Controllers;
use Hitek\Slimez\Core\BaseController;
use Hitek\Slimez\Core\ReloadlyVTUandGiftCard;

class VtuController extends BaseController{

    public function airtime($params = null){
        $reloadly = new ReloadlyVTUandGiftCard();
        echo json_encode($reloadly->accountBalance());
        return;
    }

    public function data($params = null){
        echo json_encode($params);
        echo  "by data ";
    }

    public function balance($params = null){
        $reloadly = new ReloadlyVTUandGiftCard();

        $reloadlyData =  $reloadly->reloadOperatorPromotions();
        echo $reloadlyData;
        return;
    }

    public function education($params = null){
        
    }

    public function electricity($params = null){

    }
}