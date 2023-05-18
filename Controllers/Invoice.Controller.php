<?php

namespace Controllers;

use Core\BaseController;
use Core\Response;
use Core\Validate;
use enums\InvoiceStatus;
use Models\InvoiceDetailModel;
use Models\InvoiceModel;
use Models\ProductVariantModel;
use Schemas\Invoice;
use Schemas\InvoiceDetail;
use Schemas\ProductVariant;

class InvoiceController extends BaseController
{
    private InvoiceModel $invoiceModel;
    private InvoiceDetailModel $invoiceDetailModel;
    private ProductVariantModel $productVariantModel;
    public function register(): void
    {
        $this->invoiceModel = new InvoiceModel();
        $this->invoiceDetailModel = new InvoiceDetailModel();
        $this->productVariantModel = new ProductVariantModel();
    }

    public function getInvoices(): void
    {
        $page = (int) $this->getQuery('page');
        $resultsPerPage = (int) $this->getQuery('resultsPerPage');

        // Default
        $page = $page == 0 ? 1 : $page;
        $resultsPerPage = $resultsPerPage == 0 ? 20 : $resultsPerPage;

        $numberOfPage = $this->invoiceModel->getNumberOfPage($resultsPerPage);
        $invoices = $this->invoiceModel->getInvoices($page, $resultsPerPage);

        Response::sendJson([
            'pagination' => [
                'resultPerPage' => $resultsPerPage,
                'currentPage' => $page,
                'numberOfPage' => $numberOfPage
            ],
            'invoices' => $invoices,
        ]);
    }

    public function addInvoice(): void {
        $body = Validate::getBodyData(['invoiceDetails']);
        $invoiceDetailsData = json_decode($body['invoiceDetails'], true) ;


        $invoice = new Invoice();
        $invoice->status = InvoiceStatus::PENDING;
        $invoice->createDate = new \DateTime();
        $invoice->sumPrice = 0;

        $invoiceDetails = [];
        Response::logger($invoiceDetailsData, "Invoice:59");
        if (is_array($invoiceDetailsData)) {
            foreach ($invoiceDetailsData as $data) {
                try {
                    $idProductVariant = (int) $data['idProductVariant'];
                    $quantity = (int) $data['quantity'];
                    $price = (int) $data['price'];

                    // Create object
                    $invoiceDetail = new InvoiceDetail();
                    $invoiceDetail->invoice = new Invoice();
                    $invoiceDetail->productVariant = new ProductVariant();
                    $invoiceDetail->productVariant->id = $idProductVariant;
                    $invoiceDetail->quantity = $quantity;
                    $invoiceDetail->price = $price;

                    // Add to list
                    $invoiceDetails[] = $invoiceDetail;
                    // Calc sum price
                    $invoice->sumPrice += $price * $quantity;
                } catch (\Exception) {
                    Response::sendJson("Invalid invoice details", 404);
                }
            }

        } else {
            Response::sendJson("Invalid invoice details", 404);
        }

        // Create a invoice
        $idInvoice = $this->invoiceModel->addInvoice($invoice);

        // If have error
        if ($idInvoice == null) {
            Response::sendJson("Error adding invoice", 404);
        }

        // Update id invoice in list invoice details
        foreach ($invoiceDetails as $invoiceDetail) {
            $invoiceDetail->invoice->id = $idInvoice;
        }

        // Update quantity in product variant
        foreach ($invoiceDetails as $invoiceDetail) {
            $idProductVariant = $invoiceDetail->productVariant->id;
            $productVariant = $this->productVariantModel->getById($idProductVariant);
            $newQuantity = $productVariant->quantity + $invoiceDetail->quantity;

            // Error when updated
            if (!$this->productVariantModel->updateQuantity($idProductVariant, $newQuantity)) {
                Response::sendJson("Error update product variant id = $idProductVariant", 404);
            }
        }

        // Error when inserted array of invoice details
        if (!$this->invoiceDetailModel->addInvoiceDetails($invoiceDetails)) {
            Response::sendJson("Error adding invoice detail", 404);
        }


        Response::sendJson("List invoice details added successfully");

    }
}