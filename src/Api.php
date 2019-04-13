<?php

declare(strict_types=1);

namespace Alserom\Viber;

use Alserom\Viber\Collection\UserCollection;
use Alserom\Viber\Entity\User;
use Alserom\Viber\Entity\Webhook;
use Alserom\Viber\Exception\InvalidApiRequestException;
use Alserom\Viber\Exception\InvalidApiResponseException;
use Alserom\Viber\Request\ApiRequestInterface;
use Alserom\Viber\Request\HttpRequestBuilder;
use Alserom\Viber\Request\Type as ApiReqType;
use Alserom\Viber\Response\HttpResponseSerializer;
use Alserom\Viber\Response\Type as ApiRespType;
use Psr\Cache\CacheItemInterface;
use Psr\Cache\CacheItemPoolInterface;
use Psr\Http\Client\ClientExceptionInterface;
use Psr\Http\Client\ClientInterface;
use Psr\Http\Message\ResponseInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Class Api
 * @package Alserom\Viber
 * @author Alexander Romanov <contact@alserom.com>
 */
class Api
{
    private const BASE_CACHE_KEY = 'alserom.viber.';

    private $token;

    private $psr17;

    private $httpClient;

    private $options;

    private $httpRequestBuilder;

    /**
     * @param string $token
     * @param Psr17 $psr17
     * @param ClientInterface $httpClient
     * @param array|null $options
     */
    public function __construct(string $token, Psr17 $psr17, ClientInterface $httpClient, array $options = null)
    {
        $this->token = $token;
        $this->psr17 = $psr17;
        $this->httpClient = $httpClient;

        $resolver = new OptionsResolver();
        $this->configureOptions($resolver);
        $this->options = $resolver->resolve($options ?? []);

        $this->httpRequestBuilder = new HttpRequestBuilder(
            $psr17->getRequestFactory(),
            $psr17->getStreamFactory(),
            $psr17->getUriFactory(),
            $this->options['validate_request']
        );
    }

    /**
     * @return string
     */
    public function getToken(): string
    {
        return $this->token;
    }

    /**
     * @return Psr17
     */
    public function getPsr17(): Psr17
    {
        return $this->psr17;
    }

    /**
     * @param OptionsResolver $resolver
     */
    private function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'validate_request' => true,
            'cache'            => function (OptionsResolver $cacheResolver) {
                $cacheResolver->setDefaults([
                    'pool'    => null,
                    'methods' => function (OptionsResolver $methodsResolver) {
                        $methodOptions = function (OptionsResolver $methodResolver, array $defaults) {
                            $methodResolver->setDefaults($defaults);
                            $methodResolver->setAllowedTypes('enable', 'bool');
                            $methodResolver->setAllowedTypes('base_key', 'string');
                            $methodResolver->setAllowedTypes('ttl', ['null', 'int']);
                        };
                        $methodsResolver->setDefaults([
                            ApiReqType\GetAccountInfo::API_METHOD =>
                                function (OptionsResolver $methodResolver) use ($methodOptions) {
                                    $methodOptions($methodResolver, [
                                        'enable'   => true,
                                        'base_key' => sprintf(
                                            '%s%s.',
                                            self::BASE_CACHE_KEY,
                                            ApiReqType\GetAccountInfo::API_METHOD
                                        ),
                                        'ttl'      => null
                                    ]);
                                },
                            ApiReqType\GetOnline::API_METHOD      =>
                                function (OptionsResolver $methodResolver) use ($methodOptions) {
                                    $methodOptions($methodResolver, [
                                        'enable'   => true,
                                        'base_key' => sprintf(
                                            '%s%s.',
                                            self::BASE_CACHE_KEY,
                                            ApiReqType\GetOnline::API_METHOD
                                        ),
                                        'ttl'      => 5
                                    ]);
                                },
                            ApiReqType\GetUserDetails::API_METHOD =>
                                function (OptionsResolver $methodResolver) use ($methodOptions) {
                                    $methodOptions($methodResolver, [
                                        'enable'   => true,
                                        'base_key' => sprintf(
                                            '%s%s.',
                                            self::BASE_CACHE_KEY,
                                            ApiReqType\GetUserDetails::API_METHOD
                                        ),
                                        'ttl'      => 60 * 60 * 6
                                    ]);
                                }
                        ]);
                        $methodsResolver->setAllowedTypes(ApiReqType\GetAccountInfo::API_METHOD, 'array');
                        $methodsResolver->setAllowedTypes(ApiReqType\GetOnline::API_METHOD, 'array');
                        $methodsResolver->setAllowedTypes(ApiReqType\GetUserDetails::API_METHOD, 'array');
                    }
                ]);
                $cacheResolver->setAllowedTypes('pool', ['null', CacheItemPoolInterface::class]);
                $cacheResolver->setAllowedTypes('methods', 'array');
            }
        ]);
        $resolver->setAllowedTypes('validate_request', 'bool');
        $resolver->setAllowedTypes('cache', 'array');
    }

    /**
     * @param ApiRequestInterface $apiRequest
     * @return ResponseInterface
     * @throws InvalidApiRequestException
     */
    private function getResponse(ApiRequestInterface $apiRequest): ResponseInterface
    {
        $apiMethod = $apiRequest->getApiMethod();
        $baseKey = $this->options['cache']['methods'][$apiMethod]['base_key'] ?? null;
        $key =  $baseKey ? $baseKey . $apiRequest->getHash() : null;
        try {
            $item = $this->getCacheItem($apiMethod, $key);
            if ($item && $item->isHit()) {
                return HttpResponseSerializer::fromString(
                    (string) $item->get(),
                    $this->psr17->getResponseFactory(),
                    $this->psr17->getStreamFactory()
                );
            }

            $response = $this->httpClient->sendRequest($this->httpRequestBuilder->build($apiRequest));
            $pool = $this->options['cache']['pool'];
            if ($pool instanceof CacheItemPoolInterface && $item) {
                $item
                    ->set(HttpResponseSerializer::toString($response))
                    ->expiresAfter($this->options['cache']['methods'][$apiMethod]['ttl']);
                $pool->save($item);
            }

            return $response;
        } catch (InvalidApiRequestException $ex) {
            throw $ex;
        } catch (\Exception | \Psr\Cache\InvalidArgumentException | ClientExceptionInterface $ex) {
            throw new InvalidApiRequestException($ex->getMessage(), $ex->getCode(), $ex);
        }
    }

    /**
     * @param string $apiMethod
     * @param string|null $key
     * @return CacheItemInterface|null
     * @throws \Psr\Cache\InvalidArgumentException
     */
    private function getCacheItem(string $apiMethod, string $key = null): ?CacheItemInterface
    {
        $pool = $this->options['cache']['pool'];
        $enabled = $this->options['cache']['methods'][$apiMethod]['enable'] ?? false;

        return ($key && $enabled && $pool instanceof CacheItemPoolInterface) ? $pool->getItem($key) : null;
    }

    /**
     * @param Webhook $webhook
     * @return ApiRespType\SetWebhookResponse
     * @throws InvalidApiRequestException|InvalidApiResponseException
     */
    public function setWebhook(Webhook $webhook): ApiRespType\SetWebhookResponse
    {
        $response = $this->getResponse(new ApiReqType\SetWebhook($this->token, $webhook));

        return new ApiRespType\SetWebhookResponse($response);
    }

    /**
     * @return ApiRespType\SetWebhookResponse
     * @throws InvalidApiRequestException|InvalidApiResponseException
     */
    public function removeWebhook(): ApiRespType\SetWebhookResponse
    {
        $response = $this->getResponse(new ApiReqType\RemoveWebhook($this->token));

        return new ApiRespType\SetWebhookResponse($response);
    }

    /**
     * @param Message $message
     * @return ApiRespType\SendMessageResponse
     */
    public function sendMessage(Message $message): ApiRespType\SendMessageResponse
    {
        $to = $message->getTo() !== null ? $message->getTo()->toArray()[0] : new User();

        $response = $this->getResponse(
            new ApiReqType\SendMessage(
                $this->token,
                $to,
                $message->getEntity(),
                $message->getSender(),
                $message->getMinApiVersion()
            )
        );

        return new ApiRespType\SendMessageResponse($response);
    }

    /**
     * @param Message $message
     * @return ApiRespType\BroadcastMessageResponse
     */
    public function broadcastMessage(Message $message): ApiRespType\BroadcastMessageResponse
    {
        $response = $this->getResponse(
            new ApiReqType\BroadcastMessage(
                $this->token,
                $message->getTo() ?: new UserCollection(new User()),
                $message->getEntity(),
                $message->getSender(),
                $message->getMinApiVersion()
            )
        );

        return new ApiRespType\BroadcastMessageResponse($response);
    }

    /**
     * @return ApiRespType\GetAccountInfoResponse
     * @throws InvalidApiRequestException|InvalidApiResponseException
     */
    public function getAccountInfo(): ApiRespType\GetAccountInfoResponse
    {
        $response = $this->getResponse(new ApiReqType\GetAccountInfo($this->token));

        return new ApiRespType\GetAccountInfoResponse($response);
    }

    /**
     * @param User $user
     * @return ApiRespType\GetUserDetailsResponse
     * @throws InvalidApiRequestException|InvalidApiResponseException
     */
    public function getUserDetails(User $user): ApiRespType\GetUserDetailsResponse
    {
        $response = $this->getResponse(new ApiReqType\GetUserDetails($this->token, $user));

        return new ApiRespType\GetUserDetailsResponse($response);
    }

    /**
     * @param UserCollection $users
     * @return ApiRespType\GetOnlineResponse
     * @throws InvalidApiRequestException|InvalidApiResponseException
     */
    public function getOnline(UserCollection $users): ApiRespType\GetOnlineResponse
    {
        $response = $this->getResponse(new ApiReqType\GetOnline($this->token, $users));

        return new ApiRespType\GetOnlineResponse($response);
    }

    /**
     * @param User $user
     * @return ApiRespType\GetUserOnlineResponse
     * @throws InvalidApiRequestException|InvalidApiResponseException
     */
    public function getUserOnline(User $user): ApiRespType\GetUserOnlineResponse
    {
        $users = new UserCollection($user);
        $response = $this->getResponse(new ApiReqType\GetOnline($this->token, $users));

        return new ApiRespType\GetUserOnlineResponse($response);
    }

    /**
     * @param Message $message
     * @return ApiRespType\PostToPublicChatResponse
     */
    public function postToPublicChat(Message $message): ApiRespType\PostToPublicChatResponse
    {
        $from = $message->getFrom() ?: $this->getAnyAdminUser();

        $response = $this->getResponse(
            new ApiReqType\PostToPublicChat(
                $this->token,
                $from,
                $message->getEntity(),
                $message->getSender(),
                $message->getMinApiVersion()
            )
        );

        return new ApiRespType\PostToPublicChatResponse($response);
    }

    /**
     * @return UserCollection|null
     * @throws InvalidApiRequestException|InvalidApiResponseException
     */
    public function getAdmins(): ?UserCollection
    {
        $members = $this->getAccountInfo()->getAccount()->getMembers();
        $admins = [];

        if ($members === null) {
            return null;
        }

        foreach ($members as $member) {
            if ($member->getRole() === 'admin') {
                $admins[] = $member;
            }
        }

        return $admins ? new UserCollection(...$admins) : null;
    }

    /**
     * @return User
     * @throws InvalidApiRequestException|InvalidApiResponseException
     */
    public function getAnyAdminUser(): User
    {
        $admins = $this->getAdmins();

        return $admins ? $admins->toArray()[0] : new User();
    }
}
