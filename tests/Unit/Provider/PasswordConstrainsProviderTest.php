<?php

namespace App\Tests\Unit\Provider;

use App\Constrain\PasswordConstrain;
use App\Provider\PasswordConstrainsProvider;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Yaml\Parser;

/**
 * Class PasswordConstrainsProviderTest
 */
class PasswordConstrainsProviderTest extends TestCase
{
    public function testGetConstrains(): void
    {
        // create mock
        $testRule = ['pattern' => '/^.{6,}$/', 'message' => 'Password length is minimum 5 character'];
        $parserMock = $this->createMock(Parser::class);
        $parserMock->method('parseFile')
            ->willReturn([
                $testRule,
            ]);

        // init data
        $provider = new PasswordConstrainsProvider($parserMock, 'fake_file_path');
        $constrain = new PasswordConstrain($testRule['pattern'], $testRule['message']);

        // test
        $res = $provider->getConstrains();

        $this->assertEquals(
            [$constrain],
            $res
        );
    }
}
