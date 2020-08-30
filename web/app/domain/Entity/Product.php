<?php
declare(strict_types=1);
namespace App\Domain\Entity;

use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\GeneratedValue;
use Doctrine\ORM\Mapping\Id;
use Doctrine\ORM\Mapping\Table;
use DateTime;

/**
 * @Entity
 * @Table(name="products", uniqueConstraints={@UniqueConstraint(name="name_idx", columns={"name"})})
 */
class Product
{
    /**
     * @var int
     * @Column(type="integer", nullable=false)
     * @Id
     * @GeneratedValue(strategy="IDENTITY")
     */
    private int $id;

    /**
     * @var string
     *
     * @Column(type="string", nullable=false, length=100)
     */
    private string $name;

    /**
     * @var float
     * @Column(type="float", nullable=false)
     */
    private float $price;

    /**
     * @var int
     * @Column(name="user_id", type="integer", nullable=false)
     */
    private int $userId;

    /**
     * @var DateTime
     * @Column(type="datetime", nullable=false)
     */
    private DateTime $created;

    /**
     * @var DateTime
     * @Column(type="datetime", nullable=false)
     */
    private DateTime $updated;

    /**
     * Product constructor.
     * @param string $name
     * @param float $price
     * @param int $userId
     */
    public function __construct(string $name, float $price, int $userId)
    {
        $this->name = $name;
        $this->price = $price;
        $this->userId = $userId;
        $this->created = new DateTime();
        $this->updated = new DateTime();
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     * @return self
     */
    public function setName(string $name): self
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @return float
     */
    public function getPrice(): float
    {
        return $this->price;
    }

    /**
     * @param float $price
     * @return self
     */
    public function setPrice(float $price): self
    {
        $this->price = $price;
        return $this;
    }

    /**
     * @return int
     */
    public function getUserId(): int
    {
        return $this->userId;
    }

    /**
     * @param int $userId
     * @return self
     */
    public function setUserId(int $userId): self
    {
        $this->userId = $userId;
        return $this;
    }

    /**
     * @return DateTime
     */
    public function getCreated(): DateTime
    {
        return $this->created;
    }

    /**
     * @return DateTime
     */
    public function getUpdated(): DateTime
    {
        return $this->updated;
    }

    /**
     * @param DateTime $updated
     * @return self
     */
    public function setUpdated(DateTime $updated): self
    {
        $this->updated = $updated;
        return $this;
    }
}
