<?php
//var_dump('pouette');die;
include_once 'C:\wamp64\www\crm_tools\utility.php';

$query_id = null;
//var_dump($query_id);die;
//$bdd = connexion_base_mysql_new();
////	var_dump($bdd);die;
//	$query_insert = "SELECT * FROM crm_queries_result WHERE queryDate = '2017-06-15' AND query_id = '177'";
////	echo $query_insert;die;
//	$select = $bdd->query($query_insert);
////	var_dump($select);die;
//	foreach($select as $row){
//		
//		var_dump($row);
//		
//	}
function load_value()
{
//	echo 'test';die;
//	$page = $_GET['page'];
	$page='brahim';
	$bdd_mysql = connexion_base_mysql();
	$date = date("Y-m-d");
	$date_before = date('Y-m-d',strtotime(date('Y-m-d'))-86400);
	if ($page == '')
	{
		$query_mysql = "SELECT * FROM query_qualite_donnee where enable_history = 1";
		
	}
	else 
	{
		$query_mysql = "SELECT * FROM query_qualite_donnee where enable_history = 1 and page = '$page'";
	}
	if ($page == NULL)
		{
			$bdd_mysql->exec("delete from result_quality where Query_Date = '$date'");
			echo "\n";
			echo 'delete';
			echo "\n";
		}
//	echo $query_mysql;
	$result_mysql = $bdd_mysql->query($query_mysql);
	foreach($result_mysql as $row_mysql)
	{
//		echo date('h:i:s') . '<br>';
		$string = $row_mysql['Query'];
		//$result_query = get_connexion($bdd_mysql, $row_mysql['connexion']);
		$bdd_oracle = connexion_base_oracle($row_mysql['connexion']);
		if ($row_mysql['Page'] == 'insert_value')
		{
			$string = str_replace("value_date", $date_before, $row_mysql['Query']);
			echo "\n";
			echo $date_before;
			echo "\n";
		}
		else
		{
			$string = str_replace("value_date", $date, $row_mysql['Query']);
		}
		$prepared_statement = oci_parse($bdd_oracle, $string);
		
		$result = oci_execute($prepared_statement);
		if(!result)
		{
			echo "Error running : " ;
			echo "\n" . $string. "\n<br>";
		}
				
		
		$i = 0;
		while (($row = oci_fetch_row($prepared_statement)) != false) 
		{
			foreach($row as $row_useless)
			{
				$query_string = "INSERT INTO result_quality(Query_Name,Query_result,Query_Date) VALUES('$row_mysql[Query_Name]', '$row[$i]', '$date')";
				echo $query_string . "\n<br>";
				$bdd_mysql->exec($query_string);
				$i++;
			}
			$i = 0;
		}
	}
	$bdd_mysql->commit();
}

load_value();

?>