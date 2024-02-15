<?php

namespace Hitek\Slimez\App\Models;

use Exception;
use Hitek\Slimez\Core\BaseModel;
use Hitek\Slimez\Core\Exceptions;

class ProjectImagesModel
{
    protected $projectImagesId;
    protected $projectId;
    protected $projectImage;

    private $tableNames = ['projectImages'];

    // Setters
    public function setProjectImagesId($projectImagesId)
    {
        $this->projectImagesId = $projectImagesId;
    }
    public function setProjectId($projectId)
    {
        $this->projectId = $projectId;
    }
    public function setProjectImage($projectImage)
    {
        $this->projectImage = $projectImage;
    }

    // Getters
    public function getProjectImagesId()
    {
        return $this->projectImagesId;
    }
    public function getProjectId()
    {
        return $this->projectId;
    }
    public function getProjectImage()
    {
        return $this->projectImage;
    }

    // CRUD Operations

    // Select a project image record
    public function selectQuery()
    {
        try {
            return BaseModel::query()
                ->select(tableName: $this->tableNames[0])
                ->where("projectImagesId = ?", [$this->projectImagesId])
                ->first();
        } catch (Exception $e) {
            Exceptions::exceptionHandler($e);
        }
    }

    // Insert a new project image record
    public function insertQuery()
    {
        try {
            $insertData = [
                'projectImagesId' => $this->projectImagesId,
                'projectId' => $this->projectId,
                'projectImage' => $this->projectImage,
            ];

            return BaseModel::query()
                ->insert(tableName: $this->tableNames[0], query: $insertData)
                ->save();
        } catch (Exception $e) {
            Exceptions::exceptionHandler($e);
        }
    }

    // Update a project image record
    public function updateQuery()
    {
        try {
            $updateData = [
                'projectId' => $this->projectId,
                'projectImage' => $this->projectImage,
            ];

            return BaseModel::query()
                ->update(tableName: $this->tableNames[0], dataValues: $updateData)
                ->where("projectImagesId = ?", [$this->projectImagesId])
                ->save();
        } catch (Exception $e) {
            Exceptions::exceptionHandler($e);
        }
    }
    
    // Delete a project image record
    public function deleteQuery()
    {
        try {

            if (empty($this->projectImagesId)) {
                return false; // Handle error: No identifier provided
            }

            // 
            return BaseModel::query()
                ->delete(tableName: $this->tableNames[0])
                ->where("projectImagesId = ?", [$this->projectImagesId])
                ->save();

        } catch (Exception $e) {
            Exceptions::exceptionHandler($e);
        }
    }
}
