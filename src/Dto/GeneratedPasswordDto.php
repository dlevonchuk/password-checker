<?php

namespace App\Dto;

/**
 * Class GeneratedPasswordDto
 */
class GeneratedPasswordDto
{
    /** @var string[] */
    public $char = [];

    /**
     * @return null|string
     */
    public function getPassword(): ?string
    {
        if (!isset($this->char[0])) {
            return null;
        }

        return $this->char[0];
    }
}
