<?php

namespace App\Generator;

use App\Exception\PasswordGenerationException;

/**
 * Interface PasswordGeneratorInterface
 */
interface PasswordGeneratorInterface
{
    /**
     * @return string
     *
     * @throws PasswordGenerationException
     */
    public function generate(): string;
}
