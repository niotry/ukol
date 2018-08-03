<?php

namespace App\Model;

use Nette\Utils\DateTime;
use Nette;
use Nette\Utils\ArrayHash;

class ProjectModel{
    
    
    private $database;
    
    public function __construct(Nette\Database\Context $database) {
        $this->database = $database;
        
    }
    
    public function getProjects($userId = false){
        if(!$userId){
            return $this->database->table('projects');
        } else {
            
            $projectsDTB = $this->database->table('projects')->fetchAll();
            $likesDTB = $this->database->table('likes')->where('id_user', $userId)->fetchAll();
            
            // vytvoření a dodání sloupce isLiked do pole Projects
            $projects=[];
            foreach ($projectsDTB as $project){
                $projects[]=[
                    'id' => $project->id,
                    'name' => $project->name,
                    'date' => $project->date,
                    'type' => $project->type,
                    'isProject' => $project->isProject,
                    'isLiked' => FALSE
                    ];
            }
            
            //přidělení likes k projektům
            $countRows = count($projects);
            foreach ($likesDTB as $like){
                for($i=0; $i<$countRows; $i++){
                    if($projects[$i]['id']==$like['id_project']){
                        $projects[$i]['isLiked']= TRUE;
                    }
                }
            };
            
            return $projects;
        }
    }
    
    public function saveProject($values, $projectId){
        try{ 
            $values['date'] = DateTime::createFromFormat('d.m.Y', $values['date']);
            
            if($projectId == null){
                $this->database->table('projects')->insert($values);
            }else{
                $this->database->table('projects')->wherePrimary($projectId)->update($values);
            }
            return true;
        } catch (Exception $ex) {
            return false;
        }
    }
    
    public function deleteProject($projectId){
        try{
            $this->database->table('projects')->where('id', $projectId)->delete();   
            
            return true;
        } catch (Exception $ex) {
            
            return false;
        }
        
    }
    
    public function getOneProject($projectId){
        
        $row = $this->database->table('projects')->get($projectId);
        
        $project = ArrayHash::from($row);
        $project['date'] = $project['date']->format('d.m.Y');
        
        return $project;
        
    }
    
    public function likeProject($projectId, $userId){
        $this->database->table('likes')->insert(['id_project' => $projectId,
                                                'id_user'    => $userId]);
    }
    
    public function dislikeProject($projectId, $userId){
        $this->database->table('likes')->where('id_project', $projectId)
                                       ->where('id_user', $userId)
                                       ->delete();
    }
    
    
    
    
    
    
}
