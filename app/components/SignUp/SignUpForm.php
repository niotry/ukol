<?php

namespace App\Components;

use App\Model;
use Nette;
use Nette\Application\UI\Form;
use Nette\Application\UI\Control;


class SignUpForm extends Control
{
    
	const PASSWORD_MIN_LENGTH = 7;

	private $userManager;
        
        public $onFormSubmit;


	public function __construct(Model\UserManager $userManager)
	{
		$this->userManager = $userManager;
	}
        
        public function render(){
            $this->template->setFile(__DIR__.'/SignUpForm.latte');
            $this->template->render();
        }
        
	protected function createComponentForm()
	{
		$form = new Form;
		$form->addText('username', 'Uživatelské jméno:')
			->setRequired('Vypiště uživatelské jméno.');

		$form->addEmail('email', 'Váš e-mail:')
                        ->setRequired('Zadejte svůj e-mail.');
                
		$form->addPassword('password', 'Heslo:')
			->setRequired('Prosím zadejte heslo')
			->addRule($form::MIN_LENGTH, 'Heslo musí mít minimálně 7 znaků', $this::PASSWORD_MIN_LENGTH);
                
                $form->addPassword('password2', 'Heslo znovu')
                        ->setRequired('Zadejte heslo pro ověření.')
                        ->addRule(Form::EQUAL, 'Hesla se neshodují', $form['password']);

		$form->addSubmit('send', 'Zaregistrovat')
                     ->setAttribute('class', 'btn btn-primary');

		$form->onSuccess[] = [$this, 'handleForm'];

		return $form;
	}
        
        public function handleForm(Form $form, $values){
            try {
		$this->userManager->add($values->username, $values->email, $values->password);
                $this->onFormSubmit();
                
            } catch (Model\DuplicateNameException $e) {
                $form['username']->addError('Uživatelské jméno je již obsazené.');
                
            }
        }
}
interface ISignUpFormFactory{
    
    /**
     * @return SignUpForm
     */
    
    public function create();
}
