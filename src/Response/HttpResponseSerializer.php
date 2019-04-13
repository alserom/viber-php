<?php

declare(strict_types=1);

namespace Alserom\Viber\Response;

use Psr\Http\Message\ResponseFactoryInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\StreamFactoryInterface;

/**
 * Class HttpResponseSerializer
 * @package Alserom\Viber\Response
 * @author Alexander Romanov <contact@alserom.com>
 */
final class HttpResponseSerializer
{
    /**
     * Copied and modified from guzzle/psr7 package
     * @link https://github.com/guzzle/psr7/blob/1.5.2/src/functions.php#L27-L39
     * @license https://github.com/guzzle/psr7/blob/1.5.2/LICENSE
     *
     * @param ResponseInterface $response
     * @return string
     */
    public static function toString(ResponseInterface $response): string
    {
        $str = sprintf(
            'HTTP/%s %d %s',
            $response->getProtocolVersion(),
            $response->getStatusCode(),
            $response->getReasonPhrase()
        );

        foreach ($response->getHeaders() as $name => $values) {
            $str .= "\r\n$name: " . implode(', ', $values);
        }

        return "$str\r\n\r\n" . $response->getBody()->__toString();
    }

    /**
     * Copied and modified from guzzle/psr7 package
     * @link https://github.com/guzzle/psr7/blob/1.5.2/src/functions.php#L497-L512
     * @license https://github.com/guzzle/psr7/blob/1.5.2/LICENSE
     *
     * @param string $message
     * @param ResponseFactoryInterface $responseFactory
     * @param StreamFactoryInterface $streamFactory
     * @return ResponseInterface
     * @throws \InvalidArgumentException
     */
    public static function fromString(
        string $message,
        ResponseFactoryInterface $responseFactory,
        StreamFactoryInterface $streamFactory
    ): ResponseInterface {
        $data = self::parseString($message);
        if (!preg_match('/^HTTP\/.* [0-9]{3}( .*|$)/', $data['start-line'])) {
            throw new \InvalidArgumentException('Invalid response string: ' . $data['start-line']);
        }
        $parts = explode(' ', $data['start-line'], 3);

        $response = $responseFactory->createResponse((int)$parts[1], $parts[2] ?? '');
        foreach ((array)$data['headers'] as $name => $values) {
            $response = $response->withHeader($name, $values);
        }

        return $response
            ->withProtocolVersion(explode('/', $parts[0])[1])
            ->withBody($streamFactory->createStream($data['body']));
    }

    /**
     * Copied and modified from guzzle/psr7 package
     * @link https://github.com/guzzle/psr7/blob/1.5.2/src/functions.php#L767-L813
     * @license https://github.com/guzzle/psr7/blob/1.5.2/LICENSE
     *
     * @param string $message
     * @return array
     * @throws \InvalidArgumentException
     */
    protected static function parseString(string $message): array
    {
        $message = ltrim($message, "\r\n");
        $messageParts = preg_split("/\r?\n\r?\n/", $message, 2);
        if ($messageParts === false || \count($messageParts) !== 2) {
            throw new \InvalidArgumentException('Invalid message: Missing header delimiter');
        }
        [$rawHeaders, $body] = $messageParts;
        $rawHeaders .= "\r\n";
        $headerParts = preg_split("/\r?\n/", $rawHeaders, 2);
        if ($headerParts === false || \count($headerParts) !== 2) {
            throw new \InvalidArgumentException('Invalid message: Missing status line');
        }
        [$startLine, $rawHeaders] = $headerParts;
        if (preg_match("/(?:^HTTP\/|^[A-Z]+ \S+ HTTP\/)(\d+(?:\.\d+)?)/i", $startLine, $matches)
            && $matches[1] === '1.0'
        ) {
            $rawHeaders = (string)preg_replace("(\r?\n[ \t]++)", ' ', $rawHeaders);
        }

        $count = preg_match_all(
            "(^([^()<>@,;:\\\"/[\]?={}\x01-\x20\x7F]++):[ \t]*+((?:[ \t]*+[\x21-\x7E\x80-\xFF]++)*+)[ \t]*+\r?\n)m",
            $rawHeaders,
            $headerLines,
            PREG_SET_ORDER
        );

        if ($count !== substr_count($rawHeaders, "\n")) {
            if (preg_match("(\r?\n[ \t]++)", $rawHeaders)) {
                throw new \InvalidArgumentException('Invalid header syntax: Obsolete line folding');
            }
            throw new \InvalidArgumentException('Invalid header syntax');
        }
        $headers = [];
        foreach ((array)$headerLines as $headerLine) {
            $headers[$headerLine[1]][] = $headerLine[2];
        }

        return [
            'start-line' => $startLine,
            'headers'    => $headers,
            'body'       => $body
        ];
    }
}
