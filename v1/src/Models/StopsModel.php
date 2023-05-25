<?php
namespace Vanier\Api\Models;

use Vanier\Api\Models\BaseModel;

class StopsModel extends BaseModel{
    private $table_name = "stop";
    public function __construct(){
        parent::__construct();
    }

    public function updateStop(array $stop_data, array $stop_id){
        $this->update($this->table_name, $stop_data, $stop_id);
    }

    public function deleteStop($stop_id){
        $this->delete($this->table_name, ["stop_id" =>$stop_id]);
    }

    public function createStop(array $stop_data){
        return $this->insert($this->table_name, $stop_data);
    }

    public function getStopById(int $stop_id){
        $sql = "SELECT * FROM $this->table_name WHERE stop_id = :stop_id";
        return $this->run($sql, [":stop_id"=> $stop_id])->fetchAll();
    }

    public function getAll($filters){
        $query_value = [];
        $sql = "SELECT * FROM $this->table_name WHERE 1";
        if(isset($filters["name"])){
            $sql .= " AND name LIKE CONCAT('%', :name,'%')";
            $query_value[":name"] = $filters["name"];
        }
        if(isset($filters["type"])){
            $sql .= " AND type LIKE CONCAT('%', :type,'%')";
            $query_value[":type"] = $filters["type"];
        }
        return $this->paginate($sql, $query_value);
    }
}