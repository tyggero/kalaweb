<?php

namespace App\Model;

use Nette;
use Nette\Utils\DateTime;

class EventManager
{
    use Nette\SmartObject;

    /**
     * @var Nette\Database\Context
     */
    private $database;

    public function __construct(Nette\Database\Context $database)
    {
        $this->database = $database;
    }

    public function getComingEvents()
    {
        return $this->database->table('events')
            ->where('end_date >= ', date('Y-m-d'))
            ->where('removed = 0')
            ->order('start_date ASC');
    }

    public function getPastEvents()
    {
        return $this->database->table('events')
            ->where('start_date <= ', date('Y-m-d'))
            ->where('removed = 0')
            ->order('end_date DESC');
    }

    public function getEvent($eventId)
    {
        $event = $this->database->table('events')->get($eventId); //když nedostane z databáze, vrací NULL
        return $event;
    }

    public function saveEvent($values)
    {
        //změnit přijatý formát datumů na formát v DB
        $values->start_date = date('Y-m-d H:i:s', strtotime($values->start_date));
        $values->end_date = date('Y-m-d H:i:s', strtotime($values->end_date));

        if($values->id){
            $event = $this->database->table('events')->get($values->id);
            $event->update($values);
        }else{
            $event = $this->database->table('events')->insert($values);
        }
        return $event;
    }

    public function removeEvent($eventId)
    {
        $event = $this->database->table('events')->get($eventId);
        $event->update(array('removed' => 1));
        return $event;
    }

    public function restoreEvent($eventId)
    {
        $event = $this->database->table('events')->get($eventId);
        $event->update(array('removed' => 0));
        return $event;
    }
}