<?php

namespace App\Provider;

use App\Constrain\PasswordConstrain;

/**
 * Interface ConstrainsProviderInterface
 */
interface ConstrainsProviderInterface
{
    /**
     * @return PasswordConstrain[]
     */
    public function getConstrains(): array;
}
