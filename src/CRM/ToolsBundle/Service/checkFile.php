<?php
/**
 * Created by PhpStorm.
 * User: zkissarli
 * Date: 17/07/2017
 * Time: 10:40
 */

namespace CRM\ToolsBundle\Service;
use CRM\ToolsBundle\Service\utility;

class checkFile extends utility
{
    public function check_file_uploaded($config, $filePath, $file_name, $currentHostname, $file_import)
    {
        $critical_error_found = 0;
        $file_type = NULL;
        $nb_lines = 0;
        $nbr_limit = $config['file_import_line_limit'];

        if ($this->startsWith($file_name, 'JEU_') && sizeof(explode('_', $file_name)) >= 4) {

            $file_type = "JEU";
            $fileDate = explode('_', $file_name)[sizeof(explode('_', $file_name)) - 2];
            $game_name = substr($file_name, 4, -20);
            $file_lines = file($filePath);
            $nominal_line_size = sizeof(explode('|', $config['game_config']['header']));
            // fill errors array with 0 values
            $errors = array
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
                $errors['existence_validity'] += 1;
            }
            if (!$this->endsWith(strtolower($file_name), '.csv')) {
                $errors['extension_validity'] += 1;
            }
            if (strpos($file_name, ' ') != false) {
                $errors['space_validity'] += 1;
            }

            if (!$this->isValiDate($fileDate, 'Ymd')) {
                $errors['file_date_validity_1'] += 1;
            } else if (\DateTime::createFromFormat('Ymd', $fileDate) < new \DateTime("now")) {
                $errors['file_date_validity_2'] += 1;
            } else if ($fileDate == (new \DateTime("now"))->format('Ymd')) {
                $errors['file_date_validity_2'] += 1;
            } else if (\DateTime::createFromFormat('Ymd', $fileDate) > (new \DateTime("now"))->modify('+20 day')) {
                $errors['file_date_validity_3'] += 1;
            }

            $nb_invalid_rows = 0;

            foreach ($file_lines as $line) {
                $nb_lines += 1;
                if ($nb_lines == 1) {
                    $bom = pack("CCC", 0xef, 0xbb, 0xbf);
                    if (0 === strncmp($line, $bom, 3)) {
                        $line = substr($line, 3);
                    }
                    if (trim($line) != $config['game_config']['header']) {
                        $errors['header_validity'] += 1;
                    }
                } else {
                    $row_invalid = false;

                    $columns = explode('|', trim($line));
                    if (trim($line) == null || trim($line) == "") {
                        $errors['empty_lines'] += 1;
                        $row_invalid = true;
                        continue;
                    }
                    if (sizeof($columns) != $nominal_line_size) {
                        $errors['column_count_validity'] += 1;
                        $row_invalid = true;
                        continue;
                    }
                    if ($columns[0] != 'JEU') {
                        $errors['type_validity'] += 1;
                        $row_invalid = true;
                    }
                    if ($columns[1] != $game_name) {
                        $errors['game_name_validity'] += 1;
                        $row_invalid = true;
                    }
                    if (!$this->isValiDate($columns[2], 'd/m/Y')) {
                        $errors['registration_date_validity_1'] += 1;
                        $row_invalid = true;
                    } else if ((\DateTime::createFromFormat('d/m/Y', $columns[2]) > new \DateTime("now"))) {
                        $errors['registration_date_validity_2'] += 1;
                        $row_invalid = true;
                    }
                    if (trim($columns[4]) == null || trim($columns[4]) == "") {
                        $errors['last_name_validity'] += 1;
                        $row_invalid = true;
                    }
                    if (trim($columns[5]) == null || trim($columns[5]) == "") {
                        $errors['first_name_validity'] += 1;
                        $row_invalid = true;
                    }
                    //	if(trim($columns[6]) == null  || trim($columns[6]) == "")							{$errors['address_validity']				+= 1; $row_invalid = true; }
                    if (trim($columns[8]) == null || trim($columns[8]) == "") {
                        $errors['zip_code_validity'] += 1;
                        $row_invalid = true;
                    }
                    //	if(trim($columns[9]) == null  || trim($columns[9]) == "")							{$errors['city_validity']					+= 1; $row_invalid = true; }
                    //	if(trim($columns[11]) == null || trim($columns[11]) == "")							{$errors['country_validity']				+= 1; $row_invalid = true; }
                    if (strlen(trim($columns[11])) != 2) {
                        $errors['country_validity'] += 1;
                        $row_invalid = true;
                    }//LPN20170123
                    if (!in_array(strtoupper($columns[12]), $config['game_config']['languages'])) {
                        $errors['language_validity'] += 1;
                        $row_invalid = true;
                    }
                    if ($columns[14] != null && !$this->isValiDate($columns[14], 'd/m/Y')) {
                        $errors['birthdate_validity_1'] += 1;
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
                        $errors['birthdate_validity_2'] += 1;
                        $row_invalid = true;
                    }
                    if (!filter_var($columns[15], FILTER_VALIDATE_EMAIL)) {
                        $errors['email_validity'] += 1;
                        $row_invalid = true;
                    }
                    if ($columns[16] != '0' && $columns[16] != '1') {
                        $errors['brand_optin_validity'] += 1;
                        $row_invalid = true;
                    }
                    if ($columns[17] != '0' && $columns[17] != '1') {
                        $errors['partners_optin_validity'] += 1;
                        $row_invalid = true;
                    }
                    if (!in_array(strtoupper($columns[18]), $config['game_config']['brands'])) {
                        $errors['brand_validity'] += 1;
                        $row_invalid = true;
                    }
                    if (strpos($columns[13], 'E+') != null) {
                        $errors['phone_validity'] += 1;
                        $row_invalid = true;
                    }
                    if ($row_invalid) {
                        $nb_invalid_rows += 1;
                    }
                }

            }
            var_dump($errors);
            die;
        }


    }
}