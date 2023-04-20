<?php
namespace Schemas;

use Cassandra\Date;

class Customer{
    public int $id_customer;
    public int $id_account;

    public string $name;
    public string $gender;
    public \DateTime $birthday;
    public string $phone;
    public string $address;

    /**
     * @param int $id_customer
     * @param int $id_account
     * @param string $name
     * @param string $gender
     * @param Date $birthday
     * @param string $phone
     * @param string $address
     */
    public function __construct(int $id_customer, int $id_account, string $name, string $gender, \DateTime $birthday, string $phone, string $address)
    {
        $this->id_customer = $id_customer;
        $this->id_account = $id_account;
        $this->name = $name;
        $this->gender = $gender;
        $this->birthday = $birthday;
        $this->phone = $phone;
        $this->address = $address;
    }


}