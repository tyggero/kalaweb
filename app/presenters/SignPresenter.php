<?php
namespace App\Presenters;

use Nette;
use Nette\Application\UI\Form;
use App\Model\UserManager;

class SignPresenter extends BasePresenter
{
    private $userManager;

    public function __construct(UserManager $userManager)
    {
        $this->userManager = $userManager;
    }

    protected function createComponentSignInForm()
    {
    	$form = $this->form();
    	$form->addText('username', 'E-mail:')
    		->setRequired('Musíš vyplnit e-mail');

    	$form->addPassword('password', 'Heslo:')
    		->setRequired('Musíš vyplnit heslo');

    	$form->addSubmit('send', 'Přihlásit se');

    	$form->onSuccess[] = [$this, 'signInFormSucceeded'];
    	return $form;
    }

    public function signInFormSucceeded($form, $values)
	{
	    try {
	        $this->getUser()->login($values->username, $values->password);
	        $this->restoreRequest($this->backlink);
            $this->redirect('Homepage:');

	    } catch (Nette\Security\AuthenticationException $e) {
	        $form->addError("Nesprávný e-mail nebo heslo.");
	    }
	}

	public function actionOut()
	{
	    $this->getUser()->logout();
	    $this->flashMessage('Odhlášení bylo úspěšné.');
	    $this->redirect('Homepage:');
	}

	protected function createComponentSignUpForm()
    {
    	$form = $this->form();
    	$form->addEmail('email', 'E-mail:')
    		->setRequired('Musíš vyplnit email')
    		->addRule(Form::EMAIL, 'Neplatná emailová adresa');

    	$form->addPassword('password', 'Heslo:')
    		->setRequired('Zadej heslo');

    	$form->addPassword('password2', 'Kontrola hesla:')
    		->setRequired('Vyplň heslo pro kontrolu')
    		->addRule(Form::EQUAL, 'Hesla se neshodují', $form['password']);

    	$form->addText('nickname', 'Přezdívka:')
    		->setRequired('Musíte vyplnit uživatelské jméno');

    	$form->addText('firstname', 'Jméno:')
    		->setRequired('Musíte vyplnit uživatelské jméno');

    	$form->addText('surname', 'Příjmení:')
    		->setRequired('Musíte vyplnit uživatelské jméno');
    	

    	$form->addSubmit('send', 'Registrovat se');

    	$form->onSuccess[] = [$this, 'signUpFormSucceeded'];
    	return $form;
    }

    public function signUpFormSucceeded($form, $values)
	{
	    $values->id = $this->getParameter('eventId');

	    try{
	    	$user = $this->userManager->saveUser($values);
	    	$this->flashMessage("Registrace proběhla úpěšně.", 'success'); // flash message se vkládá přímo do Layoutu
	    	$this->redirect('Sign:in');
	    } catch (Nette\Database\UniqueConstraintViolationException $e) {
	        $form->addError("Tento email už je registrován.");
	    }
	}
    
}