<?php

namespace App\Persistence;

use App\Checker\PasswordCheckerInterface;
use App\Entity\Manager\PasswordManager;
use App\Entity\Password;
use App\Validation\PasswordValidationError;
use Doctrine\Persistence\ObjectRepository;

/**
 * Class PasswordDbHandlerPassword
 */
class PasswordDbHandlerPassword implements PasswordPersistenceHandlerInterface
{
    /** @var PasswordCheckerInterface */
    private $passwordChecker;

    /** @var PasswordManager */
    private $passwordManager;

    /** @var ObjectRepository */
    private $passwordRepository;

    /**
     * PasswordStorageHandler constructor.
     *
     * @param PasswordCheckerInterface  $passwordChecker
     * @param PasswordManager  $passwordManager
     * @param ObjectRepository $passwordRepository
     */
    public function __construct(
        PasswordCheckerInterface $passwordChecker,
        PasswordManager $passwordManager,
        ObjectRepository $passwordRepository
    ) {
        $this->passwordChecker = $passwordChecker;
        $this->passwordManager = $passwordManager;
        $this->passwordRepository = $passwordRepository;
    }

    /**
     * @return PasswordValidationError[]
     */
    public function handle(): array
    {
        /** @var PasswordValidationError[] $errorsCollection */
        $errorsCollection = [];
        /** @var int[] $passwordIds */
        $passwordIds = [];
        /** @var Password[] $allPasswords */
        $allPasswords = $this->passwordRepository->findAll();

        /** @var Password $password */
        foreach ($allPasswords as $password) {
            if ($this->passwordChecker->checkPassword($password->getPassword())) {
                $passwordIds[] = $password->getId();
            } else {
                $errorsCollection[] = new PasswordValidationError(
                    $password->getPassword(),
                    $this->passwordChecker->getErrorMessage());
            }
        }

        if (!empty($passwordIds)) {
            $this->passwordManager->markAsValid($passwordIds);
        }

        return $errorsCollection;
    }
}
