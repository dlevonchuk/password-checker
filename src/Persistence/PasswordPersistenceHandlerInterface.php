<?php

namespace App\Persistence;

use App\Validation\PasswordValidationError;

/**
 * Interface PasswordPersistenceHandlerInterface
 */
interface PasswordPersistenceHandlerInterface
{
    /**
     * @return PasswordValidationError[]
     */
    public function handle(): array;
}
