<?php

namespace App\Presenters;

use App\Components\ISignInFormFactory;
use App\Components\ISignUpFormFactory;
use Nette\Application\UI\Form;


class SignPresenter extends BasePresenter
{


	private $signInFormFactory;

	private $signUpFormFactory;


	public function __construct(ISignInFormFactory $signInFormFactory, ISignUpFormFactory $signUpFormFactory)
	{
		$this->signInFormFactory = $signInFormFactory;
		$this->signUpFormFactory = $signUpFormFactory;
	}


	protected function createComponentSignInForm()
	{
                $form = $this->signInFormFactory->create();
                $form ->onFormSubmit[] = function (){
                   $this->redirect('Homepage:default');
                };
                
                return $form;
	}


	/**
	 * Sign-up form factory.
	 * @return Form
	 */
	protected function createComponentSignUpForm()
	{
            $form = $this->signUpFormFactory->create();
            $form ->onFormSubmit[] = function (){
                $this->redirect('Homepage:default');
            };
                
            return $form;

	}


	public function actionOut()
	{
		$this->getUser()->logout();
                $this->flashMessage('Byl jste odhlášen.');
                $this->redirect('Homepage:default');
	}
}
