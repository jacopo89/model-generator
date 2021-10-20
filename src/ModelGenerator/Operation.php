<?php


namespace ModelGenerator\Bundle\ModelGeneratorBundle\ModelGenerator;


class Operation implements \JsonSerializable
{

    protected string $name;
    protected string $method;
    protected Model $model;

    /**
     * @return Model
     */
    public function getModel(): Model
    {
        return $this->model;
    }

    /**
     * @param Model $model
     */
    public function setModel(Model $model): void
    {
        $this->model = $model;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName(string $name): void
    {
        $this->name = $name;
    }

    /**
     * @param string $method
     */
    public function setMethod(string $method): void
    {
        $this->method = $method;
    }

    /**
     * @return string
     */
    public function getMethod(): string
    {
        return $this->method;
    }

    public function jsonSerialize()
    {
        return [
            "name" => $this->name,
            "method" => $this->method,
            "model" => $this->model,
        ];
    }
}
