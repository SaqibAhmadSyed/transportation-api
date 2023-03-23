<?php
namespace Vanier\Api\Models;

use Vanier\Api\Models\BaseModel;

class FeedInfosModel extends BaseModel{
    private $table_name = "feed_info";
    public function __construct(){
        parent::__construct();
    }

    public function getFeedInfoById(int $feed_info_id){
        $sql = "SELECT * FROM $this->table_name WHERE feed_info_id = :feed_info_id";
        return $this->run($sql, [":feed_info_id"=> $feed_info_id])->fetchAll();
    }

    public function getAll(){
        $sql = "SELECT * FROM $this->table_name";
        return $this->run($sql)->fetchAll();
    }
}