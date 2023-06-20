<?php

namespace NBP\View;

use InvalidArgumentException;

class View
{
    private string $sourceCodeFilename;
    private array $attributes;

    public function __construct(string $sourceCodeFilename, array $attributes)
    {
        $this->sourceCodeFilename = $sourceCodeFilename;
        $this->attributes = $attributes;
    }

    public function render(): void
    {
        if (file_exists($this->sourceCodeFilename)) {
            $this->tryRender();
        } else {
            throw new InvalidArgumentException("View missing $this->sourceCodeFilename");
        }
    }

    private function tryRender(): void
    {
        try {
            ob_start();
            require($this->sourceCodeFilename);
            ob_end_flush();
        } catch (ViewAttributeException $exception) {
            ob_end_clean();
            throw $exception;
        }
    }

    public function __get(string $name)
    {
        if ($name === '') {
            throw new ViewAttributeException("Improper usage of view attribute in $this->sourceCodeFilename");
        }
        if (\array_key_exists($name, $this->attributes)) {
            return $this->attributes[$name];
        }
        throw new ViewAttributeException("Attribute '$name' isn't defined in $this->sourceCodeFilename");
    }
}