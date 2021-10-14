<?php


namespace ModelGenerator\Bundle\ModelGeneratorBundle\ModelGenerator;


class EnumOption implements \JsonSerializable
{
    private string $id;
    private string $label;

    /**
     * @return string
     */
    public function getId(): string
    {
        return $this->id;
    }

    /**
     * @param string $id
     */
    public function setId(string $id): void
    {
        $this->id = $id;
    }

    /**
     * @return string
     */
    public function getLabel(): string
    {
        return $this->label;
    }

    /**
     * @param string $label
     */
    public function setLabel(string $label): void
    {
        $this->label = $label;
    }

    public function jsonSerialize()
    {
        return [
            "id" => $this->id,
            "label" => $this->label
        ];
    }
}
