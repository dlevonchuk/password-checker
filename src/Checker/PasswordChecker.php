<?php

namespace App\Checker;

use App\Constrain\PasswordConstrain;
use App\Provider\ConstrainsProviderInterface;

/**
 * Class PasswordChecker
 */
class PasswordChecker implements PasswordCheckerInterface
{
    /** @var ConstrainsProviderInterface */
    protected $constrainsProvider;

    /** @var string */
    protected $errorMessage;

    /**
     * PasswordChecker constructor.
     *
     * @param ConstrainsProviderInterface $constrainsProvider
     */
    public function __construct(ConstrainsProviderInterface $constrainsProvider)
    {
        $this->constrainsProvider = $constrainsProvider;
    }

    /**
     * @param string $password
     *
     * @return bool
     */
    public function checkPassword(string $password): bool
    {
        /** @var PasswordConstrain[] $allConstrains */
        $allConstrains = $this->constrainsProvider->getConstrains();

        /** @var PasswordConstrain $constrain */
        foreach ($allConstrains as $constrain) {
            if (!preg_match($constrain->getPattern(), $password)) {
                $this->errorMessage = $constrain->getMessage();

                return false;
            }
        }

        return true;
    }

    /**
     * @return string
     */
    public function getErrorMessage(): string
    {
        return $this->errorMessage;
    }
}
