<?php

namespace Hitek\Slimez\App\Models;

use Exception;
use Hitek\Slimez\Core\BaseModel;
use Hitek\Slimez\Core\Exceptions;

class UserVpnFilesModel extends BaseModel
{
    protected $configId;
    protected $userId;
    protected $status;

    protected $tableNames = ['userVpnFiles'];

    // Getters and Setters
    public function getConfigId()
    {
        return $this->configId;
    }

    public function setConfigId($configId): self
    {
        $this->configId = $configId;
        return $this;
    }

    public function getUserId()
    {
        return $this->userId;
    }

    public function setUserId($userId): self
    {
        $this->userId = $userId;
        return $this;
    }

    public function getStatus()
    {
        return $this->status;
    }

    public function setStatus($status): self
    {
        $this->status = $status;
        return $this;
    }

    // CRUD Methods
    // selectQuery() Implementation
    public function selectQuery()
    {
        try {
            return BaseModel::query()
                ->select($this->tableNames[0])
                ->where("configId = ? || userId = ?", [$this->configId, $this->userId])
                ->first();
        } catch (Exception $e) {
            Exceptions::exceptionHandler($e);
        }
    }

    // insertQuery() Implementation
    public function insertQuery()
    {
        try {
            return BaseModel::query()
                ->insert($this->tableNames[0], array_filter([
                    'configId' => $this->configId,
                    'userId' => $this->userId,
                    'status' => $this->status,
                ]))
                ->save();
        } catch (Exception $e) {
            Exceptions::exceptionHandler($e);
        }
    }

    // updateQuery() Implementation
    public function updateQuery()
    {

        $updateData = array_filter([
            'userId' => $this->userId,
            'status' => $this->status,
        ]);

        if (empty($updateData)) {
            return false; // No data to update
        }

        try {
            return BaseModel::query()
                ->update(tableName: $this->tableNames[0], dataValues: $updateData)
                ->where("configId = ? || userId = ?", [$this->configId, $this->userId])
                ->save();
        } catch (Exception $e) {
            Exceptions::exceptionHandler($e);
        }
    }

    // deleteQuery() Implementation
    public function deleteQuery()
    {
        try {
            return BaseModel::query()
                ->delete($this->tableNames[0])
                ->where("configId = ? || userId = ?", [$this->configId, $this->userId])
                ->save();
        } catch (Exception $e) {
            Exceptions::exceptionHandler($e);
        }
    }
}
