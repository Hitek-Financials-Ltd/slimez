<?php


namespace Hitek\Slimez\App\Models;

use Exception;
use Hitek\Slimez\Core\BaseModel;
use Hitek\Slimez\Core\Security;
use Hitek\Slimez\Core\Exceptions;

class UserModel
{
    protected $userId;
    protected $username;
    protected $email;
    protected $password;
    protected $fname; // First Name
    protected $mname; // Middle Name
    protected $lname; // Last Name
    protected $phone;
    protected $country;
    protected $address;
    protected $gender;
    protected $status;
    protected $timestamp;

    protected $tableNames = array('users');

    // Assuming other necessary properties and methods exist...

    // Getters and Setters

    public function getUserId()
    {
        return $this->userId;
    }

    public function setUserId($userId)
    {
        $this->userId = $userId;
        return $this;
    }

    public function getUsername()
    {
        return Security::decryption(Security::insertForwardSlashed($this->username));
    }

    public function setUsername($username)
    {
        $this->username = Security::replaceForwardSlashed(Security::encryption(Security::removeSpaces($username)));
        return $this;
    }

    public function getEmail()
    {
        return Security::decryption(Security::insertForwardSlashed($this->email));
    }

    public function setEmail($email)
    {
        $this->email = Security::replaceForwardSlashed(Security::encryption(Security::removeSpaces($email)));
        return $this;
    }

    public function getPassword()
    {
        return Security::insertForwardSlashed($this->password);
    }

    public function setPassword($password)
    {
        $this->password = Security::replaceForwardSlashed(Security::hashPassword($password));
        return $this;
    }

    public function getFname()
    {
        return Security::decryption(Security::insertForwardSlashed($this->fname));
    }

    public function setFname($fname)
    {
        $this->fname = Security::replaceForwardSlashed(Security::encryption(Security::removeSpaces($fname)));
        return $this;
    }

    public function getMname()
    {
        return Security::decryption(Security::insertForwardSlashed($this->mname));
    }

    public function setMname($mname)
    {
        $this->mname = Security::replaceForwardSlashed(Security::encryption(Security::removeSpaces($mname)));
        return $this;
    }

    public function getLname()
    {
        return Security::decryption(Security::insertForwardSlashed($this->lname));
    }

    public function setLname($lname)
    {
        $this->lname = Security::replaceForwardSlashed(Security::encryption(Security::removeSpaces($lname)));
        return $this;
    }

    public function getPhone()
    {
        return Security::decryption(Security::insertForwardSlashed($this->phone));
    }

    public function setPhone($phone)
    {
        $this->phone = Security::replaceForwardSlashed(Security::encryption(Security::formatMobile($phone)));
        return $this;
    }

    public function getCountry()
    {
        return $this->country;
    }

    public function setCountry($country)
    {
        $this->country = $country;
        return $this;
    }

    public function getAddress()
    {
        return $this->address;
    }

    public function setAddress($address)
    {
        $this->address = $address;
        return $this;
    }

    public function getGender()
    {
        return $this->gender;
    }

    public function setGender($gender)
    {
        $this->gender = $gender;
        return $this;
    }

    public function getStatus()
    {
        return $this->status;
    }

    public function setStatus($status)
    {
        $this->status = $status;
        return $this;
    }

    public function getTimestamp()
    {
        return $this->timestamp;
    }

    public function setTimestamp($timestamp)
    {
        $this->timestamp = $timestamp;
        return $this;
    }

    // select the user data
    public function selectQuery()
    {
        try {
            return BaseModel::query()
                ->select(tableName: $this->tableNames[0])
                ->where("userId = ? || email = ? || phone = ? || username = ?", [$this->userId, $this->email, $this->phone, $this->username])
                ->first();
        } catch (Exception $e) {
            Exceptions::exceptionHandler($e);
        }
    }

    // delete data
    public function deleteQuery(bool $isSoftDelete = true)
    {
        try {
            $whereCondition = !empty($this->userId) ? "userId = ?" : (!empty($this->email) ? "email = ?" : null);
            $updateValue = !empty($this->userId) ? $this->userId : $this->email;

            if ($whereCondition === null) {
                // Handle error: No identifier provided
                return false;
            }

            if ($isSoftDelete) {
                return BaseModel::query()
                    ->update(tableName: $this->tableNames[0], dataValues: ["status" => 5])
                    ->where($whereCondition, [$updateValue])
                    ->save();
            } else {
                return BaseModel::query()
                    ->delete(tableName: $this->tableNames[0])
                    ->where($whereCondition, [$updateValue])
                    ->save();
            }
        } catch (Exception $e) {
            Exceptions::exceptionHandler($e);
        }
    }



    // update the users table 
    public function updateQuery()
    {
        try {
            $updateData = array_filter([
                "fname" => $this->fname,
                "mname" => $this->mname,
                "lname" => $this->lname,
                "address" => $this->address,
                "gender" => $this->gender,
                "email" => $this->email,
                "phone" => $this->phone,
                "username" => $this->username,
                "timestamp" => $this->timestamp
            ]);

            if (empty($updateData)) {
                return false; // No data to update
            }

            $updateValue = !empty($this->userId) ? $this->userId : $this->email;

            return BaseModel::query()
                ->update(tableName: $this->tableNames[0], dataValues: $updateData)
                ->where("userId = ? || email = ?", [$updateValue, $updateValue])
                ->save();
        } catch (Exception $e) {
            Exceptions::exceptionHandler($e);
        }
    }


    //    insert data to table
    public function insertQuery()
    {
        try {
            $dbTransactionData = [
                $this->tableNames,
                [
                    ['userId' => $this->userId, 'email' => $this->email, 'password' => $this->password],
                    // Include other related table data as needed
                ]
            ];

            return BaseModel::query()
                ->insertDbTransact(transactionData: $dbTransactionData)
                ->save();
        } catch (Exception $e) {
            Exceptions::exceptionHandler($e);
        }
    }
}
