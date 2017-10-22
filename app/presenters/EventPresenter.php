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
	    $this['eventForm']->setDefaults($event->toArray());
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

	    $form->addText("start_date", "Od:")
		    ->setRequired("Zadej datum začátku!")
		    ->setType('date');
	    //$form->addText('start_time', 'Sraz:')
	    //	->setType('time');
	    $form->addText('start_place', 'místo:');

	    $form->addText('end_date', 'Do:')
	    	->setRequired("Zadej datum konce!")
		    ->setType('date');
	    //$form->addText('end_time', 'Konec:')
	    //	->setType('time');
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

	    $event = $this->eventManager->saveEvent($values);

	    $this->flashMessage("Akce byla úspěšně uložena.", 'success'); // flash message se vkládá přímo do Layoutu
	    $this->redirect('show', $event->id);
	}
}