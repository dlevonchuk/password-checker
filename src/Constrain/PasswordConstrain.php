<?php

namespace App\Constrain;

/**
 * Class PasswordConstrain
 */
class PasswordConstrain
{
    /** @var string */
    protected $pattern;

    /** @var string */
    protected $message;

    /**
     * Constrain constructor.
     *
     * @param string $pattern
     * @param string $message
     */
    public function __construct(string $pattern, string $message)
    {
        $this->pattern = $pattern;
        $this->message = $message;
    }

    /**
     * @return string
     */
    public function getPattern(): string
    {
        return $this->pattern;
    }

    /**
     * @return string
     */
    public function getMessage(): string
    {
        return $this->message;
    }
}
