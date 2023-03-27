<?php

namespace Sherlockode\SyliusAdvancedContentPlugin\User;

use Sherlockode\AdvancedContentBundle\User\AnonymousUserProvider;
use Sylius\Component\Core\Model\AdminUserInterface;
use Sylius\Component\User\Repository\UserRepositoryInterface;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Contracts\Translation\TranslatorInterface;

class AdminUserProvider extends AnonymousUserProvider
{
    /**
     * @var TokenStorageInterface
     */
    private $tokenStorage;

    /**
     * @var UserRepositoryInterface
     */
    private $userRepository;

    /**
     * @param TranslatorInterface     $translator
     * @param TokenStorageInterface   $tokenStorage
     * @param UserRepositoryInterface $userRepository
     */
    public function __construct(
        TranslatorInterface $translator,
        TokenStorageInterface $tokenStorage,
        UserRepositoryInterface $userRepository
    ) {
        parent::__construct($translator);

        $this->tokenStorage = $tokenStorage;
        $this->userRepository = $userRepository;
    }

    /**
     * @return int|null
     */
    public function getUserId(): ?int
    {
        $token = $this->tokenStorage->getToken();
        if ($token === null) {
            return null;
        }

        $user = $token->getUser();
        if ($user === null) {
            return null;
        }

        return $user->getId();
    }

    /**
     * @param int|null $userId
     *
     * @return string
     */
    public function getUserName(?int $userId): string
    {
        if ($userId === null) {
            return parent::getUserName($userId);
        }

        $user = $this->userRepository->find($userId);
        if ($user === null) {
            return parent::getUserName($userId);
        }

        if (!$user instanceof AdminUserInterface) {
            return $user->getUsername();
        }

        return $user->getFirstName() . ' ' . $user->getLastName();
    }
}
