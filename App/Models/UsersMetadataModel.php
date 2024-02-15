<?php

namespace Hitek\Slimez\App\Models;

use Exception;
use Hitek\Slimez\Core\BaseModel;
use Hitek\Slimez\Core\Exceptions;

class UsersMetadataModel
{
    protected $usersMetaId;
    protected $userId;
    protected $countryOfResidence;
    protected $cityOfResidence;
    protected $villageRepresented;
    protected $currentEducationLevel;
    protected $status;

    private $tableNames = ['usersMetadata'];

    // Setters
    public function setMetadataId($metadataId)
    {
        $this->usersMetaId = $metadataId;
        return $this;
    }
    public function setUserId($userId)
    {
        $this->userId = $userId;
        return $this;
    }
    public function setCountryOfResidence($countryOfResidence)
    {
        $this->countryOfResidence = $countryOfResidence;
        return $this;
    }
    public function setCityOfResidence($cityOfResidence)
    {
        $this->cityOfResidence = $cityOfResidence;
        return $this;
    }
    public function setVillageRepresented($villageRepresented)
    {
        $this->villageRepresented = $villageRepresented;
        return $this;
    }
    public function setCurrentEducationLevel($currentEducationLevel)
    {
        $this->currentEducationLevel = $currentEducationLevel;
        return $this;
    }

    public function setStatus($status)
    {
        $this->status = $status;
        return $this;
    }

    // Getters
    public function getMetadataId()
    {
        return $this->usersMetaId;
    }
    public function getUserId()
    {
        return $this->userId;
    }
    public function getCountryOfResidence()
    {
        return $this->countryOfResidence;
    }
    public function getCityOfResidence()
    {
        return $this->cityOfResidence;
    }
    public function getVillageRepresented()
    {
        return $this->villageRepresented;
    }
    public function getCurrentEducationLevel()
    {
        return $this->currentEducationLevel;
    }
    public function getStatus()
    {
        return $this->status;
    }

    // CRUD Operations

    // Select a user metadata record
    public function selectQuery()
    {
        try {
            return BaseModel::query()
                ->select(tableName: $this->tableNames[0])
                ->where("usersMetaId = ?", [$this->usersMetaId])
                ->first();
        } catch (Exception $e) {
            Exceptions::exceptionHandler($e);
            return null;
        }
    }

    // Insert a new user metadata record
    public function insertQuery()
    {
        try {
            $insertData = [
                'usersMetaId' => $this->usersMetaId,
                'userId' => $this->userId,
                'countryOfResidence' => $this->countryOfResidence,
                'cityOfResidence' => $this->cityOfResidence,
                'villageRepresented' => $this->villageRepresented,
                'currentEducationLevel' => $this->currentEducationLevel,
                'status' => $this->status,
            ];

            return BaseModel::query()
                ->insert(tableName: $this->tableNames[0], query: $insertData)
                ->save();
        } catch (Exception $e) {
            Exceptions::exceptionHandler($e);
            return null;
        }
    }

    // Update a user metadata record
    public function updateQuery()
    {
        try {
            $updateData = [
                'countryOfResidence' => $this->countryOfResidence,
                'cityOfResidence' => $this->cityOfResidence,
                'villageRepresented' => $this->villageRepresented,
                'currentEducationLevel' => $this->currentEducationLevel,
                'status' => $this->status,
            ];

            return BaseModel::query()
                ->update(tableName: $this->tableNames[0], dataValues: $updateData)
                ->where("usersMetaId = ?", [$this->usersMetaId])
                ->save();
        } catch (Exception $e) {
            Exceptions::exceptionHandler($e);
            return null;
        }
    }

    // Delete a user metadata record
    public function deleteQuery()
    {
        try {
            if (empty($this->usersMetaId)) {
                // Handle error: No identifier provided
                throw new Exception("No metadataId provided for delete operation.");
            }
            return BaseModel::query()
                ->delete(tableName: $this->tableNames[0])
                ->where("usersMetaId = ?", [$this->usersMetaId])
                ->save();
        } catch (Exception $e) {
            Exceptions::exceptionHandler($e);
            return null;
        }
    }
}
