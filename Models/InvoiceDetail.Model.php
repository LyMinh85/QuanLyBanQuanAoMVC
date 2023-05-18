<?php

namespace Models;

use Core\DB;
use enums\ClothingSize;
use Schemas\Invoice;
use Schemas\InvoiceDetail;
use Schemas\Product;
use Schemas\ProductVariant;

class InvoiceDetailModel
{
    private function convertRowToInvoiceDetail($row): InvoiceDetail {
        $invoiceDetail = new InvoiceDetail();
        $invoiceDetail->invoice = new Invoice();
        $invoiceDetail->invoice->id = (int) $row['id'];
        $invoiceDetail->invoice->sumPrice = (int) $row['sum_price'];
        $invoiceDetail->quantity = (int) $row['quantity'];
        $invoiceDetail->price = (int) $row['price'];

        $productVariant = new ProductVariant();
        $productVariant->id = (int) $row['productVariantId'];
        $productVariant->product = new Product();
        $productVariant->product->name = $row['productName'];
        $productVariant->size = ClothingSize::tryFrom($row['size']);
        $productVariant->color = $row['color'];
        $productVariant->urlImage = $row['url_image'];

        $invoiceDetail->productVariant = $productVariant;
        return $invoiceDetail;
    }

    public function getInvoiceDetails(int $page, int $resultsPerPage, int $idInvoice): array {
        $sqlGetProducts = "
            SELECT id.id_invoice, id.id_product_variant, id.quantity, price,
                   create_date, status, sum_price, id_product,
                   color, size, url_image
            FROM invoice_detail as id
            INNER JOIN invoice i on id.id_invoice = i.id_invoice
            INNER JOIN product_variant pv on id.id_product_variant = pv.id_product_variant
            WHERE i.id_invoice = ?
            ";
        $result = DB::getDB()->execute_query($sqlGetProducts, [$idInvoice]);
        DB::close();

        $invoiceDetails = [];
        while ($row = $result->fetch_assoc()) {
            $invoiceDetail = $this->convertRowToInvoiceDetail($row);
            $invoiceDetails[] = $invoiceDetail;
        }

        return $invoiceDetails;
    }

    public function addInvoiceDetails(array $invoiceDetails): bool {
        $sql = "Insert into invoice_detail(id_invoice, id_product_variant, quantity, price)
                VALUES ";

        $list_value = [];
        foreach ($invoiceDetails as $invoiceDetail) {
            if (empty($list_value)) {
                $sql .= " (?, ?, ?, ?) ";
            } else {
                $sql .= ", (?, ?, ?, ?) ";

            }
            $list_value[] = $invoiceDetail->invoice->id;
            $list_value[] = $invoiceDetail->productVariant->id;
            $list_value[] = $invoiceDetail->quantity;
            $list_value[] = $invoiceDetail->price;
        }

        $result = DB::getDB()->execute_query($sql, $list_value);
        if (!$result)
            return false;
        DB::close();
        return true;
    }
}