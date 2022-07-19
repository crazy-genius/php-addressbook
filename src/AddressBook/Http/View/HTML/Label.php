<?php

declare(strict_types=1);

namespace AddressBook\Http\View\HTML;

class Label extends AbstractTag
{
    public function __construct(private readonly string $value)
    {
        parent::__construct(uniqid('label_', true));
    }

    public function toString(): string
    {
        return sprintf('<label>%s</label>', $this->value);
    }
}
