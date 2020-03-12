<?php

namespace App\Generator;

use App\Dto\GeneratedPasswordDto;
use App\Exception\PasswordGenerationException;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;
use Symfony\Contracts\HttpClient\ResponseInterface;

/**
 * Class ApiPasswordGenerator
 */
class ApiPasswordGenerator implements PasswordGeneratorInterface
{
    /** @var string */
    const API_URL = 'https://www.passwordrandom.com/query?command=password&format=json&count=1';

    /** @var HttpClientInterface */
    protected $httpClient;

    /** @var SerializerInterface */
    protected $serializer;

    /**
     * ApiPasswordGenerator constructor.
     *
     * @param HttpClientInterface $httpClient
     * @param SerializerInterface $serializer
     */
    public function __construct(HttpClientInterface $httpClient, SerializerInterface $serializer)
    {
        $this->httpClient = $httpClient;
        $this->serializer = $serializer;
    }

    /**
     * {@inheritDoc}
     */
    public function generate(): string
    {
        try {
            /** @var ResponseInterface $response */
            $response = $this->httpClient->request('GET', self::API_URL);
            /** @var GeneratedPasswordDto $passwordDto */
            $passwordDto = $this->serializer->deserialize($response->getContent(), GeneratedPasswordDto::class, 'json');

            return $passwordDto->getPassword();
        } catch (TransportExceptionInterface $generationException) {
            throw new PasswordGenerationException('PasswordRandom API generation error'); // todo: thick about better solution
        }
    }
}
