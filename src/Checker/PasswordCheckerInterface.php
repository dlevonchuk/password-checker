<?php

namespace App\Checker;

/**
 * Interface PasswordCheckerInterface
 */
interface PasswordCheckerInterface
{
    /**
     * @return string
     */
    public function getErrorMessage(): string;

    /**
     * @param string $password
     *
     * @return bool
     */
    public function checkPassword(string $password): bool;
}
