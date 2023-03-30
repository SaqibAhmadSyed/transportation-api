<?php
namespace Vanier\Api\Models;

use Vanier\Api\Models\BaseModel;

class SchedulesModel extends BaseModel{
    private $table_name = "schedule";
    public function __construct(){
        parent::__construct();
    }

    public function getScheduleById(int $schedule_id){
        $sql = "SELECT * FROM $this->table_name WHERE schedule_id = :schedule_id";
        return $this->run($sql, [":schedule_id"=> $schedule_id])->fetchAll();
    }

    public function getAll($filters){
        $query_value = [];
        $sql = "SELECT * FROM $this->table_name";
        if (isset($filters["description"])) {
            $sql .= " AND film.description LIKE CONCAT('%', :description,'%')";
            $query_value[":description"] = $filters["description"];
        }
        return $this->paginate($sql, $query_value);
    }
}