<?php

declare(strict_types=1);

namespace App\Domain\Product;

class ProductCategory
{
    private string $category;

    public function __construct(string $category)
    {
        $this->validate($category);
        $this->category = $category;
    }

    public function category(): string
    {
        return $this->category;
    }

    private function validate(string $category): void
    {
        if (empty($category)) {
            throw new \InvalidArgumentException('Category cannot be empty');
        }
    }
}
