<?php
    
namespace Hitek\Slimez\App\Models;

use Exception;
use Hitek\Slimez\Core\BaseModel;
use Hitek\Slimez\Core\Exceptions;

class ServerSettingsModel extends BaseModel{

    protected $settingsId;
    protected $paymentGateWay = 1; // Default value for payment gateway
    protected $isOnMaintenance = 0; // Default value for maintenance status
    protected $tableNames = array('server_settings');

    // Getter for settingsId
    public function getSettingsId() {
        return $this->settingsId;
    }

    // Getter for paymentGateWayserver_settings
    public function getPaymentGateWay() {
        return $this->paymentGateWay;
    }

    // Getter for isOnMaintenance
    public function getIsOnMaintenance() {
        return $this->isOnMaintenance;
    }

    // Setter for settingsId
    public function setSettingsId($settingsId) {
        $this->settingsId = $settingsId;
        return $this; // Chaining
    }

    // Setter for paymentGateWay
    public function setPaymentGateWay($paymentGateWay) {
        $this->paymentGateWay = $paymentGateWay;
        return $this; // Chaining
    }

    // Setter for isOnMaintenance
    public function setIsOnMaintenance($isOnMaintenance) {
        $this->isOnMaintenance = $isOnMaintenance;
        return $this; // Chaining
    }

    public function selectQuery(bool $isAll = false)
    {
        try {
            if($isAll){
                return BaseModel::query()
                ->select($this->tableNames[0])
                ->where("settingsId != ?", [$this->settingsId])
                ->get();
            }

            return BaseModel::query()->select($this->tableNames[0])
                ->where("settingsId != ?", [$this->settingsId])->first();
        } catch (Exception $e) {
            Exceptions::exceptionHandler($e);
        }
    }

    public function insertQuery()
    {
        try {
            $insertData = array_filter([
                'settingsId' => $this->settingsId,
                'paymentGateWay' => $this->paymentGateWay,
                'isOnMaintenance' => $this->isOnMaintenance
            ]);

            return BaseModel::query()->insert($this->tableNames[0], $insertData)->save();
        } catch (Exception $e) {
            Exceptions::exceptionHandler($e);
        }
    }

    public function updateQuery()
    {
        try {
            $updateData = array_filter([
                'paymentGateWay' => $this->paymentGateWay,
                'isOnMaintenance' => $this->isOnMaintenance
            ]);

            return BaseModel::query()->update($this->tableNames[0], $updateData)
                ->where("settingsId = ?", [$this->settingsId])->save();
        } catch (Exception $e) {
            Exceptions::exceptionHandler($e);
        }
    }

    public function deleteQuery()
    {
        try {
            return BaseModel::query()->delete($this->tableNames[0])
                ->where("settingsId = ?", [$this->settingsId])
                ->save();
        } catch (Exception $e) {
            Exceptions::exceptionHandler($e);
        }
    }

}
