<?php

declare(strict_types=1);


namespace AddressBook\Http\View\HTML;


class Br extends AbstractTag
{
    public function __construct()
    {
        parent::__construct(uniqid('br_', true));
    }

    public function toString(): string
    {
        return '<br>';
    }
}
