<?php
namespace App\Components;

use Nette\Application\UI\Form;
use Nette;
use App\Model\ProjectModel;
use Nette\Application\UI\Control;
use App\components\FormValidator;

class ProjectForm extends Control{
    
    
    const NAME_MAX_LENGTH = 30;

    private $projectId;
    private $projectModel;
    
    public $onFormSubmit;
    
    public function __construct(int $projectId = null, ProjectModel $projectModel) {
        
        $this->projectId = $projectId;
        $this->projectModel = $projectModel;
        
        parent::__construct();
    }
    
    public function render() {
        $this->template->setFile(__DIR__ . '/ProjectForm.latte');
        $this->template->render();
    }

    protected function createComponentForm() {
        
        $form = new Form;

        $form ->addText('name', 'Název: ')
              ->setAttribute('PlaceHolder', 'Nazev projektu')
              ->addRule(Form::MAX_LENGTH, 'Název projektu je dlouhý, max: '.$this::NAME_MAX_LENGTH.' znaků', $this::NAME_MAX_LENGTH)
              ->setRequired('Zadejte prosím název projektu.');
        
        $form ->addText('date', 'Datum odevzdání:')
              ->setAttribute('placeHolder', 'DD.MM.YYYY')
              ->addRule(FormValidator::DATE, 'Zadejte platný datum.') /* ->addRule(Form::PATTERN, 'Datum musí být ve formátu 15.10.2011', '([0-9]{1,2})\.([0-9]{1,2})\.([0-9]{4})'*/
              ->setRequired('Zadejte datum odevzdání');
        
        $form ->addSelect('type', 'Typ projektu:', ['Omezený'=>'Omezený', 'Neomezený'=>'Neomezený'])
              ->setRequired();
        
        $form ->addCheckbox('isProject', 'Webový projekt');
        
        $form ->addSubmit('send', 'Uložit')
              ->setAttribute('class', 'btn btn-primary');
        
        $form ->onAnchor[]=[$this, 'handleForm'];
        
        return $form;
    } 
    
    public function handleForm(Form $form){
        
        if($form->isSuccess()){
            
            $isSaved = $this->projectModel->saveProject($form->getValues(), $this->projectId);
            $this->onFormSubmit($isSaved);
            
        }elseif(!$form->isSubmitted() && $this->projectId!=null){
            
            $project = $this->projectModel->getOneProject($this->projectId);
            $form->setDefaults($project);
            
        }
    }
}


interface IProjectFormFactory
{
    /**
     * @return ProjectForm
     */
    public function create(int $projectId = null);
}
