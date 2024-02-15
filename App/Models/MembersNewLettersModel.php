<?php

namespace Hitek\Slimez\App\Models;

use Exception;
use Hitek\Slimez\Core\BaseModel;
use Hitek\Slimez\Core\Exceptions;

class MembersNewLettersModel
{
    protected $newsLettersEmailId;
    protected $email;
    protected $status;

    private $tableNames = ['membersNewLetters'];

    // Setters
    public function setNewsLettersEmailId($newsLettersEmailId)
    {
        $this->newsLettersEmailId = $newsLettersEmailId;
    }
    public function setEmail($email)
    {
        $this->email = $email;
    }
    public function setStatus($status)
    {
        $this->status = $status;
    }

    // Getters
    public function getNewsLettersEmailId()
    {
        return $this->newsLettersEmailId;
    }
    public function getEmail()
    {
        return $this->email;
    }
    public function getStatus()
    {
        return $this->status;
    }

    // CRUD Operations

    // Select a newsletter subscription record
    public function selectQuery()
    {
        try {
            return BaseModel::query()
                ->select(tableName: $this->tableNames[0])
                ->where("newsLettersEmailId = ?", [$this->newsLettersEmailId])
                ->first();
        } catch (Exception $e) {
            Exceptions::exceptionHandler($e);
        }
    }

    // Insert a new newsletter subscription record
    public function insertQuery()
    {
        try {
            $insertData = [
                'newsLettersEmailId' => $this->newsLettersEmailId,
                'email' => $this->email,
                'status' => $this->status,
            ];

            return BaseModel::query()
                ->insert(tableName: $this->tableNames[0], query: $insertData)
                ->save();
        } catch (Exception $e) {
            Exceptions::exceptionHandler($e);
        }
    }

    // Update a newsletter subscription record
    public function updateQuery()
    {
        try {
            $updateData = array_filter([
                'email' => $this->email,
                'status' => $this->status,
            ], function ($value) {
                return !is_null($value);
            });

            if (empty($updateData)) {
                return false; // No data to update
            }

            return BaseModel::query()
                ->update(tableName: $this->tableNames[0], dataValues: $updateData)
                ->where("newsLettersEmailId = ?", [$this->newsLettersEmailId])
                ->save();
        } catch (Exception $e) {
            Exceptions::exceptionHandler($e);
        }
    }

    // Delete a newsletter subscription record
    public function deleteQuery()
    {
        try {
            if (empty($this->newsLettersEmailId)) {
                return false; // Handle error: No identifier provided
            }
            return BaseModel::query()
                ->delete(tableName: $this->tableNames[0])
                ->where("newsLettersEmailId = ?", [$this->newsLettersEmailId])
                ->save();
        } catch (Exception $e) {
            Exceptions::exceptionHandler($e);
        }
    }
}
