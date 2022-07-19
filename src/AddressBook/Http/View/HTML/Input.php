<?php

declare(strict_types=1);

namespace AddressBook\Http\View\HTML;

class Input extends AbstractTag
{
    public function __construct(
        string                  $Id,
        private readonly string $type,
        private readonly string $name,
        private readonly string $value,
        private readonly int    $size = 0,
    )
    {
        parent::__construct($Id);
    }

    public function toString(): string
    {
        $extra = $this->size > 0 ? sprintf('size="%d"', $this->size) : '';

        return sprintf(
            '<input id="%s" type="%s" name="%s" value="%s" %s />',
            $this->Id,
            $this->type,
            $this->name,
            $this->value,
            $extra,
        );
    }
}
