<?php
/**
 * Created by PhpStorm.
 * User: zkissarli
 * Date: 12/10/2017
 * Time: 17:41
 */

namespace CRM\ToolsBundle\Service;

//use Thread;

//class checkQueryTime extends \Thread implements Countable , Traversable , ArrayAccess
class checkQueryTime extends \Thread
{
    protected $connOracleQ5;
    protected $connOracleP1;

    public function __construct($doctrine){
        $this->connOracleQ5 = $doctrine->getManager('oracle_Q5')->getConnection();
        $this->connOracleP1 = $doctrine->getManager('oracle_P1')->getConnection();
    }

    public function run($env, $queryText){

        if($env=='Q5'){
            $query = $this->connOracleQ5->prepare($queryText);
            $query->execute();
            $result = $query->fetchAll();

            return $result;
        }else{
            $query = $this->connOracleP1->prepare($queryText);
            $query->execute();
        }
    }


}

