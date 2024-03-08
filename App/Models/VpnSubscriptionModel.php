<?php

namespace Hitek\Slimez\App\Models;

use Exception;
use Hitek\Slimez\Core\BaseModel;
use Hitek\Slimez\Core\Exceptions;

class VpnSubscriptionModel extends BaseModel
{
    protected $subId;
    protected $userId;
    protected $subType;
    protected $duration;
    protected $amount;
    protected $startDate;
    protected $endDate;

    protected $tableNames = ['vpn_subscription'];

    // Getters
    public function getSubId()
    {
        return $this->subId;
    }
    public function getUserId()
    {
        return $this->userId;
    }
    public function getSubType()
    {
        return $this->subType;
    }
    public function getDuration()
    {
        return $this->duration;
    }
    public function getAmount()
    {
        return $this->amount;
    }
    public function getStartDate()
    {
        return $this->startDate;
    }
    public function getEndDate()
    {
        return $this->endDate;
    }

    // Setters
    public function setSubId($subId): self
    {
        $this->subId = $subId;
        return $this;
    }
    public function setUserId($userId): self
    {
        $this->userId = $userId;
        return $this;
    }
    public function setSubType($subType): self
    {
        $this->subType = $subType;
        return $this;
    }
    public function setDuration($duration): self
    {
        $this->duration = $duration;
        return $this;
    }
    public function setAmount($amount): self
    {
        $this->amount = $amount;
        return $this;
    }
    public function setStartDate($startDate): self
    {
        $this->startDate = $startDate;
        return $this;
    }
    public function setEndDate($endDate): self
    {
        $this->endDate = $endDate;
        return $this;
    }

    // CRUD Methods
    public function selectQuery()
    {
        try {
            return BaseModel::query()
                ->select($this->tableNames[0])
                ->where("subId = ? || userId = ?", [$this->subId, $this->userId])
                ->first();
        } catch (Exception $e) {
            Exceptions::exceptionHandler($e);
        }
    }

    public function insertQuery()
    {
        try {
            // Assuming $this->duration is in months and needs to be an integer for calculation
            $startDate = new \DateTime($this->startDate); // Assuming $this->startDate is already set to '2024-02-10'
            $duration = new \DateInterval('P' . (int)$this->duration . 'M');
            $endDate = (clone $startDate)->add($duration);

            $insertData = array_filter([
                'subId' => $this->subId,
                'userId' => $this->userId,
                'duration' => $this->duration,
                'subType' => $this->subType,
                'amount' => $this->amount,
                'startDate' => $startDate->format('Y-m-d H:i:s'),
                'endDate' => $endDate->format('Y-m-d H:i:s'),
            ]);

            return BaseModel::query()
                ->insert($this->tableNames[0], $insertData)
                ->save();
        } catch (Exception $e) {
            Exceptions::exceptionHandler($e);
        }
    }

    public function updateQuery()
    {
        try {
            // Recalculate endDate based on updated duration
            $startDate = new \DateTime($this->startDate);
            $duration = new \DateInterval('P' . (int)$this->duration . 'M');
            $endDate = (clone $startDate)->add($duration);

            $updateData = array_filter([
                'userId' => $this->userId,
                'duration' => $this->duration,
                'subType' => $this->subType,
                'amount' => $this->amount,
                'startDate' => $startDate->format('Y-m-d H:i:s'),
                'endDate' => $endDate->format('Y-m-d H:i:s'),
            ]);

            if (empty($updateData)) {
                return false; // No data to update
            }

            return BaseModel::query()
                ->update(tableName: $this->tableNames[0], dataValues: $updateData)
                ->where("subId = ? || userId = ?", [$this->subId, $this->userId])
                ->save();
        } catch (Exception $e) {
            Exceptions::exceptionHandler($e);
        }
    }


    public function deleteQuery()
    {
        try {
            return BaseModel::query()
                ->delete($this->tableNames[0])
                ->where("subId = ? || userId = ?", [$this->subId, $this->userId])
                ->save();
        } catch (Exception $e) {
            Exceptions::exceptionHandler($e);
        }
    }
}
