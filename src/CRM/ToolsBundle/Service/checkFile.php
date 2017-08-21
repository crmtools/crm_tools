<?php
/**
 * Created by PhpStorm.
 * User: zkissarli
 * Date: 17/07/2017
 * Time: 10:40
 */

namespace CRM\ToolsBundle\Service;


class checkFile extends utility{

   private $config = array (
       'file_import_line_limit'			    => 25000,
       'update_subscription_config'		    => array
       (
           'header'	                            => "TYPE|EMAIL|OPTIN|LANGUAGE_CODE|BRAND|SOURCE|REGISTRATION_DATE|COUNTRY_CODE",//LPN20170123
           'brands'                         	=> array('ADA','MAE','MAEVA.COM','PV','PVCI','PVP','PVR','SE','P_CP','P_SP','P_VN','E_CP','E_SP', 'E_VN'),
           'languages'                         	=> array('DE','EN','IT','ES','FR','NL'),
           'errors'                         	=> array
           (
               'existence_validity'			    => array( 'critical' => 1, 'label' => "The file is already awaiting integration (or has already been integrated)."),
               'space_validity'				    => array( 'critical' => 1, 'label' => "The file name cannot contain any space"),
               'file_date_validity_1'			=> array( 'critical' => 1, 'label' => "The format of the date in the file name must be 'YYYYMMDD'."),
               'file_date_validity_2'			=> array( 'critical' => 1, 'label' => "The date in the file name must be in the future."),
               'file_date_validity_3'			=> array( 'critical' => 1, 'label' => "The date cannot be more than 20 days in the future."),
               'extension_validity'			    => array( 'critical' => 1, 'label' => "The extension of the file must be 'csv'."),
               'header_validity'				=> array( 'critical' => 1, 'label' => "The header of the file is not correct."),
               'column_count_validity' 		    => array( 'critical' => 1, 'label' => "The number of column must be 8 ( column separator : pipe  '|')"),//LPN20170123 : + 1 colonne
               'type_validity'					=> array( 'critical' => 1, 'label' => "The first field of the file must either be 'EMAIL_ALONE' or 'DESABO'"),
               'email_validity'				    => array( 'critical' => 0, 'label' => "Invalid email"),
               'optin_validity'				    => array( 'critical' => 1, 'label' => "The field OPTIN can only contain 0 or 1, and must not be empty"),
               'country_validity'				=> array( 'critical' => 0, 'label' => "The field COUNTRY CODE cannot be empty and must be 2 characters long."),//LPN20170123
               'country_validity_2'			    => array( 'critical' => 0, 'label' => "The field COUNTRY CODE must be an ISO country code."),//BME20170412
               'language_validity'				=> array( 'critical' => 0, 'label' => "The field LANGUAGE_CODE cannot be empty and must be one of the following : DE,EN,IT,ES,FR,NL"),
               'brand_validity'				    => array( 'critical' => 1, 'label' => "The field BRAND must be one of : ADA, MAE, MAEVA.COM, PV, PVCI, PVP, PVR, SE, P_CP, P_SP, P_VN, E_CP, E_SP, E_VN"),
               //'source_validity'				=> 0,
               'registration_date_validity_1'	=> array( 'critical' => 1, 'label' => "The format of the field REGISTRATION_DATE must be 'DD/MM/YYYY'"),
               'registration_date_validity_2'	=> array( 'critical' => 1, 'label' => "The field REGISTRATION_DATE cannot be in the future (Must be the day the contact gave its consent)"),
               'empty_lines'					=> array( 'critical' => 1, 'label' => "The file cannot contain empty rows")
           ),
       ),
       'game_config'						    => array
       (
           'header'	                            => "TYPE_IMPORT|GAME_NAME|REGISTRATION_DATE|TITLE_CODE|LAST_NAME|FIRST_NAME|ADRESS_LINE1|ADRESS_LINE2|ZIP_CODE|CITY|STATE|COUNTRY_CODE|LANGUAGE_CODE|MOBILE_NUMBER|BIRTH_DATE|EMAIL|MRK_OPTIN|PARTNERS_OPTIN|MRK_CODE",
           'brands'                         	=> array('ADA','MAE','MAEVA.COM','PV','PVCI','PVP','PVR','E_CP','E_SP','E_VN', 'P_CP','P_SP','SE','P_VN', 'MULTI'),
           'languages'                          => array('DE','EN','IT','ES','FR','NL'),
           'errors'	                            => array
           (
               'existence_validity'			    => array( 'critical' => 1, 'label' => "The file is already awaiting integration (or has already been integrated)"),
               'space_validity'				    => array( 'critical' => 1, 'label' => "The file name cannot contain any space"),
               'file_date_validity_1'			=> array( 'critical' => 1, 'label' => "The format of the date in the file name must be 'YYYYMMDD'."),
               'file_date_validity_2'			=> array( 'critical' => 1, 'label' => "The date in the file name must be in the future."),
               'file_date_validity_3'			=> array( 'critical' => 1, 'label' => "The date cannot be more than 20 days in the future."),
               'extension_validity'			    => array( 'critical' => 1, 'label' => "The extension of the file must be 'csv'."),
               'header_validity'				=> array( 'critical' => 1, 'label' => "The header of the file is not correct."),
               'column_count_validity' 		    => array( 'critical' => 1, 'label' => "The number of column must be 19 ( column separator : pipe  '|')"),
               'type_validity'					=> array( 'critical' => 1, 'label' => "The first field of the file must be 'JEU'"),
               'game_name_validity'			    => array( 'critical' => 1, 'label' => "The game name in the file must be the same as the game name in the file name"),
               'registration_date_validity_1'	=> array( 'critical' => 0, 'label' => "The format of the field REGISTRATION_DATE must be 'DD/MM/YYYY'"),
               'registration_date_validity_2'	=> array( 'critical' => 1, 'label' => "The field REGISTRATION_DATE cannot be in the future (Must be the day the contact participated in the game)"),
               'last_name_validity'			    => array( 'critical' => 0, 'label' => "The field LAST_NAME cannot be empty."),
               'first_name_validity'			=> array( 'critical' => 0, 'label' => "The field FIRST_NAME cannot be empty."),
               'address_validity'				=> array( 'critical' => 0, 'label' => "The field ADRESS_LINE1 cannot be empty."),
               'zip_code_validity'				=> array( 'critical' => 0, 'label' => "The field ZIP_CODE cannot be empty."),
               'city_validity'					=> array( 'critical' => 0, 'label' => "The field CITY cannot be empty."),
               'country_validity'				=> array( 'critical' => 0, 'label' => "The field COUNTRY CODE cannot be empty and must be 2 characters long."),//LPN20170123
               'country_validity_2'			    => array( 'critical' => 0, 'label' => "The field COUNTRY CODE an ISO country code (EN, UK are not)."),//BME20170412
               'language_validity'				=> array( 'critical' => 0, 'label' => "The field LANGUAGE_CODE cannot be empty, and must contain one of the following : DE,EN,IT,ES,FR,NL."),
               'birthdate_validity_1'			=> array( 'critical' => 1, 'label' => "The format of the field BIRTH_DATE is not valid (DD/MM/YYYY)."),
               'birthdate_validity_2'			=> array( 'critical' => 0, 'label' => "Minor players and players whose age is over 100 will not be integrated."),
               'email_validity'				    => array( 'critical' => 0, 'label' => "Invalid email."),
               'brand_optin_validity'			=> array( 'critical' => 1, 'label' => "The field MRK_OPTIN cannot be null and must contain 0 or 1."),
               'partners_optin_validity'		=> array( 'critical' => 1, 'label' => "The field PARTNERS_OPTIN cannot be null and must contain 0 or 1."),
               'brand_validity'				    => array( 'critical' => 1, 'label' => "The field BRAND must be one of : ADA, E_CP, E_SP, LAT, MAE, MAEVA.COM, PV, PVCI, PVP, PVR, P_CP, P_SP, SE, P_VN, E_VN, MULTI"),
               'phone_validity'				    => array( 'critical' => 0, 'label' => "Phone numbers in scientific notation (34E+44)"),
               'empty_lines'					=> array( 'critical' => 1, 'label' => "The file cannot contain empty rows")
           )
       ),
       'update_address_config'					=> array //mmbengue ajout update_adress
       (
           'header'                         	=> "ID_CONTACT|EMAIL|ID_SYSTEM|CODE_SYSTEM|CIVILITY_CODE|FIRST_NAME|LAST_NAME|LINE_ADRESSE1|LINE_ADRESSE2|LINE_ADRESSE3|LINE_ADRESSE4|ZIP_CODE|CITY|COUNTRY_CODE|MOVED|DECEASED|PARTNER_NAME|REGISTRATION_DATE|EXTRACTION_DATE",
           'errors'	                            => array
           (
               'existence_validity'			    => array( 'critical' => 1, 'label' => "The file is already awaiting integration (or has already been integrated)"),
               'space_validity'				    => array( 'critical' => 1, 'label' => "The file name cannot contain any space"),
               'file_date_validity_1'			=> array( 'critical' => 1, 'label' => "The format of the date in the file name must be 'YYYY-MM-DD'."),
               'file_date_validity_2'			=> array( 'critical' => 1, 'label' => "The date in the file name must be in the future."),
               'key_validity'			        => array( 'critical' => 1, 'label' => "Tone of the key of update  cannot be empty ."),
               'extension_validity'			    => array( 'critical' => 1, 'label' => "The extension of the file must be 'csv'."),
               'header_validity'				=> array( 'critical' => 1, 'label' => "The header of the file is not correct."),
               'column_count_validity' 		    => array( 'critical' => 1, 'label' => "The number of column must be 19 ( column separator : pipe  '|')"),
               'type_validity'					=> array( 'critical' => 1, 'label' => "The first field of the file must be 'ID_CONTACT'"),
               'registration_date_validity_1'	=> array( 'critical' => 0, 'label' => "The format of the field REGISTRATION_DATE must be 'DD/MM/YYYY'"),
               'registration_date_validity_2'	=> array( 'critical' => 1, 'label' => "The field REGISTRATION_DATE cannot be in the future (Must be the day the contact participated in the game)"),
               'moved_validity_1'			    => array( 'critical' => 1, 'label' => "The field MOVED cannot be empty."),
               'moved_validity_2'			    => array( 'critical' => 1, 'label' => "The field MOVED can only contain '0' or '1'."),
               'partner_name_validity'			=> array( 'critical' => 1, 'label' => "The field PARTNER_NAME cannot be empty."),
               'country_validity_1'			    => array( 'critical' => 0, 'label' => "The field COUNTRY CODE != 2."),
               'country_validity_2'			    => array( 'critical' => 0, 'label' => "The field COUNTRY CODE an ISO country code (EN, UK are not)."),
               'empty_lines'					=> array( 'critical' => 1, 'label' => "The file cannot contain empty rows")
           )
       ),
       'color_config'					        => array
       (
           array('color_value' => '#ff9c15', 'min_value' => 0, 'max_value' => 100) //,
           //array('color_value' => '#ffcc80', 'min_value' => 0, 'max_value' => 20),
           //array('color_value' => '#ff9900', 'min_value' => 21, 'max_value' => 50),
           //array('color_value' => '#b36b00', 'min_value' => 51, 'max_value' => 100)
       ),
       'countries'	 => array
       (
           'AD','AE','AF','AG','AI','AL','AM','AN','AO','AQ','AR','AS','AT','AU','AW','AX','AZ','BA','BB','BD','BE',
           'BF','BG','BH','BI','BJ','BL','BM','BN','BO','BR','BS','BT','BV','BW','BY','BZ','CA','CC','CD','CF','CG',
           'CH','CI','CK','CL','CM','CN','CO','CR','CU','CV','CX','CY','CZ','DE','DJ','DK','DM','DO','DZ','EC','EE',
           'EG','EH','ER','ES','ET','FI','FJ','FK','FM','FO','FR','GA','GB','GD','GE','GF','GG','GH','GI','GL','GM',
           'GN','GP','GQ','GR','GS','GT','GU','GW','GY','HK','HM','HN','HR','HT','HU','ID','IE','IL','IM','IN','IO',
           'IQ','IR','IS','IT','JE','JM','JO','JP','KE','KG','KH','KI','KM','KN','KP','KR','KW','KY','KZ','LA','LB',
           'LC','LI','LK','LR','LS','LT','LU','LV','LY','MA','MC','MD','ME','MF','MG','MH','MK','ML','MM','MN','MO',
           'MP','MQ','MR','MS','MT','MU','MV','MW','MX','MY','MZ','NA','NC','NE','NF','NG','NI','NL','NO','NP','NR',
           'NU','NZ','OM','PA','PE','PF','PG','PH','PK','PL','PM','PN','PR','PS','PT','PW','PY','QA','RE','RO','RS',
           'RU','RW','SA','SB','SC','SD','SE','SG','SH','SI','SJ','SK','SL','SM','SN','SO','SR','ST','SV','SY','SZ',
           'TC','TD','TF','TG','TH','TJ','TK','TL','TM','TN','TO','TR','TT','TV','TW','TZ','UA','UG','UM','US','UY',
           'UZ','VA','VC','VE','VG','VI','VN','VU','WF','WS','YE','YT','ZA','ZM','ZW'
       )
   );

    public function check_file_uploaded($tmp_file, $file_path, $file_name, $currentHostname, $file_import, $em, $user_id, $tmp_path_dir, $upload_path_dir){

        $critical_error_found = 0;
        $file_type = NULL;
        $nb_lines = 0;
        $nbr_limit =$this->config['file_import_line_limit'];

        $error_message= NULL;


        if ($this->startsWith($file_name, 'JEU_') && sizeof(explode('_', $file_name)) >= 4){
            $file_type = "JEU";
            $file_date = explode('_', $file_name)[sizeof(explode('_', $file_name)) - 2];
            $game_name = substr($file_name, 4, -20);

            move_uploaded_file($tmp_file, $file_path);
            $file_lines = file($file_path);
            $nominal_line_size = sizeof(explode('|', $this->config['game_config']['header']));
            // fill errors array with 0 values
            $errors_array = array
            (
                'existence_validity' => 0,
                'space_validity' => 0,
                'file_date_validity_1' => 0,
                'file_date_validity_2' => 0,
                'file_date_validity_3' => 0,
                'extension_validity' => 0,
                'header_validity' => 0,
                'column_count_validity' => 0,
                'type_validity' => 0,
                'game_name_validity' => 0,
                'registration_date_validity_1' => 0,
                'registration_date_validity_2' => 0,
                'last_name_validity' => 0,
                'first_name_validity' => 0,
                //'address_validity'			=> 0,
                'zip_code_validity' => 0,
                //'city_validity'				=> 0,
                'country_validity' => 0,
                'country_validity_2' => 0,
                'language_validity' => 0,
                'birthdate_validity_1' => 0, // présente mais pas au format date
                'birthdate_validity_2' => 0, // présente et < 18 ou > 100
                'email_validity' => 0,
                'brand_optin_validity' => 0,
                'partners_optin_validity' => 0,
                'brand_validity' => 0,
                'phone_validity' => 0,
                'empty_lines' => 0
            );

            foreach ($file_import as $row) {
                $errors_array['existence_validity'] += 1;
            }

            if (!$this->endsWith(strtolower($file_name), '.csv')) {
                $errors_array['extension_validity'] += 1;
            }
            if (strpos($file_name, ' ') != false) {
                $errors_array['space_validity'] += 1;
            }

            if (!$this->isValiDate($file_date, 'Ymd')) {
                $errors_array['file_date_validity_1'] += 1;
            } else if (\DateTime::createFromFormat('Ymd', $file_date) < new \DateTime("now")) {
                $errors_array['file_date_validity_2'] += 1;
            } else if ($file_date == (new \DateTime("now"))->format('Ymd')) {
                $errors_array['file_date_validity_2'] += 1;
            } else if (\DateTime::createFromFormat('Ymd', $file_date) > (new \DateTime("now"))->modify('+20 day')) {
                $errors_array['file_date_validity_3'] += 1;
            }

            $nb_invalid_rows = 0;

            foreach ($file_lines as $line){
                $nb_lines += 1;
                if ($nb_lines == 1) {
                    $bom = pack("CCC", 0xef, 0xbb, 0xbf);
                    if (0 === strncmp($line, $bom, 3)) {
                        $line = substr($line, 3);
                    }
                    if (trim($line) != $this->config['game_config']['header']) {
                        $errors_array['header_validity'] += 1;
                    }
                } else {
                    $row_invalid = false;

                    $columns = explode('|', trim($line));
                    if (trim($line) == null || trim($line) == "") {
                        $errors_array['empty_lines'] += 1;
                        $row_invalid = true;
                        continue;
                    }
                    if (sizeof($columns) != $nominal_line_size) {
                        $errors_array['column_count_validity'] += 1;
                        $row_invalid = true;
                        continue;
                    }
                    if ($columns[0] != 'JEU') {
                        $errors_array['type_validity'] += 1;
                        $row_invalid = true;
                    }
                    if ($columns[1] != $game_name) {
                        $errors_array['game_name_validity'] += 1;
                        $row_invalid = true;
                    }
                    if (!$this->isValiDate($columns[2], 'd/m/Y')) {
                        $errors_array['registration_date_validity_1'] += 1;
                        $row_invalid = true;
                    } else if ((\DateTime::createFromFormat('d/m/Y', $columns[2]) > new \DateTime("now"))) {
                        $errors_array['registration_date_validity_2'] += 1;
                        $row_invalid = true;
                    }
                    if (trim($columns[4]) == null || trim($columns[4]) == "") {
                        $errors_array['last_name_validity'] += 1;
                        $row_invalid = true;
                    }
                    if (trim($columns[5]) == null || trim($columns[5]) == "") {
                        $errors_array['first_name_validity'] += 1;
                        $row_invalid = true;
                    }
                    //	if(trim($columns[6]) == null  || trim($columns[6]) == "")							{$errors_array['address_validity']				+= 1; $row_invalid = true; }
                    if (trim($columns[8]) == null || trim($columns[8]) == "") {
                        $errors_array['zip_code_validity'] += 1;
                        $row_invalid = true;
                    }
                    //	if(trim($columns[9]) == null  || trim($columns[9]) == "")							{$errors_array['city_validity']					+= 1; $row_invalid = true; }
                    //	if(trim($columns[11]) == null || trim($columns[11]) == "")							{$errors_array['country_validity']				+= 1; $row_invalid = true; }
                    if (strlen(trim($columns[11])) != 2) {
                        $errors_array['country_validity'] += 1;
                        $row_invalid = true;
                    }//LPN20170123
                    if (!in_array(strtoupper($columns[12]), $this->config['game_config']['languages'])) {
                        $errors_array['language_validity'] += 1;
                        $row_invalid = true;
                    }
                    if ($columns[14] != null && !$this->isValiDate($columns[14], 'd/m/Y')) {
                        $errors_array['birthdate_validity_1'] += 1;
                        $row_invalid = true;
                    }
                    if
                    (
                        $this->isValiDate($columns[14], 'd/m/Y') &&
                        (
                            $this->getAge(\DateTime::createFromFormat('d/m/Y', $columns[14])) < 18
                            ||
                            $this->getAge(\DateTime::createFromFormat('d/m/Y', $columns[14])) > 100
                        )
                    ) {
                        $errors_array['birthdate_validity_2'] += 1;
                        $row_invalid = true;
                    }
                    if (!filter_var($columns[15], FILTER_VALIDATE_EMAIL)) {
                        $errors_array['email_validity'] += 1;
                        $row_invalid = true;
                    }
                    if ($columns[16] != '0' && $columns[16] != '1') {
                        $errors_array['brand_optin_validity'] += 1;
                        $row_invalid = true;
                    }
                    if ($columns[17] != '0' && $columns[17] != '1') {
                        $errors_array['partners_optin_validity'] += 1;
                        $row_invalid = true;
                    }
                    if (!in_array(strtoupper($columns[18]), $this->config['game_config']['brands'])) {
                        $errors_array['brand_validity'] += 1;
                        $row_invalid = true;
                    }
                    if (strpos($columns[13], 'E+') != null) {
                        $errors_array['phone_validity'] += 1;
                        $row_invalid = true;
                    }
                    if ($row_invalid) {
                        $nb_invalid_rows += 1;
                    }
                }
            }

            $this->check_file_array['config']= $this->config;
            $this->check_file_array['errors_array']= $errors_array;
            $this->check_file_array['nb_lines']= $nb_lines;

            foreach($errors_array as $error_name => $error_count ) {
                $critical = $this->config['game_config']['errors'][$error_name]['critical'];
                if ($error_count > 0){
                    if ($critical > 0) {
                        $critical_error_found = 1;
                    }
                }
            }

        }else if($this->startsWith($file_name,'UPDATE_SUBSCRIPTION') && sizeof(explode('_',$file_name)) >= 5 ){
            $file_type = "UPDATE_SUBSCRIPTION";
            $file_date = explode('_',$file_name)[sizeof(explode('_',$file_name)) - 2];

            move_uploaded_file($tmp_file, $file_path);
            $file_lines = file($file_path);
            $nominal_line_size = sizeof(explode('|', $this->config['update_subscription_config']['header']));

            // fill errors array with 0 values
            $errors_array = array
            (
                'existence_validity'			=> 0,
                'space_validity'				=> 0,
                'file_date_validity_1'			=> 0,
                'file_date_validity_2'			=> 0,
                'file_date_validity_3'			=> 0,
                'extension_validity'			=> 0,
                'header_validity'				=> 0,
                'column_count_validity' 		=> 0,
                'type_validity'					=> 0,
                'email_validity'				=> 0,
                'optin_validity'				=> 0,
                'country_validity'				=> 0,
                'country_validity_2'			=> 0,
                'language_validity'				=> 0,
                'brand_validity'				=> 0,
                //'source_validity'				=> 0,
                'registration_date_validity_1'	=> 0,
                'registration_date_validity_2'	=> 0,
                'empty_lines'					=> 0
            );

            foreach ($file_import as $row) {
                $errors_array['existence_validity'] += 1;
            }

            if (!$this->endsWith(strtolower($file_name), '.csv')) {
                $errors_array['extension_validity'] += 1;
            }
            if (strpos($file_name, ' ') != false) {
                $errors_array['space_validity'] += 1;
            }

            if (!$this->isValiDate($file_date, 'Ymd')) {
                $errors_array['file_date_validity_1'] += 1;
            } else if (\DateTime::createFromFormat('Ymd', $file_date) < new \DateTime("now")) {
                $errors_array['file_date_validity_2'] += 1;
            } else if ($file_date == (new \DateTime("now"))->format('Ymd')) {
                $errors_array['file_date_validity_2'] += 1;
            } else if (\DateTime::createFromFormat('Ymd', $file_date) > (new \DateTime("now"))->modify('+20 day')) {
                $errors_array['file_date_validity_3'] += 1;
            }

            $nb_invalid_rows = 0;

            foreach ($file_lines as $line){
                $nb_lines += 1;
                $row_invalid = false;

                if ($nb_lines == 1) {
                    $bom = pack("CCC", 0xef, 0xbb, 0xbf);
                    if (0 === strncmp($line, $bom, 3)) {
                        $line = substr($line, 3);
                    }
                    if (trim($line) != $this->config['update_subscription_config']['header']) {
                        $errors_array['header_validity'] += 1;
                    }
                }else{
                    $columns = explode('|',trim($line));

                    if(trim($line) == null  || trim($line) == ""){
                        $errors_array['empty_lines'] += 1;
                        $row_invalid = true; continue;
                    }
                    if(sizeof($columns) != $nominal_line_size){
                        $errors_array['column_count_validity'] += 1;
                        $row_invalid = true;  continue;
                    }
                    if($columns[0] != 'EMAIL_ALONE' && $columns[0] != 'DESABO'){
                        $errors_array['type_validity'] += 1;
                        $row_invalid = true;
                    }
                    if($columns[2] != '0' && $columns[2] != '1'){
                        $errors_array['optin_validity'] += 1;
                        $row_invalid = true;
                    }
                    if(!in_array($columns[3], $this->config['update_subscription_config']['languages'])){
                        $errors_array['language_validity'] += 1;
                        $row_invalid = true;
                    }
                    if(!in_array($columns[4], $this->config['update_subscription_config']['brands'])){
                        $errors_array['brand_validity'] += 1;
                        $row_invalid = true;
                    }
                    if(!filter_var($columns[1], FILTER_VALIDATE_EMAIL)){
                        $errors_array['email_validity'] += 1;
                        $row_invalid = true;
                    }
                    if(!$this->isValiDate($columns[6],'d/m/Y')){
                        $errors_array['registration_date_validity_1'] += 1;
                        $row_invalid = true;
                    }else if((\DateTime::createFromFormat('d/m/Y', $columns[6])> new \DateTime("now") )){
                        $errors_array['registration_date_validity_2'] += 1;
                        $row_invalid = true;
                    }
                    if(strlen(trim($columns[7])) != 2){
                        $errors_array['country_validity'] += 1;
                        $row_invalid = true;
                    }//LPN20170123

                    if($row_invalid) {
                        $nb_invalid_rows += 1;
                    }
                }
            }

            $this->check_file_array['config']= $this->config;
            $this->check_file_array['errors_array']= $errors_array;
            $this->check_file_array['nb_lines']= $nb_lines;

            foreach($errors_array as $error_name => $error_count ) {
                $critical = $this->config['update_subscription_config']['errors'][$error_name]['critical'];
                if ($error_count > 0){
                    if ($critical > 0) {
                        $critical_error_found = 1;
                    }
                }
            }

        }else if($this->startsWith($file_name,'UPDATE_ADDRESS') && sizeof(explode('_',$file_name)) >= 5 ){
            $file_type = "UPDATE_ADDRESS";
            $file_date = explode('_',$file_name)[sizeof(explode('_',$file_name)) - 2];

            move_uploaded_file($tmp_file, $file_path);
            $file_lines = file($file_path);
            $nominal_line_size = sizeof(explode('|',$this->config['update_address_config']['header']));

             // fill errors array with 0 values
            $errors_array = array
            (
                'existence_validity'			=> 0,
                'space_validity'				=> 0,
                'file_date_validity_1'			=> 0,
                'file_date_validity_2'			=> 0,
                'extension_validity'			=> 0,
                'header_validity'				=> 0,
                'column_count_validity' 		=> 0,
                'type_validity'					=> 0,
                'moved_validity_1'				=> 0,
                'moved_validity_2'				=> 0,
                'key_validity'					=> 0,
                'partner_name_validity'			=> 0,
                'registration_date_validity_1'	=> 0,
                'registration_date_validity_2'	=> 0,
                'country_validity_1'			=> 0,
                'country_validity_2'			=> 0,
                'empty_lines'					=> 0
            );


            foreach ($file_import as $row) {
                $errors_array['existence_validity'] += 1;
            }

            if (!$this->endsWith(strtolower($file_name), '.csv')) {
                $errors_array['extension_validity'] += 1;
            }
            if (strpos($file_name, ' ') != false) {
                $errors_array['space_validity'] += 1;
            }

            if (!$this->isValiDate($file_date, 'Y-m-d')) {
                $errors_array['file_date_validity_1'] += 1;
            } else if (\DateTime::createFromFormat('Y-m-d', $file_date) < new \DateTime("now")){
                $errors_array['file_date_validity_2'] += 1;
            } else if ($file_date == (new \DateTime("now"))->format('Y-m-d')) {
                $errors_array['file_date_validity_2'] += 1;
            }
//            else if (\DateTime::createFromFormat('Y-m-d', $file_date) > (new \DateTime("now"))->modify('+20 day')) {
//                $errors_array['file_date_validity_3'] += 1;
//            }

            $nb_invalid_rows = 0;

            foreach($file_lines as $line){
                $nb_lines += 1;
                $row_invalid = false;

                if($nb_lines == 1){
                    $bom = pack("CCC", 0xef, 0xbb, 0xbf);
                    if (0 === strncmp($line, $bom, 3)) {
                        $line = substr($line, 3);
                    }
                    if(trim($line) != $this->config['update_address_config']['header'])
                    {
                        $errors_array['header_validity'] += 1;
                    }
                }else{
                    $columns = explode('|',trim($line));

                    if(trim($line) == null  || trim($line) == ""){
                        $errors_array['empty_lines'] += 1;
                        $row_invalid = true;
                        continue;
                    }
                    if(sizeof($columns) != $nominal_line_size){
                        $errors_array['column_count_validity'] += 1;
                        $row_invalid = true;
                        continue;
                    }
                    if($columns[0] == null  && $columns[1] == null && ($columns[2] == null || $columns[3] == null)){
                        $errors_array['key_validity'] += 1;
                        $row_invalid = true;
                    }
                    if($columns[14] == null || trim($columns[14]) == ""){
                        $errors_array['moved_validity_1'] += 1;
                        $row_invalid = true;
                    }
                    if($columns[14] != '0' && $columns[14] != '1'){
                        $errors_array['moved_validity_2'] += 1;
                        $row_invalid = true;
                    }
                    if($columns[16] == null || trim($columns[16]) == ''){
                        $errors_array['partner_name_validity'] += 1;
                        $row_invalid = true;
                    }
                    if(!$this->isValiDate($columns[17],'d/m/Y')){
                        $errors_array['registration_date_validity_1']	+= 1;
                        $row_invalid = true;
                    }else if(\DateTime::createFromFormat('d/m/Y', $columns[17])> new \DateTime("now")){
                        $errors_array['registration_date_validity_2']	+= 1;
                        $row_invalid = true;
                    }
                    if($columns[13] != null && strlen(trim($columns[13])) != 2){
                        $errors_array['country_validity_1'] += 1;
                        $row_invalid = true;
                    }
                    if($columns[13] != null && !in_array($columns[13],$this->config['countries'])) {
                        $errors_array['country_validity_2'] += 1;
                        $row_invalid = true;
                    }

                    if($row_invalid) {
                        $nb_invalid_rows += 1;
                    }
                }

            }

            $this->check_file_array['config']= $this->config;
            $this->check_file_array['errors_array']= $errors_array;
            $this->check_file_array['nb_lines']= $nb_lines;

            foreach($errors_array as $error_name => $error_count ) {
                $critical = $this->config['update_address_config']['errors'][$error_name]['critical'];
                if ($error_count > 0){
                    if ($critical > 0) {
                        $critical_error_found = 1;
                    }
                }
            }

        }else{
            $error_message= 'The filemask must be \'JEU_*_YYYYMMDD_HHMISS.csv\' or \'UPDATE_SUBSCRIPTION_*_YYYYMMDD_HHMISS.csv\' or \'UPDATE_ADDRESS_*_YYYY-MM-DD_HH-MI-SS.csv\'';
            $this->check_file_array['error_message'] = $error_message;
            $critical_error_found = 1;

            return $this->check_file_array;
        }

        if($critical_error_found == 0 ){
            $is_insert= $this->insert_upload_file($file_name, $file_date, $file_type, $em, $nbr_limit, $user_id);
            if($is_insert){
//                exec('move '.$tmp_path_dir.'* ' .$upload_path_dir);
                exec('move C:\wamp64\www\buff_upload\* C:\wamp64\www\tmp_file_import\ ');
            }else{
                unlink($file_path);
            }
        }else{
            unlink($file_path);
        }

        return $this->check_file_array;
    }

    public function insert_upload_file($file_name, $file_date, $file_type, $em, $nbr_limit, $user_id){

        $nbr_line = $em->getRepository('CRMToolsBundle:CrmImportFile')->getNbLine($file_date, $file_type);

        foreach($nbr_line as $row_nbr){
            $nbr_in_base = $row_nbr['NBR'];
        }
        $nb_lines= $this->check_file_array['nb_lines'] -=  1;

        if ($nb_lines  > $nbr_limit){
            $error_message= "The daily limit of rows to process is $nbr_limit The file exceeds the limit : $nb_lines lines";
            $this->check_file_array['error_message'] = $error_message;
            return 0;
        }else if (($nb_lines + $nbr_in_base) > $nbr_limit){
            $error_message= "$nbr_in_base rows are already awaiting processing for $file_date, addinf the $nb_lines lines from the file would exceed the daily limit (of $nbr_limit) by " . (($nb_lines + $nbr_in_base) - $nbr_limit) . "";
            $this->check_file_array['error_message'] = $error_message;
            return 0;
        }else{
            $current_date= new \DateTime("now");
            $import_date= $current_date->format('Ymd');
            $insert_exec = $em->getRepository('CRMToolsBundle:CrmImportFile')->insertFileUpload($user_id, $file_name, $nb_lines, $import_date, $file_date, $file_type, $em);
            return 1;
        }
    }
}

