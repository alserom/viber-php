<?php

declare(strict_types=1);

namespace Tests\Alserom\Viber;

use Alserom\Viber\Psr17;
use PHPUnit\Framework\TestCase;

/**
 * Class Psr17Test
 * @package Tests\Alserom\Viber
 * @author Alexander Romanov <contact@alserom.com>
 */
class Psr17Test extends TestCase
{
    /**
     * @param mixed $arg
     *
     * @dataProvider dataProvider
     * @expectedException \InvalidArgumentException
     */
    public function testUseForAllFails($arg): void
    {
        Psr17::useForAll($arg);
    }

    /**
     * @return array
     */
    public function dataProvider(): array
    {
        return [
            [null],
            ['string'],
            [new \stdClass()]
        ];
    }
}
