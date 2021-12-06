<?php


namespace ModelGenerator\Bundle\ModelGeneratorBundle\ModelGenerator;


class SubResourceOperation extends Operation
{
    const OPERATION_TYPE = "item";

    public function __construct($name, $method, $model, $path, $responseType, $resource)
    {
        parent::__construct($name, $method, $model, $path, $responseType,$resource);
        $this->operationType = self::OPERATION_TYPE;
    }

    /**
     * @return string
     */
    public function getOperationType(): string
    {
        return $this->operationType;
    }

    /**
     * @param string $operationType
     */
    public function setOperationType(string $operationType): void
    {
        $this->operationType = $operationType;
    }
}
