<?php

namespace CRM\UserBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\MappedSuperclass
 */
abstract class BaseUser implements UserInterface, \Serializable {


    /**
     * @ORM\Column(name="username", type="string", length=25, unique=true)
     * @Assert\NotBlank()
     * @Assert\Length(min=3)
     */
    protected $username;

    /**
     * @ORM\Column(name="password", type="string", length=64)
     */
    protected $password = "";

    /**
     * @ORM\Column(name="email", type="string", length=60, unique=true)
     */
    protected $email = "";

    /**
     * @ORM\Column(name="roles", type="simple_array")
     * @Assert\Count(
     *      min = "1",
     *      minMessage = "You must specify at least one role",
     * )
     */
    protected $roles = array();

    /**
     * @var string
     *
     * @ORM\Column(name="salt", type="string", length=255)
     */
    protected $salt = "";

    const USER = 'ROLE_USER';

    public function __construct($username = "", $password = "", array $roles = array(self::USER)) {

        $this->username = $username;
        $this->password = $password ?: md5(uniqid(null, true));
        $this->roles = $roles;
        //$this->salt = md5(uniqid(null, true)); //bcrypt generate salt automatically. No need to be persisted
    }

    public function __toString() {
        return $this->getUsername();
    }

    public function getUsername() {
        return $this->username;
    }

    /**
     * Set username
     *
     * @param string $username
     *
     * @return User
     */
    public function setUsername($username) {
        $this->username = $username;
        return $this;
    }

    public function getSalt() {
        return $this->salt;
    }

    public function getPassword() {
        return $this->password;
    }

    /**
     * Set password
     *
     * @param string $password
     *
     * @return User
     */
    public function setPassword($password) {
        $this->password = (string)$password;
        return $this;
    }

    public function getEmail() {
        return $this->email;
    }

    /**
     * Set email
     *
     * @param string $email
     *
     * @return User
     */
    public function setEmail($email) {
        $this->email = (string)$email;
        return $this;
    }

    public function getRoles() {
        return $this->roles ?: array(self::USER);
    }

    /**
     * Set roles
     *
     * @param array $role
     *
     * @return User
     */
    public function setRoles(array $roles) {
        $this->roles = $roles;
        return $this;
    }

    /**
     * Set salt
     *
     * @param string $salt
     * @return User
     */
    public function setSalt($salt)
    {
        $this->salt = $salt;

        return $this;
    }

    public function eraseCredentials() {

    }

    /** @see \Serializable::serialize() */
    public function serialize() {
        return serialize(array(
            $this->id,
            $this->username,
            $this->password,
            $this->salt,
            $this->roles,
        ));
    }

    /** @see \Serializable::unserialize() */
    public function unserialize($serialized) {
        list (
            $this->id,
            $this->username,
            $this->password,
            $this->salt,
            $this->roles,
            ) = unserialize($serialized);
    }
}
