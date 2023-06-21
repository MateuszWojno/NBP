<?php

namespace NBP\View;

use Exception;

class Validation
{
    private function __construct(private array $fieldsAndMessages)
    {
    }

    public static function failure(string $fieldName, string $message): Validation
    {
        return new self([$fieldName => $message]);
    }

    public static function success(): Validation
    {
        return new self([]);
    }

    public static function failures(array $failures): Validation
    {
        return new self($failures);
    }

    public function failed(string $fieldName): bool
    {
        return \array_key_exists($fieldName, $this->fieldsAndMessages);
    }

    public function message(string $fieldName): string
    {
        if (\array_key_exists($fieldName, $this->fieldsAndMessages)) {
            return $this->fieldsAndMessages[$fieldName];
        }
        throw new Exception("Field validation wasn't failed ");
    }
}