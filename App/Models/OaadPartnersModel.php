<?php

namespace Hitek\Slimez\App\Models;

use Exception;
use Hitek\Slimez\Core\BaseModel;
use Hitek\Slimez\Core\Exceptions;

class OaadPartnersModel
{
    protected $partnerId;
    protected $partnerName;
    protected $partnerLogo;
    protected $partnerWebsite;
    protected $partnershipDetails;
    protected $durationInMonths;
    protected $status;
    protected $createdAt;

    private $tableNames = ['oaadPartners'];

    // Setters
    public function setPartnerId($partnerId)
    {
        $this->partnerId = $partnerId;
    }
    public function setPartnerName($partnerName)
    {
        $this->partnerName = $partnerName;
    }
    public function setPartnerLogo($partnerLogo)
    {
        $this->partnerLogo = $partnerLogo;
    }
    public function setPartnerWebsite($partnerWebsite)
    {
        $this->partnerWebsite = $partnerWebsite;
    }
    public function setPartnershipDetails($partnershipDetails)
    {
        $this->partnershipDetails = $partnershipDetails;
    }
    public function setDurationInMonths($durationInMonths)
    {
        $this->durationInMonths = $durationInMonths;
    }
    public function setStatus($status)
    {
        $this->status = $status;
    }
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;
    }

    // Getters
    public function getPartnerId()
    {
        return $this->partnerId;
    }
    public function getPartnerName()
    {
        return $this->partnerName;
    }
    public function getPartnerLogo()
    {
        return $this->partnerLogo;
    }
    public function getPartnerWebsite()
    {
        return $this->partnerWebsite;
    }
    public function getPartnershipDetails()
    {
        return $this->partnershipDetails;
    }
    public function getDurationInMonths()
    {
        return $this->durationInMonths;
    }
    public function getStatus()
    {
        return $this->status;
    }
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    // CRUD Operations

    // Select a partner record
    public function selectQuery()
    {
        try {
            return BaseModel::query()
                ->select(tableName: $this->tableNames[0])
                ->where("partnerId = ?", [$this->partnerId])
                ->first();
        } catch (Exception $e) {
            Exceptions::exceptionHandler($e);
        }
    }

    // Insert a new partner record
    public function insertQuery()
    {
        try {
            $insertData = [
                'partnerId' => $this->partnerId,
                'partnerName' => $this->partnerName,
                'partnerLogo' => $this->partnerLogo,
                'partnerWebsite' => $this->partnerWebsite,
                'partnershipDetails' => $this->partnershipDetails,
                'durationInMonths' => $this->durationInMonths,
                'status' => $this->status,
                'createdAt' => $this->createdAt,
            ];

            return BaseModel::query()
                ->insert(tableName: $this->tableNames[0], query: $insertData)
                ->save();
        } catch (Exception $e) {
            Exceptions::exceptionHandler($e);
        }
    }

    // Update a partner record
    public function updateQuery()
    {
        try {
            $updateData = array_filter([
                'partnerName' => $this->partnerName,
                'partnerLogo' => $this->partnerLogo,
                'partnerWebsite' => $this->partnerWebsite,
                'partnershipDetails' => $this->partnershipDetails,
                'durationInMonths' => $this->durationInMonths,
                'status' => $this->status,
                // Typically, createdAt would not be updated.
            ], function ($value) {
                return !is_null($value);
            });

            if (empty($updateData)) {
                return false; // No data to update
            }

            return BaseModel::query()
                ->update(tableName: $this->tableNames[0], dataValues: $updateData)
                ->where("partnerId = ?", [$this->partnerId])
                ->save();
        } catch (Exception $e) {
            Exceptions::exceptionHandler($e);
        }
    }

    // Delete a partner record
    public function deleteQuery()
    {
        try {
            if (empty($this->partnerId)) {
                return false; // Handle error: No identifier provided
            }
            return BaseModel::query()
                ->delete(tableName: $this->tableNames[0])
                ->where("partnerId = ?", [$this->partnerId])
                ->save();
        } catch (Exception $e) {
            Exceptions::exceptionHandler($e);
        }
    }
}
