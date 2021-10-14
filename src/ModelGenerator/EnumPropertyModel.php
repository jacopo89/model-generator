<?php


namespace ModelGenerator\Bundle\ModelGeneratorBundle\ModelGenerator;


class EnumPropertyModel extends PropertyModel
{
    /**
     * @var EnumOption[]
     */
    private $options = [];

    /**
     * @param EnumOption[] $options
     */
    public function setOptions(array $options): void
    {
        $this->options = $options;
    }

    /**
     * @return EnumOption[]
     */
    public function getOptions(): array
    {
        return $this->options;
    }

    public function addOption(EnumOption $option){
        $this->options[] = $option;
    }

    public function jsonSerialize()
    {
        $array = [
            "options" => $this->options
        ];
        return array_merge(parent::jsonSerialize(),$array);
    }
}
