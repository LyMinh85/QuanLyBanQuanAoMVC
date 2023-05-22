<?php

namespace Models;

use Core\DB;
use enums\InvoiceStatus;
use Schemas\Account;
use Schemas\Invoice;
use Schemas\InvoiceDetail;
use Schemas\Product;
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

    public function getById($id): Invoice{
        $sql = "
            SELECT *
            FROM `invoice`
            WHERE `id_invoice`='$id'
        ";
        $result = DB::getDB()->query($sql);
        
        $invoice = new Invoice();
        while ($row = $result->fetch_assoc()) {
            $invoice->id = $row["id_invoice"];
            $invoice->createDate = \DateTime::createFromFormat('Y-m-d',$row['create_date']);
            $invoice->quantity = $row["quantity"];
            $invoice->sumPrice = (int) $row['sum_price'];
            $invoice->account = new Account();
            $invoice->account->id_account = $row["id_account"];
            $invoice->product = new Product();
            $invoice->product->id = $row["id_product"];
        }

        return $invoice;
    }

    public function getInvoices(int $page, int $resultsPerPage): array {
        $pageFirstResult = ($page-1) * $resultsPerPage;
        $sqlGetProducts = "
                SELECT * 
                FROM `invoice`,`product`,`account`
                WHERE `invoice`.`id_product` = `product`.`id_product` and `invoice`.`id_account` = `account`.`id_account`
                GROUP BY `invoice`.`id_invoice`";
        $result = DB::getDB()->execute_query($sqlGetProducts);
        DB::close();

        $invoices = [];
        while ($row = $result->fetch_assoc()) {
            $idInvoice = (int) $row['id_invoice'];

            // Create a Invoice object for this row if it doesn't already exist
            if (!isset($invoices[$idInvoice])) {
                $invoice = new Invoice();
                $invoice->id = $idInvoice;
                $invoice->account = new Account();
                $invoice->account->id_account = $row["id_account"];
                $invoice->product = new Product();
                $invoice->product->id = $row["id_product"];
                $invoice->createDate = \DateTime::createFromFormat('Y-m-d',$row['create_date']);
                $invoice->quantity = $row["quantity"];
                $invoice->sumPrice = (int) $row['sum_price'];
                $invoices[$idInvoice] = $invoice;
            } else {
                $invoice = $invoices[$idInvoice];
            }
        }

        return array_values($invoices);
    }

    public function addInvoice(Invoice $invoice): int|null {
        $date = $invoice->createDate->format("Y-m-d");
        $id_account = $invoice->account->id_account;
        $id_product = $invoice->product->id;
        $sql = "INSERT INTO `invoice`(`id_account`, `id_product`, `create_date`, `quantity`, `sum_price`) 
               VALUES ('$id_account-','$id_product','$date','$invoice->quantity','$invoice->sumPrice')";

        DB::getDB()->query($sql);
        return null;
    }
}