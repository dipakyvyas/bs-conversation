<?php
namespace BsConversation\Model;

use Doctrine\Common\Collections\ArrayCollection;

/**
 *
 * @author jonasgarbuio
 *        
 */
interface AttachmentEnabledMessageInterface
{
    /**
     * @return ArrayCollection
     */
    public function getAttachments();

    /**
     * 
     * @param ArrayCollection $attachments
     */
    public function setAttachments(ArrayCollection $attachments);
    
}