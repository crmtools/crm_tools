<?php

/**
 * Created by PhpStorm.
 * User: zkissarli
 * Date: 13/07/2017
 * Time: 16:04
 */
namespace CRM\ToolsBundle\Service;

class utility
{
    function isDate($date, $format)
    {
        $d = DateTime::createFromFormat($format, $date);
        return $d && $d->format($format) == $date;
    }

    function toDate($date, $format)
    {
        if(isDate($date, $format))
        {
            return DateTime::createFromFormat($format,$date);
        }
        else
        {
            echo "The string provided does not seem to be a date (format :'$format', string : '$date')";
            //throw new Exception("The string provided does not seem to be a date (format :'$format', string : '$date')");
        }
    }

    function toString($date, $format)
    {
        return $date->format($format);
    }


    function findDateString($string)
    {
        $matches; // [\.-_]
        if(preg_match ( "@[-_\.]([0-9]{4}-[0-9]{2}-[0-9]{2})($|[-_\.])@", $string, $matches) && isDate($matches[1],'Y-m-d'))
        {
            return $matches[1];
        }
        else if(preg_match ( "@[-_\.]([0-9]{2}-[0-9]{2}-[0-9]{4})($|[-_\.])@", $string, $matches) && isDate($matches[1],'d-m-Y'))
        {
            return $matches[1];
        }
        else if(preg_match ( "@[-_\.]([0-9]{8})($|[-_\.])@", $string, $matches) &&  isDate($matches[1],'dmY'))
        {
            return $matches[1];
        }
        else if(preg_match ( "@[-_\.]([0-9]{8})($|[-_\.])@", $string, $matches) &&  isDate($matches[1],'Ymd'))
        {
            return $matches[1];
        }
        else
        {
            echo "<br>No match in $string<br>";
        }
    }

    function findDate($string)
    {
        $matches; // [\.-_]
        if(preg_match ( "@[-_\.]([0-9]{4}-[0-9]{2}-[0-9]{2})($|[-_\.])@", $string, $matches) && isDate($matches[1],'Y-m-d'))
        {
            //print_r($matches);
            return toDate($matches[1],'Y-m-d');
        }
        else if(preg_match ( "@[-_\.]([0-9]{2}-[0-9]{2}-[0-9]{4})($|[-_\.])@", $string, $matches) && isDate($matches[1],'d-m-Y'))
        {
            //print_r($matches);
            return toDate($matches[1],'d-m-Y');
        }
        else if(preg_match ( "@[-_\.]([0-9]{8})($|[-_\.])@", $string, $matches) &&  isDate($matches[1],'dmY'))
        {
            return toDate($matches[1],'dmY');
        }
        else if(preg_match ( "@[-_\.]([0-9]{8})($|[-_\.])@", $string, $matches) &&  isDate($matches[1],'Ymd'))
        {
            return toDate($matches[1],'Ymd');
        }
    }

    function getPerson($bdd, $code_appli, $id_refext)
    {
        $query = "select id_contact from cli_refext where code_appli = '$code_appli' and id_refext = '$id_refext'";
        $prepared_statement = oci_parse($bdd,$query );
        oci_execute($prepared_statement);
        while (($row = oci_fetch_row($prepared_statement)) != false)
        {
            return $row[0] ;
        }
        return null;
    }

    function displayVariable($variable, $variableName = "Variable : ")
    {
        echo "<br>$variableName => '$variable'<br>";
    }

    function getUserHostname()
    {
        return strtoupper(str_replace('.pvcp.intra','',gethostbyaddr($_SERVER['REMOTE_ADDR'])));
    }

    function getUsername()
    {

    }

    function isAdmin($bdd,$hostname)
    {
        $result = $bdd->query("SELECT * FROM crm_users where hostname = '$hostname'");
        foreach($result as $row)
        {
            if($row['is_admin'])
            {
                return true;
            }
        }
        return false;
    }

    function isCurrentUserAdmin($bdd)
    {

        $hostname = getUserHostname();
        $result = $bdd->query("SELECT * FROM crm_users where hostname = '$hostname'");
        foreach($result as $row)
        {
            if($row['is_admin'])
            {
                return true;
            }
        }
        return false;
    }

    function getAge($date)
    {
        return $date->diff(new \DateTime("now"))->format('%y');
    }

    public function startsWith($haystack, $needle)
    {
        $length = strlen($needle);
        return (substr($haystack, 0, $length) === $needle);
    }

    function endsWith($haystack, $needle)
    {
        $length = strlen($needle);
        if ($length == 0) {
            return true;
        }

        return (substr($haystack, -$length) === $needle);
    }


    function connexion($table)
    {
        $bdd = connexion_base_mysql();

        $date = date('Y-m-d');
        $hostname = substr(gethostbyaddr($_SERVER['REMOTE_ADDR']),0,-11);

        /*  echo $date  . '<br>';
         echo $hostname; */
        $query_delete = "delete from connexion_of_people where id_connexion = '$hostname' and equipe = '$table' and date_connexion = str_to_date('$date','%Y-%m-%d')";
        $bdd->exec($query_delete);
        $query_insert = "insert into connexion_of_people(id_connexion,date_connexion,equipe) values('$hostname', str_to_date('$date','%Y-%m-%d'),'$table')";
        $bdd->exec($query_insert);
        $bdd->commit();
    }

    function isValiDate($date, $format)
    {
        $d = \DateTime::createFromFormat($format, $date);
        return $d && $d->format($format) == $date;
    }




    function generate_days($start_date,$end_date)
    {
        $date_array = array();
        $start_date = date("d-m-Y", strtotime($start_date));
        $end_date = date("d-m-Y", strtotime($end_date));
        /* if(!isValiDate($start_date) || !isValiDate($end_date) || $end_date < $start_date) {
            die('One of the dates is not in the valid format(DD-MM-YYYY) Or last date is before first date');
        } */
        $start_date = DateTime::createFromFormat('!d-m-Y', $start_date);
        $start_date_tmp = $start_date;
        $end_date = DateTime::createFromFormat('!d-m-Y', $end_date);
        while ($start_date<$end_date)
        {
            array_push($date_array,$start_date->format('Y-m-d'));
            $start_date->modify('+1 day');
        }
        array_push($date_array,$start_date->format('Y-m-d'));
        return ($date_array);
    }

    function connexion_base_mysql()
    {
        global $config;
        $bdd = new PDO($config['database_string_mysql'],$config['database_user_mysql'],$config['database_password_mysql']);
        $bdd->exec('SET NAMES utf8');
        $bdd->beginTransaction();
        return($bdd);
    }

    function connexion_base_mysql_new()
    {
        global $config;
        $bdd = new PDO($config['database_string_mysql'],$config['database_user_mysql'],$config['database_password_mysql']);
        $bdd->exec('SET NAMES utf8');
        //$bdd->beginTransaction();
        return($bdd);
    }

    function get_id_connexion($env)
    {
        $bdd = connexion_base_mysql();
        $query = "select * from crm_connexion where Name = '$env'";
        $result_query = $bdd->query($query);
        foreach($result_query as $row_connexion)
        {
            $tab = array(	1 => $row_connexion['Connection_String'],
                2 => $row_connexion['UserName'],
                3 => $row_connexion['PassWord']);
        }
        return ($tab);
    }

    function connexion_base_oracle($env)
    {
        $tab = get_id_connexion($env);
        $bdd = oci_connect($tab[2], $tab[3], $tab[1]);
        if (!$bdd)
        {
            $e = oci_error();
            trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
        }
        $prepared_statement = oci_parse($bdd, "ALTER SESSION SET NLS_DATE_FORMAT = 'YYYY/MM/DD HH24:MI:SS'");
        oci_execute($prepared_statement);

        //$prepared_statement = oci_parse($bdd_oracle, $oracle_query_string);
        //$bdd->exec("ALTER SESSION SET NLS_DATE_FORMAT = 'YYYY/MM/DD HH24:MI:SS'");
        return($bdd);
    }


    function get_connexion($bdd_mysql, $connexion)
    {
        $query = "select * from crm_connexion where Name = '$connexion'";
        $result_query = $bdd_mysql->query($query);
        return ($result_query);
    }

    function generate_array_abscissa($days)
    {
        $result_count = count($days);
        if ($result_count <= 15)
        {
            //echo 'je ne sais pas';
            return ($days);
        }
        $new_array_days = array();
        $i = $result_count / 7;
        $i = round($i, 0);
        $j = 0;
        for($incre = 0;$incre < $result_count; $incre++)
        {
            if ($incre == $j)
            {
                array_push($new_array_days, $days[$incre]);
                $j = $j + $i;
            }
            /* else
            {
                array_push($new_array_days, NULL);
            } */
        }
        array_push($new_array_days, $days[$result_count - 1]);
        return ($new_array_days);
    }

    function print_tab_mysql($bdd_mysql, $query_string,$query_name)
    {

        $select = $bdd_mysql->query($query_string);
        $count_column = $select->columnCount();
        echo '<table>';
        echo '<tr><th>'.$query_name.'</th></tr>';
        echo '<tr>';
        for($i = 0;$i<$count_column;$i++)
        {
            $meta = $select->getColumnMeta($i);
            echo "<th style=background-color:#5bacf7;>".$meta['name'].'</th>';
        }
        echo '</tr>';
        foreach($select as $row)
        {
            echo '<tr>';
            for($i=0;$i<$count_column;$i++)
            {
                echo '<td>'.$row[$i].'</td>';
            }
            echo '</tr>';
        }
        echo '</table>';
    }

    function print_tab_data($bdd_mysql, $query_string,$query_name,$color)
    {

        $select = $bdd_mysql->query($query_string);
        $count_column = $select->columnCount();

        echo "<tr><th center:left; class='$color'>".$query_name.'</th>';
        foreach($select as $row)
        {
            if (preg_match("#Optin#",$query_name))
            {
                for($i=1;$i<$count_column;$i++)// = $i + 2)
                {
                    echo '<td>'.$row[$i].'%'.'</td>';
                }
                echo '</tr>';
            }
            else
            {
                for($i=1;$i<$count_column;$i++)// = $i + 2)
                {
                    echo '<td>'.$row[$i].'</td>';
                }
                echo '</tr>';
            }
        }
    }

    function print_tab_mysql_metrique($bdd_mysql, $query_string,$query_name)
    {
        global $config;

        $select = $bdd_mysql->query($query_string);
        $count_column = $select->columnCount();
        //echo '<table class=arbre>';
        echo '<tr><th><input style="width:250px" type="button" onclick="toggleVisibility(\''.$query_name.'\')" value='.$query_name.' /></th>';
        foreach($select as $row)
        {

            if ($row['Sources'] == 'Total')
            {
                //echo  "<td   width='300'>".$row['Sources'].'</td>';
                //echo $row['Query_Name'];
                for($i=2;$i<$count_column;$i++)// = $i + 2)
                {
                    echo "<td>".$row[$i].'</td>';
                }
                echo '</tr>';
                echo "\n";
            }
            else
            {
                echo "<tr style='display:none;' isVisible='0' name='" . $query_name . "'>";
                echo  "<td width='300'>"."$row[Sources]".'</td>';
                //echo $row['Query_Name'];
                for($i=2;$i<$count_column;$i++)// = $i + 2)
                {
                    echo "<td>".$row[$i].'</td>';
                }
                echo '</tr>';
                echo "\n";
            }
        }

        /* echo "</div>";
        echo '</table>'; */
    }

    function print_tab_mysql_with_button($bdd_mysql, $query_string,$query_name)
    {
        global $config;
        $select = $bdd_mysql->query($query_string);
        $count_column = $select->columnCount();

        echo '<table class=arbre>';
        echo '<tr><th>'.$query_name.'</th></tr>';
        echo '<tr>';
        for($i = 0;$i<$count_column;$i++)
        {
            $meta = $select->getColumnMeta($i);
            echo "<th style=background-color:#5bacf7;>".$meta['name'].'</th>';
        }
        echo '</tr>';

        foreach($select as $row)
        {
            $Name = str_replace(' ', '%20', $row['Query_Name']);
            //echo $Name;
            echo '<tr>';
            echo  '<td  width="300">'."<input style='width:290px' type='button' onclick=location.href='http://$config[hostname]/load_one_query.php?name=$Name' value='$row[Query_Name]' />".'</td>';
            //echo $row['Query_Name'];
            for($i=1;$i<$count_column;$i++)// = $i + 2)
            {
                echo '<td>'.$row[$i].'</td>';
            }
            echo '</tr>';
        }
        echo '</table>';
    }

    function print_tab_mysql_bis($bdd_mysql, $query_string,$query_name,$color)
    {
        $select = $bdd_mysql->query($query_string);
        $count_column = $select->columnCount();
        echo '<table>';
        echo "<tr><th class='$color'>".$query_name.'</th></tr>';
        echo '<tr>';
        for($i = 0;$i<$count_column;$i++)
        {
            $meta = $select->getColumnMeta($i);
            echo "<th class='$color'>".$meta['name'].'</th>';
        }
        echo '</tr>';
        foreach($select as $row)
        {
            echo '<tr>';
            for($i=0;$i<$count_column;$i++)// = $i + 2)
            {
                echo '<td>'.$row[$i].'</td>';
            }
            echo '</tr>';
        }
        echo '</table>';
    }

    function print_tab_oracle($bdd_oracle, $oracle_query_string,$query_name)
    {
        echo $oracle_query_string;
        echo '<table class="container">';
        //$bdd_oracle = connexion_base_oracle();
        //displayVariable($oracle_query_string, '$oracle_query_string');
        $prepared_statement = oci_parse($bdd_oracle, $oracle_query_string);
        oci_execute($prepared_statement);
        $ncols = oci_num_fields($prepared_statement);
        $i = 0;
        // Print Header ($query_name)
        echo '<tr>';
        echo "<th colspan='$ncols' style='background-color:#5bacf7;text-align:left;'>$query_name</th>";
        echo '</tr>';
        echo '<tr>';
        for ($i = 1; $i <= $ncols; $i++)
        {
            $column_name  = oci_field_name($prepared_statement, $i);
            echo "<th style=background-color:#5bacf7;>$column_name</th>";
            //$column_type  = oci_field_type($prepared_statement, $i);
        }
        echo '</tr>';
        while (($row = oci_fetch_row($prepared_statement)) != false)
        {
            $i = 1;
            echo '<tr>';
            foreach($row as $cell_content)
            {
                $column_name  = oci_field_name($prepared_statement, $i);
                //echo $column_name . '<br>';
                //echo gettype($cell_content). ' | ' . $cell_content . '<br>';
                echo "<td>$cell_content</td>";
                $i++;
            }
            echo '</tr>';
        }
        echo '</table>';
    }

    function print_tab_oracle_tab($bdd_oracle, $oracle_query_string,$query_name,$tab)
    {
        // ---- print_tab_oracle "bis"
        echo '<table class="container">';
        //$bdd_oracle = connexion_base_oracle();
        $prepared_statement = oci_parse($bdd_oracle, $oracle_query_string);
        oci_execute($prepared_statement);
        $ncols = oci_num_fields($prepared_statement);
        $i = 0;
        echo '<tr>';
        echo '<th colspan=100 style=background-color:#5bacf7><p align="left">'. $query_name.'</p></th>';
        echo '</tr>';
        for ($i = 1; $i <= $ncols; $i++)
        {
            $column_name  = oci_field_name($prepared_statement, $i);
            echo "<th style=background-color:#5bacf7;>$column_name</th>";
            //$column_type  = oci_field_type($prepared_statement, $i);
        }

        while (($row = oci_fetch_row($prepared_statement)) != false)
        {
            $i = 1;
            echo '<tr>';
            foreach($row as $cell_content)
            {
                $column_name  = oci_field_name($prepared_statement, $i);
                foreach($tab as $row_tab)
                {
                    if ($row_tab == $column_name)
                    {$value=1;break;}
                    else
                    {$value=0;}
                }
                //echo $column_name . '<br>';
                //echo gettype($cell_content). ' | ' . $cell_content . '<br>';
                if ($value == 1 && $cell_content == NULL)
                {
                    echo '<td class="bad">'. $cell_content.'</td>';
                }
                else
                {
                    echo '<td>'. $cell_content.'</td>';
                }
                $i++;
            }
            echo '</tr>';
        }
        echo '</table>';
    }

    function get_user()
    {
        $bdd = connexion_base_mysql();

        $date = date('Y-m-d');
        $hostname = getUserHostname();

        $query_insert = "SELECT username FROM crm_users where hostname = '$hostname'";

        $select = $bdd->query($query_insert);
        $count_column = $select->columnCount();
        foreach($select as $row)
        {
            for($i=0;$i<$count_column;$i++)// = $i + 2)
            {
                $name = $row[$i];
            }
        }
        if ($name != '')
        {
            echo "Welcome " . $name . " ,Have a good day :)";
        }
        else
        {
            echo "Salut inconnu,Bienvenue :)";
        }
        $bdd->commit();
    }

    function autorized_user($indice)
    {
        $bdd = connexion_base_mysql();

        $hostname = substr(gethostbyaddr($_SERVER['REMOTE_ADDR']),0,-11);

        $query_insert = "SELECT authorized FROM crm_users where hostname = '$hostname'";
        $select = $bdd->query($query_insert);
        $count_column = $select->columnCount();
        foreach($select as $row)
        {
            for($i=0;$i<$count_column;$i++)// = $i + 2)
            {
                $value = $row[$i];
            }
        }
        if ($value < 0 || $value > $indice)
        {
            echo "Acces denied, Call Equipe CRM ( dsi.crm@groupepvcp.com  ) for more information";
            echo "Acces non autorisé, merci de vous adresser à l'équipe CRM ( dsi.crm@groupepvcp.com  ) pour plus d'information";
            header("http://". $config['hostname'] . "/acces_denied.php");
            exit();
        }
    }

    function hostname_exists()
    {
        $bdd = connexion_base_mysql();
        $exists = false;
        $hostname = substr(gethostbyaddr($_SERVER['REMOTE_ADDR']),0,-11);
        $query_insert = "SELECT authorized FROM crm_users where hostname = '$hostname'";
        $select = $bdd->query($query_insert);
        foreach($select as $row)
        {
            return true;
        }
        return false;
    }


}