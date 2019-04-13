<?php

namespace Alserom\Viber\Response;

use Psr\Http\Message\ResponseInterface;

/**
 * Interface ApiResponseInterface
 * @package Alserom\Viber\Response
 * @author Alexander Romanov <contact@alserom.com>
 */
interface ApiResponseInterface
{
    public const JSON_ERRORS = [
        JSON_ERROR_DEPTH                 => 'The maximum stack depth has been exceeded',
        JSON_ERROR_STATE_MISMATCH        => 'Invalid or malformed JSON',
        JSON_ERROR_CTRL_CHAR             => 'Control character error, possibly incorrectly encoded',
        JSON_ERROR_SYNTAX                => 'Syntax error',
        JSON_ERROR_UTF8                  => 'Malformed UTF-8 characters, possibly incorrectly encoded',
        JSON_ERROR_RECURSION             => 'One or more recursive references in the value to be encoded',
        JSON_ERROR_INF_OR_NAN            => 'One or more NAN or INF values in the value to be encoded',
        JSON_ERROR_UNSUPPORTED_TYPE      => 'A value of a type that cannot be encoded was given',
        JSON_ERROR_INVALID_PROPERTY_NAME => 'A property name that cannot be encoded was given',
        JSON_ERROR_UTF16                 => 'Malformed UTF-16 characters, possibly incorrectly encoded'
    ];

    /**
     * @return string
     */
    public function __toString(): string;

    /**
     * @return ResponseInterface
     */
    public function getHttpResponse(): ResponseInterface;

    /**
     * @return string|null
     */
    public function getChatHostname(): ?string;

    /**
     * @return array
     */
    public function getData(): array;
}
