<?php

declare(strict_types=1);

namespace Alserom\Viber;

use Alserom\Viber\Event\EventFactory;
use Alserom\Viber\Event\EventInterface;
use Alserom\Viber\Exception\InvalidEventException;
use Alserom\Viber\Exception\InvalidEventHandlerException;
use Alserom\Viber\Exception\InvalidServerRequestException;
use Alserom\Viber\Request\Type\SendMessage;
use Alserom\Viber\Response\ApiResponseInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\StreamInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Psr\Log\LoggerInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\OptionsResolver\Options;
use Alserom\Viber\Event\Type as EventType;

/**
 * Class Bot
 * @package Alserom\Viber
 * @author Alexander Romanov <contact@alserom.com>
 */
class Bot implements RequestHandlerInterface
{
    private const SIGNATURE_HEADER_NAME = 'X-Viber-Content-Signature';

    private $api;

    private $options;

    private $response;

    private $handlers = [];

    /**
     * Bot constructor.
     * @param Api $api
     * @param array|null $options
     */
    public function __construct(Api $api, array $options = null)
    {
        $this->api = $api;

        $resolver = new OptionsResolver();
        $this->configureOptions($resolver);
        $this->options = $resolver->resolve($options ?? []);

        $this->response = $api->getPsr17()->getResponseFactory()->createResponse();
    }

    /**
     * @param OptionsResolver $resolver
     */
    private function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'welcome_message'          => null,
            'validate_welcome_message' => true,
            'logger'                   => null,
            'debug'                    => false,
            'error_codes'              => function (OptionsResolver $errorCodesResolver) {
                $errorCodesResolver->setDefaults([
                    'invalid_signature' => 403,
                    'invalid_body'      => 400,
                    'invalid_event'     => 400,
                    'invalid_handler'   => 200
                ]);
                $errorCodesResolver->setAllowedTypes('invalid_signature', 'int');
                $errorCodesResolver->setAllowedTypes('invalid_body', 'int');
                $errorCodesResolver->setAllowedTypes('invalid_event', 'int');
                $errorCodesResolver->setAllowedTypes('invalid_handler', 'int');
            }
        ]);
        $resolver->setAllowedTypes('welcome_message', ['null', 'callable', Message::class]);
        $resolver->setAllowedTypes('validate_welcome_message', 'bool');
        $resolver->setAllowedTypes('logger', ['null', LoggerInterface::class]);
        $resolver->setAllowedTypes('debug', 'bool');
        $resolver->setAllowedTypes('error_codes', 'array');
        $resolver->setNormalizer('welcome_message', function (Options $options, $value) {
            if (\is_callable($value)) {
                $value = \Closure::fromCallable($value);
            }
            return $value;
        });
    }

    /**
     * @inheritdoc
     */
    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        try {
            $this->handleRequest($request);
        } catch (\Exception $ex) {
            $this->handleException($ex);
        }

        return $this->response;
    }

    /**
     * @param ServerRequestInterface $request
     */
    private function handleRequest(ServerRequestInterface $request): void
    {
        $this->debugIncomingRequest('Handling a request', $request);
        $signature = $request->getHeader(self::SIGNATURE_HEADER_NAME)[0] ?? '';
        $body = $request->getBody()->__toString();

        if (!$this->isSignatureValid($signature, $body)) {
            throw new InvalidServerRequestException(
                $request,
                'Invalid signature',
                $this->options['error_codes']['invalid_signature']
            );
        }

        $data = (array) json_decode($body, true, 512, JSON_BIGINT_AS_STRING);
        $jsonError = json_last_error();
        if ($jsonError !== JSON_ERROR_NONE) {
            $msg = ApiResponseInterface::JSON_ERRORS[$jsonError] ?? 'Unknown';
            throw new InvalidServerRequestException(
                $request,
                sprintf('Invalid body. JSON decoding error: %s.', $msg),
                $this->options['error_codes']['invalid_body']
            );
        }

        try {
            $event = EventFactory::create($data);
        } catch (InvalidEventException $ex) {
            throw new InvalidServerRequestException(
                $request,
                'Invalid event',
                $this->options['error_codes']['invalid_event'],
                $ex
            );
        }

        $this->handleEvent($event);
        $this->debugIncomingRequest('The request was successfully handled', $request);
    }

    /**
     * @param EventInterface $event
     */
    private function handleEvent(EventInterface $event): void
    {
        $this->debugIncomingEvent('Handling an event with type: {type}', $event);
        $type = $event->getEventType();
        $handler = $this->handlers[$type] ?? null;

        if ($event instanceof EventType\ConversationStarted) {
            $this->debugIncomingEvent('Setting up a welcome message.', $event);
            try {
                $message = $this->generateWelcomeMessage($event);
                $this->response = $this->response
                    ->withHeader('Content-Type', 'application/json')
                    ->withBody($message);
            } catch (\Exception $ex) {
                $this->logException($ex);
            }
        }

        if ($handler === null) {
            $this->debugIncomingEvent('No handlers found. Event type: {type}', $event);
            return;
        }

        try {
            $handler($event, $this->api);
        } catch (\Exception $ex) {
            throw new InvalidEventHandlerException($ex);
        }
        $this->debugIncomingEvent('Handling an event was successfully completed. Event type: {type}', $event);
    }

    /**
     * @param EventType\ConversationStarted $event
     * @return StreamInterface
     */
    private function generateWelcomeMessage(EventType\ConversationStarted $event): StreamInterface
    {
        $message = $this->options['welcome_message'];

        if ($message instanceof \Closure) {
            $message = $message(clone $event->getUser(), $event->isSubscribed());
        }

        if ($message === null || !$message instanceof Message) {
            return $this->api->getPsr17()->getStreamFactory()->createStream(json_encode(''));
        }

        $sendMsgReq = new SendMessage(
            $this->api->getToken(),
            $event->getUser(),
            $message->getEntity(),
            $message->getSender(),
            $message->getMinApiVersion()
        );
        $psr17 = $this->api->getPsr17();
        $sendMsgReq
            ->setUriFactory($psr17->getUriFactory())
            ->setStreamFactory($psr17->getStreamFactory())
            ->setRequestFactory($psr17->getRequestFactory());

        if ($this->options['validate_welcome_message']) {
            $sendMsgReq->validate();
        }

        return $sendMsgReq->getBody();
    }

    /**
     * @param \Exception $ex
     */
    private function handleException(\Exception $ex): void
    {
        $statusCode = 500;
        if ($ex instanceof InvalidServerRequestException) {
            $statusCode = $ex->getCode();
        }

        if ($ex instanceof InvalidEventHandlerException) {
            $statusCode = $this->options['error_codes']['invalid_handler'];
        }

        $this->response = $this->response->withStatus($statusCode);
        $this->logException($ex);
    }

    /**
     * @param \Exception $ex
     */
    private function logException(\Exception $ex): void
    {
        $logger = $this->options['logger'];
        if (!$logger instanceof LoggerInterface) {
            return;
        }

        if ($ex instanceof InvalidServerRequestException) {
            $message = $ex->getMessage();
            $context = [
                'exception' => $ex,
                'request'   => $ex->getRequest()
            ];
            $prev = $ex->getPrevious();

            if ($prev && $prev instanceof InvalidEventException) {
                $message = $prev->getMessage();
                $context['event_data'] = $prev->getData();
            }

            $logger->error($message, $context);
            return;
        }

        $logger->critical($ex->getMessage(), ['exception' => $ex]);
    }

    /**
     * @param string $message
     * @param EventInterface $event
     */
    private function debugIncomingEvent(string $message, EventInterface $event): void
    {
        $logger = $this->options['logger'];
        if ($logger instanceof LoggerInterface && $this->options['debug']) {
            $logger->debug($message, ['type' => $event->getEventType(), 'event_data' => $event->getData()]);
        }
    }

    /**
     * @param string $message
     * @param ServerRequestInterface $request
     */
    private function debugIncomingRequest(string $message, ServerRequestInterface $request): void
    {
        $logger = $this->options['logger'];
        if ($logger instanceof LoggerInterface && $this->options['debug']) {
            $logger->debug($message, ['request' => $request]);
        }
    }

    /**
     * @param string $signature
     * @param string $body
     * @return bool
     */
    private function isSignatureValid(string $signature, string $body): bool
    {
        $sign = hash_hmac('sha256', $body, $this->api->getToken());

        return hash_equals($signature, $sign);
    }

    /**
     * @param string $eventType
     * @param callable $handler
     * @return Bot
     */
    public function on(string $eventType, callable $handler): self
    {
        if (\in_array(strtolower($eventType), EventInterface::AVAILABLE_EVENTS, true)) {
            $this->handlers[$eventType] = \Closure::fromCallable($handler);
        }

        return $this;
    }

    /**
     * @param callable $handler
     * @return Bot
     */
    public function onConversationStarted(callable $handler): self
    {
        return $this->on(EventType\ConversationStarted::TYPE, $handler);
    }

    /**
     * @param callable $handler
     * @return Bot
     */
    public function onDelivered(callable $handler): self
    {
        return $this->on(EventType\Delivered::TYPE, $handler);
    }

    /**
     * @param callable $handler
     * @return Bot
     */
    public function onFailed(callable $handler): self
    {
        return $this->on(EventType\Failed::TYPE, $handler);
    }

    /**
     * @param callable $handler
     * @return Bot
     */
    public function onMessage(callable $handler): self
    {
        return $this->on(EventType\Message::TYPE, $handler);
    }

    /**
     * @param callable $handler
     * @return Bot
     */
    public function onSeen(callable $handler): self
    {
        return $this->on(EventType\Seen::TYPE, $handler);
    }

    /**
     * @param callable $handler
     * @return Bot
     */
    public function onSubscribed(callable $handler): self
    {
        return $this->on(EventType\Subscribed::TYPE, $handler);
    }

    /**
     * @param callable $handler
     * @return Bot
     */
    public function onUnsubscribed(callable $handler): self
    {
        return $this->on(EventType\Unsubscribed::TYPE, $handler);
    }
}
