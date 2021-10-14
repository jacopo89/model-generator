<?php


namespace ModelGenerator\Bundle\ModelGeneratorBundle\ModelGenerator;


class PropertyModel implements \JsonSerializable
{
    private string $id;
    private string $type;
    private string $label;
    private ?string $resourceName = null;
    private ?SubResource $resource = null;
    private ?string $optionText = null;

    /**
     * @var string[]
     */
    private $validators = [];

    /**
     * @var string[]
     */
    private $errorMessages = [];

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

    /**
     * @return string|null
     */
    public function getResourceName(): ?string
    {
        return $this->resourceName;
    }

    /**
     * @param string|null $resourceName
     */
    public function setResourceName(?string $resourceName): void
    {
        $this->resourceName = $resourceName;
    }

    /**
     * @return SubResource|null
     */
    public function getResource(): ?SubResource
    {
        return $this->resource;
    }

    /**
     * @param SubResource|null $resource
     */
    public function setResource(?SubResource $resource): void
    {
        $this->resource = $resource;
    }

    /**
     * @return string|null
     */
    public function getOptionText(): ?string
    {
        return $this->optionText;
    }

    /**
     * @param string|null $optionText
     */
    public function setOptionText(?string $optionText): void
    {
        $this->optionText = $optionText;
    }

    /**
     * @return string[]
     */
    public function getErrorMessages(): array
    {
        return $this->errorMessages;
    }

    /**
     * @param string[] $errorMessages
     */
    public function setErrorMessages(array $errorMessages): void
    {
        $this->errorMessages = $errorMessages;
    }

    /**
     * @return string[]
     */
    public function getValidators(): array
    {
        return $this->validators;
    }

    /**
     * @param string[] $validators
     */
    public function setValidators(array $validators): void
    {
        $this->validators = $validators;
    }


    public function jsonSerialize()
    {
        return [
            "id" => $this->id,
            "type" => $this->type,
            "label" => $this->label,
            "resourceName" => $this->resourceName,
            "resource"=> $this->resource,
            "validators" => $this->validators,
            "errorMessages"=> $this->errorMessages
        ];
    }
}
