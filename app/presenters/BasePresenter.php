<?php

namespace App\Presenters;

use Nette;


/**
 * Base presenter for all application presenters.
 */
abstract class BasePresenter extends Nette\Application\UI\Presenter
{
    
    protected function beforeRender(){
        if($this->isAjax()){
            $this->redrawControl('flashes');
        }
        
    }
    
}
