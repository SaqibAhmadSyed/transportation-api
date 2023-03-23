<?php
namespace Vanier\Api\Models;

use Vanier\Api\Models\BaseModel;

class FaresModel extends BaseModel{
    private $table_name = "fare";
    public function __construct(){
        parent::__construct();
    }

    public function getFareById(int $fare_id){
        $sql = "SELECT * FROM $this->table_name WHERE fare_id = :fare_id";
        return $this->run($sql, [":fare_id"=> $fare_id])->fetchAll();
    }

    public function getAll(){
        $sql = "SELECT * FROM $this->table_name";
        return $this->run($sql)->fetchAll();
    }
}