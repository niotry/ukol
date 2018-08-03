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
            $userId = $this->getUser()->getId();
            $this->template->projects = $this->projectModel->getProjects($this->getUser()->isLoggedIn()? $userId:FALSE);

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
    

    public function handleDelete($projectId){
        if($this->getUser()->isLoggedIn()){
            
                if($projectId){
                    $isDeleted = $this->projectModel->deleteProject($projectId);
                    if($isDeleted){
                        $this->flashMessage('Projekt úspěšně smazán.', 'success');
                        $this->redrawControl('projectTable');
                    }else{
                        $this->flashMessage('Projekt se nepodařilo vymazat.', 'error');
                    }

                }else{
                    $this->flashMessage('Vyskytla se chyba.', 'error'); 
                }
            
        }else{
            $this->flashMessage('Práce s projekty je umožněna pouze přihlášeným uživatelům.', 'error');
            $this->redirect('default'); 
        }
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
    
    public function handleLike($projectId){
        if($this->isAjax()){
            $this->projectModel->likeProject($projectId, $this->getUser()->getId());
            $this->flashMessage('Tento projekt se mi líbí.', 'success');
            $this->redrawControl('projectItems');
        }else{
            $this->redirect('default');   
        }
    }
    
    public function handleDislike($projectId){
        
        if($this->isAjax()){
            $this->projectModel->dislikeProject($projectId, $this->getUser()->getId());
            $this->flashMessage('Tento projekt se mi už nelíbí.', 'success');
            $this->redrawControl('projectItems');
        }else{
            $this->redirect('default');
        }
        
    }

    
}
