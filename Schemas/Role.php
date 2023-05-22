<?php
namespace Schemas;

class Role
{
    public int $id_role;
    public string $name_role;

    public function __construct(int $id_role, string $name_role){
        $this->id_role = $id_role;
        $this->name_role = $name_role; 
    }

}


    
?>