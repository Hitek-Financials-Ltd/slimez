<?php

namespace Hitek\Slimez\App\Models;

use Exception;
use Hitek\Slimez\Core\BaseModel;
use Hitek\Slimez\Core\Exceptions;


class CurrencyRateModel extends BaseModel
{
    protected $id;
    protected $country;
    protected $rate;
    protected $status;
    protected $updateAt;

    protected $tableNames = ['currency_rate'];

    // Getters
    public function getId()
    {
        return $this->id;
    }

    public function getCountry()
    {
        return $this->country;
    }

    public function getRate()
    {
        return $this->rate;
    }

    public function getStatus()
    {
        return $this->status;
    }
    public function getUpdateAt()
    {
        return $this->updateAt;
    }

    // Setters
    public function setId($id): self
    {
        $this->id = $id;
        return $this;
    }

    public function setCountry($country): self
    {
        $this->country = $country;
        return $this;
    }

    public function setRate($rate): self
    {
        $this->rate = $rate;
        return $this;
    }

    public function setStatus($status): self
    {
        $this->status = $status;
        return $this;
    }

    public function setUpdateAt($updateAt): self
    {
        $this->updateAt = $updateAt;
        return $this;
    }

    // CRUD Methods
    public function selectQuery(bool $isSelectAll = false)
    {
        try {
            if ($isSelectAll) {
                return BaseModel::query()
                    ->select($this->tableNames[0])
                    ->where("id != ? AND status = ?", ['all', 1])
                    ->get();
            }
            return BaseModel::query()
                ->select($this->tableNames[0])
                ->where("id = ? || country = ? AND status = ?", [$this->id, $this->country, 1])
                ->first();
        } catch (Exception $e) {
            Exceptions::exceptionHandler($e);
        }
    }

    public function insertQuery()
    {
        try {
            $insertData = array_filter([
                'country' => $this->country,
                'rate' => $this->rate,
                'updateAt' => $this->updateAt,
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
            $updateData = array_filter([
                'country' => $this->country,
                'rate' => $this->rate,
                'status' => $this->status,
                'updateAt' => $this->updateAt
            ]);

            if (empty($updateData)) {
                return false; // No data to update
            }

            return BaseModel::query()
                ->update(tableName: $this->tableNames[0], dataValues: $updateData)
                ->where("id = ? || country = ?", [$this->id, $this->country])
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
                ->where("id = ? || country = ?", [$this->id, $this->country])
                ->save();
        } catch (Exception $e) {
            Exceptions::exceptionHandler($e);
        }
    }
}
