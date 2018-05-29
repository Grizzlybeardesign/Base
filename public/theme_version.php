<?php
$version = array();

$version[] = array(
			'version'=>'0.1',
			'file'=>'inc.zip'
			);

$current_version = array_values(array_slice($version, -1))[0];

header("Content-type:application/json");
echo json_encode($current_version);