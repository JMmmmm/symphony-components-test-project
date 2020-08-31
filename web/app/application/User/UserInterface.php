<?php
declare(strict_types=1);
namespace App\Application\User;

interface UserInterface
{
    /**
     * @return int
     */
    public function getId(): int;

    /**
     * @return string
     */
    public function getEmail(): string;
}
