<?php


namespace ModelGenerator\Bundle\ModelGeneratorBundle\ModelGenerator;


class Operation implements \JsonSerializable
{

    protected string $name;
    protected string $method;
    protected ?string $path = null;
    protected Model $model;
    protected string $operationType;
    protected ?string $responseType;
    protected ?string $resource;

    public function __construct($name, $method, $model, $path, $responseType, $resource=null)
    {
        $this->name=$name;
        $this->method=$method;
        $this->model = $model;
        $this->responseType = $responseType;
        $this->path= self::manipulatePath($path);
        $this->resource = $resource;
    }

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

    /**
     * @return string|null
     */
    public function getPath(): ?string
    {
        return $this->path;
    }

    /**
     * @param string|null $path
     */
    public function setPath(?string $path): void
    {
        $this->path = $path;
    }

    public function jsonSerialize()
    {
        return [
            "name" => $this->name,
            "method" => $this->method,
            "model" => $this->model,
            "path" => $this->path,
            "operationType" => $this->operationType,
            "responseType" => $this->responseType,
            "resource"=>$this->resource
        ];
    }

    private static function manipulatePath(?string $path){
        if(is_null($path)) return null;

        return str_replace("{", "\${", $path);

    }
}
