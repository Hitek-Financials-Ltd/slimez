<?php

namespace Hitek\Slimez\App\Models;

use Exception;
use Hitek\Slimez\Core\BaseModel;
use Hitek\Slimez\Core\Exceptions;

class ForumAudiosModel
{
    protected $messagesId;
    protected $forumId;
    protected $userId;
    protected $audioLink;
    protected $isReviewed;
    protected $status;
    protected $createdAt;

    private $tableNames = array('forumAudios');

    // Setters
    public function setMessagesId($messagesId)
    {
        $this->messagesId = $messagesId;
    }
    public function setForumId($forumId)
    {
        $this->forumId = $forumId;
    }
    public function setUserId($userId)
    {
        $this->userId = $userId;
    }
    public function setAudioLink($audioLink)
    {
        $this->audioLink = $audioLink;
    }
    public function setIsReviewed($isReviewed)
    {
        $this->isReviewed = $isReviewed;
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
    public function getMessagesId()
    {
        return $this->messagesId;
    }
    public function getForumId()
    {
        return $this->forumId;
    }
    public function getUserId()
    {
        return $this->userId;
    }
    public function getAudioLink()
    {
        return $this->audioLink;
    }
    public function getIsReviewed()
    {
        return $this->isReviewed;
    }
    public function getStatus()
    {
        return $this->status;
    }
    public function getCreatedAt()
    {
        return $this->createdAt;
    }
    // Select a forum audio record
    public function selectQuery()
    {
        try {
            return BaseModel::query()
                ->select(tableName: $this->tableNames[0])
                ->where("messagesId = ? || forumId = ? || userId = ?", [$this->messagesId, $this->forumId, $this->userId])
                ->first();
        } catch (Exception $e) {
            Exceptions::exceptionHandler($e);
        }
    }

    // Insert a new forum audio record
    public function insertQuery()
    {
        try {
            $insertData = [
                'messagesId' => $this->messagesId,
                'forumId' => $this->forumId,
                'userId' => $this->userId,
                'audioLink' => $this->audioLink,
                'isReviewed' => $this->isReviewed,
                'status' => $this->status,
                'createdAt' => $this->createdAt, // Ensure this is formatted correctly for your database
            ];

            return BaseModel::query()
                ->insert(tableName: $this->tableNames[0], query: $insertData)
                ->save();
        } catch (Exception $e) {
            Exceptions::exceptionHandler($e);
        }
    }

    // Update a forum audio record
    public function updateQuery()
    {
        try {
            $updateData = array_filter([
                'audioLink' => $this->audioLink,
                'isReviewed' => $this->isReviewed,
                'status' => $this->status,
                // You might not always want to update createdAt
            ], function ($value) {
                return !is_null($value);
            });

            if (empty($updateData)) {
                return false; // No data to update
            }

            return BaseModel::query()
                ->update(tableName: $this->tableNames[0], dataValues: $updateData)
                ->where("messagesId = ?", [$this->messagesId])
                ->save();
        } catch (Exception $e) {
            Exceptions::exceptionHandler($e);
        }
    }

    // Delete a forum audio record
    public function deleteQuery()
    {
        try {
            if (empty($this->messagesId)) {
                // Handle error: No identifier provided
                return false;
            }
            return BaseModel::query()
                ->delete(tableName: $this->tableNames[0])
                ->where("messagesId = ?", [$this->messagesId])
                ->save();
        } catch (Exception $e) {
            Exceptions::exceptionHandler($e);
        }
    }
}
