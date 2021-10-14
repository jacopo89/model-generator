<?php


namespace ModelGenerator\Bundle\ModelGeneratorBundle\ModelGenerator;


class SubResource implements \JsonSerializable
{
    private Model $model;
    private string $title;
    private string $resourceName;

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
    public function getTitle(): string
    {
        return $this->title;
    }

    /**
     * @param string $title
     */
    public function setTitle(string $title): void
    {
        $this->title = $title;
    }

    /**
     * @return string
     */
    public function getResourceName(): string
    {
        return $this->resourceName;
    }

    /**
     * @param string $resourceName
     */
    public function setResourceName(string $resourceName): void
    {
        $this->resourceName = $resourceName;
    }


    public function jsonSerialize()
    {
        return [
            "title"=>$this->title,
            "model"=>$this->model,
            "resourceName"=> $this->resourceName
        ];
    }
}
