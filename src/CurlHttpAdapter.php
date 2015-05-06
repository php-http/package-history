<?php

/*
 * This file is part of the Http Adapter package.
 *
 * (c) Eric GELOEN <geloen.eric@gmail.com>
 *
 * For the full copyright and license information, please read the LICENSE
 * file that was distributed with this source code.
 */

namespace Http\Adapter;

use Http\Adapter\Message\InternalRequestInterface;

/**
 * @author GeLo <geloen.eric@gmail.com>
 */
abstract class CurlHttpAdapter extends CoreHttpAdapter
{
    /**
     * Prepares the protocol version
     *
     * @param InternalRequestInterface $internalRequest
     *
     * @return integer
     */
    protected function prepareProtocolVersion(InternalRequestInterface $internalRequest)
    {
        return $internalRequest->getProtocolVersion() === InternalRequestInterface::PROTOCOL_VERSION_1_0
            ? CURL_HTTP_VERSION_1_0
            : CURL_HTTP_VERSION_1_1;
    }

    /**
     * Prepares the content
     *
     * @param InternalRequestInterface $internalRequest
     *
     * @return array|string
     */
    protected function prepareContent(InternalRequestInterface $internalRequest)
    {
        if (!$internalRequest->hasFiles()) {
            return $this->prepareBody($internalRequest);
        }

        $content = [];

        foreach ($internalRequest->getAllData() as $name => $data) {
            $content = array_merge($content, $this->prepareRawContent($name, $data));
        }

        foreach ($internalRequest->getFiles() as $name => $file) {
            $content = array_merge($content, $this->prepareRawContent($name, $file, true));
        }

        return $content;
    }

    /**
     * Creates a file
     *
     * @param string $file
     *
     * @return mixed
     */
    protected function createFile($file)
    {
        return $this->isSafeUpload() ? new \CurlFile($file) : '@'.$file;
    }

    /**
     * Checks if it is safe upload
     *
     * @return boolean
     */
    protected function isSafeUpload()
    {
        return defined('CURLOPT_SAFE_UPLOAD');
    }

    /**
     * Prepares the raw content
     *
     * @param string       $name
     * @param array|string $data
     * @param boolean      $isFile
     *
     * @return array
     */
    private function prepareRawContent($name, $data, $isFile = false)
    {
        if (!is_array($data)) {
            return [$name => $isFile ? $this->createFile($data) : $data];
        }

        $preparedData = [];

        foreach ($data as $subName => $subData) {
            $preparedData = array_merge(
                $preparedData,
                $this->prepareRawContent($this->prepareName($name, $subName), $subData, $isFile)
            );
        }

        return $preparedData;
    }
}
