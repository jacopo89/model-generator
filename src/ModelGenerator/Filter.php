<?php


namespace ModelGenerator\Bundle\ModelGeneratorBundle\ModelGenerator;


class Filter implements \JsonSerializable
{
    private string $type;
    private string $name;

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
     * @return string
     */
    public function getType(): string
    {
        return $this->type;
    }

    /**
     * @param string $type
     */
    public function setType(string $type): void
    {
        $this->type = $type;
    }

    public function jsonSerialize()
    {
        return [
            "type" => $this->type,
            "name"=> $this->name
        ];
    }
}
