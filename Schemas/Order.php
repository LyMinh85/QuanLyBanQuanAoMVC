<?php

namespace Schemas;

class Order{

    public int $id_order;
    public int $id_customer;
    public string $address;
    public \DateTime $create_date;
    public \DateTime $receive_date;
    public string $method_of_payment;
    public int $sum_price;
    public int $status;

    /**
     * @param int $id_order
     * @param int $id_customer
     * @param string $address
     * @param \DateTime $create_date
     * @param \DateTime $receive_date
     * @param string $method_of_payment
     * @param int $sum_price
     * @param int $status
     */
    public function __construct(int $id_order, int $id_customer, string $address, \DateTime $create_date, \DateTime $receive_date, string $method_of_payment, int $sum_price, int $status)
    {
        $this->id_order = $id_order;
        $this->id_customer = $id_customer;
        $this->address = $address;
        $this->create_date = $create_date;
        $this->receive_date = $receive_date;
        $this->method_of_payment = $method_of_payment;
        $this->sum_price = $sum_price;
        $this->status = $status;
    }


}