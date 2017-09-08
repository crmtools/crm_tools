<?php
/**
 * Created by PhpStorm.
 * User: zkissarli
 * Date: 06/09/2017
 * Time: 10:33
 */

namespace CRM\ToolsBundle\Service;


class refreshAnalysis
{
    private $connDefault;
    private $connOracleQ5;
    private $connOracleP1;

    function __construct($doctrine)
    {
        $this->connDefault  = $doctrine->getManager('default')->getConnection();
        $this->connOracleQ5 = $doctrine->getManager('oracle_Q5')->getConnection();
        $this->connOracleP1 = $doctrine->getManager('oracle_P1')->getConnection();
    }

    function refreshButtonWithId($query_id, $current_date)
    {

        $this->connDefault->beginTransaction();
        $currentQuery = $this->getOneQueryWithId($query_id);
        $resultQuery  = $this->executeQueryWithId($currentQuery);
        $idDelete     = $this->deleteInResultWithQueryId($query_id, $current_date);
//        $this->connDefault->commit();
        if($idDelete){
            $this->insertResultQuery($currentQuery, $resultQuery, $current_date);
        }
    }

    public function getOneQueryWithId($query_id){
        $sql = "SELECT * FROM crm_queries WHERE id = '" . $query_id . "'";
        echo $sql;
        $query = $this->connDefault->prepare($sql);
        $query->execute();
        $currentQuery = $query->fetchAll();

        return $currentQuery;
    }

    public function executeQueryWithId($currentQuery){

        $sql= $currentQuery[0]['queryText'];
        echo $sql;
        $query = $this->connOracleQ5->prepare($sql);
        $query->execute();
        $result = $query->fetchAll();
        foreach($result as $row){
            foreach($row as $value){
                $countResult= $value;
            }
        }

        return $countResult;
    }

    public function deleteInResultWithQueryId($query_id, $current_date){

        $sql = "DELETE FROM crm_queries_result WHERE queryDate = '" . $current_date . "' AND query_id = " . $query_id ;
        echo $sql;
        $query = $this->connDefault->prepare($sql);
        $query->execute();

        return true;
    }

    public function insertResultQuery($currentQuery, $result, $current_date){

        $currentQuery= $currentQuery[0];
        $sql = "INSERT INTO crm_queries_result (queryName, QueryResult, queryDate, query_id) VALUES ('".$currentQuery['queryName']."', $result, '$current_date', ".$currentQuery['id'].")";
        echo $sql;
        $query = $this->connDefault->prepare($sql);
        $query->execute();
    }


}