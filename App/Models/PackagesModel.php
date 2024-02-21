<?php

namespace Hitek\Slimez\App\Models;

use Exception;
use Hitek\Slimez\Core\BaseModel;
use Hitek\Slimez\Core\Exceptions;

class PackagesModel extends BaseModel
{
    protected $packageId;
    protected $duration;
    protected $amount;
    protected $title;
    protected $status;

    protected $tableNames = ['packages'];

    public function getPackageId()
    {
        return $this->packageId;
    }
    public function setPackageId($packageId): self
    {
        $this->packageId = $packageId;
        return $this;
    }

    public function getDuration()
    {
        return $this->duration;
    }
    public function setDuration($duration): self
    {
        $this->duration = $duration;
        return $this;
    }

    public function getAmount()
    {
        return $this->amount;
    }
    public function setAmount($amount): self
    {
        $this->amount = $amount;
        return $this;
    }

    public function getTitle()
    {
        return $this->title;
    }
    public function setTitle($title): self
    {
        $this->title = $title;
        return $this;
    }

    public function getStatus()
    {
        return $this->status;
    }
    public function setStatus($status): self
    {
        $this->status = $status;
        return $this;
    }

    public function selectQuery($isAll = false)
    {
        try {
            if ($isAll) {
                return BaseModel::query()->select($this->tableNames[0])
                    ->where("packageId = ? || status = ?", [$this->packageId, $this->status])
                    ->get();
            }
            return BaseModel::query()->select($this->tableNames[0])
                ->where("packageId = ? || status = ?", [$this->packageId, $this->status])
                ->first();
        } catch (Exception $e) {
            Exceptions::exceptionHandler($e);
        }
    }

    public function insertQuery()
    {
        try {
            $insertData = array_filter([
                'packageId' => $this->packageId,
                'duration' => $this->duration,
                'amount' => $this->amount,
                'title' => $this->title,
                'status' => $this->status,
            ]);

            return BaseModel::query()->insert($this->tableNames[0], $insertData)->save();
        } catch (Exception $e) {
            Exceptions::exceptionHandler($e);
        }
    }

    public function updateQuery()
    {
        $updateData = array_filter([
            'duration' => $this->duration,
            'amount' => $this->amount,
            'title' => $this->title,
            'status' => $this->status,
        ]);

        if (empty($updateData)) {
            return false; // No data to update
        }

        try {
            return BaseModel::query()
                ->update(tableName: $this->tableNames[0], dataValues: $updateData)
                ->where("packageId = ?", [$this->packageId])
                ->save();
        } catch (Exception $e) {
            Exceptions::exceptionHandler($e);
        }
    }

    public function deleteQuery()
    {
        try {
            return BaseModel::query()->delete($this->tableNames[0])
                ->where("packageId = ?", [$this->packageId])->save();
        } catch (Exception $e) {
            Exceptions::exceptionHandler($e);
        }
    }
}
