<?php

namespace Hitek\Slimez\App\Models;

use Exception;
use Hitek\Slimez\Core\BaseModel;
use Hitek\Slimez\Core\Exceptions;

class TransactionVpnModel extends BaseModel
{
    protected $vpnId;
    protected $userId;
    protected $duration;
    protected $transactionRecordId;
    protected $updatedAt;
    protected $createdAt;
    /*transaction record data */
    protected $transactionType;
    protected $transactionStatus;
    protected $transactionReference;
    protected $transactionTypeId;
    protected $transactionSessionId;
    protected $transactionNarration;
    protected $transactionCurrency;
    protected $amountPaid;
    protected $amountExpectedToPay;
    protected $walletBalanceBefore;
    protected $walletBalanceAfter;
    protected $transactionFee;

    protected $tableNames = ['transaction_vpn', 'transaction_record'];

    public function getVpnId()
    {
        return $this->vpnId;
    }

    public function setVpnId($vpnId): self
    {
        $this->vpnId = $vpnId;
        return $this;
    }

    public function getTransactionFee()
    {
        return $this->transactionFee;
    }

    public function setTransactionFee($transactionFee): self
    {
        $this->transactionFee = $transactionFee;
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

    public function getDuration()
    {
        return $this->duration;
    }

    public function setDuration($duration): self
    {
        $this->duration = $duration;
        return $this;
    }

    public function getTransactionRecordId()
    {
        return $this->transactionRecordId;
    }

    public function setTransactionRecordId($transactionRecordId)
    {
        $this->transactionRecordId = $transactionRecordId;
        return $this;
    }

    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt($updatedAt): self
    {
        $this->updatedAt = $updatedAt;
        return $this;
    }

    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    public function setCreatedAt($createdAt): self
    {
        $this->createdAt = $createdAt;
        return $this;
    }

     /**transaction record table */

     public function getTransactionType()
     {
         return $this->transactionType;
     }
 
     public function setTransactionType($transactionType)
     {
         $this->transactionType = $transactionType;
         return $this;
     }
 
     public function getTransactionStatus()
     {
         return $this->transactionStatus;
     }
 
     public function setTransactionStatus($transactionStatus)
     {
         $this->transactionStatus = $transactionStatus;
         return $this;
     }
 
     public function getTransactionReference()
     {
         return $this->transactionReference;
     }
 
     public function setTransactionReference($transactionReference)
     {
         $this->transactionReference = $transactionReference;
         return $this;
     }
 
     public function getTransactionTypeId()
     {
         return $this->transactionTypeId;
     }
 
     public function setTransactionTypeId($transactionTypeId)
     {
         $this->transactionTypeId = $transactionTypeId;
         return $this;
     }
 
     public function getTransactionSessionId()
     {
         return $this->transactionSessionId;
     }
 
     public function setTransactionSessionId($transactionSessionId)
     {
         $this->transactionSessionId = $transactionSessionId;
         return $this;
     }
 
     public function getTransactionNarration()
     {
         return $this->transactionNarration;
     }
 
     public function setTransactionNarration($transactionNarration)
     {
         $this->transactionNarration = $transactionNarration;
         return $this;
     }
 
     public function getTransactionCurrency()
     {
         return $this->transactionCurrency;
     }
 
     public function setTransactionCurrency($transactionCurrency)
     {
         $this->transactionCurrency = $transactionCurrency;
         return $this;
     }
 
     public function getAmountPaid()
     {
         return $this->amountPaid;
     }
 
     public function setAmountPaid($amountPaid)
     {
         $this->amountPaid = $amountPaid;
         return $this;
     }
 
     public function getAmountExpectedToPay()
     {
         return $this->amountExpectedToPay;
     }
 
     public function setAmountExpectedToPay($amountExpectedToPay)
     {
         $this->amountExpectedToPay = $amountExpectedToPay;
         return $this;
     }
 
     public function getWalletBalanceBefore()
     {
         return $this->walletBalanceBefore;
     }
 
     public function setWalletBalanceBefore($walletBalanceBefore)
     {
         $this->walletBalanceBefore = $walletBalanceBefore;
         return $this;
     }
 
     public function getWalletBalanceAfter()
     {
         return $this->walletBalanceAfter;
     }
 
     public function setWalletBalanceAfter($walletBalanceAfter)
     {
         $this->walletBalanceAfter = $walletBalanceAfter;
         return $this;
     }

    // CRUD methods for transaction_vpn table

    public function selectQuery($isAll = false)
    {
        try {
            if ($isAll) {
                return BaseModel::query()->select($this->tableNames[0])
                    ->where("vpnId != ? AND userId = ?", ['67', $this->userId])
                    ->get();
            }
            return BaseModel::query()->select($this->tableNames[0])
                ->where("vpnId = ? || userId = ? || transactionRecordId = ?", [$this->vpnId, $this->userId, $this->transactionRecordId])
                ->first();
        } catch (Exception $e) {
            Exceptions::exceptionHandler($e);
        }
    }

    public function insertQuery(bool $isTrans = false)
    {
        try {
            if(!$isTrans){
            $insertData = array_filter([
                'vpnId' => $this->vpnId,
                'userId' => $this->userId,
                'duration' => $this->duration,
                'transactionRecordId' => $this->transactionRecordId,
                'updatedAt' => $this->updatedAt,
                'createdAt' => $this->createdAt,
            ]);

            return BaseModel::query()->insert($this->tableNames[0], $insertData)->save();
        }

        /* start preparing data for transactional insert*/
        $insertCreditData = array_filter([
            'vpnId' => $this->vpnId,
            'userId' => $this->userId,
            'duration' => $this->duration,
            'transactionRecordId' => $this->transactionRecordId,
            'updatedAt' => $this->updatedAt,
            'createdAt' => $this->createdAt,
        ]);
    /**prepare the data for transaction record insert */
    $insertTransactionData = array_filter([
        'transId' => $this->transactionRecordId,
        'transactionType' => $this->transactionType,
        'transactionStatus' => $this->transactionStatus,
        'transactionReference' => $this->transactionReference,
        'transactionTypeId' => $this->transactionTypeId,
        'transactionSessionId' => $this->transactionSessionId,
        'transactionNarration' => $this->transactionNarration,
        'transactionCurrency' => $this->transactionCurrency,
        'amountPaid' => $this->amountPaid,
        'transactionFee' => $this->transactionFee,
        'amountExpectedToPay' => $this->amountExpectedToPay,
        'walletBalanceBefore' => $this->walletBalanceBefore,
        'walletBalanceAfter' => $this->walletBalanceAfter,
    ]);

    /**
        * transaction insert
        */
        $tranData = [
            /**tables */
                $this->tableNames,
                [
                $insertCreditData,
                /**first table data */
                $insertTransactionData,
                /**second table data */
            ],
        ];
        /*insert the data */
        return BaseModel::query()->insertDbTransact($tranData)->save();

       
        } catch (Exception $e) {
            Exceptions::exceptionHandler($e);
        }
    }

    public function updateQuery()
    {
        $updateData = array_filter([
            'duration' => $this->duration,
            'updatedAt' => $this->updatedAt,
        ]);

        if (empty($updateData)) {
            return false; // No data to update
        }

        try {
            return BaseModel::query()
                ->update(tableName: $this->tableNames[0], dataValues: $updateData)
                ->where("vpnId = ? || userId = ? || transactionRecordId = ?", [$this->vpnId, $this->userId, $this->transactionRecordId])
                ->save();
        } catch (Exception $e) {
            Exceptions::exceptionHandler($e);
        }
    }

    public function deleteQuery()
    {
        try {
            return BaseModel::query()->delete($this->tableNames[0])
            ->where("vpnId = ? || userId = ? || transactionRecordId = ?", [$this->vpnId, $this->userId, $this->transactionRecordId])->save();
        } catch (Exception $e) {
            Exceptions::exceptionHandler($e);
        }
    }
}
