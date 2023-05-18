<?php

namespace Schemas;

class InvoiceDetail
{
    public Invoice $invoice;
    public ProductVariant $productVariant;
    public int $quantity;
    public int $price;
}