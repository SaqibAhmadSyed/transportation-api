<?php
namespace Vanier\Api\Models;

use Vanier\Api\Models\BaseModel;

class SchedulesModel extends BaseModel{
    private $table_name = "schedule";
    
    public function __construct(){
        parent::__construct();
    }

    public function updateSchedule(array $schedule_data, array $schedule_id)
    {
        $this->update($this->table_name, $schedule_data, $schedule_id);
    }

    public function deleteSchedule($schedule_id)
    {
        $this->delete($this->table_name, ["schedule_id" =>$schedule_id]);
    }

    public function createSchedule(array $schedule_data)
    {
        return $this->insert($this->table_name, $schedule_data);
    }

    public function getScheduleById(int $schedule_id){
        $sql = "SELECT * FROM $this->table_name WHERE schedule_id = :schedule_id";
        return $this->run($sql, [":schedule_id"=> $schedule_id])->fetchAll();
    }

    public function getAll($filters){
        $query_value = [];
        $sql = "SELECT * FROM $this->table_name WHERE 1";
        if (isset($filters["arrival_time"])) {
            $sql .= " AND arrival_time LIKE CONCAT('%', :arrival_time,'%')";
            $query_value[":arrival_time"] = $filters["arrival_time"];
        }
        if (isset($filters["departure_time"])) {
            $sql .= " AND departure_time LIKE CONCAT('%', :departure_time,'%')";
            $query_value[":departure_time"] = $filters["departure_time"];
        }
        return $this->paginate($sql, $query_value);
    }
}