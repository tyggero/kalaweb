<?php
namespace App\Presenters;

use Nette;
use App\Model\EventManager;
//use Nette\Application\UI\Form;

class EventPresenter extends BasePresenter
{
    private $eventManager;

    //metoda form() definovana v BasePresenter

    public function __construct(EventManager $eventManager)
    {
        $this->eventManager = $eventManager;
    }

    public function renderShow($eventId)
	{
    	$this->template->event = $this->eventManager->getEvent($eventId);
	}

	public function actionCreate()
	{
		if(!$this->getUser()->isLoggedIn()){
			$this->redirect('Sign:in');
		}
	}

	// action upravy clanku
	public function actionEdit($eventId)
	{
	    $event = $this->eventManager->getEvent($eventId);
	    if (!$event) {
	        $this->error('Akce nebyla nalezena');
	    }
        $eventArray = $event->toArray();
        $eventArray['start_date_dateString'] = $this->eventManager->getFormatedDateStr($eventArray['start_date']);
        $eventArray['start_date_timeString'] = $this->eventManager->getFormatedTimeStr($eventArray['start_date']);
        $eventArray['end_date_dateString'] = $this->eventManager->getFormatedDateStr($eventArray['end_date']);
        $eventArray['end_date_timeString'] = $this->eventManager->getFormatedTimeStr($eventArray['end_date']);
	    $this['eventForm']->setDefaults($eventArray);
	}

	public function actionRemove($eventId)
	{
		$event = $this->eventManager->removeEvent($eventId);
	    $this->flashMessage("Akce $event->name byla úspěšně smazána", 'success');
	    $this->redirect('Homepage:default');
	}

	public function actionRestore($eventId)
	{
		if (!$this->getUser()->isLoggedIn()) {
	        $this->redirect('Sign:in');
	    }

	    $event = $this->eventManager->restoreEvent($eventId);
	    $this->flashMessage("Akce $event->name byla úspěšně obnovena", 'success');
	    $this->redirect('Homepage:default');
	}

	// továrnička na formulář akce
	protected function createComponentEventForm()
	{
	    $form = $this->form();

	    $form->addText('name', 'Název akce:')
	        ->setRequired();

	    $form->addText("start_date_dateString", "Od:")
		    ->setRequired("Zadej datum začátku!")
            ->setAttribute("class", "datepicker-here")
            ->setAttribute("data-language", "cs");
	    $form->addText('start_date_timeString', 'Sraz:');

	    $form->addText('start_place', 'místo:');

	    $form->addText('end_date_dateString', 'Do:')
	    	->setRequired("Zadej datum konce!")
            ->setAttribute("class", "datepicker-here")
            ->setAttribute("data-language", "cs");
        $form->addText('end_date_timeString', 'Sraz:');

	    $form->addText('end_place', 'místo:');

	    $form->addText('bring', 'S sebou:');

	    $form->addTextArea('text', 'Text:');

	    $form->addTextArea('notes', 'Poznámky (toto uvidí jen vedení):');

	    $form->addSubmit('send', 'Uložit akci');

	    $form->onSuccess[] = [$this, 'eventFormSucceeded']; // po uspesnem odeslani formulare zavolat tuto metodu
	    return $form;
	}

	// callback zpracovani formulare
	public function eventFormSucceeded($form, $values)
	{
	    if (!$this->getUser()->isLoggedIn()) {
	        $this->error('Pro vytvoření nebo editování akce se musíš přihlásit.');
	    }

	    $values->id = $this->getParameter('eventId');

        //spojit přijatý formát datumu a času na formát datumu v DB
        //$values->start_date = date('Y-m-d H:i:s', strtotime($values->start_date_dateString." ".$values->start_date_timeString));
        $values->start_date = $this->eventManager->createDate($values->start_date_dateString, $values->start_date_timeString);
        unset($values->start_date_dateString);
        unset($values->start_date_timeString);
        //$values->end_date = date('Y-m-d H:i:s', strtotime($values->end_date_dateString." ".$values->end_date_timeString));
        $values->end_date = $this->eventManager->createDate($values->end_date_dateString, $values->end_date_timeString);
        unset($values->end_date_dateString);
        unset($values->end_date_timeString);

	    $event = $this->eventManager->saveEvent($values);

	    $this->flashMessage("Akce byla úspěšně uložena.", 'success'); // flash message se vkládá přímo do Layoutu
	    $this->redirect('show', $event->id);
	}
}