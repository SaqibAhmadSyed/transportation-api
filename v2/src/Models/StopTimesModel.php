<?php
namespace Vanier\Api\Models;

use Vanier\Api\Models\BaseModel;

class StopTimesModel extends BaseModel{
    private $table_name = "stop_time";
    public function __construct(){
        parent::__construct();
    }

    public function getStopTimeById(int $stop_time_id){
        $sql = "SELECT * FROM $this->table_name WHERE stop_time_id = :stop_time_id";
        return $this->run($sql, [":stop_time_id"=> $stop_time_id])->fetchAll();
    }

    public function getAll(){
        $sql = "SELECT * FROM $this->table_name";
        return $this->run($sql)->fetchAll();
    }
}