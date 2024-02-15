<?php

namespace Hitek\Slimez\App\Models;

use Exception;
use Hitek\Slimez\Core\BaseModel;
use Hitek\Slimez\Core\Exceptions;

class EventsCalendarModel
{
    protected $eventId;
    protected $eventName;
    protected $eventDescription;
    protected $eventDate;
    protected $eventLocation;
    protected $status;
    protected $createdAt;
    protected $updatedAt;

    private $tableNames = ['EventsCalendar'];

    // Setters
    public function setEventId($eventId)
    {
        $this->eventId = $eventId;
    }
    public function setEventName($eventName)
    {
        $this->eventName = $eventName;
    }
    public function setEventDescription($eventDescription)
    {
        $this->eventDescription = $eventDescription;
    }
    public function setEventDate($eventDate)
    {
        $this->eventDate = $eventDate;
    }
    public function setEventLocation($eventLocation)
    {
        $this->eventLocation = $eventLocation;
    }
    public function setStatus($status)
    {
        $this->status = $status;
    }
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;
    }
    public function setUpdatedAt($updatedAt)
    {
        $this->updatedAt = $updatedAt;
    }

    // Getters
    public function getEventId()
    {
        return $this->eventId;
    }
    public function getEventName()
    {
        return $this->eventName;
    }
    public function getEventDescription()
    {
        return $this->eventDescription;
    }
    public function getEventDate()
    {
        return $this->eventDate;
    }
    public function getEventLocation()
    {
        return $this->eventLocation;
    }
    public function getStatus()
    {
        return $this->status;
    }
    public function getCreatedAt()
    {
        return $this->createdAt;
    }
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }

    // CRUD Operations

    // Select an event record
    public function selectQuery()
    {
        try {
            return BaseModel::query()
                ->select(tableName: $this->tableNames[0])
                ->where("eventId = ?", [$this->eventId])
                ->first();
        } catch (Exception $e) {
            Exceptions::exceptionHandler($e);
            return null;
        }
    }

    // Insert a new event record
    public function insertQuery()
    {
        try {
            $insertData = [
                'eventId' => $this->eventId,
                'eventName' => $this->eventName,
                'eventDescription' => $this->eventDescription,
                'eventDate' => $this->eventDate,
                'eventLocation' => $this->eventLocation,
                'status' => $this->status,
                'createdAt' => $this->createdAt, // Assuming `createdAt` is managed manually
                'updatedAt' => $this->updatedAt,
            ];

            return BaseModel::query()
                ->insert(tableName: $this->tableNames[0], query: $insertData)
                ->save();
        } catch (Exception $e) {
            Exceptions::exceptionHandler($e);
            return null;
        }
    }

    // Update an event record
    public function updateQuery()
    {
        try {
            $updateData = [
                'eventName' => $this->eventName,
                'eventDescription' => $this->eventDescription,
                'eventDate' => $this->eventDate,
                'eventLocation' => $this->eventLocation,
                'status' => $this->status,
                'updatedAt' => $this->updatedAt,
            ];

            return BaseModel::query()
                ->update(tableName: $this->tableNames[0], dataValues: $updateData)
                ->where("eventId = ?", [$this->eventId])
                ->save();
        } catch (Exception $e) {
            Exceptions::exceptionHandler($e);
            return null;
        }
    }

    // Delete an event record
    public function deleteQuery()
    {
        try {
            if (empty($this->eventId)) {
                // Handle error: No identifier provided
                throw new Exception("No eventId provided for delete operation.");
            }
            return BaseModel::query()
                ->delete(tableName: $this->tableNames[0])
                ->where("eventId = ?", [$this->eventId])
                ->save();
        } catch (Exception $e) {
            Exceptions::exceptionHandler($e);
            return null;
        }
    }
}
