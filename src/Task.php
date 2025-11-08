<?php

namespace TaskCli;

class Task
{
    public string $createdAt;
    public string $updatedAt;

    public function __construct(
        public ?int $ID,
        public string $description,
        public ?string $status,
        ?string $createdAt,
        ?string $updatedAt
    ) {
        date_default_timezone_set("America/Sao_Paulo");
        $this->createdAt = $createdAt ?? date("Y-m-d H-i-s");
        $this->updatedAt = $updatedAt ?? date("Y-m-d H-i-s");
    }
}
