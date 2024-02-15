<?php

namespace Hitek\Slimez\App\Models;

use Exception;
use Hitek\Slimez\Core\BaseModel;
use Hitek\Slimez\Core\Exceptions;

class MembersModel extends BaseModel
{
    private $memId;
    private $userId;
    private $oaadMemberId;
    private $memberPosition;
    private $memberEducationLevel;
    private $yearJoined;
    private $status;

    protected $tableNames = ['members']; // Assuming 'members' is the table name

    // Chainable setters
    public function setMemId($memId): self
    {
        $this->memId = $memId;
        return $this;
    }

    public function setUserId($userId): self
    {
        $this->userId = $userId;
        return $this;
    }

    public function setOaadMemberId($oaadMemberId): self
    {
        $this->oaadMemberId = $oaadMemberId;
        return $this;
    }

    public function setMemberPosition($memberPosition): self
    {
        $this->memberPosition = $memberPosition;
        return $this;
    }

    public function setMemberEducationLevel($memberEducationLevel): self
    {
        $this->memberEducationLevel = $memberEducationLevel;
        return $this;
    }

    public function setYearJoined($yearJoined): self
    {
        $this->yearJoined = $yearJoined;
        return $this;
    }

    public function setStatus($status): self
    {
        $this->status = $status;
        return $this;
    }

    // Select a member record
    public function selectQuery()
    {
        try {
            return $this->query()
                        ->select($this->tableNames[0])
                        ->where("memId = ?", [$this->memId])
                        ->first();
        } catch (Exception $e) {
            Exceptions::exceptionHandler($e);
        }
    }

    // Insert a new member record
    public function insertQuery()
    {
        try {
            $insertData = [
                'memId' => $this->memId,
                'userId' => $this->userId,
                'oaadMemberId' => $this->oaadMemberId,
                'memberPosition' => $this->memberPosition,
                'memberEducationLevel' => $this->memberEducationLevel,
                'yearJoined' => $this->yearJoined->format('Y-m-d H:i:s'), // Assuming yearJoined is a DateTime object
                'status' => $this->status,
            ];

            return $this->query()
                        ->insert($this->tableNames[0], $insertData)
                        ->save();
        } catch (Exception $e) {
            Exceptions::exceptionHandler($e);
        }
    }

    // Update a member record
    public function updateQuery()
    {
        try {
            $updateData = array_filter([
                'userId' => $this->userId,
                'oaadMemberId' => $this->oaadMemberId,
                'memberPosition' => $this->memberPosition,
                'memberEducationLevel' => $this->memberEducationLevel,
                'yearJoined' => $this->yearJoined->format('Y-m-d H:i:s'),
                'status' => $this->status,
            ], function ($value) {
                return !is_null($value);
            });

            if (empty($updateData)) {
                return false; // No data to update
            }

            return $this->query()
                        ->update($this->tableNames[0], $updateData)
                        ->where("memId = ?", [$this->memId])
                        ->save();
        } catch (Exception $e) {
            Exceptions::exceptionHandler($e);
        }
    }

    // Delete a member record
    public function deleteQuery()
    {
        try {
            if (empty($this->memId)) {
                return false; // No identifier provided
            }
            return $this->query()
                        ->delete($this->tableNames[0])
                        ->where("memId = ?", [$this->memId])
                        ->save();
        } catch (Exception $e) {
            Exceptions::exceptionHandler($e);
        }
    }
}
