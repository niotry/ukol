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
    
    public function getProjects(){
        return $this->database->table('projects');
        
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
    
    
    
    
    
    
}
