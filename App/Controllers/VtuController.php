<?php
namespace Hitek\Slimez\App\Controllers;
use Hitek\Slimez\Core\BaseController;

class VtuController extends BaseController{

    public function airtime(){
        echo  "Buy your airtime";
    }

    public function data($params = null){
        echo json_encode($params);
        echo  "by data ";
    }
}