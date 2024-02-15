<?php

namespace Hitek\Slimez\App\Models;

use Exception;
use Hitek\Slimez\Core\BaseModel;
use Hitek\Slimez\Core\Exceptions;

class OaadProjectsModel
{
    protected $projectId;
    protected $projectName;
    protected $projectNumber;
    protected $projectDesc;
    protected $projectLocation;
    protected $projectStartDate;
    protected $projectEndDate;
    protected $status;
    protected $createdAt;

    private $tableNames = ['oaadProjects'];

    // Setters
    public function setProjectId($projectId)
    {
        $this->projectId = $projectId;
    }
    public function setProjectName($projectName)
    {
        $this->projectName = $projectName;
    }
    public function setProjectNumber($projectNumber)
    {
        $this->projectNumber = $projectNumber;
    }
    public function setProjectDesc($projectDesc)
    {
        $this->projectDesc = $projectDesc;
    }
    public function setProjectLocation($projectLocation)
    {
        $this->projectLocation = $projectLocation;
    }
    public function setProjectStartDate($projectStartDate)
    {
        $this->projectStartDate = $projectStartDate;
    }
    public function setProjectEndDate($projectEndDate)
    {
        $this->projectEndDate = $projectEndDate;
    }
    public function setStatus($status)
    {
        $this->status = $status;
    }
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;
    }

    // Getters
    public function getProjectId()
    {
        return $this->projectId;
    }
    public function getProjectName()
    {
        return $this->projectName;
    }
    public function getProjectNumber()
    {
        return $this->projectNumber;
    }
    public function getProjectDesc()
    {
        return $this->projectDesc;
    }
    public function getProjectLocation()
    {
        return $this->projectLocation;
    }
    public function getProjectStartDate()
    {
        return $this->projectStartDate;
    }
    public function getProjectEndDate()
    {
        return $this->projectEndDate;
    }
    public function getStatus()
    {
        return $this->status;
    }
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    // CRUD Operations

    // Select a project record
    public function selectQuery()
    {
        try {
            return BaseModel::query()
                ->select(tableName: $this->tableNames[0])
                ->where("projectId = ?", [$this->projectId])
                ->first();
        } catch (Exception $e) {
            Exceptions::exceptionHandler($e);
        }
    }

    // Insert a new project record
    public function insertQuery()
    {
        try {
            $insertData = [
                'projectId' => $this->projectId,
                'projectName' => $this->projectName,
                'projectNumber' => $this->projectNumber,
                'projectDesc' => $this->projectDesc,
                'projectLocation' => $this->projectLocation,
                'projectStartDate' => $this->projectStartDate,
                'projectEndDate' => $this->projectEndDate,
                'status' => $this->status,
                'createdAt' => $this->createdAt,
            ];

            return BaseModel::query()
                ->insert(tableName: $this->tableNames[0], query: $insertData)
                ->save();
        } catch (Exception $e) {
            Exceptions::exceptionHandler($e);
        }
    }

    // Update a project record
    public function updateQuery()
    {
        try {
            $updateData = array_filter([
                'projectName' => $this->projectName,
                'projectNumber' => $this->projectNumber,
                'projectDesc' => $this->projectDesc,
                'projectLocation' => $this->projectLocation,
                'projectStartDate' => $this->projectStartDate,
                'projectEndDate' => $this->projectEndDate,
                'status' => $this->status,
                // Note: Typically, createdAt would not be updated.
            ], function ($value) {
                return !is_null($value);
            });

            if (empty($updateData)) {
                return false; // No data to update
            }

            return BaseModel::query()
                ->update(tableName: $this->tableNames[0], dataValues: $updateData)
                ->where("projectId = ?", [$this->projectId])
                ->save();
        } catch (Exception $e) {
            Exceptions::exceptionHandler($e);
        }
    }

    // Delete a project record
    public function deleteQuery()
    {
        try {
            if (empty($this->projectId)) {
                return false; // Handle error: No identifier provided
            }
            return BaseModel::query()
                ->delete(tableName: $this->tableNames[0])
                ->where("projectId = ?", [$this->projectId])
                ->save();
        } catch (Exception $e) {
            Exceptions::exceptionHandler($e);
        }
    }
}
