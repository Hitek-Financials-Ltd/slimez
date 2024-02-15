<?php

namespace Hitek\Slimez\App\Models;

use Exception;
use Hitek\Slimez\Core\BaseModel;
use Hitek\Slimez\Core\Exceptions;

class ProjectSponsorsModel
{
    protected $sponsorsId;
    protected $projectId;
    protected $sponsorName;
    protected $sponsorLogo;
    protected $sponsorWebsite;
    protected $status;

    private $tableNames = ['projectSponsors'];

    // Setters
    public function setSponsorsId($sponsorsId)
    {
        $this->sponsorsId = $sponsorsId;
    }
    public function setProjectId($projectId)
    {
        $this->projectId = $projectId;
    }
    public function setSponsorName($sponsorName)
    {
        $this->sponsorName = $sponsorName;
    }
    public function setSponsorLogo($sponsorLogo)
    {
        $this->sponsorLogo = $sponsorLogo;
    }
    public function setSponsorWebsite($sponsorWebsite)
    {
        $this->sponsorWebsite = $sponsorWebsite;
    }
    public function setStatus($status)
    {
        $this->status = $status;
    }

    // Getters
    public function getSponsorsId()
    {
        return $this->sponsorsId;
    }
    public function getProjectId()
    {
        return $this->projectId;
    }
    public function getSponsorName()
    {
        return $this->sponsorName;
    }
    public function getSponsorLogo()
    {
        return $this->sponsorLogo;
    }
    public function getSponsorWebsite()
    {
        return $this->sponsorWebsite;
    }
    public function getStatus()
    {
        return $this->status;
    }

    // CRUD Operations

    // Select a project sponsor record
    public function selectQuery()
    {
        try {
            return BaseModel::query()
                ->select(tableName: $this->tableNames[0])
                ->where("sponsorsId = ?", [$this->sponsorsId])
                ->first();
        } catch (Exception $e) {
            Exceptions::exceptionHandler($e);
        }
    }

    // Insert a new project sponsor record
    public function insertQuery()
    {
        try {
            $insertData = [
                'sponsorsId' => $this->sponsorsId,
                'projectId' => $this->projectId,
                'sponsorName' => $this->sponsorName,
                'sponsorLogo' => $this->sponsorLogo,
                'sponsorWebsite' => $this->sponsorWebsite,
                'status' => $this->status,
            ];

            return BaseModel::query()
                ->insert(tableName: $this->tableNames[0], query: $insertData)
                ->save();
        } catch (Exception $e) {
            Exceptions::exceptionHandler($e);
        }
    }

    // Update a project sponsor record
    public function updateQuery()
    {
        try {
            $updateData = array_filter([
                'projectId' => $this->projectId,
                'sponsorName' => $this->sponsorName,
                'sponsorLogo' => $this->sponsorLogo,
                'sponsorWebsite' => $this->sponsorWebsite,
                'status' => $this->status,
            ], function ($value) {
                return !is_null($value);
            });

            if (empty($updateData)) {
                return false; // No data to update
            }

            return BaseModel::query()
                ->update(tableName: $this->tableNames[0], dataValues: $updateData)
                ->where("sponsorsId = ?", [$this->sponsorsId])
                ->save();
        } catch (Exception $e) {
            Exceptions::exceptionHandler($e);
        }
    }

    // Delete a project sponsor record
    public function deleteQuery()
    {
        try {
            if (empty($this->sponsorsId)) {
                return false; // Handle error: No identifier provided
            }
            return BaseModel::query()
                ->delete(tableName: $this->tableNames[0])
                ->where("sponsorsId = ?", [$this->sponsorsId])
                ->save();
        } catch (Exception $e) {
            Exceptions::exceptionHandler($e);
        }
    }
}
