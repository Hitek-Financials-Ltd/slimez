<?php

namespace Hitek\Slimez\App\Models;

use Exception;
use Hitek\Slimez\Core\BaseModel;
use Hitek\Slimez\Core\Exceptions;

class LawsModel extends BaseModel
{
    protected $lawsId;
    protected $userAgreement;
    protected $privacyPolicy;
    protected $lawStatus;

    protected $tableNames = ['laws'];

    public function getLawsId()
    {
        return $this->lawsId;
    }

    public function setLawsId($lawsId)
    {
        $this->lawsId = $lawsId;
        return $this;
    }

    public function getUserAgreement()
    {
        return $this->userAgreement;
    }

    public function setUserAgreement($userAgreement)
    {
        $this->userAgreement = $userAgreement;
        return $this;
    }

    public function getPrivacyPolicy()
    {
        return $this->privacyPolicy;
    }

    public function setPrivacyPolicy($privacyPolicy)
    {
        $this->privacyPolicy = $privacyPolicy;
        return $this;
    }

    public function getLawStatus()
    {
        return $this->lawStatus;
    }

    public function setLawStatus($lawStatus)
    {
        $this->lawStatus = $lawStatus;
        return $this;
    }

    public function selectQuery()
    {
        try {
            return BaseModel::query()
                ->select(tableName: $this->tableNames[0])
                ->where("lawsId = ? || lawStatus = ?", [$this->lawsId, $this->lawStatus])
                ->first();
        } catch (Exception $e) {
            Exceptions::exceptionHandler($e);
        }
    }

    public function deleteQuery(bool $isSoftDelete = true)
    {
        try {
            if ($isSoftDelete) {
                return BaseModel::query()
                    ->update(tableName: $this->tableNames[0], dataValues: ["lawStatus" => 5])
                    ->where("lawsId = ?", [$this->lawsId])
                    ->save();
            } else {
                return BaseModel::query()
                    ->delete(tableName: $this->tableNames[0])
                    ->where("lawsId = ?", [$this->lawsId])
                    ->save();
            }
        } catch (Exception $e) {
            Exceptions::exceptionHandler($e);
        }
    }

    public function updateQuery()
    {
        try {
            $updateData = array_filter([
                "userAgreement" => $this->userAgreement,
                "privacyPolicy" => $this->privacyPolicy,
                "lawStatus" => $this->lawStatus
            ]);

            if (empty($updateData)) {
                return false;
            }

            return BaseModel::query()
                ->update(tableName: $this->tableNames[0], dataValues: $updateData)
                ->where("lawsId = ?", [$this->lawsId])
                ->save();
        } catch (Exception $e) {
            Exceptions::exceptionHandler($e);
        }
    }

    public function insertQuery($isTransaction = false)
    {
        $lawsData = array_filter([
            'lawsId' => $this->lawsId,
            'userAgreement' => $this->userAgreement,
            'privacyPolicy' => $this->privacyPolicy,
            'lawStatus' => $this->lawStatus
        ]);

        try {
            if ($isTransaction) {
                $tranData = [
                    $this->tableNames,
                    [$lawsData]
                ];
                return BaseModel::query()->insertDbTransact($tranData)->save();
            }

            return BaseModel::query()
                ->insert(tableName: $this->tableNames[0], query: $lawsData)
                ->save();
        } catch (Exception $e) {
            Exceptions::exceptionHandler($e);
        }
    }
}
