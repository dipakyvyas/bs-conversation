<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/BsConversation for the canonical source repository
 * @copyright Copyright (c) 2005-2015 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace BsConversation\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use BsConversation\Model\ConversationInterface;
use BsConversation\Service\ConversationService;
use BsConversation\Options\Options;

class IndexController extends AbstractActionController
{
    /**
     * 
     * @var ConversationService
     */
    protected $conversationService;
    /**
     * 
     * @var Options
     */
    protected $options;
    
    public function __construct(ConversationService $conversationService,Options $options){
        $this->conversationService = $conversationService;
        $this->options = $options;
    }
    
    
    public function indexAction()
    {
        return array();
    }

    
    public function unsubscribeConversationAction(){
        
        $conversationId = $this->params('conversation');
        $email = urldecode($this->params('email'));
        
        $conversation = $this->conversationService->findConversation($conversationId);
       
        if(!$conversation instanceof ConversationInterface){
            echo "No Conversation found for id ".$conversationId;
            exit;
        }
        
        
        foreach ($conversation->getParticipants() as $participant){
            if($participant->getEmail() == $email){
                $conversation->getParticipants()->removeElement($participant);
                break;
            }
        }
        try {
            $this->conversationService->saveConversation($conversation);
        } catch (\Exception $e) {
            echo $e->getMessage();
            exit;
        }
        if($this->options->getUnsubscribeRedirectionUrl()){
            header('Location: '.$this->options->getUnsubscribeRedirectionUrl());
        } else {
            echo $email.' has been successfully unsubscribed from the conversation : '.($conversation->getTitle()?:'#'.$conversation->getId());
        }
        exit;
        
    }
    
}
