<?php

namespace Dexi;

use Dexi\DTO\ExecutionDTO;
use Dexi\DTO\FileDTO;
use Dexi\DTO\ResultDTO;

class Executions {

    /**
     * @var Client
     */
    private $client;

    function __construct(Client $client) {
        $this->client = $client;
    }

    /**
     * Get execution
     * @param string $executionId
     * @return ExecutionDTO
     */
    public function get($executionId) {
        return $this->client->requestJson("executions/$executionId");
    }

    /**
     * Delete execution permanently
     * @param string $executionId
     * @return boolean
     */
    public function remove($executionId) {
        return $this->client->requestBoolean("executions/$executionId",'DELETE');
    }

    /**
     * Get the entire result of an execution.
     * @param string $executionId
     * @return ResultDTO
     */
    public function getResult($executionId) {
        return $this->client->requestJson("executions/$executionId/result");
    }

    /**
     * Get a file from a result set
     * @param string $executionId
     * @param string $fileId
     * @return FileDTO
     */
    public function getResultFile($executionId, $fileId) {
        $response = $this->client->request("executions/$executionId/file/$fileId");
        return new FileDTO($response->headers['content-type'], $response->content);
    }

    /**
     * Stop running execution
     * @param string $executionId
     * @return bool
     */
    public function stop($executionId) {
        return $this->client->requestBoolean("executions/$executionId/stop",'POST');
    }

    /**
     * Resume stopped execution
     * @param string $executionId
     * @return bool
     */
    public function resume($executionId) {
        return $this->client->requestBoolean("executions/$executionId/continue",'POST');
    }
}
