<?php

declare(strict_types=1);

namespace ModelGenerator\Bundle\ModelGeneratorBundle\Resources\Listing\Model;

class ResourceListing
{
    /**
     * @var string
     */
    private string $id;

    /**
     * @var string
     */
    private string $label;

    /**
     * @param string $id
     * @param string $label
     */
    public function __construct(string $id, string $label)
    {
        $this->id = $id;
        $this->label = $label;
    }



}
