<?php

namespace App\Domain\Dtos;


final readonly class VenueDto
{
    public function __construct(
        public int $id,
        public string $name,
        public string $address,
        public string $city,
        public int $capacity,
        public string $surface,
        public string $image,
    ) {}
}