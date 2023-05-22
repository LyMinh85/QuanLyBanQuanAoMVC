<?php

namespace Schemas;

use enums\InvoiceStatus;

class Invoice
{
    public int $id;
    public Account $account;
    public Product $product;
    public \DateTime $createDate;
    public int $quantity;
    public int $sumPrice;
}