<?php

namespace CRM\ToolsBundle\Repository;

use Doctrine\ORM\EntityRepository;

/**
 * CrmQueriesUcrRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class CrmQueriesUcrRepository extends EntityRepository
{
    public function getUcrQueriesContact(){
        $sql = "SELECT queryName, queryText FROM crm_queries_ucr where pageName = 'contact' order by Displayorder asc";
        $em = $this->getEntityManager();
        $query = $em->getConnection()->prepare($sql);
        $query->execute();
        $queries_ucr_contact = $query->fetchAll();

        return $queries_ucr_contact;
    }

    public function getResultUcrQueries($queries_ucr_modify){
        $queries_ucr_result= null;
        foreach ($queries_ucr_modify as $row){
            $sql = $row['queryText'];
            $queryName = $row['queryName'];

            $em = $this->getEntityManager();
            $query = $em->getConnection()->prepare($sql);
            $query->execute();
            $queryResult = $query->fetchAll();

            if ($queryResult){
                $queries_ucr_result[$queryName] = $queryResult;
            }
        }

        return $queries_ucr_result;
    }

    public function getUcrQueriesBooking(){
        $sql = "SELECT queryName, queryText FROM crm_queries_ucr where pageName = 'booking' order by Displayorder asc";
        $em = $this->getEntityManager();
        $query = $em->getConnection()->prepare($sql);
        $query->execute();
        $queries_ucr_booking = $query->fetchAll();

        return $queries_ucr_booking;

    }
}

