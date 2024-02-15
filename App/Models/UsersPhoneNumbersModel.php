<?php

namespace Hitek\Slimez\App\Models;

use Exception;
use Hitek\Slimez\Core\BaseModel;
use Hitek\Slimez\Core\Exceptions;

class UsersPhoneNumbersModel
{
    protected $usersPhoneId;
    protected $userId;
    protected $phoneNumber1;
    protected $phoneNumber2; // Optional, could be null
    protected $status;

    private $tableNames = ['usersPhoneNumbers'];

    // Setters
    public function setUsersPhoneId($usersPhoneId)
    {
        $this->usersPhoneId = $usersPhoneId;
        return $this;
    }
    public function setUserId($userId)
    {
        $this->userId = $userId;
        return $this;
    }
    public function setPhoneNumber1($phoneNumber1)
    {
        $this->phoneNumber1 = $phoneNumber1;
        return $this;
    }
    public function setPhoneNumber2($phoneNumber2)
    {
        $this->phoneNumber2 = $phoneNumber2;
        return $this;
    }
    public function setStatus($status)
    {
        $this->status = $status;
        return $this;
    }

    // Getters
    public function getUsersPhoneId()
    {
        return $this->usersPhoneId;
    }
    public function getUserId()
    {
        return $this->userId;
    }
    public function getPhoneNumber1()
    {
        return $this->phoneNumber1;
    }
    public function getPhoneNumber2()
    {
        return $this->phoneNumber2;
    }
    public function getStatus()
    {
        return $this->status;
    }

    // CRUD Operations

    // Select a user phone number record
    public function selectQuery()
    {
        try {
            return BaseModel::query()
                ->select(tableName: $this->tableNames[0])
                ->where("usersPhoneId = ?", [$this->usersPhoneId])
                ->first();
        } catch (Exception $e) {
            Exceptions::exceptionHandler($e);
        }
    }

    // Insert a new user phone number record
    public function insertQuery()
    {
        try {
            $insertData = [
                'usersPhoneId' => $this->usersPhoneId,
                'userId' => $this->userId,
                'phoneNumber1' => $this->phoneNumber1,
                'phoneNumber2' => $this->phoneNumber2,
                'status' => $this->status,
            ];

            return BaseModel::query()
                ->insert(tableName: $this->tableNames[0], query: $insertData)
                ->save();
        } catch (Exception $e) {
            Exceptions::exceptionHandler($e);
        }
    }

    // Update a user phone number record
    public function updateQuery()
    {
        try {
            $updateData = [
                'phoneNumber1' => $this->phoneNumber1,
                'phoneNumber2' => $this->phoneNumber2,
                'status' => $this->status,
            ];

            return BaseModel::query()
                ->update(tableName: $this->tableNames[0], dataValues: $updateData)
                ->where("usersPhoneId = ?", [$this->usersPhoneId])
                ->save();
        } catch (Exception $e) {
            Exceptions::exceptionHandler($e);
        }
    }

    // Delete a user phone number record
    public function deleteQuery()
    {
        try {
            if (empty($this->usersPhoneId)) {
                return false; // Handle error: No identifier provided
            }
            return BaseModel::query()
                ->delete(tableName: $this->tableNames[0])
                ->where("usersPhoneId = ?", [$this->usersPhoneId])
                ->save();
        } catch (Exception $e) {
            Exceptions::exceptionHandler($e);
        }
    }
}
