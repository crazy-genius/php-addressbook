<?php

declare(strict_types=1);


namespace AddressBook\Http\View\HTML;


abstract class AbstractTag
{
    public function __construct(
        protected readonly string $Id,
    )
    {
    }

    public function __toString(): string
    {
        return $this->toString();
    }

    abstract public function toString(): string;
}
