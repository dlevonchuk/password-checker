<?php

namespace App\Tests\Unit\Generator;

use App\Dto\GeneratedPasswordDto;
use App\Generator\ApiPasswordGenerator;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;
use Symfony\Contracts\HttpClient\ResponseInterface;

/**
 * Class ApiPasswordGeneratorTest
 */
class ApiPasswordGeneratorTest extends TestCase
{
    const PASSWORD = 'generatedpassword';

    public function testGenerate()
    {
        // create mock
        $httpClientMock = $this->createMock(HttpClientInterface::class);

        $dto = new GeneratedPasswordDto();
        $dto->char[] = self::PASSWORD;
        $serializerMock = $this->createMock(SerializerInterface::class);
        $serializerMock->method('deserialize')
            ->willReturn($dto);

        // test case
        $generator = new ApiPasswordGenerator($httpClientMock, $serializerMock);
        $pass = $generator->generate();

        $this->assertSame(
            self::PASSWORD,
            $pass
        );
    }
}
