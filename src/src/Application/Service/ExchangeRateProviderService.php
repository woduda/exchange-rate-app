<?php

declare(strict_types=1);

namespace Application\Service;

use DateTime;
use Domain\ExchangeRate\Dto\ExchangeRateCollectionDto;
use Domain\ExchangeRate\Exception\ExternalSourceUnreachableException;
use Domain\ExchangeRate\Factory\ExchangeRateCollectionDtoFactory;
use Domain\ExchangeRate\Service\ExchangeRateProviderService as ExchangeRateProviderServiceInterface;
use GuzzleHttp\Client as GuzzleHttpClient;
use GuzzleHttp\Exception\ClientException;
use Psr\Log\LoggerInterface;
use Symfony\Component\HttpFoundation\Response;
use Throwable;

class ExchangeRateProviderService implements ExchangeRateProviderServiceInterface
{
    protected const EXCHANGE_RATES_ENDPOINT_TEMPLATE = '%s/%s/%s%s';
    protected const FETCH_METHOD = 'GET';
    protected const FORMAT_AS_JSON = '?format=json';

    protected GuzzleHttpClient $client;
    protected LoggerInterface $logger;
    protected string $endpoint;
    protected string $currencyTable;

    public function __construct(
        GuzzleHttpClient $client,
        LoggerInterface $logger,
        string $endpoint,
        string $currencyTable
    ) {
        $this->client = $client;
        $this->logger = $logger;
        $this->endpoint = $endpoint;
        $this->currencyTable = $currencyTable;
    }

    public function fetch(DateTime $dateTime): ExchangeRateCollectionDto
    {
        try {
            $response = $this->client->request(
                self::FETCH_METHOD,
                sprintf(
                    self::EXCHANGE_RATES_ENDPOINT_TEMPLATE,
                    $this->endpoint,
                    $this->currencyTable,
                    $dateTime->format('Y-m-d'),
                    self::FORMAT_AS_JSON
                ));

            switch ($response->getStatusCode()) {
                case Response::HTTP_OK:
                    $body = json_decode($response->getBody()->getContents())[0];

                    if (empty($body) === false && empty($body->rates) === false) {
                        $exchangeRatesCollection = ExchangeRateCollectionDtoFactory::createFromRawNbp($body);
                        $this->logger->info(sprintf('Successfully fetched %s currencies', count($body->rates)));

                        return $exchangeRatesCollection;
                    }

                    break;
                case Response::HTTP_NOT_FOUND:
                    return new ExchangeRateCollectionDto();
                default:
                    throw ExternalSourceUnreachableException::create();
            }
        } catch (ClientException $exception) {
            $response = $exception->getResponse();

            if ($response && $response->getStatusCode() === Response::HTTP_NOT_FOUND) {
                return new ExchangeRateCollectionDto();
            }

            throw $exception;
        } catch (Throwable $exception) {
            $this->logger->error((string)$exception);

            throw ExternalSourceUnreachableException::create();
        }
    }
}
