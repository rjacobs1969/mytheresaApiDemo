<?php

declare(strict_types=1);

namespace App\Domain\Product;

final class ProductFilter
{
    private ProductFilterType $type;
    private string $value;

    public function __construct(
        ProductFilterType $type,
        string $value
    ) {
        $this->type = $type;
        $this->value = $value;
    }

    public function type(): ProductFilterType
    {
        return $this->type;
    }

    public function value(): string
    {
        return $this->value;
    }
}
