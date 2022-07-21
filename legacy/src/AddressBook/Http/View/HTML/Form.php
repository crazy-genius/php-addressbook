<?php

declare(strict_types=1);

namespace AddressBook\Http\View\HTML;

class Form extends AbstractTag
{
    public function __construct(
        string $Id,
        private readonly string $method,
        private readonly string $action,
        private array $children = [],
    )
    {
        parent::__construct($Id);
    }

    public function addChild(AbstractTag $child): void
    {
        $this->children[] = $child;
    }

    public function addHtml(Html $html): void
    {
        $this->children[] = $html;
    }

    public function toString(): string
    {
        $content = sprintf(
            '<form accept-charset="utf-8" enctype="multipart/form-data" id="%s" method="%s" action="%s" >',
            $this->Id,
            $this->method,
            $this->action,
        );

        foreach ($this->children as $child) {
            $content .= $child->toString();
        }

        $content .= '</form>';

        return $content;
    }
}
