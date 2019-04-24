<?php

declare(strict_types=1);

namespace Tests\Alserom\Viber;

use Alserom\Viber\Entity\Contact;
use Alserom\Viber\Entity\Keyboard;
use Alserom\Viber\Entity\Location;
use Alserom\Viber\Entity\Message\Text;
use Alserom\Viber\Entity\RichMedia;
use Alserom\Viber\Message;
use PHPUnit\Framework\TestCase;

/**
 * Class MessageTest
 * @package Tests\Alserom\Viber
 * @author Alexander Romanov <contact@alserom.com>
 */
class MessageTest extends TestCase
{
    public function testDefaultMessageType(): void
    {
        $message = new Message();

        $this->assertInstanceOf(Text::class, $message->getEntity());
    }

    /**
     * @param string $type
     * @param string $method
     *
     * @dataProvider failsDataProvider
     * @expectedException \Error
     */
    public function testEntityMethodFails(string $type, string $method): void
    {
        $message = new Message($type);
        $message->$method();
    }

    /**
     * @return array
     */
    public function failsDataProvider(): array
    {
        return [
            ['text', 'getMedia'],
            ['file', 'getText']
        ];
    }

    /**
     * @param string $type
     * @param string $setter
     * @param string $getter
     * @param mixed $value
     *
     * @dataProvider dataProvider
     */
    public function testEntityMethod(string $type, string $setter, string $getter, $value): void
    {
        $message = new Message($type);

        if ($setter) {
            $this->assertInstanceOf(Message::class, $message->$setter($value));
        }
        $this->assertEquals($value, $message->$getter());
    }

    /**
     * @return array
     */
    public function dataProvider(): array
    {
        return [
            ['text', 'setTrackingData', 'getTrackingData', 'Tracking data value'],
            ['text', 'setKeyboard', 'getKeyboard', new Keyboard()],
            ['carousel', 'setAltText', 'getAltText', 'Some text'],
            ['carousel', 'setRichMedia', 'getRichMedia', new RichMedia()],
            ['contact', 'setContact', 'getContact', new Contact()],
            ['sticker', 'setMedia', 'getMedia', 'https://example.com'],
            ['url', 'setMedia', 'getMedia', 'https://example.com'],
            ['file', 'setMedia', 'getMedia', 'https://example.com'],
            ['video', 'setMedia', 'getMedia', 'https://example.com'],
            ['picture', 'setMedia', 'getMedia', 'https://example.com'],
            ['file', 'setSize', 'getSize', 123],
            ['video', 'setSize', 'getSize', 123],
            ['file', 'setFileName', 'getFileName', 'Some file name'],
            ['video', 'setFileName', 'getFileName', 'Some file name'],
            ['picture', 'setFileName', 'getFileName', 'Some file name'],
            ['location', 'setLocation', 'getLocation', new Location(50.0, 50.0)],
            ['text', 'setText', 'getText', 'Hello world!'],
            ['picture', 'setText', 'getText', 'Hello world!'],
            ['video', 'setThumbnail', 'getThumbnail', 'https://example.com'],
            ['picture', 'setThumbnail', 'getThumbnail', 'https://example.com'],
            ['sticker', 'setStickerId', 'getStickerId', 12345],
            ['video', 'setDuration', 'getDuration', 123],
            ['carousel', '', 'getType', 'rich_media'],
            ['contact', '', 'getType', 'contact'],
            ['file', '', 'getType', 'file'],
            ['keyboard', '', 'getType', 'keyboard'],
            ['location', '', 'getType', 'location'],
            ['picture', '', 'getType', 'picture'],
            ['sticker', '', 'getType', 'sticker'],
            ['text', '', 'getType', 'text'],
            ['url', '', 'getType', 'url'],
            ['video', '', 'getType', 'video']
        ];
    }
}
