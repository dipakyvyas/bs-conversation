<?php
namespace BsConversation\Options;

use Zend\Stdlib\AbstractOptions;

/**
 *
 * @author mat_wright
 *        
 */
class Options extends AbstractOptions
{
    
    protected $conversationClass;
    
    protected $messageClass;
    
    protected $deliveryClass;
    
    protected $transport;
    
    protected $generalOptions;
    
    protected $unsubscribeRedirectionUrl;
    
    protected $subjectIncludeConversationId;

    /**
     */
    function __construct($options)
    {
        $this->conversationClass = $options['mapper']['conversation_class'];
        $this->messageClass = $options['mapper']['message_class'];
        $this->transport = $options['transport'];
        $this->generalOptions = $options['options'];
        $this->unsubscribeRedirectionUrl = $options['options']['unsubscribe_redirection_url'];
        $this->subjectIncludeConversationId = $options['options']['subject_include_conversation_id'];
    }
    /**
     * @return string $conversationClass
     */
    public function getConversationClass()
    {
        return $this->conversationClass;
    }

    /**
     * @param string $conversationClass
     */
    public function setConversationClass($conversationClass)
    {
        $this->conversationClass = $conversationClass;
    }

    /**
     * @return string $messageClass
     */
    public function getMessageClass()
    {
        return $this->messageClass;
    }

    /**
     * @param string $messageClass
     */
    public function setMessageClass($messageClass)
    {
        $this->messageClass = $messageClass;
    }

    /**
     * @return string $deliveryClass
     */
    public function getDeliveryClass()
    {
        return $this->deliveryClass;
    }

    /**
     * @param string $deliveryClass
     */
    public function setDeliveryClass($deliveryClass)
    {
        $this->deliveryClass = $deliveryClass;
    }
    /**
     * @return the $transport
     */
    public function getTransport()
    {
        return $this->transport;
    }

    /**
     * @param field_type $transport
     */
    public function setTransport($transport)
    {
        $this->transport = $transport;
    }
    /**
     * @return the $generalOptions
     */
    public function getGeneralOptions()
    {
        return $this->generalOptions;
    }

    /**
     * @param Ambigous <array, Traversable, null> $generalOptions
     */
    public function setGeneralOptions($generalOptions)
    {
        $this->generalOptions = $generalOptions;
    }
    /**
     * @return the $unsubscribeRedirectionUrl
     */
    public function getUnsubscribeRedirectionUrl()
    {
        return $this->unsubscribeRedirectionUrl;
    }

    /**
     * @param field_type $unsubscribeRedirectionUrl
     */
    public function setUnsubscribeRedirectionUrl($unsubscribeRedirectionUrl)
    {
        $this->unsubscribeRedirectionUrl = $unsubscribeRedirectionUrl;
    }
    /**
     * @return the $subjectIncludeConversationId
     */
    public function getSubjectIncludeConversationId()
    {
        return $this->subjectIncludeConversationId;
    }

    /**
     * @param field_type $subjectIncludeConversationId
     */
    public function setSubjectIncludeConversationId($subjectIncludeConversationId)
    {
        $this->subjectIncludeConversationId = $subjectIncludeConversationId;
    }




}