<?php

declare(strict_types=1);

namespace UI\Http\Web\Controller\ExchangeRate;

use Application\Query\FindCurrenciesForDate\FindCurrenciesForDateQuery;
use Application\QueryBus;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Validation;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class ListController extends AbstractController
{
    private ValidatorInterface $validator;
    private QueryBus $queryBus;

    public function __construct(
        ValidatorInterface $validator,
        QueryBus $queryBus
    ) {
        $this->validator = $validator;
        $this->queryBus = $queryBus;
    }

    /**
     * @Route("/getExchangeListForm", name="getExchangeListForm", methods={"GET"})
     */
    public function getExchangeListForm(): Response
    {
        return $this->render('exchange_rate/list-form.html.twig', []);
    }

    /**
     * @Route("/getExchangeListTable", name="getExchangeListTable", methods={"POST"})
     */
    public function getExchangeListTable(Request $request): Response
    {
        $input = $request->request->all();
        $constraint = new Assert\Collection(['exchange-rate-date' => [new Assert\Date(), new Assert\NotBlank()]]);
        $violations = $this->validator->validate($input, $constraint);

        if ($violations->count() > 0) {
            return $this->render('exchange_rate/list-form.html.twig', ['violations' => $violations]);
        }

        return $this->render(
            'exchange_rate/list-table.html.twig',
            [
                'exchangeRateCollectionDto' => $this->queryBus->handle(
                    new FindCurrenciesForDateQuery(new \DateTimeImmutable($input['exchange-rate-date']))
                )
            ]
        );
    }
}
