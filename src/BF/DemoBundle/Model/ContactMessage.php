<?php
namespace BF\DemoBundle\Model;

class ContactMessage
{
    protected $email;

    protected $message;

    /**
     * @return the unknown_type
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param unknown_type $email
     */
    public function setEmail($email)
    {
        $this->email = $email;
        return $this;
    }

    /**
     * @return the unknown_type
     */
    public function getMessage()
    {
        return $this->message;
    }

    /**
     * @param unknown_type $message
     */
    public function setMessage($message)
    {
        $this->message = $message;
        return $this;
    }

}
