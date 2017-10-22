<?php
namespace App\Presenters;

use Nette;
use Nette\Application\UI\Form;

class PostPresenter extends BasePresenter
{
    /** @var Nette\Database\Context */
    private $database;

    // konstruktor
    public function __construct(Nette\Database\Context $database)
    {
        $this->database = $database;
    }

    // vyrenderuje podle šablony show.latte
    public function renderShow($postId)
    {
        $post = $this->database->table('posts')->get($postId);

    	if (!$post) {
            $this->error('Stránka nebyla nalezena');
        }
    
        $this->template->post = $post;

    	$this->template->comments = $post->related('comment')->order('created_at');
    }

    // Tovarnicka na formulare
    protected function createComponentCommentForm()
	{
	    $form = $this->form();

	    $form->addText('name', 'Jméno:')
	        ->setRequired();

	    $form->addEmail('email', 'Email:');

	    $form->addTextArea('content', 'Komentář:')
	        ->setRequired();

	    $form->addSubmit('send', 'Publikovat komentář');

	    $form->onSuccess[] = [$this, 'commentFormSucceeded']; // po uspesnem odeslani formulare zavolat tuto metodu
	    return $form;
	}

	// zpracovani formulare
	public function commentFormSucceeded($form, $values)
	{
	    $postId = $this->getParameter('postId');

	    $this->database->table('comments')->insert([
	        'post_id' => $postId,
	        'name' => $values->name,
	        'email' => $values->email,
	        'content' => $values->content,
	    ]);

	    $this->flashMessage('Děkuji za komentář', 'success');
	    $this->redirect('this');
	}

	// továrnička na přidání článku
	protected function createComponentPostForm()
	{
	    $form = $this->form();

	    $form->addText('title', 'Název:')
	        ->setRequired();

	    $form->addTextArea('content', 'Text článku:')
	        ->setRequired();

	    $form->addSubmit('send', 'Publikovat článek');

	    $form->onSuccess[] = [$this, 'postFormSucceeded']; // po uspesnem odeslani formulare zavolat tuto metodu
	    return $form;
	}

	// callback zpracovani formulare
	public function postFormSucceeded($form, $values)
	{
	    if (!$this->getUser()->isLoggedIn()) {
	        $this->error('Pro vytvoření nebo editování příspěvku se musíte přihlásit.');
	    }

	    $postId = $this->getParameter('postId');

	    if ($postId) {
	        $post = $this->database->table('posts')->get($postId);
	        $post->update($values);
	    } else {
	        $post = $this->database->table('posts')->insert($values);
	    }
	    $this->flashMessage("Příspěvek byl úspěšně publikován.", 'success'); // flash message se vkládá přímo do Layoutu
	    $this->redirect('show', $post->id);
	}

	// action upravy clanku
	public function actionEdit($postId)
	{
	    if (!$this->getUser()->isLoggedIn()) {
	        $this->redirect('Sign:in');
	    }

	    $post = $this->database->table('posts')->get($postId);
	    if (!$post) {
	        $this->error('Příspěvek nebyl nalezen');
	    }
	    $this['postForm']->setDefaults($post->toArray());
	}

	public function actionCreate()
	{
		if(!$this->getUser()->isLoggedIn()){
			$this->redirect('Sign:in');
		}
	}
}