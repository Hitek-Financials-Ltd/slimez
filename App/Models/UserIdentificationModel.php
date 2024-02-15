<?php


namespace Hitek\Slimez\App\Models;

use Hitek\Slimez\Core\BaseModel;
use Hitek\Slimez\Core\Security;

class UserIdentificationModel extends BaseModel
{
    /**
     *@var string user identification identificationId property 
     */
    protected $identificationId;
    /**
     *@var string user Identification userid property 
     */
    protected $userId;
    /**
     *@var string user Identification meansOfIdentification property 
     */
    protected $meansOfIdentification;
    /**
     *@var string user Identification IdentificationNumber
     */
    protected $IdentificationNumber;

    /**
     *@var string user Identification IdentificationImage property 
     */
    protected $IdentificationImage;
    /**
     *@var string user Identification status property 
     */
    protected $status;
    /**
     *@var string database table name
     */
    protected $tableName = 'users_identification';

    /**
     * Get the value of identificationId
     */
    public function getIdentificationId()
    {
        return $this->identificationId;
    }

    /**
     * Set the value of identificationId
     */
    public function setIdentificationId($identificationId): self
    {
        $this->identificationId = $identificationId;
        return $this;
    }

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
     * Get the value of meansOfIdentification
     */
    public function getMeansOfIdentification()
    {
        return $this->meansOfIdentification;
    }

    /**
     * Set the value of meansOfIdentification
     */
    public function setMeansOfIdentification($meansOfIdentification): self
    {
        $this->meansOfIdentification = $meansOfIdentification;
        return $this;
    }

    /**
     * Get the value of IdentificationNumber
     */
    public function getIdentificationNumber()
    {
        return Security::decryption($this->IdentificationNumber);
    }

    /**
     * Set the value of IdentificationNumber
     */
    public function setIdentificationNumber($IdentificationNumber): self
    {
        $this->IdentificationNumber = Security::encryption($IdentificationNumber);
        return $this;
    }

    /**
     * Get the value of IdentificationImage
     */
    public function getIdentificationImage()
    {
        return $this->IdentificationImage;
    }

    /**
     * Set the value of IdentificationImage
     */
    public function setIdentificationImage($IdentificationImage): self
    {
        $this->IdentificationImage = $IdentificationImage;
        return $this;
    }

    /**
     * Get the value of status
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Set the value of status
     */
    public function setStatus($status): self
    {
        $this->status = $status;
        return $this;
    }

    /**
     * delete from user identification table
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
