<?php

namespace App\Entity;

/**
 * Class Password
 */
class Password
{
    /** @var int */
    protected $id;

    /** @var string */
    protected $password;

    /** @var bool */
    protected $isValid;

    /**
     * @return string
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    /**
     * @param string $password
     */
    public function setPassword(string $password): void
    {
        $this->password = $password;
    }

    /**
     * @return bool
     */
    public function isValid(): bool
    {
        return $this->isValid;
    }

    /**
     * @param bool $valid
     */
    public function setIsValid(bool $valid): void
    {
        $this->isValid = $valid;
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }
}
