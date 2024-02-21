<?php

namespace Hitek\Slimez\App\Models;

use Exception;
use Hitek\Slimez\Core\BaseModel;
use Hitek\Slimez\Core\Exceptions;

class VpnConfigsModel extends BaseModel
{
    protected $confId;
    protected $confCountryCode;
    protected $configFile;
    protected $flagImage;
    protected $zoneNumber;
    protected $username;
    protected $password;
    protected $protocol;
    protected $status;

    protected $tableNames = ['vpn_configs'];

    // Getters and setters are omitted for brevity but follow the same pattern as shown above
    // Getter and Setter for confId
    public function getConfId()
    {
        return $this->confId;
    }

    public function setConfId($confId): self
    {
        $this->confId = $confId;
        return $this;
    }

    // Getter and Setter for confCountryCode
    public function getConfCountryCode()
    {
        return $this->confCountryCode;
    }

    public function setConfCountryCode($confCountryCode): self
    {
        $this->confCountryCode = $confCountryCode;
        return $this;
    }

    // Getter and Setter for configFile
    public function getConfigFile()
    {
        return $this->configFile;
    }

    public function setConfigFile($configFile): self
    {
        $this->configFile = $configFile;
        return $this;
    }

    // Getter and Setter for flagImage
    public function getFlagImage()
    {
        return $this->flagImage;
    }

    public function setFlagImage($flagImage): self
    {
        $this->flagImage = $flagImage;
        return $this;
    }

    // Getter and Setter for zoneNumber
    public function getZoneNumber()
    {
        return $this->zoneNumber;
    }

    public function setZoneNumber($zoneNumber): self
    {
        $this->zoneNumber = $zoneNumber;
        return $this;
    }

    // Getter and Setter for username
    public function getUsername()
    {
        return $this->username;
    }

    public function setUsername($username): self
    {
        $this->username = $username;
        return $this;
    }

    // Getter and Setter for password
    public function getPassword()
    {
        return $this->password;
    }

    public function setPassword($password): self
    {
        $this->password = $password;
        return $this;
    }

    // Getter and Setter for protocol
    public function getProtocol()
    {
        return $this->protocol;
    }

    public function setProtocol($protocol): self
    {
        $this->protocol = $protocol;
        return $this;
    }

    // Getter and Setter for status
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
                    ->where("confId = ? || status = ?", [$this->confId, $this->status])
                    ->get();
            }

            return BaseModel::query()->select($this->tableNames[0])
                ->where("confId = ? || status = ?", [$this->confId, $this->status])->first();
        } catch (Exception $e) {
            Exceptions::exceptionHandler($e);
        }
    }

    public function insertQuery()
    {
        try {
            return BaseModel::query()->insert($this->tableNames[0], [
                'confId' => $this->confId,
                'confCountryCode' => $this->confCountryCode,
                'configFile' => $this->configFile,
                'flagImage' => $this->flagImage,
                'zoneNumber' => $this->zoneNumber,
                'username' => $this->username,
                'password' => $this->password,
                'protocol' => $this->protocol,
                'status' => $this->status,
            ])->save();
        } catch (Exception $e) {
            Exceptions::exceptionHandler($e);
        }
    }

    public function updateQuery()
    {
        $updateData = array_filter([
            'confCountryCode' => $this->confCountryCode,
            'configFile' => $this->configFile,
            'flagImage' => $this->flagImage,
            'zoneNumber' => $this->zoneNumber,
            'username' => $this->username,
            'password' => $this->password,
            'protocol' => $this->protocol,
            'status' => $this->status,
        ]);

        if (empty($updateData)) {
            return false; // No data to update
        }

        try {

            return BaseModel::query()
                    ->update(tableName: $this->tableNames[0], dataValues: $updateData)
                    ->where("confId = ?", [$this->confId])
                    ->save();
        } catch (Exception $e) {
            Exceptions::exceptionHandler($e);
        }
    }

    public function deleteQuery()
    {
        try {
            return BaseModel::query()->delete($this->tableNames[0])->where("confId = ?", [$this->confId])->save();
        } catch (Exception $e) {
            Exceptions::exceptionHandler($e);
        }
    }
}
