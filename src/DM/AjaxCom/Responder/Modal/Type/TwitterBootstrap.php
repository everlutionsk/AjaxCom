<?php

namespace DM\AjaxCom\Responder\Modal\Type;

use DM\AjaxCom\Responder\Modal\AbstractModalType;

class TwitterBootstrap extends AbstractModalType
{
    public function button()
    {
        
    }

    /**
     * Render modal window and return its html
     *
     * @return string $html 
     */
       
    public function getHtml()
    {   
        $html = '
            <div class="modal fade hide" 
            id="'.$this->getId().'">
            <div class="modal-header">
            <a class="close" data-dismiss="modal">&times;</a>      
            <h3>'.$this->getTitle().'</h3>
            </div>
            <div class="modal-body">
            <div class="modal-container"><?php echo $this->body;?></div>
            </div>
            <div class="modal-footer">
            The footer comes here
            </div>
            </div>
            ';
        
        return $html;    
        
    }

}
