<?php

/*
 * This file is part of the Http Adapter Common package.
 *
 * (c) Eric GELOEN <geloen.eric@gmail.com>
 *
 * For the full copyright and license information, please read the LICENSE
 * file that was distributed with this source code.
 */

namespace Http\Adapter\Common\Exception;

use Http\Adapter\Exception\MultiHttpAdapterException as MultiHttpAdapterExceptionInterface;
use Http\Adapter\Exception\HttpAdapterException as HttpAdapterExceptionInterface;
use Psr\Http\Message\ResponseInterface;

/**
 * @author GeLo <geloen.eric@gmail.com>
 */
class MultiHttpAdapterException extends \Exception implements MultiHttpAdapterExceptionInterface
{
    /**
     * @var HttpAdapterExceptionInterface[]
     */
    private $exceptions;

    /**
     * @var ResponseInterface[]
     */
    private $responses;

    /**
     * @param HttpAdapterExceptionInterface[] $exceptions
     * @param ResponseInterface[]             $responses
     */
    public function __construct(array $exceptions = [], array $responses = [])
    {
        parent::__construct('An error occurred when sending multiple requests.');

        $this->setExceptions($exceptions);
        $this->setResponses($responses);
    }

    /**
     * {@inheritdoc}
     */
    public function getExceptions()
    {
        return $this->exceptions;
    }

    /**
     * {@inheritdoc}
     */
    public function hasException(HttpAdapterExceptionInterface $exception)
    {
        return array_search($exception, $this->exceptions, true) !== false;
    }

    /**
     * {@inheritdoc}
     */
    public function hasExceptions()
    {
        return !empty($this->exceptions);
    }

    /**
     * {@inheritdoc}
     */
    public function setExceptions(array $exceptions)
    {
        $this->clearExceptions();
        $this->addExceptions($exceptions);
    }

    /**
     * {@inheritdoc}
     */
    public function addException(HttpAdapterExceptionInterface $exception)
    {
        $this->exceptions[] = $exception;
    }

    /**
     * {@inheritdoc}
     */
    public function addExceptions(array $exceptions)
    {
        foreach ($exceptions as $exception) {
            $this->addException($exception);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function removeException(HttpAdapterExceptionInterface $exception)
    {
        unset($this->exceptions[array_search($exception, $this->exceptions, true)]);
        $this->exceptions = array_values($this->exceptions);
    }

    /**
     * {@inheritdoc}
     */
    public function removeExceptions(array $exceptions)
    {
        foreach ($exceptions as $exception) {
            $this->removeException($exception);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function clearExceptions()
    {
        $this->exceptions = [];
    }

    /**
     * {@inheritdoc}
     */
    public function getResponses()
    {
        return $this->responses;
    }

    /**
     * {@inheritdoc}
     */
    public function hasResponse(ResponseInterface $response)
    {
        return array_search($response, $this->responses, true) !== false;
    }

    /**
     * {@inheritdoc}
     */
    public function hasResponses()
    {
        return !empty($this->responses);
    }

    /**
     * {@inheritdoc}
     */
    public function setResponses(array $responses)
    {
        $this->clearResponses();
        $this->addResponses($responses);
    }

    /**
     * {@inheritdoc}
     */
    public function addResponse(ResponseInterface $response)
    {
        $this->responses[] = $response;
    }

    /**
     * {@inheritdoc}
     */
    public function addResponses(array $responses)
    {
        foreach ($responses as $response) {
            $this->addResponse($response);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function removeResponse(ResponseInterface $response)
    {
        unset($this->responses[array_search($response, $this->responses, true)]);
        $this->responses = array_values($this->responses);
    }

    /**
     * {@inheritdoc}
     */
    public function removeResponses(array $responses)
    {
        foreach ($responses as $response) {
            $this->removeResponse($response);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function clearResponses()
    {
        $this->responses = [];
    }
}
