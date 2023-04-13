<?php
namespace Vanier\Api\Models;

use Vanier\Api\Models\BaseModel;

class StopsModel extends BaseModel{
    private $table_name = "stop";
    public function __construct(){
        parent::__construct();
    }

    public function getStopById(int $stop_id){
        $sql = "SELECT * FROM $this->table_name WHERE stop_id = :stop_id";
        return $this->run($sql, [":stop_id"=> $stop_id])->fetchAll();
    }

    public function getAll($filters){
        $query_value = [];
        $sql = "SELECT * FROM $this->table_name";
        return $this->paginate($sql, $filters);
    }
}