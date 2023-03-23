<?php
namespace Vanier\Api\Models;

use Vanier\Api\Models\BaseModel;

class TripsModel extends BaseModel{
    private $table_name = "trip";
    public function __construct(){
        parent::__construct();
    }

    public function getTripById(int $trip_id){
        $sql = "SELECT * FROM $this->table_name WHERE trip_id = :trip_id";
        return $this->run($sql, [":trip_id"=> $trip_id])->fetchAll();
    }

    public function getAll(){
        $sql = "SELECT * FROM $this->table_name";
        return $this->run($sql)->fetchAll();
    }
}