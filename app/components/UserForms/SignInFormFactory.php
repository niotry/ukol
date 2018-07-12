<?php

namespace App\Components;

use Nette;
use Nette\Application\UI\Form;
use Nette\Security\User;


class SignInFormFactory
{
	use Nette\SmartObject;

	/** @var FormFactory */
	private $factory;

	/** @var User */
	private $user;


	public function __construct(FormFactory $factory, User $user)
	{
		$this->factory = $factory;
		$this->user = $user;
	}


	/**
	 * @return Form
	 */
	public function create(callable $onSuccess)
	{
		$form = $this->factory->create();
		$form->addText('username', 'Uživatelské jméno:')
			->setRequired('Prosím zadejte své jméno.');

		$form->addPassword('password', 'Heslo:')
			->setRequired('Prosím zadejte své heslo.');

		$form->addCheckbox('remember', 'Udržet mě přihlášeného');

		$form->addSubmit('send', 'Přihlásit')
                     ->setAttribute('class', 'btn btn-primary');

		$form->onSuccess[] = function (Form $form, $values) use ($onSuccess) {
			try {
				$this->user->setExpiration($values->remember ? '14 days' : '20 minutes');
				$this->user->login($values->username, $values->password);
			} catch (Nette\Security\AuthenticationException $e) {
				$form->addError('Jméno či heslo je nesprávné.');
				return;
			}
			$onSuccess();
		};

		return $form;
	}
}