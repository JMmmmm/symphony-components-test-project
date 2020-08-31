<?php
declare(strict_types=1);
namespace App\Application\Product;

use App\Application\Product\DTO\ProductDTO;
use App\Application\User\UserInterface;
use App\Domain\Entity\Product;
use Doctrine\ORM\EntityManagerInterface;
use Generator;
use InvalidArgumentException;

class ProductsCreationService
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
     * @param Generator|ProductDTO[] $productDTOS
     */
    public function create(Generator $productDTOS): void
    {
        $productNames = [];
        foreach ($productDTOS as $productDTO) {
            $product = new Product($productDTO->getName(), $productDTO->getPrice(), $this->user->getId());

            $this->entityManager->persist($product);

            $productNames[] = $productDTO->getName();
        }

        $this->checkProductNamesExistence($productNames);

        $this->entityManager->flush();
    }

    /**
     * @param array $productNames
     */
    private function checkProductNamesExistence(array $productNames): void
    {
        /** @var Product[] $existingProducts */
        $existingProducts = $this->entityManager
            ->getRepository(Product::class)
            ->findBy(['name' => $productNames]);

        if (!$existingProducts) {
            return;
        }

        $existingProductNames = [];
        foreach ($existingProducts as $existingProduct) {
            $existingProductNames[] = $existingProduct->getName();
        }
        
        throw new InvalidArgumentException('Next product names are existing: ' . implode(', ', $existingProductNames));
    }
}
