<?php

namespace Hitek\Slimez\App\Models;

use Exception;
use Hitek\Slimez\Core\BaseModel;
use Hitek\Slimez\Core\Exceptions;

class ForumMessagesModel
{
    protected $messagesId;
    protected $forumId;
    protected $userId;
    protected $messages;
    protected $isReviewed;
    protected $status;
    protected $createdAt;

    private $tableNames = ['forumMessages'];

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
    public function setMessages($messages)
    {
        $this->messages = $messages;
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
    public function getMessages()
    {
        return $this->messages;
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

    // Select a forum message record
    public function selectQuery()
    {
        try {
            return BaseModel::query()
                ->select(tableName: $this->tableNames[0])
                ->where("messagesId = ?", [$this->messagesId])
                ->first();
        } catch (Exception $e) {
            Exceptions::exceptionHandler($e);
        }
    }

    // Insert a new forum message record
    public function insertQuery()
    {
        try {
            $insertData = [
                'messagesId' => $this->messagesId,
                'forumId' => $this->forumId,
                'userId' => $this->userId,
                'messages' => $this->messages,
                'isReviewed' => $this->isReviewed,
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

    // Update a forum message record
    public function updateQuery()
    {
        try {
            $updateData = array_filter([
                'messages' => $this->messages,
                'isReviewed' => $this->isReviewed,
                'status' => $this->status,
                // Normally, you wouldn't update createdAt as it's a timestamp of record creation.
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

    // Delete a forum message record
    public function deleteQuery()
    {
        try {
            if (empty($this->messagesId)) {
                return false; // Handle error: No identifier provided
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
