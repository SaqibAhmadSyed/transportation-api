<?php
namespace Vanier\Api\Models;

use Vanier\Api\Models\BaseModel;

class IncidentsModel extends BaseModel{
    private $table_name = "incident";
    public function __construct(){
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

    public function getAllIncidents(){
        $sql = "SELECT * FROM $this->table_name";
        return $this->run($sql)->fetchAll();
    }
}