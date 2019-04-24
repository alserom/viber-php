<?php

declare(strict_types=1);

namespace Tests\Alserom\Viber\Entity\Message;

use Alserom\Viber\Entity\Message\MessageEntityFactory;
use Alserom\Viber\Entity\Message as MessageEntity;
use PHPUnit\Framework\TestCase;

/**
 * Class MessageEntityFactoryTest
 * @package Tests\Alserom\Viber\Entity\Message
 * @author Alexander Romanov <contact@alserom.com>
 */
class MessageEntityFactoryTest extends TestCase
{
    /**
     * @param string $type
     *
     * @dataProvider failsDataProvider
     * @expectedException \InvalidArgumentException
     */
    public function testCreateFails(string $type): void
    {
        MessageEntityFactory::create($type);
    }

    /**
     * @return array
     */
    public function failsDataProvider(): array
    {
        return [
            ['stiker'],
            ['message'],
            ['textmessage'],
            ['Message\Text']
        ];
    }

    /**
     * @param string $type
     * @param string $expected
     *
     * @dataProvider successDataProvider
     */
    public function testCreateSuccess(string $type, string $expected): void
    {
        $this->assertInstanceOf($expected, MessageEntityFactory::create($type));
    }

    /**
     * @return array
     */
    public function successDataProvider(): array
    {
        return [
            ['Carousel', MessageEntity\Carousel::class],
            [MessageEntity\Carousel::class, MessageEntity\Carousel::class],
            ['Contact', MessageEntity\Contact::class],
            [MessageEntity\Contact::class, MessageEntity\Contact::class],
            ['File', MessageEntity\File::class],
            [MessageEntity\File::class, MessageEntity\File::class],
            ['Keyboard', MessageEntity\Keyboard::class],
            [MessageEntity\Keyboard::class, MessageEntity\Keyboard::class],
            ['Location', MessageEntity\Location::class],
            [MessageEntity\Location::class, MessageEntity\Location::class],
            ['Picture', MessageEntity\Picture::class],
            [MessageEntity\Picture::class, MessageEntity\Picture::class],
            ['sticker', MessageEntity\Sticker::class],
            [MessageEntity\Sticker::class, MessageEntity\Sticker::class],
            ['Text', MessageEntity\Text::class],
            [MessageEntity\Text::class, MessageEntity\Text::class],
            ['Url', MessageEntity\Url::class],
            [MessageEntity\Url::class, MessageEntity\Url::class],
            ['Video', MessageEntity\Video::class],
            [MessageEntity\Video::class, MessageEntity\Video::class]
        ];
    }
}
