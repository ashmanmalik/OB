<?php
sleep(3);
$response = new stdClass;
$response->status = "success";
die(json_encode($response));		
		