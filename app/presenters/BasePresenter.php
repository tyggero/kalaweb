<?php
namespace App\Presenters;

use Nette;
use Nette\Security\User;

abstract class BasePresenter extends Nette\Application\UI\Presenter
{
    
    /** @persistent */
    public $backlink;

    public $formFactory;
    
    public function startup()
    {
        parent::startup();

        // KONTROLA OPRAVNENI (definovano v config.neon)
        if (!$this->user->isAllowed($this->name, $this->action)) {
            if($this->user->isLoggedIn()){
                $this->flashMessage('Nemáte dostatečná oprávnění', 'warning');
                $this->redirect('Homepage:');
            }else{
                $this->redirect('Sign:in', [
                    'backlink' => $this->storeRequest()
                ]);
            }
        }   
    }

    /**
     * Logout user
     */
    public function handleLogout()
    {
        $this->user->logOut();
        $this->flashMessage('Odhlásili jsme tě');
        $this->redirect('this');
    }

    /**
     * Vrátí upravený form pro bootstrap apod.
     */
    public function form()
    {
        $form = new \Nette\Application\UI\Form;

        $renderer = $form->getRenderer();

        $renderer->wrappers['controls']['container'] = null;
        $renderer->wrappers['pair']['container'] = 'div class=form-group';
        $renderer->wrappers['pair']['.error'] = 'has-error';
        $renderer->wrappers['control']['container'] = 'div class=col-sm-9';
        $renderer->wrappers['label']['container'] = 'div class="col-sm-3 control-label"';
        $renderer->wrappers['control']['description'] = 'span class=help-block';
        $renderer->wrappers['control']['errorcontainer'] = 'span class=help-block';

        $form->getElementPrototype()->class('form-horizontal');

        $form->onRender[] = function ($form) {
            foreach ($form->getControls() as $control) {
                $type = $control->getOption('type');
                if ($type === 'button') {
                    $control->getControlPrototype()->addClass(empty($usedPrimary) ? 'btn btn-primary' : 'btn btn-default');
                    $usedPrimary = true;
                } elseif (in_array($type, ['text', 'textarea', 'select'], true)) {
                    $control->getControlPrototype()->addClass('form-control');
                } elseif (in_array($type, ['checkbox', 'radio'], true)) {
                    $control->getSeparatorPrototype()->setName('div')->addClass($type);
                }
            }
        };

        return $form;
    }
}
