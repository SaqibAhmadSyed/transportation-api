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

    public function getAll(){
        $sql = "SELECT * FROM $this->table_name";
        return $this->run($sql)->fetchAll();
    }
}