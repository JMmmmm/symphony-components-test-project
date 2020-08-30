<?php
declare(strict_types=1);
namespace App\Http\Controller\Product;

use App\Application\Product\ProductsCreationService;
use App\Http\Assembler\Product\ProductDTOsAssembler;
use App\Http\Validation\RequestValidator;
use InvalidArgumentException;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Validator\Constraints\Collection;
use Symfony\Component\Validator\Constraints\Count;
use Symfony\Component\Validator\Constraints\NotNull;

class ProductsCreationController
{
    use RequestValidator;

    private ProductDTOsAssembler $productDTOsAssembler;

    private ProductsCreationService $productsCreationService;

    public function __construct(ProductDTOsAssembler $productDTOsAssembler, ProductsCreationService $productsCreationService)
    {
        $this->productDTOsAssembler = $productDTOsAssembler;
        $this->productsCreationService = $productsCreationService;
    }


    public function create(Request $request): JsonResponse
    {
        $constraints = new Collection([
            'products' => [new NotNull(), new Count(['min' => 2, 'max' => 5])]
        ]);

        try {
            $this->validate($request, $constraints);
            $productsDTOs = $this->productDTOsAssembler->create($request->get('products'));
            $this->productsCreationService->create($productsDTOs);
        } catch (InvalidArgumentException $exception) {
            return new JsonResponse($exception->getMessage(), Response::HTTP_UNPROCESSABLE_ENTITY);
        } catch (\Throwable $exception) {
            return new JsonResponse($exception->getMessage(), $exception->getCode());
        }

        return new JsonResponse('success', Response::HTTP_OK);
    }
}
