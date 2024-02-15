<?php


namespace Hitek\Slimez\App\Models;

use Hitek\Slimez\Core\BaseModel;

class UserMetaDataModel extends BaseModel
{

    /**
     *@var string user metadata userid property 
     */
    protected $userId;
    /**
     *@var string user metadata device name property 
     */
    protected $deviceName;
    /**
     *@var string user metadata device id property 
     */
    protected $deviceId;

    /**
     *@var string user metadata ip property 
     */
    protected $ipAddress;
    /**
     *@var string database table name
     */
    protected $tableName = 'users_metadata';

    /**
     * Get the value of userId
     */
    public function getUserId()
    {
        return $this->userId;
    }

    /**
     * Set the value of userId
     */
    public function setUserId($userId): self
    {
        $this->userId = $userId;
        return $this;
    }

    /**
     * Get the value of deviceName
     */
    public function getDeviceName()
    {
        return $this->deviceName;
    }

    /**
     * Set the value of deviceName
     */
    public function setDeviceName($deviceName): self
    {
        $this->deviceName = $deviceName;
        return $this;
    }

    /**
     * Get the value of deviceId
     */
    public function getDeviceId()
    {
        return $this->deviceId;
    }

    /**
     * Set the value of deviceId
     */
    public function setDeviceId($deviceId): self
    {
        $this->deviceId = $deviceId;
        return $this;
    }

    /**
     * Get the value of ipAddress
     */
    public function getIpAddress()
    {
        return $this->ipAddress;
    }

    /**
     * Set the value of ipAddress
     */
    public function setIpAddress($ipAddress): self
    {
        $this->ipAddress = $ipAddress;
        return $this;
    }


    /**
     * delete from user metadata table
     */
/**
     * delete from account settings table
     */

     public function deleteQuery(): BaseModel
     {
         /**
          * @var array prepare the array data of the row to be deleted 
          * make sure the array key correspond with the database table field to be deleted
          * the array must not be greater than 1 or less than 0
          */
        return $this;
     }
 
     /**
      * select from account settings table
      */
     public function selectQuery():BaseModel
     {
         /**
          * select from settings table
          */
        return $this;
     }
 
     /**
      * @var array get all the accounts settings
      */
 
     public function selectAllQuery(): BaseModel
     {
         /**
          * select from account settings table
          */
        
         /**
          * return the data to the client
          */
         return $this;
     }
 
     /**
      * update data in account settings table
      */
     public function updateQuery(): BaseModel
     {
         /**
          * @var array prepare the array data of the row to be updated 
          * make sure the array key correspond with the database table field to be updated
          * the array must not be greater than 1 or less than 0
          */
        return $this;
     }
 
     /**
      *@var BaseModel insert into account settings table
      */
     public function insertQuery(): BaseModel
     {
         /**
          * @var array prepare the array data to be inserted into account settings table
          * make sure the array key correspond with the database table field the data is to be inserted
          * you can insert 1 or all at once it doesn't matter, but make sure the the key is thesame as the table field
          */
         
         /**
          * insert into account settings table, do not forget to call the save() method else the data will not be 
          * saved to the database
          */
         return $this;
     }
}
