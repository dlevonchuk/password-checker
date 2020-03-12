<?php

namespace App\Provider;

use App\Constrain\PasswordConstrain;
use App\Exception\InvalidConstrainFileStructureException;
use Symfony\Component\Yaml\Parser;

/**
 * Class PasswordConstrainsProvider
 */
class PasswordConstrainsProvider implements ConstrainsProviderInterface
{
    /** @var Parser */
    protected $yamlParser;

    /** @var string */
    protected $filePath;

    /** @var array */
    protected $constrains = [];

    /**
     * ConstrainsProvider constructor.
     *
     * @param Parser $yamlParser
     * @param string $filePath
     */
    public function __construct(Parser $yamlParser, string $filePath)
    {
        $this->yamlParser = $yamlParser;
        $this->filePath = $filePath;
    }

    /**
     * @return PasswordConstrain[]
     *
     * @throws InvalidConstrainFileStructureException
     */
    public function getConstrains(): array
    {
        if (!empty($this->constrains)) {
            return $this->constrains;
        }

        $res = [];
        $constrainsArray = $this->yamlParser->parseFile($this->filePath);
        foreach ($constrainsArray as $constrain) {
            if (!isset($constrain['pattern']) || !isset($constrain['message'])) {
                throw new InvalidConstrainFileStructureException('Invalid file structure');
            }
            $res[] = new PasswordConstrain($constrain['pattern'], $constrain['message']);
        }
        $this->constrains = $res;

        return $this->constrains;
    }
}
