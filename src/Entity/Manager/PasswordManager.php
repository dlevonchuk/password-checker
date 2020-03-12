<?php

namespace App\Entity\Manager;

use Doctrine\DBAL\Driver\Connection;

/**
 * Class PasswordManager
 */
class PasswordManager
{
    /** @var Connection */
    protected $connection;

    /**
     * PasswordManager constructor.
     *
     * @param Connection $connection
     */
    public function __construct(Connection $connection)
    {
        $this->connection = $connection;
    }

    /**
     * @param array $ids
     *
     * @return int
     */
    public function markAsValid(array $ids): int
    {
         return $this->connection->executeUpdate(
            'UPDATE passwords SET valid = 1 WHERE id IN (?)',
            [$ids],
            [\Doctrine\DBAL\Connection::PARAM_INT_ARRAY]
        );
    }
}
