<?php
namespace Vanier\Api\Models;

use Vanier\Api\Models\BaseModel;

class ServicesModel extends BaseModel{
    private $table_name = "service";
    public function __construct(){
        parent::__construct();
    }

    public function getServiceById(int $service_id){
        $sql = "SELECT * FROM $this->table_name WHERE service_id = :service_id";
        return $this->run($sql, [":service_id"=> $service_id])->fetchAll();
    }

    public function getAll($filters){
        $filters = [];
        $sql = "SELECT * FROM $this->table_name";
        return $this->paginate($sql, $filters);
    }
}