<?php
declare(strict_types=1);
namespace App\Entities\Application;

use App\Domain\Entity\Product;
use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\GeneratedValue;
use Doctrine\ORM\Mapping\Id;
use Doctrine\ORM\Mapping\Table;
use Doctrine\ORM\Mapping\ManyToMany;
use Doctrine\ORM\Mapping\JoinTable;
use Doctrine\ORM\Mapping\JoinColumn;
use DateTime;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * @Entity
 * @Table(name="orders")
 */
class Order
{
    public const STATUS_NEW = 'new';
    public const STATUS_PAID = 'paid';

    /**
     * @var int
     * @Column(type="integer", nullable=false)
     * @Id
     * @GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var string
     * @Column(name="status", type="text", nullable=false, options={"default":"new"})
     */
    private $status;

    /**
     * @var float
     *
     * @Column(name="total_amount_sum", type="float", nullable=false)
     */
    private $totalAmountSum;

    /**
     * @var Collection|Product[]
     *
     * @ManyToMany(targetEntity="App\Domain\Entity\Product")
     * @JoinTable(name="orders_products_many_to_many",
     *     joinColumns={@JoinColumn(name="order_id", referencedColumnName="id")},
     *     inverseJoinColumns={@JoinColumn(name="product_id", referencedColumnName="id")}
     * )
     */
    private $products;

    /**
     * @var int
     * @Column(name="user_id", type="integer", nullable=false)
     */
    private $userId;

    /**
     * @var DateTime
     *
     * @Column(name="created", type="datetime", nullable=false)
     */
    protected $created;

    /**
     * @var DateTime
     *
     * @Column(name="updated", type="datetime", nullable=false)
     */
    protected $updated;

    /**
     * Order constructor.
     * @param float $totalAmountSum
     * @param Product[] $products
     * @param int $userId
     */
    public function __construct(float $totalAmountSum, array $products, int $userId)
    {
        $this->totalAmountSum = $totalAmountSum;
        $this->products = new ArrayCollection($products);;
        $this->userId = $userId;
        $this->created = new DateTime();
        $this->updated = new DateTime();
    }

    /**
     * @return string
     */
    public function getStatus(): string
    {
        return $this->status;
    }

    /**
     * @param string $status
     * @return self
     */
    public function setStatus(string $status): self
    {
        $this->status = $status;
        return $this;
    }

    /**
     * @return float
     */
    public function getTotalAmountSum(): float
    {
        return $this->totalAmountSum;
    }

    /**
     * @param float $totalAmountSum
     * @return self
     */
    public function setTotalAmountSum(float $totalAmountSum): self
    {
        $this->totalAmountSum = $totalAmountSum;
        return $this;
    }

    /**
     * @return Product[]|Collection
     */
    public function getProducts(): Collection
    {
        return $this->products;
    }

    /**
     * @param Product $product
     * @return $this
     */
    public function addProduct(Product $product): self
    {
        $this->products->add($product);
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
