<?php
declare(strict_types=1);
use App\Infrastructure\Doctrine\EntityManagerFactory;
use Doctrine\ORM\Tools\Console\ConsoleRunner;

require_once __DIR__ . '/../../public/index.php';

$entityManager = EntityManagerFactory::getInstance();

return ConsoleRunner::createHelperSet($entityManager);