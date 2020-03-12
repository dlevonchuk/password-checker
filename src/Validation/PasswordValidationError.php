<?php

namespace App\Validation;

/**
 * Class PasswordValidationError
 */
class PasswordValidationError
{
    /** @var string */
    protected $password;

    /** @var string */
    protected $errorMessage;

    /**
     * PasswordValidationError constructor.
     *
     * @param string $password
     * @param string $errorMessage
     */
    public function __construct(string $password, string $errorMessage)
    {
        $this->password = $password;
        $this->errorMessage = $errorMessage;
    }

    /**
     * @return string
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    /**
     * @return string
     */
    public function getErrorMessage(): string
    {
        return $this->errorMessage;
    }
}
