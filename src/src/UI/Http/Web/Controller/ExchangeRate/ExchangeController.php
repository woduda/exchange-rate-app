<?php

declare(strict_types=1);

namespace UI\Http\Web\Controller\ExchangeRate;

use Application\Query\ExchangeCurrencyToAnotherOne\ExchangeCurrencyToAnotherOneQuery;
use Application\Query\FindCurrenciesCodes\FindCurrenciesCodesQuery;
use Application\QueryBus;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Component\Validator\Constraints as Assert;
use DateTimeImmutable;

class ExchangeController extends AbstractController
{
    private ValidatorInterface $validator;
    private QueryBus $queryBus;

    public function __construct(ValidatorInterface $validator, QueryBus $queryBus)
    {
        $this->validator = $validator;
        $this->queryBus = $queryBus;
    }

    /**
     * @Route("/getExchangeRateForm", name="getExchangeRateForm", methods={"GET"})
     */
    public function getExchangeListForm(): Response
    {
        return $this->render(
            'exchange_rate/exchange-form.html.twig',
            ['codes' => $this->queryBus->handle(new FindCurrenciesCodesQuery())->toArray()]
        );
    }

    /**
     * @Route("/getExchangeResult", name="getExchangeResult", methods={"POST"})
     */
    public function getExchangingResult(Request $request): Response
    {
        $input = $request->request->all();
        $constraint = new Assert\Collection([
            'amount'        => [new Assert\NotBlank(), new Assert\Positive()],
            'currency-from' => [new Assert\NotBlank(), new Assert\Length(['min' => 3, 'max' => '3'])],
            'currency-to'   => [new Assert\NotBlank(), new Assert\Length(['min' => 3, 'max' => '3'])],
            'date'          => [new Assert\NotBlank(), new Assert\Date()]
        ]);
        $violations = $this->validator->validate($input, $constraint);

        if ($violations->count() > 0) {
            return $this->render(
                'exchange_rate/exchange-form.html.twig',
                [
                    'violations' => $violations,
                    'codes' => $this->queryBus->handle(new FindCurrenciesCodesQuery())->toArray()
                ]);
        }

        return $this->render(
            'exchange_rate/exchange-result.html.twig',
            [
                'exchangeResultDto' => $this->queryBus->handle(new ExchangeCurrencyToAnotherOneQuery(
                    $input['amount'],
                    $input['currency-from'],
                    $input['currency-to'],
                    new DateTimeImmutable($input['date'])
                ))
            ]
        );
    }
}
