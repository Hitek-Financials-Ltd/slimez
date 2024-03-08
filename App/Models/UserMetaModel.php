<?php

namespace Hitek\Slimez\App\Models;

use Exception;
use Hitek\Slimez\Core\BaseModel;
use Hitek\Slimez\Core\Exceptions;

class UserMetaModel extends BaseModel
{
    protected $metaId;
    protected $userId;
    protected $ipAddress;
    protected $device;
    protected $isOnline;

    protected $tableNames = ['user_meta'];

    public function getMetaId()
    {
        return $this->metaId;
    }
    public function setMetaId($metaId)
    {
        $this->metaId = $metaId;
        return $this;
    }


    public function getIsOnline()
    {
        return $this->isOnline;
    }
    public function setIsOnline($isOnline)
    {
        $this->isOnline = $isOnline;
        return $this;
    }

    public function getUserId()
    {
        return $this->userId;
    }
    public function setUserId($userId)
    {
        $this->userId = $userId;
        return $this;
    }

    public function getIpAddress()
    {
        return $this->ipAddress;
    }
    public function setIpAddress($ipAddress)
    {
        $this->ipAddress = $ipAddress;
        return $this;
    }

    public function getDevice()
    {
        return $this->device;
    }
    public function setDevice($device)
    {
        $this->device = $device;
        return $this;
    }

    public function selectQuery()
    {
        try {
            return BaseModel::query()->select($this->tableNames[0])
                ->where("metaId = ? || userId = ?", [$this->metaId, $this->userId])->first();
        } catch (Exception $e) {
            Exceptions::exceptionHandler($e);
        }
    }

    public function insertQuery($isTransaction = false)
    { 

        $insertMetaData = array_filter([
            'metaId' => $this->metaId,
            'userId' => $this->userId,
            'ipAddress' => $this->ipAddress,
            'device' => $this->device,
        ]);

        try {
            if ($isTransaction) {
                $tranData = [
                    /**tables */
                     $this->tableNames,
                     [
                        /**first table data */
                        $insertMetaData
                        /**second table data */
                    ],
                ];
                return BaseModel::query()->insertDbTransact($tranData)->save();
            }
            /**single insert */
            return BaseModel::query()->insert($this->tableNames[0], $insertMetaData)->save();
        } catch (Exception $e) {
            Exceptions::exceptionHandler($e);
        }
    }

    public function updateQuery()
    {

        
        $updateData = array_filter([
            "ipAddress" => $this->ipAddress,
            "device" => $this->device,
            "isOnline" => $this->isOnline,
        ]);

        if($this->device == 0){
            $updateData["device"] = $this->device;
        }

        if (empty($updateData)) {
            return false; // No data to update
        }

        try {
            return BaseModel::query()
                ->update(tableName: $this->tableNames[0], dataValues: $updateData)
                ->where("metaId = ? || userId = ?", [$this->metaId, $this->userId])
                ->save();
        } catch (Exception $e) {
            Exceptions::exceptionHandler($e);
        }
    }

    public function deleteQuery()
    {
        try {
            return BaseModel::query()->delete($this->tableNames[0])
                ->where("metaId = ? || userId = ?", [$this->metaId, $this->userId])->save();
        } catch (Exception $e) {
            Exceptions::exceptionHandler($e);
        }
    }
}
