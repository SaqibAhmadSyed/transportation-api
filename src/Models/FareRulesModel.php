<?php
namespace Vanier\Api\Models;

use Vanier\Api\Models\BaseModel;

class FareRulesModel extends BaseModel{
    private $table_name = "fare_rule";
    public function __construct(){
        parent::__construct();
    }

    public function getFareRuleById(int $fare_rule_id){
        $sql = "SELECT * FROM $this->table_name WHERE fare_rule_id = :fare_rule_id";
        return $this->run($sql, [":fare_rule_id"=> $fare_rule_id])->fetchAll();
    }

    public function getAll(){
        $sql = "SELECT * FROM $this->table_name";
        return $this->run($sql)->fetchAll();
    }
}