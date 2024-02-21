<?php

namespace Hitek\Slimez\App\Models;

use Exception;
use Hitek\Slimez\Core\BaseModel;
use Hitek\Slimez\Core\Exceptions;

class UserPersonalInfoModel extends BaseModel
{
    protected $pInfoId;
    protected $userId;
    protected $fname;
    protected $mname;
    protected $lname;
    protected $country;
    protected $address;

    protected $tableNames = ['user_personal_info'];

    public function getPInfoId()
    {
        return $this->pInfoId;
    }
    public function setPInfoId($pInfoId): self
    {
        $this->pInfoId = $pInfoId;
        return $this;
    }

    public function getUserId()
    {
        return $this->userId;
    }
    public function setUserId($userId): self
    {
        $this->userId = $userId;
        return $this;
    }

    public function getFname()
    {
        return $this->fname;
    }
    public function setFname($fname): self
    {
        $this->fname = $fname;
        return $this;
    }

    public function getMname()
    {
        return $this->mname;
    }
    public function setMname($mname): self
    {
        $this->mname = $mname;
        return $this;
    }

    public function getLname()
    {
        return $this->lname;
    }
    public function setLname($lname): self
    {
        $this->lname = $lname;
        return $this;
    }

    public function getCountry()
    {
        return $this->country;
    }
    public function setCountry($country): self
    {
        $this->country = $country;
        return $this;
    }

    public function getAddress()
    {
        return $this->address;
    }
    public function setAddress($address): self
    {
        $this->address = $address;
        return $this;
    }

    public function selectQuery()
    {
        try {
            return BaseModel::query()->select($this->tableNames[0])
            ->where("pInfoId = ? || userId = ?", [$this->pInfoId, $this->userId])->first();
        } catch (Exception $e) {
            Exceptions::exceptionHandler($e);
        }
    }

    public function insertQuery()
    {
        $updateData = array_filter([
            'pInfoId' => $this->pInfoId,
            'userId' => $this->userId,
            'fname' => $this->fname,
            'mname' => $this->mname,
            'lname' => $this->lname,
            'country' => $this->country,
            'address' => $this->address,
        ]);
        if (empty($updateData)) {
            return false; // No data to update
        }

        try {
            return BaseModel::query()
            ->insert($this->tableNames[0], $updateData)
            ->save();
        } catch (Exception $e) {
            Exceptions::exceptionHandler($e);
        }
    }

    public function updateQuery()
    {
        $updateData = array_filter([
            'userId' => $this->userId,
            'fname' => $this->fname,
            'mname' => $this->mname,
            'lname' => $this->lname,
            'country' => $this->country,
            'address' => $this->address,
        ]);

        if (empty($updateData)) {
            return false; // No data to update
        }

        try {
            return BaseModel::query()
            ->update(tableName: $this->tableNames[0], dataValues: $updateData)
            ->where("pInfoId = ? || userId = ?", [$this->pInfoId, $this->userId])
            ->save();
        } catch (Exception $e) {
            Exceptions::exceptionHandler($e);
        }
    }

    public function deleteQuery()
    {
        try {
            return BaseModel::query()->delete($this->tableNames[0])
            ->where("pInfoId = ? || userId = ?", [$this->pInfoId, $this->userId])->save();
        } catch (Exception $e) {
            Exceptions::exceptionHandler($e);
        }
    }
}
