<?php

namespace App\Presenters;

use Nette;
use App\Model\ProjectModel;
use App\Components\IProjectFormFactory;

class HomepagePresenter extends BasePresenter
{
    
    private $projectModel;
    
    private $projectFormFactory;

    public function __construct(ProjectModel $projectModel, IProjectFormFactory $projectFormFactory)
    {
        $this->projectModel = $projectModel;
        
        $this->projectFormFactory = $projectFormFactory;
        
        parent::__construct();
        
    }
    
    public function renderDefault()
    {
            $this->template->projects = $this->projectModel->getProjects();
    }
    
    public function renderCreate(){
        if(!$this->getUser()->isLoggedIn()){
            
            $this->flashMessage('Práce s projekty je umožněna pouze přihlášeným uživatelům.', 'error');
            $this->redirect('default');    
            
        }
    }

    public function actionUpdate($projectId){
        if($this->getUser()->isLoggedIn()){
            
            if(!$projectId){
                $this->flashMessage('Vyskytla se chyba.', 'error');
                $this->redirect('default');
            }
            
        }else{
            
            $this->flashMessage('Práce s projekty je umožněna pouze přihlášeným uživatelům.', 'error');
            $this->redirect('default');    
            
        }
        
    }
    

    public function actionDelete($projectId){
        if($this->getUser()->isLoggedIn()){
            
            if($projectId){
                
                $isDeleted = $this->projectModel->deleteProject($projectId);
                if($isDeleted){
                    $this->flashMessage('Projekt úspěšně smazán.');
                }else{
                    $this->flashMessage('Projekt se nepodařilo vymazat.');
                }
                
            }else{
                $this->flashMessage('Vyskytla se chyba.', 'error'); 
            }
            
            
        }else{
            $this->flashMessage('Práce s projekty je umožněna pouze přihlášeným uživatelům.', 'error');
        }
        
        $this->redirect('default'); 
        
    }
    
    protected function createComponentProjectForm() { 
            
            $form = $this->projectFormFactory->create($this->getParameter('projectId'));
            $form ->onFormSubmit[] = function ($isSaved){
                if ($isSaved){
                    $this->flashMessage('Projekt byl úspěšně uložen.', 'success');
                    $this->redirect('default');
                }else {
                    $this ->flashMessage('Projekt se nepodařilo uložit.', 'error');
                }
            };
            return $form;
    }
    

    
}
