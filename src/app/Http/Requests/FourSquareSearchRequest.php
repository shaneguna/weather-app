<?php

namespace App\Http\Requests;

final class FourSquareSearchRequest
{
    protected string $city;

    protected int $limit = 5;

    public function getCity(): string
    {
        return $this->city;
    }

    public function getLimit(): int
    {
        return $this->limit;
    }

    public function setCity(string $city): self
    {
        $this->city = $city;
        return $this;
    }

    public function setLimit(string $location): self
    {
        $this->limit = $location;
        return $this;
    }
}
