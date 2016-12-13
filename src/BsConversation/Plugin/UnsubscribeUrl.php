<?php
namespace BsConversation\Plugin;

use BsConversation\Model\ConversationInterface;
use Zend\View\Helper\Url;
use BsConversation\Model\ParticipantInterface;
/**
 *
 * @author jonasgarbuio
 *        
 */
class UnsubscribeUrl
{
  /**
   * @var Url
   */
   protected $urlHelper;
    
    public function __construct(Url $urlHelper){
        $this->urlHelper = $urlHelper;
    }
    
    public function __invoke(ConversationInterface $conversation, $participant){
        
        if($participant instanceof ParticipantInterface){
            $email = $email->getEmail();
        } elseif (is_string($participant)){
            $email = $participant; 
        }
        
        if(!$email){
            throw new \Exception('Invalid argument given');
        }
        
        return $this->urlHelper->__invoke('bs-conversation/unsubscribe',['conversation' => $conversation->getId(), 'email' => $email], ['force_canonical' => true]);
        
    }
    
}