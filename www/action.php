<?php

//get data from form
$show = $_POST['show-popup'];
$url = $_POST['url'];

//retrieve data from js file
$script = file_get_contents('src/js/script.js');
$data = explode(';',$script, 3);

//format strings
$data[0] = sprintf('let url = "%s"', $url ?: "chocoala");
$data[1] = sprintf('let showPopup = %s', $show );

//data merging
$newScript = implode(';', $data);
file_put_contents('src/js/script.js', $newScript);

require_once 'formLoader.php';