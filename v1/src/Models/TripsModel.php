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

    public function getAll($filters){
        $query_value = [];
        $sql = "SELECT * FROM $this->table_name WHERE 1";
        if (isset($filters["name"])) {
            $sql .= " AND name LIKE CONCAT('%', :name,'%')";
            $query_value[":name"] = $filters["name"];
        }
        if (isset($filters["type"])) {
            $sql .= " AND type LIKE CONCAT('%', :type,'%')";
            $query_value[":type"] = $filters["type"];
        }
        return $this->paginate($sql, $filters);
    }

    public function createTrip(array $trip_data){
        return $this->insert($this->table_name, $trip_data);
    } 

    public function updateTrip(array $trip_data, array $trip_id){
        return $this->update($this->table_name, $trip_data, $trip_id);
    }
    
    public function deleteTrip($trip_id){
        $this->delete($this->table_name, ["trip_id" =>$trip_id]);
    }
}