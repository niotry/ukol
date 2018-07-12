<?php

namespace App\Components;

use App\Model;
use Nette;
use Nette\Application\UI\Form;


class SignUpFormFactory
{
	use Nette\SmartObject;

	const PASSWORD_MIN_LENGTH = 7;

	/** @var FormFactory */
	private $factory;

	/** @var Model\UserManager */
	private $userManager;


	public function __construct(FormFactory $factory, Model\UserManager $userManager)
	{
		$this->factory = $factory;
		$this->userManager = $userManager;
	}


	/**
	 * @return Form
	 */
	public function create(callable $onSuccess)
	{
		$form = $this->factory->create();
		$form->addText('username', 'Uživatelské jméno:')
			->setRequired('Vypiště uživatelské jméno.');

		$form->addEmail('email', 'Váš e-mail:')
                        ->setRequired('Zadejte svůj e-mail.');
                

		$form->addPassword('password', 'Heslo:')
			->setRequired('Prosím zadejte heslo')
			->addRule($form::MIN_LENGTH, 'Heslo musí mít minimálně 7 znaků', $this::PASSWORD_MIN_LENGTH);

		$form->addSubmit('send', 'Zaregistrovat')
                     ->setAttribute('class', 'btn btn-primary');

		$form->onSuccess[] = function (Form $form, $values) use ($onSuccess) {
			try {
				$this->userManager->add($values->username, $values->email, $values->password);
			} catch (Model\DuplicateNameException $e) {
				$form['username']->addError('Uživatelské jméno je již obsazené.');
				return;
			}
			$onSuccess();
		};

		return $form;
	}
}
