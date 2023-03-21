<?php
namespace Vanier\Api\Models;

use Vanier\Api\Models\BaseModel;

class IncidentsModel extends BaseModel{
    private $table_name = "incident";
    public function __construct(){
        parent::__construct();
    }

    public function getIncidentById(int $incident_id){
        $sql = "SELECT * FROM $this->table_name WHERE incident_id = :incident_id";
        return $this->run($sql, [":incident_id"=> $incident_id])->fetchAll();
    }

    public function getAll(){
        $sql = "SELECT * FROM $this->table_name";
        return $this->run($sql)->fetchAll();
    }
}