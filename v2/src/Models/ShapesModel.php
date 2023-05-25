<?php
namespace Vanier\Api\Models;

use Vanier\Api\Models\BaseModel;

class ShapesModel extends BaseModel{
    private $table_name = "shape";
    public function __construct(){
        parent::__construct();
    }

    public function getShapesById(int $shape_id){
        $sql = "SELECT * FROM $this->table_name WHERE shape_id = :shape_id";
        return $this->run($sql, [":shape_id"=> $shape_id])->fetchAll();
    }

    public function getAll($filters){
        $filters = [];
        $sql = "SELECT * FROM $this->table_name";
        return $this->paginate($sql, $filters);
    }
}