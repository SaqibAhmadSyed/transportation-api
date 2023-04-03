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
        $sql = "SELECT * FROM $this->table_name WHERE 1";
        if (isset($filters["name"])) {
            $sql .= " AND name LIKE CONCAT('%', :name,'%')";
            $query_value[":name"] = $filters["name"];
        }
        if (isset($filters["type"])) {
            $sql .= " AND type LIKE CONCAT('%', :type,'%')";
            $query_value[":type"] = $filters["type"];
        }
        return $this->paginate($sql, $query_value);
    }
}