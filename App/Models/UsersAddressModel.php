<?php

namespace Hitek\Slimez\App\Models;

use Exception;
use Hitek\Slimez\Core\BaseModel;
use Hitek\Slimez\Core\Exceptions;

class UsersAddressModel
{
    protected $addressId;
    protected $userId;
    protected $address1;
    protected $address2;
    protected $status;

    private $tableNames = ['usersAddress'];

    // Setters
    public function setAddressId($addressId)
    {
        $this->addressId = $addressId;
        return $this;
    }
    public function setUserId($userId)
    {
        $this->userId = $userId;
        return $this;
    }
    public function setAddress1($address1)
    {
        $this->address1 = $address1;
        return $this;
    }
    public function setAddress2($address2)
    {
        $this->address2 = $address2;
        return $this;
    }
    public function setStatus($status)
    {
        $this->status = $status;
        return $this;
    }

    // Getters
    public function getAddressId()
    {
        return $this->addressId;
    }
    public function getUserId()
    {
        return $this->userId;
    }
    public function getAddress1()
    {
        return $this->address1;
    }
    public function getAddress2()
    {
        return $this->address2;
    }
    
    public function getStatus()
    {
        return $this->status;
    }

    // CRUD Operations

    // Select a user address record
    public function selectQuery()
    {
        try {
            return BaseModel::query()
                ->select(tableName: $this->tableNames[0])
                ->where("addressId = ?", [$this->addressId])
                ->first();
        } catch (Exception $e) {
            Exceptions::exceptionHandler($e);
        }
    }

    // Insert a new user address record
    public function insertQuery()
    {
        try {
            $insertData = [
                'addressId' => $this->addressId,
                'userId' => $this->userId,
                'address1' => $this->address1,
                'address2' => $this->address2,
                'status' => $this->status,
            ];

            return BaseModel::query()
                ->insert(tableName: $this->tableNames[0], query: $insertData)
                ->save();
        } catch (Exception $e) {
            Exceptions::exceptionHandler($e);
        }
    }

    // Update a user address record
    public function updateQuery()
    {
        try {
            $updateData = [
                'address1' => $this->address1,
                'address2' => $this->address2,
                'status' => $this->status,
            ];

            return BaseModel::query()
                ->update(tableName: $this->tableNames[0], dataValues: $updateData)
                ->where("addressId = ?", [$this->addressId])
                ->save();
        } catch (Exception $e) {
            Exceptions::exceptionHandler($e);
        }
    }

    // Delete a user address record
    public function deleteQuery()
    {
        try {
            if (empty($this->addressId)) {
                return false; // Handle error: No identifier provided
            }
            return BaseModel::query()
                ->delete(tableName: $this->tableNames[0])
                ->where("addressId = ?", [$this->addressId])
                ->save();
        } catch (Exception $e) {
            Exceptions::exceptionHandler($e);
        }
    }
}
