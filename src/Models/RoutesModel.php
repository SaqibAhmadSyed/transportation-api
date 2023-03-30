<?php
namespace Vanier\Api\Models;

use Vanier\Api\Models\BaseModel;

class RoutesModel extends BaseModel{
    private $table_name = "route";
    public function __construct(){
        parent::__construct();
    }

    public function getRouteById(int $route_id){
        $sql = "SELECT * FROM $this->table_name WHERE route_id = :route_id";
        return $this->run($sql, [":route_id"=> $route_id])->fetchAll();
    }

    public function getAll($filters){
        $query_value = [];
        $sql = "SELECT * FROM $this->table_name";
        if (isset($filters["long_name"])) {
            $sql .= " AND long_name LIKE CONCAT('%', :long_name,'%')";
            $query_value[":long_name"] = $filters["long_name"];
        }
        return $this->paginate($sql, $query_value);
    }
}