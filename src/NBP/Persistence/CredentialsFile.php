<?php

namespace NBP\Persistence;


class CredentialsFile
{
    private string $host;
    private string $data;
    private string $user;
    private string $pass;

    public function __construct(string $filname)
    {
        $values = explode(";", file_get_contents($filname));
        [$this->host, $this->data, $this->user, $this->pass] = $values;
    }

    public function hostname(): string
    {
        return $this->host;
    }

    public function database(): string
    {
        return $this->data;
    }

    public function username(): string
    {
        return $this->user;
    }

    public function password(): string
    {
        return $this->pass;
    }

}