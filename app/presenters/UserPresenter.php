<?php
namespace App\Presenters;

use Nette;
use App\Model\UserManager;
use Nette\Application\UI\Form;

class UserPresenter extends BasePresenter
{
    private $userManager;

    public function __construct(UserManager $userManager)
    {
        $this->userManager = $userManager;
    }

    public function renderList()
	{
    	$this->template->users = $this->userManager->getUsers();
	}

	public function actionEdit($usrId)
	{
	    $usr = $this->userManager->getUser($usrId);
	    if (!$usr) {
	        $this->error('Uživatel nebyl nalezen');
	    }
	    $this['userForm']->setDefaults($usr->toArray());
	}

	protected function createComponentUserForm()
    {
    	$form = $this->form();
    	$form->addEmail('email', 'E-mail:')
    		->setRequired('Musíš vyplnit email')
    		->addRule(Form::EMAIL, 'Neplatná emailová adresa');

    	$form->addText('nickname', 'Přezdívka:')
    		->setRequired('Musíte vyplnit uživatelské ppřezdívku');

    	$form->addText('firstname', 'Jméno:')
    		->setRequired('Musíte vyplnit jméno');

    	$form->addText('surname', 'Příjmení:')
    		->setRequired('Musíte vyplnit upříjmení');

    	$form->addRadioList('role', 'Role:', ['guest' => 'Návštěvník', 'member' => 'Aktivní vedoucí', 'admin' => 'Admin'])
    		->setRequired('Musíte vybrat roli');
    	

    	$form->addSubmit('send', 'Uložit');

    	$form->onSuccess[] = [$this, 'userFormSucceeded'];
    	return $form;
    }

    public function userFormSucceeded($form, $values)
	{
	    $values->id = $this->getParameter('usrId');

	    try{
	    	$user = $this->userManager->saveUser($values);
	    	$this->flashMessage("Uživatel byl uložen.", 'success'); // flash message se vkládá přímo do Layoutu
	    	$this->redirect('User:list');
	    } catch (Nette\Database\UniqueConstraintViolationException $e) {
	        $form->addError("Tento email už je registrován.");
	    }
	}
}