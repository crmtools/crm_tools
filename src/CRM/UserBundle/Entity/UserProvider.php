<?php

// src/AppBundle/Security/User/WebserviceUserProvider.php

namespace CRM\UserBundle\Entity;

use Doctrine\ORM\EntityManager;
use Symfony\Component\Security\Core\User\UserProviderInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\Exception\UsernameNotFoundException;
use Symfony\Component\Security\Core\Exception\UnsupportedUserException;

class UserProvider implements UserProviderInterface {

    /**
     * @var Doctrine\ORM\EntityManager
     */
    protected $em;

    public function __construct(EntityManager $em) {
        $this->em = $em;
    }

    public function loadUserByUsername($username) {
        $user = $this->em->createQueryBuilder()
            ->select('u')
            ->from('CRMUserBundle:User', 'u')
            ->where('u.username = :username OR u.email = :email')
            ->setParameter('username', $username)
            ->setParameter('email', $username)
            ->getQuery()
            ->getOneOrNullResult();

        if ($user) {
            return $user;
        }

        throw new UsernameNotFoundException(
        sprintf('Username "%s" does not exist.', $username)
        );
    }

    public function refreshUser(UserInterface $user) {
        if (!$user instanceof User) {
            throw new UnsupportedUserException(
            sprintf('Instances of "%s" are not supported.', get_class($user))
            );
        }

        return $this->loadUserByUsername($user->getUsername());
    }

    public function supportsClass($class) {
        return User::class === $class;
    }

}
