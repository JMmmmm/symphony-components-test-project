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

    /**
     * @var ProductDTOsAssembler
     */
    private ProductDTOsAssembler $productDTOsAssembler;

    /**
     * @var ProductsCreationService
     */
    private ProductsCreationService $productsCreationService;

    /**
     * ProductsCreationController constructor.
     * @param ProductDTOsAssembler $productDTOsAssembler
     * @param ProductsCreationService $productsCreationService
     */
    public function __construct(ProductDTOsAssembler $productDTOsAssembler, ProductsCreationService $productsCreationService)
    {
        $this->productDTOsAssembler = $productDTOsAssembler;
        $this->productsCreationService = $productsCreationService;
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function create(Request $request): JsonResponse
    {
        $constraints = new Collection([
            'products' => [new NotNull(), new Count(['min' => 20, 'max' => 20])]
        ]);

        try {
            $this->validate($request, $constraints);
            $productsDTOs = $this->productDTOsAssembler->create($request->get('products'));
            $this->productsCreationService->create($productsDTOs);
        } catch (InvalidArgumentException $exception) {
            return new JsonResponse($exception->getMessage(), Response::HTTP_UNPROCESSABLE_ENTITY);
        } catch (\Throwable $exception) {
            return new JsonResponse($exception->getMessage(), Response::HTTP_SERVICE_UNAVAILABLE);
        }

        return new JsonResponse('success', Response::HTTP_OK);
    }
}
