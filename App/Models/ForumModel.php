<?php

namespace Hitek\Slimez\App\Models;

use Exception;
use Hitek\Slimez\Core\BaseModel;
use Hitek\Slimez\Core\Exceptions;

class ForumModel extends BaseModel
{
    private $forumId;
    private $createdByUser;
    private $topic;
    private $bodyMessage;
    private $createdAt;
    private $status;

    protected $tableNames = ['forum']; // Assuming 'forum' is the table name

    // Chainable setters
    public function setForumId($forumId): self
    {
        $this->forumId = $forumId;
        return $this;
    }

    public function setCreatedByUser($createdByUser): self
    {
        $this->createdByUser = $createdByUser;
        return $this;
    }

    public function setTopic($topic): self
    {
        $this->topic = $topic;
        return $this;
    }

    public function setBodyMessage($bodyMessage): self
    {
        $this->bodyMessage = $bodyMessage;
        return $this;
    }

    public function setCreatedAt($createdAt): self
    {
        $this->createdAt = $createdAt;
        return $this;
    }

    public function setStatus($status): self
    {
        $this->status = $status;
        return $this;
    }

    // Select a forum record
    public function selectQuery()
    {
        try {
            return $this->query()
                        ->select($this->tableNames[0])
                        ->where("forumId = ?", [$this->forumId])
                        ->first();
        } catch (Exception $e) {
            Exceptions::exceptionHandler($e);
        }
    }

    // Insert a new forum record
    public function insertQuery()
    {
        try {
            $insertData = [
                'forumId' => $this->forumId,
                'createdByUser' => $this->createdByUser,
                'topic' => $this->topic,
                'bodyMessage' => $this->bodyMessage,
                'createdAt' => $this->createdAt->format('Y-m-d H:i:s'), // Assuming createdAt is a DateTime object
                'status' => $this->status,
            ];

            return $this->query()
                        ->insert($this->tableNames[0], $insertData)
                        ->save();
        } catch (Exception $e) {
            Exceptions::exceptionHandler($e);
        }
    }

    // Update a forum record
    public function updateQuery()
    {
        try {
            $updateData = array_filter([
                'createdByUser' => $this->createdByUser,
                'topic' => $this->topic,
                'bodyMessage' => $this->bodyMessage,
                'createdAt' => $this->createdAt->format('Y-m-d H:i:s'),
                'status' => $this->status,
            ], function ($value) {
                return !is_null($value);
            });

            if (empty($updateData)) {
                return false; // No data to update
            }

            return $this->query()
                        ->update($this->tableNames[0], $updateData)
                        ->where("forumId = ?", [$this->forumId])
                        ->save();
        } catch (Exception $e) {
            Exceptions::exceptionHandler($e);
        }
    }

    // Delete a forum record
    public function deleteQuery()
    {
        try {
            if (empty($this->forumId)) {
                return false; // No identifier provided
            }
            return $this->query()
                        ->delete($this->tableNames[0])
                        ->where("forumId = ?", [$this->forumId])
                        ->save();
        } catch (Exception $e) {
            Exceptions::exceptionHandler($e);
        }
    }
}
