<?php

namespace Hitek\Slimez\App\Models;

use Exception;
use Hitek\Slimez\Core\BaseModel;
use Hitek\Slimez\Core\Exceptions;

class TransactionRecordModel extends BaseModel
{
    protected $transId;
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

    protected $tableNames = ['transaction_record'];

    public function getTransId()
    {
        return $this->transId;
    }

    public function setTransId($transId): self
    {
        $this->transId = $transId;
        return $this;
    }

    public function getTransactionType()
    {
        return $this->transactionType;
    }

    public function setTransactionType($transactionType): self
    {
        $this->transactionType = $transactionType;
        return $this;
    }

    public function getTransactionStatus()
    {
        return $this->transactionStatus;
    }

    public function setTransactionStatus($transactionStatus): self
    {
        $this->transactionStatus = $transactionStatus;
        return $this;
    }

    public function getTransactionReference()
    {
        return $this->transactionReference;
    }

    public function setTransactionReference($transactionReference): self
    {
        $this->transactionReference = $transactionReference;
        return $this;
    }

    public function getTransactionTypeId()
    {
        return $this->transactionTypeId;
    }

    public function setTransactionTypeId($transactionTypeId): self
    {
        $this->transactionTypeId = $transactionTypeId;
        return $this;
    }

    public function getTransactionSessionId()
    {
        return $this->transactionSessionId;
    }

    public function setTransactionSessionId($transactionSessionId): self
    {
        $this->transactionSessionId = $transactionSessionId;
        return $this;
    }

    public function getTransactionNarration()
    {
        return $this->transactionNarration;
    }

    public function setTransactionNarration($transactionNarration): self
    {
        $this->transactionNarration = $transactionNarration;
        return $this;
    }

    public function getTransactionCurrency()
    {
        return $this->transactionCurrency;
    }

    public function setTransactionCurrency($transactionCurrency): self
    {
        $this->transactionCurrency = $transactionCurrency;
        return $this;
    }

    public function getAmountPaid()
    {
        return $this->amountPaid;
    }

    public function setAmountPaid($amountPaid): self
    {
        $this->amountPaid = $amountPaid;
        return $this;
    }

    public function getAmountExpectedToPay()
    {
        return $this->amountExpectedToPay;
    }

    public function setAmountExpectedToPay($amountExpectedToPay): self
    {
        $this->amountExpectedToPay = $amountExpectedToPay;
        return $this;
    }

    public function getWalletBalanceBefore()
    {
        return $this->walletBalanceBefore;
    }

    public function setWalletBalanceBefore($walletBalanceBefore): self
    {
        $this->walletBalanceBefore = $walletBalanceBefore;
        return $this;
    }

    public function getWalletBalanceAfter()
    {
        return $this->walletBalanceAfter;
    }

    public function setWalletBalanceAfter($walletBalanceAfter): self
    {
        $this->walletBalanceAfter = $walletBalanceAfter;
        return $this;
    }

    // CRUD methods for transaction_record table

    public function selectQuery($isAll = false)
    {
        try {
            if ($isAll) {
                return BaseModel::query()->select($this->tableNames[0])
                    ->where("transId != ?", ['0'])
                    ->get();
            }
            return BaseModel::query()->select($this->tableNames[0])
                ->where("transId = ? || transactionReference = ? || transactionSessionId = ? ", [$this->transId, $this->transactionReference, $this->transactionSessionId])
                ->get();
        } catch (Exception $e) {
            Exceptions::exceptionHandler($e);
        }
    }

    public function insertQuery()
    {
        try {
            $insertData = array_filter([
                'transId' => $this->transId,
                'transactionType' => $this->transactionType,
                'transactionStatus' => $this->transactionStatus,
                'transactionReference' => $this->transactionReference,
                'transactionTypeId' => $this->transactionTypeId,
                'transactionSessionId' => $this->transactionSessionId,
                'transactionNarration' => $this->transactionNarration,
                'transactionCurrency' => $this->transactionCurrency,
                'amountPaid' => $this->amountPaid,
                'amountExpectedToPay' => $this->amountExpectedToPay,
                'walletBalanceBefore' => $this->walletBalanceBefore,
                'walletBalanceAfter' => $this->walletBalanceAfter,
            ]);

            return BaseModel::query()->insert($this->tableNames[0], $insertData)->save();
        } catch (Exception $e) {
            Exceptions::exceptionHandler($e);
        }
    }

    public function updateQuery()
    {
        $updateData = array_filter([
            'transactionType' => $this->transactionType,
            'transactionStatus' => $this->transactionStatus,
            'transactionTypeId' => $this->transactionTypeId,
            'transactionNarration' => $this->transactionNarration,
            'transactionCurrency' => $this->transactionCurrency,
            'amountPaid' => $this->amountPaid,
            'amountExpectedToPay' => $this->amountExpectedToPay,
            'walletBalanceBefore' => $this->walletBalanceBefore,
            'walletBalanceAfter' => $this->walletBalanceAfter,
        ]);

        if (empty($updateData)) {
            return false; // No data to update
        }

        try {
            return BaseModel::query()
                ->update(tableName: $this->tableNames[0], dataValues: $updateData)
                ->where("transId = ? || transactionReference = ? || transactionSessionId = ? ", [$this->transId, $this->transactionReference, $this->transactionSessionId])
                ->save();
        } catch (Exception $e) {
            Exceptions::exceptionHandler($e);
        }
    }

    public function deleteQuery()
    {
        try {
            return BaseModel::query()->delete($this->tableNames[0])
            ->where("transId = ? || transactionReference = ? || transactionSessionId = ? ", [$this->transId, $this->transactionReference, $this->transactionSessionId])
            ->save();
        } catch (Exception $e) {
            Exceptions::exceptionHandler($e);
        }
    }
}
