<?php

use \App\Classes\TravelMan;

$errMessage = '';

if (isset($_FILES['listCity'])) {

	$ext = pathinfo($_FILES['listCity']['name'], PATHINFO_EXTENSION);
	$file = $_FILES['listCity']['tmp_name'];

	if (!$_FILES['listCity']['size']) {
        $errMessage = '<p>Wrong data format!</p>';
    }
	else if (empty($file)) {
		$errMessage = '<p>Please re-upload file.</p>';
	}
	else if ($ext == 'txt') {
		$travelMan = new TravelMan($file);
		$errMessage .= $travelMan->getErrMessage();
	} else {
		$errMessage = '<p>Not support file type (*.txt only)</p>';
	}
}

require_once 'template.php';
