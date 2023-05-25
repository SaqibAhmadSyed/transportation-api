<?php
namespace Vanier\Api\Models;

use Vanier\Api\Models\BaseModel;

class IncidentsModel extends BaseModel{
    private $table_name = "incident";
    public function construct(){
        parent::__construct();
    }

    public function updateIncident(array $incident_data, array $incident_id)
    {
        $this->update($this->table_name, $incident_data, $incident_id);
    }

    public function deleteIncident($incident_id)
    {
        $this->delete($this->table_name, ["incident_id" =>$incident_id]);
    }

    public function createIncident(array $incident_data)
    {
        return $this->insert($this->table_name, $incident_data);
    }

    public function getIncidentById(int $incident_id){
        $sql = "SELECT * FROM $this->table_name WHERE incident_id = :incident_id";
        return $this->run($sql, [":incident_id"=> $incident_id])->fetchAll();
    }

    public function getAllIncidents($filters){
        $sql = "SELECT * FROM $this->table_name WHERE 1";
        $query_value = [];
        if (isset($filters["line_name"])) {
            $sql .= " AND line_name LIKE CONCAT('%', :line_name,'%')";
            $query_value[":line_name"] = $filters["line_name"];
        }
        return $this->paginate($sql, $query_value);
    }
}