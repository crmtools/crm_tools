<?php
include_once 'C:\wamp64\www\crm_tools\utility.php';

function load_value()
{
    $query_id = null;

    $page = isset($_GET['page']) &&  trim($_GET['page']) != '' ? $_GET['page'] : 'allQueries' ;

	$bdd_mysql = connexion_base_mysql_new();
    
//    $bdd_mysql->beginTransaction();
	$date = date("Y-m-d");
	$date_before = date('Y-m-d',strtotime(date('Y-m-d'))-86400);
 
    
     if($query_id!=null){
//         echo 'j\'ai un ID';die;
        $query_mysql = "SELECT * FROM crm_queries WHERE enableHistory = 1 AND id=".$query_id.";"; 
//        $result_mysql = $bdd_mysql->query($query_mysql);
//         foreach($result_mysql as $row_mysql){
//             var_dump($row_mysql);die;
//         }     
         
        $bdd_mysql->exec("DELETE FROM crm_queries_result WHERE queryDate = '$date' AND query_id=".$query_id.";");   
         echo 'j\'ai supprimer la ligne avec ID';
         
//          $query_mysql = "SELECT * FROM crm_queries_result WHERE queryDate = '2017-07-05' AND query_id=493;"; 
//          $result_mysql = $bdd_mysql->query($query_mysql);
//         foreach($result_mysql as $row_mysql){
//             var_dump($row_mysql);die;
//         }        
     }else{
//          echo 'JE N\'AI PAS UN ID';die;
        $query_mysql = "SELECT * FROM crm_queries WHERE enableHistory = 1 and ('$page' = 'allQueries' or pageName = '$page')";
//        echo $query_mysql;
	    $bdd_mysql->exec("DELETE FROM crm_queries_result WHERE queryDate = '$date' ");       
     }
    
	echo $query_mysql;
	$result_mysql = $bdd_mysql->query($query_mysql);
	foreach($result_mysql as $row_mysql)
	{  
		echo date('h:i:s') . '<br>';
		$string = $row_mysql['queryText'];
//        var_dump($string);die;
		$bdd_oracle = connexion_base_oracle($row_mysql['connexion']);
        
		if ($row_mysql['pageName'] == 'insert_value'){
			$string = str_replace("value_date", $date_before, $row_mysql['queryText']);
			echo "\n";
			echo $date_before;
			echo "\n";
		}
		else
		{
			$string = str_replace("value_date", $date, $row_mysql['queryText']);
		}
        
		$prepared_statement = oci_parse($bdd_oracle, $string);
        if (oci_error($bdd_oracle) > 0 )
		{
			echo "Error parsing : $string";
		}
		else
		{
			$result = @oci_execute($prepared_statement);
			if (!$result)
			{
				$e = oci_error($bdd_oracle);
				//echo $e['message'];
				echo "Error executing : $string <br>";
			}
			else
			{
                $i = 0;
				while (($row = oci_fetch_row($prepared_statement)) != false) {
					foreach($row as $row_useless){
//                        var_dump($row_useless);die;
                        $query_string = "INSERT INTO crm_queries_result (queryName,QueryResult,queryDate, query_id) VALUES('$row_mysql[queryName]', '$row[$i]', '$date', '$row_mysql[id]')";
                        $bdd_mysql->exec($query_string);
						$i++;
					}
					$i = 0;
                }
            }
        }
    }
    $bdd_mysql->commit();
}
          
load_value();

?>