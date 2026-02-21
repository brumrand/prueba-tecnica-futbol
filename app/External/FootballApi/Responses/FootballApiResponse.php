<?php

namespace App\External\FootballApi\Responses;

final readonly class FootballApiResponse
{
    public function __construct(
        public bool $success,
        public bool $hasData,
        public int $httpStatus,
        public array $data,
        public array $errors,
        public array $meta,
    ) {}

    public function isSuccess(): bool
    {
        return $this->success;
    }
}