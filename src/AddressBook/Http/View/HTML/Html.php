<?php

declare(strict_types=1);


namespace AddressBook\Http\View\HTML;


class Html extends AbstractTag
{
    public function __construct(private readonly string $html)
    {
        parent::__construct('');
    }

    public function toString(): string
    {
        return $this->html;
    }
}
