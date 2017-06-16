<?php

$config = array
(
        'database_string_mysql'				=> 'mysql:host=frccesvapd01.pvcp.intra;dbname=crm;port=3306',
        'database_user_mysql'				=> 'crm-dev',
        'database_password_mysql'			=> '4NCqu2t3',
		'database_string_mysql_new'			=> 'mysql:host=frccesvapd01.pvcp.intra;dbname=crm_tools;port=3306',
        'load_archive_path'					=> '/mnt/crm/www/Logs/All_BackUp',      // Chemin dossier archive
		'log_directory'						=> '/mnt/crm/www/Logs/Q5',      		// Chemin dossier archive
        'file_path'							=> '/mnt/crm/www/Logs/All',
        'hostname'							=> 'frccesvapd01.pvcp.intra:8080',
		'file_import_line_limit'			=> 25000,
		'uploaded_files_tmp_directory'		=> '/mnt/crm/www/buff_upload/',
		'uploaded_crm_files_tmp_directory'	=> '/mnt/crm/www/buff_upload_crm/',
		'uploaded_files_directory'			=> '/mnt/crm/www/tmp_file_import/',
		'update_subscription_config'		=> array
		(
			'header'	=> "TYPE|EMAIL|OPTIN|LANGUAGE_CODE|BRAND|SOURCE|REGISTRATION_DATE|COUNTRY_CODE",//LPN20170123
			//'brands'	=> array('ADA','CITAD','CITEA','CP','E_CP','E_SP','LAT','MAE','MAEVA.COM','PV','PVCI','PVP','PVR','P_CP','P_SP','SE','SP','P_VN','E_VN'),//LPN20170228 : ajout VN
			'brands'	=> array('ADA','MAE','MAEVA.COM','PV','PVCI','PVP','PVR','SE','P_CP','P_SP','P_VN','E_CP','E_SP', 'E_VN'),
			'languages'	=> array('DE','EN','IT','ES','FR','NL'),
			'errors'	=> array 
			(
				'existence_validity'			=> array( 'critical' => 1, 'label' => "The file is already awaiting integration (or has already been integrated)."),
				'space_validity'				=> array( 'critical' => 1, 'label' => "The file name cannot contain any space"),
				'file_date_validity_1'			=> array( 'critical' => 1, 'label' => "The format of the date in the file name must be 'YYYYMMDD'."),
				'file_date_validity_2'			=> array( 'critical' => 1, 'label' => "The date in the file name must be in the future."),
				'file_date_validity_3'			=> array( 'critical' => 1, 'label' => "The date cannot be more than 20 days in the future."),
				'extension_validity'			=> array( 'critical' => 1, 'label' => "The extension of the file must be 'csv'."),
				'header_validity'				=> array( 'critical' => 1, 'label' => "The header of the file is not correct."),
				'column_count_validity' 		=> array( 'critical' => 1, 'label' => "The number of column must be 8 ( column separator : pipe  '|')"),//LPN20170123 : + 1 colonne
				'type_validity'					=> array( 'critical' => 1, 'label' => "The first field of the file must either be 'EMAIL_ALONE' or 'DESABO'"),
				'email_validity'				=> array( 'critical' => 0, 'label' => "Invalid email"),
				'optin_validity'				=> array( 'critical' => 1, 'label' => "The field OPTIN can only contain 0 or 1, and must not be empty"),
				'country_validity'				=> array( 'critical' => 0, 'label' => "The field COUNTRY CODE cannot be empty and must be 2 characters long."),//LPN20170123
				'country_validity_2'			=> array( 'critical' => 0, 'label' => "The field COUNTRY CODE must be an ISO country code."),//BME20170412
				'language_validity'				=> array( 'critical' => 0, 'label' => "The field LANGUAGE_CODE cannot be empty and must be one of the following : DE,EN,IT,ES,FR,NL"),
				'brand_validity'				=> array( 'critical' => 1, 'label' => "The field BRAND must be one of : ADA, MAE, MAEVA.COM, PV, PVCI, PVP, PVR, SE, P_CP, P_SP, P_VN, E_CP, E_SP, E_VN"),
				//'source_validity'				=> 0,
				'registration_date_validity_1'	=> array( 'critical' => 1, 'label' => "The format of the field REGISTRATION_DATE must be 'DD/MM/YYYY'"),
				'registration_date_validity_2'	=> array( 'critical' => 1, 'label' => "The field REGISTRATION_DATE cannot be in the future (Must be the day the contact gave its consent)"),
				'empty_lines'					=> array( 'critical' => 1, 'label' => "The file cannot contain empty rows")	
			),
		),
		'game_config'						=> array 
		(
			'header'	=> "TYPE_IMPORT|GAME_NAME|REGISTRATION_DATE|TITLE_CODE|LAST_NAME|FIRST_NAME|ADRESS_LINE1|ADRESS_LINE2|ZIP_CODE|CITY|STATE|COUNTRY_CODE|LANGUAGE_CODE|MOBILE_NUMBER|BIRTH_DATE|EMAIL|MRK_OPTIN|PARTNERS_OPTIN|MRK_CODE",
			//'brands'	=> array('ADA','CITAD','CITEA','CP','E_CP','E_SP','LAT','MAE','MAEVA.COM','PV','PVCI','PVP','PVR','P_CP','P_SP','SE','SP','MULTI'),
			'brands'	=> array('ADA','MAE','MAEVA.COM','PV','PVCI','PVP','PVR','E_CP','E_SP','E_VN', 'P_CP','P_SP','SE','P_VN', 'MULTI'),
			'languages' => array('DE','EN','IT','ES','FR','NL'),
			'errors'	=> array
			(
				'existence_validity'			=> array( 'critical' => 1, 'label' => "The file is already awaiting integration (or has already been integrated"),
				'space_validity'				=> array( 'critical' => 1, 'label' => "The file name cannot contain any space"),
				'file_date_validity_1'			=> array( 'critical' => 1, 'label' => "The format of the date in the file name must be 'YYYYMMDD'."),
				'file_date_validity_2'			=> array( 'critical' => 1, 'label' => "The date in the file name must be in the future."),
				'file_date_validity_3'			=> array( 'critical' => 1, 'label' => "The date cannot be more than 20 days in the future."),
				'extension_validity'			=> array( 'critical' => 1, 'label' => "The extension of the file must be 'csv'."),
				'header_validity'				=> array( 'critical' => 1, 'label' => "The header of the file is not correct."),
				'column_count_validity' 		=> array( 'critical' => 1, 'label' => "The number of column must be 19 ( column separator : pipe  '|')"),			
				'type_validity'					=> array( 'critical' => 1, 'label' => "The first field of the file must be 'JEU'"),
				'game_name_validity'			=> array( 'critical' => 1, 'label' => "The game name in the file must be the same as the game name in the file name"),
				'registration_date_validity_1'	=> array( 'critical' => 0, 'label' => "The format of the field REGISTRATION_DATE must be 'DD/MM/YYYY'"),
				'registration_date_validity_2'	=> array( 'critical' => 1, 'label' => "The field REGISTRATION_DATE cannot be in the future (Must be the day the contact participated in the game)"),
				'last_name_validity'			=> array( 'critical' => 0, 'label' => "The field LAST_NAME cannot be empty."),
				'first_name_validity'			=> array( 'critical' => 0, 'label' => "The field FIRST_NAME cannot be empty."),
				'address_validity'				=> array( 'critical' => 0, 'label' => "The field ADRESS_LINE1 cannot be empty."),
				'zip_code_validity'				=> array( 'critical' => 0, 'label' => "The field ZIP_CODE cannot be empty."),
				'city_validity'					=> array( 'critical' => 0, 'label' => "The field CITY cannot be empty."),
				'country_validity'				=> array( 'critical' => 0, 'label' => "The field COUNTRY CODE cannot be empty and must be 2 characters long."),//LPN20170123
				'country_validity_2'			=> array( 'critical' => 0, 'label' => "The field COUNTRY CODE an ISO country code (EN, UK are not)."),//BME20170412
				'language_validity'				=> array( 'critical' => 0, 'label' => "The field LANGUAGE_CODE cannot be empty, and must contain one of the following : DE,EN,IT,ES,FR,NL."),
				'birthdate_validity_1'			=> array( 'critical' => 1, 'label' => "The format of the field BIRTH_DATE is not valid (DD/MM/YYYY)."), 
				'birthdate_validity_2'			=> array( 'critical' => 0, 'label' => "Minor players and players whose age is over 100 will not be integrated."), 
				'email_validity'				=> array( 'critical' => 0, 'label' => "Invalid email."),
				'brand_optin_validity'			=> array( 'critical' => 1, 'label' => "The field MRK_OPTIN cannot be null and must contain 0 or 1."),
				'partners_optin_validity'		=> array( 'critical' => 1, 'label' => "The field PARTNERS_OPTIN cannot be null and must contain 0 or 1."),
				'brand_validity'				=> array( 'critical' => 1, 'label' => "The field BRAND must be one of : ADA, E_CP, E_SP, LAT, MAE, MAEVA.COM, PV, PVCI, PVP, PVR, P_CP, P_SP, SE, P_VN, E_VN, MULTI"), 
				'phone_validity'				=> array( 'critical' => 0, 'label' => "Phone numbers in scientific notation (34E+44)"), 
				'empty_lines'					=> array( 'critical' => 1, 'label' => "The file cannot contain empty rows")	
			)
		),
		'update_address_config'						=> array //mmbengue ajout update_adress
		(
			'header'	=> "ID_CONTACT|EMAIL|ID_SYSTEM|CODE_SYSTEM|CIVILITY_CODE|FIRST_NAME|LAST_NAME|LINE_ADRESSE1|LINE_ADRESSE2|LINE_ADRESSE3|LINE_ADRESSE4|ZIP_CODE|CITY|COUNTRY_CODE|MOVED|DECEASED|PARTNER_NAME|REGISTRATION_DATE|EXTRACTION_DATE",
			'errors'	=> array
			(
				'existence_validity'			=> array( 'critical' => 1, 'label' => "The file is already awaiting integration (or has already been integrated"),
				'space_validity'				=> array( 'critical' => 1, 'label' => "The file name cannot contain any space"),
				'file_date_validity_1'			=> array( 'critical' => 1, 'label' => "The format of the date in the file name must be 'YYYY-MM-DD'."),
				'file_date_validity_2'			=> array( 'critical' => 1, 'label' => "The date in the file name must be in the future."),
				'key_validity'			        => array( 'critical' => 1, 'label' => "Tone of the key of update  cannot be empty ."),
				'extension_validity'			=> array( 'critical' => 1, 'label' => "The extension of the file must be 'csv'."),
				'header_validity'				=> array( 'critical' => 1, 'label' => "The header of the file is not correct."),
				'column_count_validity' 		=> array( 'critical' => 1, 'label' => "The number of column must be 19 ( column separator : pipe  '|')"),			
				'type_validity'					=> array( 'critical' => 1, 'label' => "The first field of the file must be 'ID_CONTACT'"),
				'registration_date_validity_1'	=> array( 'critical' => 0, 'label' => "The format of the field REGISTRATION_DATE must be 'DD/MM/YYYY'"),
				'registration_date_validity_2'	=> array( 'critical' => 1, 'label' => "The field REGISTRATION_DATE cannot be in the future (Must be the day the contact participated in the game)"),
				'moved_validity_1'			    => array( 'critical' => 1, 'label' => "The field MOVED cannot be empty."),
				'moved_validity_2'			    => array( 'critical' => 1, 'label' => "The field MOVED can only contain '0' or '1'."),
				'partner_name_validity'			=> array( 'critical' => 1, 'label' => "The field PARTNER_NAME cannot be empty."),
				'country_validity_1'			=> array( 'critical' => 0, 'label' => "The field COUNTRY CODE != 2."),
				'country_validity_2'			=> array( 'critical' => 0, 'label' => "The field COUNTRY CODE an ISO country code (EN, UK are not)."),
				'empty_lines'					=> array( 'critical' => 1, 'label' => "The file cannot contain empty rows")	
			)
		),
		'color_config'					=> array
		(
			array('color_value' => '#ffa31a', 'min_value' => 0, 'max_value' => 100) //,
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
?>




