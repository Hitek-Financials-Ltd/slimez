<?php 

namespace Hitek\Slimez\App\Models;

use Exception;
use Hitek\Slimez\Core\BaseModel;
use Hitek\Slimez\Core\Exceptions;

class TransactionDataBundleModel extends BaseModel
{
    protected $dataBundleId;
    protected $transactionRecordId;
    protected $countryCode;
    protected $networkProvider;
    protected $bundleType;
    protected $senderId;
    protected $receiverId;
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


    protected $tableNames = ['transaction_data_bundle', 'transaction_record'];

    public function getDataBundleId()
    {
        return $this->dataBundleId;
    }

    public function setDataBundleId($dataBundleId): self
    {
        $this->dataBundleId = $dataBundleId;
        return $this;
    }

    public function getTransactionRecordId()
    {
        return $this->transactionRecordId;
    }

    public function setTransactionRecordId($transactionRecordId): self
    {
        $this->transactionRecordId = $transactionRecordId;
        return $this;
    }

    public function getCountryCode()
    {
        return $this->countryCode;
    }

    public function setCountryCode($countryCode): self
    {
        $this->countryCode = $countryCode;
        return $this;
    }

    public function getNetworkProvider()
    {
        return $this->networkProvider;
    }

    public function setNetworkProvider($networkProvider): self
    {
        $this->networkProvider = $networkProvider;
        return $this;
    }

    public function getBundleType()
    {
        return $this->bundleType;
    }

    public function setBundleType($bundleType): self
    {
        $this->bundleType = $bundleType;
        return $this;
    }

    public function getSenderId()
    {
        return $this->senderId;
    }

    public function setSenderId($senderId): self
    {
        $this->senderId = $senderId;
        return $this;
    }

    public function getReceiverId()
    {
        return $this->receiverId;
    }

    public function setReceiverId($receiverId): self
    {
        $this->receiverId = $receiverId;
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

    // CRUD methods for transaction_data_bundle table

    public function selectQuery($isAll = false)
    {
        try {
            if ($isAll) {
                return BaseModel::query()->select($this->tableNames[0])
                    ->where("dataBundleId != ?", ['0'])
                    ->get();
            }
            return BaseModel::query()->select($this->tableNames[0])
                ->where("dataBundleId = ? || senderId = ? || receiverId = ?", [$this->dataBundleId, $this->senderId, $this->receiverId])
                ->get();
        } catch (Exception $e) {
            Exceptions::exceptionHandler($e);
        }
    }

    public function insertQuery(bool $isTrans = false)
    {
        try {
            if(!$isTrans){
                $insertData = array_filter([
                    'dataBundleId' => $this->dataBundleId,
                    'transactionRecordId' => $this->transactionRecordId,
                    'countryCode' => $this->countryCode,
                    'networkProvider' => $this->networkProvider,
                    'bundleType' => $this->bundleType,
                    'senderId' => $this->senderId,
                    'receiverId' => $this->receiverId,
                    'updatedAt' => $this->updatedAt,
                    'createdAt' => $this->createdAt,
                ]);

                return BaseModel::query()->insert($this->tableNames[0], $insertData)->save();
           }

            /* start preparing data for transactional insert*/
            $insertCreditData = array_filter([
                'dataBundleId' => $this->dataBundleId,
                'transactionRecordId' => $this->transactionRecordId,
                'countryCode' => $this->countryCode,
                'networkProvider' => $this->networkProvider,
                'bundleType' => $this->bundleType,
                'senderId' => $this->senderId,
                'receiverId' => $this->receiverId,
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
            'countryCode' => $this->countryCode,
            'networkProvider' => $this->networkProvider,
            'bundleType' => $this->bundleType,
            'senderId' => $this->senderId,
            'receiverId' => $this->receiverId,
            'updatedAt' => $this->updatedAt
        ]);

        if (empty($updateData)) {
            return false; // No data to update
        }

        try {
            return BaseModel::query()
                ->update(tableName: $this->tableNames[0], dataValues: $updateData)
                ->where("dataBundleId = ? || senderId = ? || receiverId = ?", [$this->dataBundleId, $this->senderId, $this->receiverId])
                ->save();
        } catch (Exception $e) {
            Exceptions::exceptionHandler($e);
        }
    }

    public function deleteQuery()
    {
        try {
            return BaseModel::query()->delete($this->tableNames[0])
            ->where("dataBundleId = ? || senderId = ? || receiverId = ?", [$this->dataBundleId, $this->senderId, $this->receiverId])->save();
        } catch (Exception $e) {
            Exceptions::exceptionHandler($e);
        }
    }
}
