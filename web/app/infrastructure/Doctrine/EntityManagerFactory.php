<?php
declare(strict_types=1);
namespace App\Infrastructure\Doctrine;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\ORMException;
use Doctrine\ORM\Tools\Setup;

/**
 * Class EntityManagerFactory
 * @package App\Infrastructure
 */
class EntityManagerFactory
{
    /**
     * @var EntityManager|null
     */
    private static $instance;

    /**
     * @return EntityManager
     * @throws ORMException
     */
    public static function getInstance(): EntityManager
    {
        if (!static::$instance instanceof EntityManager) {
            $paths = ['../../domain/Entities'];
            $isDevMode = false;
            $dbParams = [
                'driver'   => $_ENV['DB_DRIVER'],
                'user'     => $_ENV['DB_USER'],
                'password' => $_ENV['DB_PASSWORD'],
                'dbname'   => $_ENV['DB_NAME'],
            ];
            $config = Setup::createAnnotationMetadataConfiguration($paths, $isDevMode);
            $entityManager = EntityManager::create($dbParams, $config);

            static::$instance = $entityManager;
        }

        return static::$instance;
    }
}
