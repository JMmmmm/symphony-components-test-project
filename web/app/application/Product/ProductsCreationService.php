<?php
declare(strict_types=1);
namespace App\Application\Product;

use App\Application\Product\DTO\ProductDTO;
use App\Application\User\UserInterface;
use Doctrine\ORM\EntityManagerInterface;
use Generator;

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
     * @param ProductDTO[]|Generator $productDTOS
     */
    public function create(Generator $productDTOS): void
    {
        foreach ($productDTOS as $productDTO) {
            $test = 1;

            $bot = 2;
        }
    }
}
