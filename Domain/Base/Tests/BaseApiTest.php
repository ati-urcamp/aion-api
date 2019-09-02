<?php

namespace Domain\Base\Tests;

use Illuminate\Foundation\Testing\TestCase;

trait BaseApiTest
{
    /**
     * @var string
     */
    protected $modelClass = null;

    /**
     * @var string
     */
    protected $endpoint = '';

    /**
     * @var array
     */
    protected $requiredFields = [];

    /**
     * @var array
     */
    protected $headers = [];

    /**
     * @var array
     */
    protected $storeCustomData = [];

    /**
     * @var array
     */
    protected $updateCustomData = [];

    /**
     * @var array
     */
    protected $searchCustomData = [];

    /**
     * @return string
     */
    public function getModelClass()
    {
        return $this->modelClass;
    }

    /**
     * @param string $modelClass
     */
    public function setModelClass($modelClass)
    {
        $this->modelClass = $modelClass;
    }

    /**
     * @return string
     */
    public function getEndpoint()
    {
        return $this->endpoint;
    }

    /**
     * @param string $endpoint
     */
    public function setEndpoint($endpoint)
    {
        $this->endpoint = $endpoint;
    }

    /**
     * @return array
     */
    public function getRequiredFields()
    {
        return $this->requiredFields;
    }

    /**
     * @param array $requiredFields
     */
    public function setRequiredFields(array $requiredFields)
    {
        $this->requiredFields = $requiredFields;
    }

    /**
     * Set a header
     * @param $header
     * @param $value
     * @return $this
     */
    public function setHeader($header, $value)
    {
        $this->headers[$header] = $value;
        return $this;
    }

    /**
     * Get headers
     * @return array
     */
    public function getHeaders()
    {
        return $this->headers;
    }

    /**
     * @return array
     */
    public function getStoreCustomData()
    {
        return $this->storeCustomData;
    }

    /**
     * @param array $storeCustomData
     */
    public function setStoreCustomData(array $storeCustomData)
    {
        $this->storeCustomData = $storeCustomData;
    }

    /**
     * @return array
     */
    public function getUpdateCustomData()
    {
        return $this->updateCustomData;
    }

    /**
     * @param array $updateCustomData
     */
    public function setUpdateCustomData(array $updateCustomData)
    {
        $this->updateCustomData = $updateCustomData;
    }

    /**
     * @return array
     */
    public function getSearchCustomData()
    {
        return $this->searchCustomData;
    }

    /**
     * @param array $searchCustomData
     */
    public function setSearchCustomData(array $searchCustomData)
    {
        $this->searchCustomData = $searchCustomData;
    }

    /**
     * Create records based on factory model
     * @param int $count
     * @param bool $generateRecord
     * @param array $customData
     * @return mixed
     */
    protected function createRecords($count = 1, $generateRecord = false, $customData = [])
    {
        $factory = factory($this->getModelClass(), $count);
        return !$generateRecord ? $factory->create($customData) : $factory->make($customData);
    }

    /**
     * Create and get one record
     * @param array $customData
     * @return mixed
     */
    protected function getRecord($customData = [])
    {
        return $this->createRecords(1, false, $customData)->first();
    }

    /**
     * Get one record data
     * @param array $customData
     * @return mixed
     */
    protected function getRecordData($customData = [])
    {
        return $this->createRecords(1, true, $customData)->first()->toArray();
    }

    /**
     * Get one record with missing data
     * @param array $customData
     * @return mixed
     */
    protected function getRecordWithMissingData($customData = [])
    {
        $data = $this->createRecords(1, true, $customData)->first()->toArray();
        if ($this->getRequiredFields() && count($this->getRequiredFields())) {
            $requiredFieldIndex = array_rand($this->getRequiredFields());
            unset($data[$this->getRequiredFields()[$requiredFieldIndex]]);
        } else {
            unset($data[array_rand($data)]);
        }
        return $data;
    }

    /**
     * Get record's data keys
     * @return array
     */
    protected function getRecordDataKeys()
    {
        return array_keys($this->createRecords(1, true)->first()->toArray());
    }

    /**
     * Merge custom data to request
     * @param array $originalData
     * @param array $customData
     * @return array
     */
    protected function mergeCustomData($originalData = [], $customData = [])
    {
        if (isset($customData) && count($customData)) {
            $originalData = array_merge($originalData, $customData);
        }
        return $originalData;
    }

    /**
     * Call json method from tests
     * @param $method
     * @param $uri
     * @param array $data
     * @return TestCase
     */
    protected function api($method, $uri, $data = [])
    {
        $api = $this;
        if (count($this->getHeaders()) > 0) {
            $api = $this->withHeaders($this->getHeaders());
        }
        return $api->json($method, $uri, $data);
    }
}
