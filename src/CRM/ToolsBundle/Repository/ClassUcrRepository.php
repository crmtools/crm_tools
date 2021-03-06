<?php

namespace CRM\ToolsBundle\Repository;

use Doctrine\ORM\EntityRepository;

/**
 * ClassUcrRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class ClassUcrRepository extends EntityRepository{

    public function getQueryResulTotalCompaigns($queryContent){
        $queryResult= array();
        $sql= $queryContent['queryText'];

        $em = $this->getEntityManager();
        $query = $em->getConnection()->prepare($sql);
        $query->execute();
        $results = $query->fetchAll();

        return $results;
    }

    public function getQueryResult($queryContent, $start_date_param = null , $end_date_param = null ){
        $queryResult= array();
        $sql= $queryContent['queryText'];

        if($start_date_param!=null && $end_date_param!=null){
            if (preg_match("/ > SYSDATE - 35/i", $sql)){
                $sql= str_replace("> SYSDATE - 35", "BETWEEN to_date('".$start_date_param."','DD-MM-YYYY') AND to_date('".$end_date_param."','DD-MM-YYYY')", $sql);
            }else{
                $sql = str_replace(" > SYSDATE - 15"," BETWEEN to_date('".$start_date_param."','DD-MM-YYYY') AND to_date('".$end_date_param."','DD-MM-YYYY')", $sql);
            }
        }

        $em = $this->getEntityManager();
        $query = $em->getConnection()->prepare($sql);
        $query->execute();
        $results = $query->fetchAll();

        $column_names=  array_keys($results[0]);
        $queryResult[]= $column_names;
        $queryResult[]= $results;

        return $queryResult;
    }

    public function getIdsContact($sql){
        $em = $this->getEntityManager();
        $query = $em->getConnection()->prepare($sql);
        $query->execute();
        $ressults_array = $query->fetchAll();

        $contact_ids= '';
        foreach ($ressults_array as $key => $result){
            foreach($result as $column => $row) {
                $contact_ids .= ',' . $ressults_array[$key][$column];
            }
        }
        $contact_ids= substr($contact_ids, 1);

        return $contact_ids;
    }


}
