<?php

namespace Hitek\Slimez\App\Models;

use Hitek\Slimez\Core\BaseModel;

class CountriesInAfricaModel extends BaseModel
{
    protected $countryId;
    protected $countryName;
    protected $countryCode;
    protected $status;

    private $tableNames = ['countriesInAfrica'];

    // Chainable setters for fluency
    public function setCountryId($countryId): self
    {
        $this->countryId = $countryId;
        return $this;
    }

    public function setCountryName($countryName): self
    {
        $this->countryName = $countryName;
        return $this;
    }

    public function setCountryCode($countryCode): self
    {
        $this->countryCode = $countryCode;
        return $this;
    }

    public function setStatus($status): self
    {
        $this->status = $status;
        return $this;
    }

    // Select country data
    public function selectQuery()
    {
        return $this->query()
            ->select($this->tableNames[0])
            ->where("countryId = ?", [$this->countryId])
            ->first();
    }

    // Insert country data
    public function insertQuery()
    {
        $insertData = [
            'countryId' => $this->countryId,
            'countryName' => $this->countryName,
            'countryCode' => $this->countryCode,
            'status' => $this->status,
        ];

        return $this->query()
            ->insert($this->tableNames[0], $insertData)
            ->save();
    }

    // Update country data
    public function updateQuery()
    {
        $updateData = array_filter([
            'countryName' => $this->countryName,
            'countryCode' => $this->countryCode,
            'status' => $this->status,
        ], function($value) { return !is_null($value); });

        if (empty($updateData)) {
            return false; // No data to update
        }

        return $this->query()
            ->update($this->tableNames[0], $updateData)
            ->where("countryId = ?", [$this->countryId])
            ->save();
    }

    // Delete country data
    public function deleteQuery()
    {
        if (empty($this->countryId)) {
            // Handle error: No identifier provided
            return false;
        }

        return $this->query()
            ->delete($this->tableNames[0])
            ->where("countryId = ?", [$this->countryId])
            ->save();
    }
}
