<?php
declare(strict_types=1);
namespace App\Application\Order;

use App\Application\User\UserInterface;
use App\Domain\Entity\Order;
use App\Domain\Entity\Product;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;
use InvalidArgumentException;

class OrderCreationService
{
    /**
     * @var EntityManagerInterface
     */
    private EntityManagerInterface $entityManager;

    /**
     * @var UserInterface
     */
    private UserInterface $user;

    /**
     * ProductsCreationService constructor.
     * @param EntityManagerInterface $entityManager
     * @param UserInterface $user
     */
    public function __construct(EntityManagerInterface $entityManager, UserInterface $user)
    {
        $this->entityManager = $entityManager;
        $this->user = $user;
    }

    /**
     * @param array $productsIds
     * @return string
     */
    public function create(array $productsIds): string
    {
        /** @var EntityRepository $productRepository */
        $productRepository = $this->entityManager->getRepository(Product::class);

        $amountTotalSum = 0.0;
        $products = [];
        foreach ($productsIds as $productId) {
            /** @var Product|null $product */
            $product = $productRepository->findOneBy(['id' => (int)$productId]);

            if ($product === null) {
                throw new InvalidArgumentException('Product with id #' . $productId . ' is absent');
            }

            $amountTotalSum += $product->getPrice();
            $products[] = $product;
        }

        $billingNumber = uniqid();
        $order = new Order($amountTotalSum, $products, $this->user->getId(), $billingNumber);

        $this->entityManager->persist($order);
        $this->entityManager->flush();

        return $billingNumber;
    }
}
