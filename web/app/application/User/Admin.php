<?php
declare(strict_types=1);
namespace App\Application\User;

/**
 * Class Admin
 * @package App\Application\User
 */
class Admin implements UserInterface
{
    private const DEFAULT_ID = 1;
    private const DEFAULT_EMAIL = 'test@mail';

    /**
     * @var int
     */
    private int $id;

    /**
     * @var string
     */
    private string $email;

    /**
     * Admin constructor.
     * @param int $id
     * @param string $email
     */
    public function __construct(int $id = self::DEFAULT_ID, string $email = self::DEFAULT_EMAIL)
    {
        $this->id = $id;
        $this->email = $email;
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getEmail(): string
    {
        return $this->email;
    }
}
