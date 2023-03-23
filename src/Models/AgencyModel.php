<?php
namespace Vanier\Api\Models;

use Vanier\Api\Models\BaseModel;

class AgencyModel extends BaseModel{
    private $table_name = "agency";
    public function __construct(){
        parent::__construct();
    }

    public function getAgencyById(int $agency_id){
        $sql = "SELECT * FROM $this->table_name WHERE agency_id = :agency_id";
        return $this->run($sql, [":agency_id"=> $agency_id])->fetchAll();
    }

    public function getAll(){
        $sql = "SELECT * FROM $this->table_name";
        return $this->run($sql)->fetchAll();
    }
}