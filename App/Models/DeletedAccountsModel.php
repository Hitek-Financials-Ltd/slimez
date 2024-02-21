<?php

namespace Hitek\Slimez\App\Models;

use Exception;
use Hitek\Slimez\Core\BaseModel;
use Hitek\Slimez\Core\Exceptions;

class DeletedAccountsModel extends BaseModel
{
    protected $deleteId;
    protected $email;
    protected $reason;
    protected $dateDeleted;
    protected $status;

    protected $tableNames = ['deletedAccounts'];

    public function getDeleteId()
    {
        return $this->deleteId;
    }
    public function setDeleteId($deleteId): self
    {
        $this->deleteId = $deleteId;
        return $this;
    }

    public function getEmail()
    {
        return $this->email;
    }
    public function setEmail($email): self
    {
        $this->email = $email;
        return $this;
    }

    public function getReason()
    {
        return $this->reason;
    }
    public function setReason($reason): self
    {
        $this->reason = $reason;
        return $this;
    }

    public function getDateDeleted()
    {
        return $this->dateDeleted;
    }
    public function setDateDeleted($dateDeleted): self
    {
        $this->dateDeleted = $dateDeleted;
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

    // Insert a record into the database
    public function insertQuery()
    {
        try {
            $insertData = array_filter([
                'deleteId' => $this->deleteId,
                'email' => $this->email,
                'reason' => $this->reason,
                'dateDeleted' => $this->dateDeleted,
                'status' => $this->status,
            ]);

            return BaseModel::query()->insert($this->tableNames[0], $insertData)->save();
        } catch (Exception $e) {
            Exceptions::exceptionHandler($e);
        }
    }

    // Select a record from the database
    public function selectQuery($isAll = false)
    {
        try {
            if($isAll){
                return BaseModel::query()
                ->select($this->tableNames[0], '*')
                ->where("deleteId = ? || email = ?", [$this->deleteId, $this->email])
                ->get();
            }
            return BaseModel::query()
               ->select($this->tableNames[0], '*')
                ->where("deleteId = ? || email = ?", [$this->deleteId, $this->email])
                ->first();
        } catch (Exception $e) {
            Exceptions::exceptionHandler($e);
        }
    }

    // Update a record in the database
    public function updateQuery()
    {
        try {
            $updateData = array_filter([
                'email' => $this->email,
                'reason' => $this->reason,
                'dateDeleted' => $this->dateDeleted,
                'status' => $this->status,
            ]);

            return BaseModel::query()
            ->update($this->tableNames[0], $updateData)
            ->where("deleteId = ? || email = ?", [$this->deleteId, $this->email])
            ->save();
        } catch (Exception $e) {
            Exceptions::exceptionHandler($e);
        }
    }

    // Delete a record from the database
    public function deleteQuery()
    {
        try {
            return BaseModel::query()
                ->delete($this->tableNames[0])
                ->where("deleteId = ? || email = ?", [$this->deleteId, $this->email])
                ->save();
        } catch (Exception $e) {
            Exceptions::exceptionHandler($e);
        }
    }
}
