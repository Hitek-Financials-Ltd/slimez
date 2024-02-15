<?php

namespace Hitek\Slimez\App\Models;

use Exception;
use Hitek\Slimez\Core\BaseModel;
use Hitek\Slimez\Core\Exceptions;

class UsersResearchInfoModel
{
    protected $usersResearchId;
    protected $userId;
    protected $numberOfYearsInResearch;
    protected $researchArea;
    protected $researchInterest;
    protected $dataCollectionMethods;
    protected $problemsSolved;
    protected $physicalAndSocialFactor;
    protected $toolsUsed;
    protected $isLabBased;
    protected $listJournals;
    protected $listCompanies;
    protected $limitations;
    protected $whichToCollaborate;
    protected $haveConsultancyExperience;
    protected $whatServiceDoYouProvide;
    protected $yourSDG;
    protected $haveWorkExperienceInResearch;
    protected $yearsOfWorkExperience;
    protected $takeLeadershipPosition;
    protected $whichPosition;
    protected $status;
    protected $createdAt;

    private $tableNames = ['usersResearchInfo'];

    // getters
    public function getUsersResearchId() {
        return $this->usersResearchId;
    }
    
    public function getUserId() {
        return $this->userId;
    }
    
    public function getNumberOfYearsInResearch() {
        return $this->numberOfYearsInResearch;
    }
    
    public function getResearchArea() {
        return $this->researchArea;
    }
    
    public function getResearchInterest() {
        return $this->researchInterest;
    }
    
    public function getDataCollectionMethods() {
        return $this->dataCollectionMethods;
    }
    
    public function getProblemsSolved() {
        return $this->problemsSolved;
    }
    
    public function getPhysicalAndSocialFactor() {
        return $this->physicalAndSocialFactor;
    }
    
    public function getToolsUsed() {
        return $this->toolsUsed;
    }
    
    public function getIsLabBased() {
        return $this->isLabBased;
    }
    
    public function getListJournals() {
        return $this->listJournals;
    }
    
    public function getListCompanies() {
        return $this->listCompanies;
    }
    
    public function getLimitations() {
        return $this->limitations;
    }
    
    public function getWhichToCollaborate() {
        return $this->whichToCollaborate;
    }
    
    public function getHaveConsultancyExperience() {
        return $this->haveConsultancyExperience;
    }
    
    public function getWhatServiceDoYouProvide() {
        return $this->whatServiceDoYouProvide;
    }
    
    public function getYourSDG() {
        return $this->yourSDG;
    }
    
    public function getHaveWorkExperienceInResearch() {
        return $this->haveWorkExperienceInResearch;
    }
    
    public function getYearsOfWorkExperience() {
        return $this->yearsOfWorkExperience;
    }
    
    public function getTakeLeadershipPosition() {
        return $this->takeLeadershipPosition;
    }
    
    public function getWhichPosition() {
        return $this->whichPosition;
    }
    
    public function getStatus() {
        return $this->status;
    }
    
    public function getCreatedAt() {
        return $this->createdAt;
    }
    

    // Setters
    public function setUsersResearchId($usersResearchId)
    {
        $this->usersResearchId = $usersResearchId;
        return $this;
    }
    public function setUserId($userId)
    {
        $this->userId = $userId;
        return $this;
    }
    public function setNumberOfYearsInResearch($numberOfYearsInResearch)
    {
        $this->numberOfYearsInResearch = $numberOfYearsInResearch;
        return $this;
    }
    public function setResearchArea($researchArea)
    {
        $this->researchArea = $researchArea;
        return $this;
    }
    public function setResearchInterest($researchInterest)
    {
        $this->researchInterest = $researchInterest;
        return $this;
    }
    public function setDataCollectionMethods($dataCollectionMethods)
    {
        $this->dataCollectionMethods = $dataCollectionMethods;
        return $this;
    }
    public function setProblemsSolved($problemsSolved)
    {
        $this->problemsSolved = $problemsSolved;
        return $this;
    }
    public function setPhysicalAndSocialFactor($physicalAndSocialFactor)
    {
        $this->physicalAndSocialFactor = $physicalAndSocialFactor;
        return $this;
    }
    public function setToolsUsed($toolsUsed)
    {
        $this->toolsUsed = $toolsUsed;
        return $this;
    }
    public function setIsLabBased($isLabBased)
    {
        $this->isLabBased = $isLabBased;
        return $this;
    }
    public function setListJournals($listJournals)
    {
        $this->listJournals = $listJournals;
        return $this;
    }
    public function setListCompanies($listCompanies)
    {
        $this->listCompanies = $listCompanies;
        return $this;
    }
    public function setLimitations($limitations)
    {
        $this->limitations = $limitations;
        return $this;
    }
    public function setWhichToCollaborate($whichToCollaborate)
    {
        $this->whichToCollaborate = $whichToCollaborate;
        return $this;
    }
    public function setHaveConsultancyExperience($haveConsultancyExperience)
    {
        $this->haveConsultancyExperience = $haveConsultancyExperience;
        return $this;
    }
    public function setWhatServiceDoYouProvide($whatServiceDoYouProvide)
    {
        $this->whatServiceDoYouProvide = $whatServiceDoYouProvide;
        return $this;
    }
    public function setYourSDG($yourSDG)
    {
        $this->yourSDG = $yourSDG;
        return $this;
    }
    public function setHaveWorkExperienceInResearch($haveWorkExperienceInResearch)
    {
        $this->haveWorkExperienceInResearch = $haveWorkExperienceInResearch;
        return $this;
    }
    public function setYearsOfWorkExperience($yearsOfWorkExperience)
    {
        $this->yearsOfWorkExperience = $yearsOfWorkExperience;
        return $this;
    }
    public function setTakeLeadershipPosition($takeLeadershipPosition)
    {
        $this->takeLeadershipPosition = $takeLeadershipPosition;
        return $this;
    }
    public function setWhichPosition($whichPosition)
    {
        $this->whichPosition = $whichPosition;
        return $this;
    }
    public function setStatus($status)
    {
        $this->status = $status;
        return $this;
    }
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;
        return $this;
    }

    // CRUD Operations

    // Select a user research information record
    public function selectQuery()
    {
        try {
            return BaseModel::query()
                ->select(tableName: $this->tableNames[0])
                ->where("usersResearchId = ?", [$this->usersResearchId])
                ->first();
        } catch (Exception $e) {
            Exceptions::exceptionHandler($e);
        }
    }

    // Insert a new user research information record
    public function insertQuery()
    {
        try {
            $insertData = [
                'usersResearchId' => $this->usersResearchId,
                'userId' => $this->userId,
                'numberOfYearsInResearch' => $this->numberOfYearsInResearch,
                'researchArea' => $this->researchArea,
                'researchInterest' => $this->researchInterest,
                'dataCollectionMethods' => $this->dataCollectionMethods,
                'problemsSolved' => $this->problemsSolved,
                'physicalAndSocialFactor' => $this->physicalAndSocialFactor,
                'toolsUsed' => $this->toolsUsed,
                'isLabBased' => $this->isLabBased,
                'listJournals' => $this->listJournals,
                'listCompanies' => $this->listCompanies,
                'limitations' => $this->limitations,
                'whichToCollaborate' => $this->whichToCollaborate,
                'haveConsultancyExperience' => $this->haveConsultancyExperience,
                'whatServiceDoYouProvide' => $this->whatServiceDoYouProvide,
                'yourSDG' => $this->yourSDG,
                'haveWorkExperienceInResearch' => $this->haveWorkExperienceInResearch,
                'yearsOfWorkExperience' => $this->yearsOfWorkExperience,
                'takeLeadershipPosition' => $this->takeLeadershipPosition,
                'whichPosition' => $this->whichPosition,
                'status' => $this->status,
                'createdAt' => $this->createdAt, // Assuming 'createdAt' is managed automatically by the database, you might not need to set it explicitly here
            ];
            

            return BaseModel::query()
                ->insert(tableName: $this->tableNames[0], query: $insertData)
                ->save();
        } catch (Exception $e) {
            Exceptions::exceptionHandler($e);
        }
    }

    // Update a user research information record
    public function updateQuery()
    {
        try {
            $updateData = [
                // Only include fields that are being updated
            ];

            return BaseModel::query()
                ->update(tableName: $this->tableNames[0], dataValues: $updateData)
                ->where("usersResearchId = ?", [$this->usersResearchId])
                ->save();
        } catch (Exception $e) {
            Exceptions::exceptionHandler($e);
        }
    }

    // Delete a user research information record
    public function deleteQuery()
    {
        try {
            if (empty($this->usersResearchId)) {
                return false; // Handle error: No identifier provided
            }
            return BaseModel::query()
                ->delete(tableName: $this->tableNames[0])
                ->where("usersResearchId = ?", [$this->usersResearchId])
                ->save();
        } catch (Exception $e) {
            Exceptions::exceptionHandler($e);
        }
    }
}
