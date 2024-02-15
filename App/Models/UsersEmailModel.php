<?php

namespace Hitek\Slimez\App\Models;

use Exception;
use Hitek\Slimez\Core\BaseModel;
use Hitek\Slimez\Core\Exceptions;

class UsersEmailModel
{
    protected $usersEmailId;
    protected $userId;
    protected $email1;
    protected $email2; // Optional, might be null for some users
    protected $status;

    private $tableNames = ['usersEmail'];

    // Setters
    public function setUsersEmailId($usersEmailId)
    {
        $this->usersEmailId = $usersEmailId;
        return $this;
    }
    public function setUserId($userId)
    {
        $this->userId = $userId;
        return $this;
    }
    public function setEmail1($email1)
    {
        $this->email1 = $email1;
        return $this;
    }
    public function setEmail2($email2)
    {
        $this->email2 = $email2;
        return $this;
    }
    public function setStatus($status)
    {
        $this->status = $status;
        return $this;
    }

    // Getters
    public function getUsersEmailId()
    {
        return $this->usersEmailId;
    }
    public function getUserId()
    {
        return $this->userId;
    }
    public function getEmail1()
    {
        return $this->email1;
    }
    public function getEmail2()
    {
        return $this->email2;
    }
    public function getStatus()
    {
        return $this->status;
    }

    // CRUD Operations

    // Select a user email record
    public function selectQuery()
    {
        try {
            return BaseModel::query()
                ->select(tableName: $this->tableNames[0])
                ->where("usersEmailId = ?", [$this->usersEmailId])
                ->first();
        } catch (Exception $e) {
            Exceptions::exceptionHandler($e);
        }
    }

    // Insert a new user email record
    public function insertQuery()
    {
        try {
            $insertData = [
                'usersEmailId' => $this->usersEmailId,
                'userId' => $this->userId,
                'email1' => $this->email1,
                'email2' => $this->email2,
                'status' => $this->status,
            ];

            return BaseModel::query()
                ->insert(tableName: $this->tableNames[0], query: $insertData)
                ->save();
        } catch (Exception $e) {
            Exceptions::exceptionHandler($e);
        }
    }

    // Update a user email record
    public function updateQuery()
    {
        try {
            $updateData = [
                'email1' => $this->email1,
                'email2' => $this->email2,
                'status' => $this->status,
            ];

            return BaseModel::query()
                ->update(tableName: $this->tableNames[0], dataValues: $updateData)
                ->where("usersEmailId = ?", [$this->usersEmailId])
                ->save();
        } catch (Exception $e) {
            Exceptions::exceptionHandler($e);
        }
    }

    // Delete a user email record
    public function deleteQuery()
    {
        try {
            if (empty($this->usersEmailId)) {
                return false; // Handle error: No identifier provided
            }
            return BaseModel::query()
                ->delete(tableName: $this->tableNames[0])
                ->where("usersEmailId = ?", [$this->usersEmailId])
                ->save();
        } catch (Exception $e) {
            Exceptions::exceptionHandler($e);
        }
    }
}
