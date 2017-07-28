<?php

namespace CRM\ToolsBundle\Repository;

use Doctrine\ORM\EntityRepository;

/**
 * CLI_DATA_IMPORTSRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class CLI_DATA_IMPORTSRepository extends EntityRepository
{
    public function getProcessedFilesData($date_array, $filter = null){

        $result_array = array();
        foreach($date_array as $current_date){

            $sql = "SELECT 
                        FILE_NAME,
                        GAME_NAME,
                        DATE_TRAITEMENT,
                        ERROR_LIST,
                        TOTAL,
                        \"INSERT\" || ' (' || trunc(100 * \"INSERT\" / TOTAL,2) || '%)' as \"INSERT\",
                        \"UPDATE\" || ' (' || trunc(100 * \"UPDATE\" / TOTAL,2) || '%)' as \"UPDATE\",
                        \"REJECT\" || ' (' || trunc(100 * \"REJECT\" / TOTAL,2) || '%)' as \"REJECT\"
                    FROM(
                        select
                            distinct  
                            imp.file_name, 
                            max(game_name) over (partition by imp.file_name) as game_name,
                            max(date_traitement) over (partition by imp.file_name) as date_traitement, 
                            decode(action,'REJET','REJECT', action) as action,
                            nbr_ligne,
                            error_list
                        from P1RCPV.CLI_DATA_IMPORTS imp
                        left join 
                        (
                            select
                                file_name,
                                listagg(error_code || '(' || nb_error || ')','\n</br>\n') within group (order by nb_error desc) as error_list
                            from
                            (
                                select 
                                    file_name,
                                    error_code,
                                    count(*) as nb_error
                                from
                                (
                                    select file_name, error_code from p1rcpv.ERR_UPDATE_SUBSCRIPTION 
                                    union all
                                    select FILE_NAME, code_rejet from p1rcpv.ERR_JEUX
                                    union all 
                                    select FILE_NAME, REJECT_CODE from p1rcpv.ERR_APPENDING
                                )
                                group by file_name, error_code
                            )
                            group by file_name	
                        ) errors on errors.file_name = imp.file_name
                    )
                        pivot
                    (
                        max(nbr_ligne) for action in ('TOTAL' as \"TOTAL\",'INSERT' as \"INSERT\",'UPDATE' as \"UPDATE\",'REJECT' as \"REJECT\")
                    )
                    where  trunc(date_traitement) = TO_DATE('$current_date', 'YYYY-MM-DD') and file_name not like '%NEO_RC_REF_CONTACT_B2B%' $filter order by FILE_NAME";

            $em = $this->getEntityManager();
            $query = $em->getConnection()->prepare($sql);
            $query->execute();
            $result = $query->fetchAll();
            $result_array[$current_date] = $result;
        }
//        var_dump($result_array);die;
        return $result_array;

    }
}
