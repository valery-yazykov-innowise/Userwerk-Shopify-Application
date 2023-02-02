<?php

//retrieve data from js file
$script = file_get_contents('src/js/script.js');
$data = explode(';',$script, 3);

//getting the data to fill out the form
$url = str_replace('"', '', strrchr( $data[0], ' '));
$status = strrchr( $data[1], ' ');

//add data to cookies
$_COOKIE['url'] = $url;
$_COOKIE['status'] = $status;

require_once 'appPage.php';