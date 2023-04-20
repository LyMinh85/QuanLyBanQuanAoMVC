<?php

namespace Schemas;

class Account {
    public int $id_account;
    public string $username;
    public string $password;
    public int $id_group_roles;

    /**
     * @param int $id_account
     * @param string $username
     * @param string $password
     * @param int $id_group_roles
     */
    public function __construct(int $id_account, string $username, string $password, int $id_group_roles)
    {
        $this->id_account = $id_account;
        $this->username = $username;
        $this->password = $password;
        $this->id_group_roles = $id_group_roles;
    }

    /**
     * @return int
     */
    public function getIdAccount(): int
    {
        return $this->id_account;
    }

    /**
     * @param int $id_account
     */
    public function setIdAccount(int $id_account): void
    {
        $this->id_account = $id_account;
    }

    /**
     * @return string
     */
    public function getUsername(): string
    {
        return $this->username;
    }

    /**
     * @param string $username
     */
    public function setUsername(string $username): void
    {
        $this->username = $username;
    }

    /**
     * @return string
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    /**
     * @param string $password
     */
    public function setPassword(string $password): void
    {
        $this->password = $password;
    }

    /**
     * @return int
     */
    public function getIdGroupRoles(): int
    {
        return $this->id_group_roles;
    }

    /**
     * @param int $id_group_roles
     */
    public function setIdGroupRoles(int $id_group_roles): void
    {
        $this->id_group_roles = $id_group_roles;
    }



}