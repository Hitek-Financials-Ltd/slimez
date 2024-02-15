<?php

namespace Hitek\Slimez\App\Models;

use Exception;
use Hitek\Slimez\Core\BaseModel;
use Hitek\Slimez\Core\Exceptions;

class OaadElectionModel
{
    protected $electionId;
    protected $electionYear;
    protected $electionPositions;
    protected $status;

    private $tableNames = ['oaadElection'];

    // Setters
    public function setElectionId($electionId)
    {
        $this->electionId = $electionId;
    }
    public function setElectionYear($electionYear)
    {
        $this->electionYear = $electionYear;
    }
    public function setElectionPositions($electionPositions)
    {
        $this->electionPositions = $electionPositions;
    }
    public function setStatus($status)
    {
        $this->status = $status;
    }

    // Getters
    public function getElectionId()
    {
        return $this->electionId;
    }
    public function getElectionYear()
    {
        return $this->electionYear;
    }
    public function getElectionPositions()
    {
        return $this->electionPositions;
    }
    public function getStatus()
    {
        return $this->status;
    }

    // CRUD Operations

    // Select an election record
    public function selectQuery()
    {
        try {
            return BaseModel::query()
                ->select(tableName: $this->tableNames[0])
                ->where("electionId = ?", [$this->electionId])
                ->first();
        } catch (Exception $e) {
            Exceptions::exceptionHandler($e);
        }
    }

    // Insert a new election record
    public function insertQuery()
    {
        try {
            $insertData = [
                'electionId' => $this->electionId,
                'electionYear' => $this->electionYear,
                'electionPositions' => $this->electionPositions,
                'status' => $this->status,
            ];

            return BaseModel::query()
                ->insert(tableName: $this->tableNames[0], query: $insertData)
                ->save();
        } catch (Exception $e) {
            Exceptions::exceptionHandler($e);
        }
    }

    // Update an election record
    public function updateQuery()
    {
        try {
            $updateData = array_filter([
                'electionYear' => $this->electionYear,
                'electionPositions' => $this->electionPositions,
                'status' => $this->status,
            ], function ($value) {
                return !is_null($value);
            });

            if (empty($updateData)) {
                return false; // No data to update
            }

            return BaseModel::query()
                ->update(tableName: $this->tableNames[0], dataValues: $updateData)
                ->where("electionId = ?", [$this->electionId])
                ->save();
        } catch (Exception $e) {
            Exceptions::exceptionHandler($e);
        }
    }

    // Delete an election record
    public function deleteQuery()
    {
        try {
            if (empty($this->electionId)) {
                return false; // Handle error: No identifier provided
            }
            return BaseModel::query()
                ->delete(tableName: $this->tableNames[0])
                ->where("electionId = ?", [$this->electionId])
                ->save();
        } catch (Exception $e) {
            Exceptions::exceptionHandler($e);
        }
    }
}
