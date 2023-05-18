<?php

namespace Models;

use Core\DB;
use enums\InvoiceStatus;
use Schemas\Invoice;
use Schemas\InvoiceDetail;
use Schemas\ProductVariant;

class InvoiceModel
{
    public function getNumberOfPage(int $resultsPerPage): int {
        $sqlCount = "SELECT count(1) FROM invoice";
        $resultCount = DB::getDB()->execute_query($sqlCount);
        DB::close();
        $row = $resultCount->fetch_array();
        $total = $row[0];
        return ceil($total/$resultsPerPage);
    }

    public function getInvoices(int $page, int $resultsPerPage): array {
        $pageFirstResult = ($page-1) * $resultsPerPage;
        $sqlGetProducts = "
            SELECT i.id_invoice, create_date, status, sum_price, id_product_variant, quantity, price 
            FROM invoice as i
            LEFT JOIN invoice_detail id on i.id_invoice = id.id_invoice
            LIMIT $pageFirstResult,$resultsPerPage";
        $result = DB::getDB()->execute_query($sqlGetProducts);
        DB::close();

        $invoices = [];
        while ($row = $result->fetch_assoc()) {
            $idInvoice = (int) $row['id_invoice'];

            // Create a Invoice object for this row if it doesn't already exist
            if (!isset($invoices[$idInvoice])) {
                $invoice = new Invoice();
                $invoice->id = $idInvoice;
                $invoice->createDate = \DateTime::createFromFormat('Y-m-d',$row['create_date']);
                $invoice->status = InvoiceStatus::tryFrom($row['status']);
                $invoice->sumPrice = (int) $row['sum_price'];
                $invoice->invoiceDetails = [];
                $invoices[$idInvoice] = $invoice;
            } else {
                $invoice = $invoices[$idInvoice];
            }

            if (isset($row['id_product_variant'])) {
                // Create a InvoiceDetail object for this category
                $invoiceDetail = new InvoiceDetail();
                $invoiceDetail->productVariant = new ProductVariant();
                $invoiceDetail->productVariant->id = (int) $row['id_product_variant'];
                $invoiceDetail->quantity = (int) $row['quantity'];
                $invoiceDetail->price = (int) $row['price'];
                $invoice->invoiceDetails[] = $invoiceDetail;
            }
        }

        return array_values($invoices);
    }

    public function addInvoice(Invoice $invoice): int|null {
        $sql = "Insert into invoice(create_date, status, sum_price)
                values (?, ?, ?)";
        $result = DB::getDB()->execute_query(
            $sql,
            [
                $invoice->createDate->format('Y-m-d'),
                $invoice->status->value,
                $invoice->sumPrice
            ]
        );
        if (!$result)
            return null;

        // If inserted successfully
        if (DB::getDB()->insert_id) {
            $insert_id = DB::getDB()->insert_id;
            DB::close();
            return $insert_id;
        }
        DB::close();
        return null;
    }
}