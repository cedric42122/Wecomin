<?php

namespace App\Entity;

use Symfony\Component\Validator\Constraints as Assert;


class Contact
{
    /**
     * @var string|null
     * @Assert\NotBlank()
     * @Assert\Length(
     * min=2,
     * minMessage="Votre prénom est trop court",
     * max=30,
     * maxMessage="Votre prénom est trop long"
     * )
     */
    private $firstname;

    /**
     * @var string|null
     * @Assert\NotBlank()
     * @Assert\Length(
     * min=2,
     * minMessage="Votre nom est trop court",
     * max=30,
     * maxMessage="Votre nom est trop long"
     * )
     */
    private $lastname;

    /**
     * @var string|null
     * @Assert\NotBlank()
     * @Assert\Regex(
     * pattern="/[0-9]{10}/",
     * message="Votre numéro doit être composé de 10 chiffres"
     * )
     */
    private $phone;

    /**
     * @var string|null
     * @Assert\NotBlank()
     * @Assert\Email()
     */
    private $email;

    /**
     * @var string|null
     * @Assert\NotBlank()
     * @Assert\Length(
     * min=10,
     * minMessage="Votre message est trop court"
     * )
     */
    private $message;

    /**
     * Getter for Firstname
     *
     * @return [type]
     */
    public function getFirstname()
    {
        return $this->firstname;
    }

    /**
     * Setter for Firstname
     * @var [type] firstname
     *
     * @return self
     */
    public function setFirstname($firstname)
    {
        $this->firstname = $firstname;
        return $this;
    }

    /**
     * Getter for Lastname
     *
     * @return [type]
     */
    public function getLastname()
    {
        return $this->lastname;
    }

    /**
     * Setter for Lastname
     * @var [type] lastname
     *
     * @return self
     */
    public function setLastname($lastname)
    {
        $this->lastname = $lastname;
        return $this;
    }

    /**
     * Getter for Phone
     *
     * @return [type]
     */
    public function getPhone()
    {
        return $this->phone;
    }

    /**
     * Setter for Phone
     * @var [type] phone
     *
     * @return self
     */
    public function setPhone($phone)
    {
        $this->phone = $phone;
        return $this;
    }

    /**
     * Getter for Email
     *
     * @return [type]
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Setter for Email
     * @var [type] email
     *
     * @return self
     */
    public function setEmail($email)
    {
        $this->email = $email;
        return $this;
    }

    /**
     * Getter for Message
     *
     * @return [type]
     */
    public function getMessage()
    {
        return $this->message;
    }

    /**
     * Setter for Message
     * @var [type] message
     *
     * @return self
     */
    public function setMessage($message)
    {
        $this->message = $message;
        return $this;
    }
}
