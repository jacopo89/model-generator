<?php


namespace ModelGenerator\Bundle\ModelGeneratorBundle\ModelGenerator;


class ItemOperation extends Operation
{
    const OPERATION_TYPE = "item";

    public function __construct($name, $method, $model, $path, $responseType)
    {
        parent::__construct($name, $method, $model, $path, $responseType);
        $this->operationType= self::OPERATION_TYPE;
        $this->responseType = self::OPERATION_TYPE;
    }

    /**
     * @return string
     */
    public function getOperationType(): string
    {
        return $this->operationType;
    }
}
