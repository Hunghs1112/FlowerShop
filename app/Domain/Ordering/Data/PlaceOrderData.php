<?php

namespace App\Domain\Ordering\Data;

final readonly class PlaceOrderData
{
    public function __construct(
        public string $name,
        public string $phone,
        public ?string $email = null,
        public ?string $zaloId = null,
        public ?string $note = null,
        public ?string $idempotencyKey = null,
        public ?array $items = null,
        public ?string $deliveryAddress = null,
        public ?string $deliveryDate = null,
        public ?string $deliveryTime = null,
    ) {}
}
