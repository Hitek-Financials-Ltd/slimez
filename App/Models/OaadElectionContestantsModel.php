<?php

namespace Hitek\Slimez\App\Models;

use Exception;
use Hitek\Slimez\Core\BaseModel;
use Hitek\Slimez\Core\Exceptions;

class OaadElectionContestantsModel
{
    protected $contestantId;
    protected $userId;
    protected $positionContestingFor;
    protected $electionYear;
    protected $contestantImage;
    protected $contestantBios;
    protected $contestantCampaignWriteUp;
    protected $approvalStage;
    protected $createdAt;

    private $tableNames = ['oaadElectionContestants'];

    // Setters
    public function setContestantId($contestantId)
    {
        $this->contestantId = $contestantId;
    }
    public function setUserId($userId)
    {
        $this->userId = $userId;
    }
    public function setPositionContestingFor($positionContestingFor)
    {
        $this->positionContestingFor = $positionContestingFor;
    }
    public function setElectionYear($electionYear)
    {
        $this->electionYear = $electionYear;
    }
    public function setContestantImage($contestantImage)
    {
        $this->contestantImage = $contestantImage;
    }
    public function setContestantBios($contestantBios)
    {
        $this->contestantBios = $contestantBios;
    }
    public function setContestantCampaignWriteUp($contestantCampaignWriteUp)
    {
        $this->contestantCampaignWriteUp = $contestantCampaignWriteUp;
    }
    public function setApprovalStage($approvalStage)
    {
        $this->approvalStage = $approvalStage;
    }
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;
    }

    // Getters
    public function getContestantId()
    {
        return $this->contestantId;
    }
    public function getUserId()
    {
        return $this->userId;
    }
    public function getPositionContestingFor()
    {
        return $this->positionContestingFor;
    }
    public function getElectionYear()
    {
        return $this->electionYear;
    }
    public function getContestantImage()
    {
        return $this->contestantImage;
    }
    public function getContestantBios()
    {
        return $this->contestantBios;
    }
    public function getContestantCampaignWriteUp()
    {
        return $this->contestantCampaignWriteUp;
    }
    public function getApprovalStage()
    {
        return $this->approvalStage;
    }
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    // CRUD Operations

    // Select an election contestant record
    public function selectQuery()
    {
        try {
            return BaseModel::query()
                ->select(tableName: $this->tableNames[0])
                ->where("contestantId = ?", [$this->contestantId])
                ->first();
        } catch (Exception $e) {
            Exceptions::exceptionHandler($e);
        }
    }

    // Insert a new election contestant record
    public function insertQuery()
    {
        try {
            $insertData = [
                'contestantId' => $this->contestantId,
                'userId' => $this->userId,
                'positionContestingFor' => $this->positionContestingFor,
                'electionYear' => $this->electionYear,
                'contestantImage' => $this->contestantImage,
                'contestantBios' => $this->contestantBios,
                'contestantCampaignWriteUp' => $this->contestantCampaignWriteUp,
                'approvalStage' => $this->approvalStage,
                'createdAt' => $this->createdAt,
            ];

            return BaseModel::query()
                ->insert(tableName: $this->tableNames[0], query: $insertData)
                ->save();
        } catch (Exception $e) {
            Exceptions::exceptionHandler($e);
        }
    }

    // Update an election contestant record
    public function updateQuery()
    {
        try {
            $updateData = array_filter([
                'userId' => $this->userId,
                'positionContestingFor' => $this->positionContestingFor,
                'electionYear' => $this->electionYear,
                'contestantImage' => $this->contestantImage,
                'contestantBios' => $this->contestantBios,
                'contestantCampaignWriteUp' => $this->contestantCampaignWriteUp,
                'approvalStage' => $this->approvalStage,
                // Typically, createdAt would not be updated.
            ], function ($value) {
                return !is_null($value);
            });

            if (empty($updateData)) {
                return false; // No data to update
            }

            return BaseModel::query()
                ->update(tableName: $this->tableNames[0], dataValues: $updateData)
                ->where("contestantId = ?", [$this->contestantId])
                ->save();
        } catch (Exception $e) {
            Exceptions::exceptionHandler($e);
        }
    }

    // Delete an election contestant record
    public function deleteQuery()
    {
        try {
            if (empty($this->contestantId)) {
                return false; // Handle error: No identifier provided
            }
            return BaseModel::query()
                ->delete(tableName: $this->tableNames[0])
                ->where("contestantId = ?", [$this->contestantId])
                ->save();
        } catch (Exception $e) {
            Exceptions::exceptionHandler($e);
        }
    }
}
