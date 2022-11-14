<?php

namespace App\SearchModels;

trait BaseSearchTrait
{
    /**
     * ParseLogsSearch constructor.
     * @param $request
     */
    public function __construct($request = null)
    {
        $this->request = $request;
        $this->_meta = new \stdClass();
    }

    protected $query;
    protected $class_name;
    /**
     * @var \stdClass
     */
    protected $_meta;
    protected $_data;

    /**
     * @return mixed
     */
    public function getData()
    {
        return $this->_data;
    }

    /**
     * @return \stdClass
     */
    public function getMeta(): \stdClass
    {
        return $this->_meta;
    }
}
