<?php
require_once ROOT_PATH . 'app/models/BaseModel.php';

class RolModel extends BaseModel {
    
    protected $table = 'roles';
    
    public function getAllActive() {
        return $this->getAll('nombre', 'ASC');
    }
}
