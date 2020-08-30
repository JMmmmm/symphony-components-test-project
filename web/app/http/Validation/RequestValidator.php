<?php
declare(strict_types=1);
namespace App\Http\Validation;

use InvalidArgumentException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Constraints\Collection;
use Symfony\Component\Validator\ConstraintViolation;
use Symfony\Component\Validator\Validation;

trait RequestValidator
{
    /**
     * @param Request $request
     * @param Collection $constraints
     */
    public function validate(Request $request, Collection $constraints): void
    {
        $validator = Validation::createValidator();

        $requestData = $request->request->all();

        $violations = $validator->validate($requestData, $constraints);
        /** @var ConstraintViolation $violation */
        foreach ($violations as $violation) {
            throw new InvalidArgumentException($violation->getMessage());
        }
    }
}
