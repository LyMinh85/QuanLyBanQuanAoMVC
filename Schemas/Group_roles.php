<?php

namespace Schemas;

class Group_roles
{
    public int $id_group_roles;
    public string $name_group_role;

    /**
     * @param int $id_group_roles
     * @param string $name_group_role
     */
    public function __construct(int $id_group_roles, string $name_group_role)
    {
        $this->id_group_roles = $id_group_roles;
        $this->name_group_role = $name_group_role;
    }


}