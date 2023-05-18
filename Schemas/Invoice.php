<?php

namespace Schemas;

use enums\InvoiceStatus;

class Invoice
{
    public int $id;
    public \DateTime $createDate;
    public InvoiceStatus $status;
    public int $sumPrice;
    public array $invoiceDetails;
}