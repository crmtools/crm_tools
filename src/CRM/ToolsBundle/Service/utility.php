<?php

/**
 * Created by PhpStorm.
 * User: zkissarli
 * Date: 13/07/2017
 * Time: 16:04
 */
namespace CRM\ToolsBundle\Service;

use Doctrine\ORM\EntityManager;
use CRM\ToolsBundle\Entity\CrmImportFile;

class utility{

    function getEntityManager(){

        $entityManager = $this->get('get_entity_manager');

        return $entityManager;
    }



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


    public function startsWith($file_name, $beg_name_file)
    {

        $length = strlen($beg_name_file);
        return (substr($file_name, 0, $length) === $beg_name_file);
    }

    function endsWith($file_name, $end_name_file)
    {
        $length = strlen($end_name_file);
        if ($length == 0) {
            return true;
        }

        return (substr($file_name, -$length) === $end_name_file);
    }

    function isValiDate($date, $format)
    {
        $d = \DateTime::createFromFormat($format, $date);
        return $d && $d->format($format) == $date;
    }

    function generateDays($start_date, $end_date)
    {
        $date_array = array();

        while ($start_date <= $end_date) {
            array_push($date_array, $start_date->format('Y-m-d'));
            $start_date->modify('+1 day');
        }

        return ($date_array);
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