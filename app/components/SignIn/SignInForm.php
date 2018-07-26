<?php

namespace App\Components;

use Nette;
use Nette\Application\UI\Form;
use Nette\Security\User;
use Nette\Application\UI\Control;


class SignInForm extends Control
{
    
        public $onFormSubmit;
	/** @var User */
	private $user;

	public function __construct(User $user)
	{
		$this->user = $user;
	}
        
        public function render() {
            $this->template->setFile(__DIR__ . '/SignInForm.latte');
            $this->template->render();
        }

	protected function createComponentForm()
	{
		$form = new Form();
		$form->addText('username', 'Uživatelské jméno:')
			->setRequired('Prosím zadejte své jméno.');

		$form->addPassword('password', 'Heslo:')
			->setRequired('Prosím zadejte své heslo.');

		$form->addCheckbox('remember', 'Udržet mě přihlášeného');

		$form->addSubmit('send', 'Přihlásit')
                     ->setAttribute('class', 'btn btn-primary');

		$form->onSuccess[] = [$this, 'handleForm'];

		return $form;
	}
        
        public function handleForm(Form $form, $values){
            if($form->isSuccess()){
                        try {
				$this->user->setExpiration($values->remember ? '14 days' : '20 minutes');
				$this->user->login($values->username, $values->password);
                                $this->onFormSubmit();
			} catch (Nette\Security\AuthenticationException $e) {
				$form->addError('Jméno či heslo je nesprávné.');
				return;
			}
            }
            
        }
}

interface ISignInFormFactory
{
    /**
     * @return SignInForm
     */
    public function create();
}
