<?php

declare(strict_types=1);
namespace App\Models;

use Carbon\Carbon;

class Task
{

    public function __construct(private string $name,
                                private string $description,
                                private ?Carbon $created_at = null,
                                private ?int $id = null){}

    public function getName(): string
    {
        return $this->name;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function getCreatedAt(): ?Carbon
    {
        return $this->created_at;
    }

    public function getId(): ?int
    {
        return $this->id;
    }


}