<?php

namespace App\External\FootBallApi\Responses;

final readonly class FootballApiResponse
{
    public function __construct(
        public bool $success,
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