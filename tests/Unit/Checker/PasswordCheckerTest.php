<?php

namespace App\Tests\Unit\Checker;

use App\Checker\PasswordChecker;
use App\Constrain\PasswordConstrain;
use App\Provider\ConstrainsProviderInterface;
use PHPUnit\Framework\TestCase;

/**
 * Class PasswordCheckerTest
 */
class PasswordCheckerTest extends TestCase
{
    public function testPasswordCheck()
    {
        // create mock
        $constrain = new PasswordConstrain('/^.{6,}$/', 'Password length is minimum 5 character');
        $providerMock = $this->createMock(ConstrainsProviderInterface::class);
        $providerMock
            ->method('getConstrains')
            ->willReturn([
                $constrain,
            ]);


        $checker = new PasswordChecker($providerMock);

        // incorrect case
        $res = $checker->checkPassword('pass');

        $this->assertSame(false, $res);
        $this->assertSame(
            $constrain->getMessage(),
            $checker->getErrorMessage()
        );

        // correct case
        $res = $checker->checkPassword('password');

        $this->assertSame(true, $res);
    }
}
