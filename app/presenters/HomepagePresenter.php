<?php

namespace App\Presenters;

use Nette;
use App\Model\EventManager;


class HomepagePresenter extends BasePresenter
{
    
    private $eventManager;

    public function __construct(EventManager $eventManager)
    {
        $this->eventManager = $eventManager;
    }

    public function renderDefault()
	{
    	$this->template->events = $this->eventManager->getComingEvents()
        ->limit(5);
	}
}
