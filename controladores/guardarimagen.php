<?php

$filename = $_FILES['file']['name'];

$valid_extensions = array("jpg", "jpeg", "png");

$extension = pathinfo($filename, PATHINFO_EXTENSION);

if (in_array(strtolower($extension), $valid_extensions)) {

	if (move_uploaded_file($_FILES['file']['tmp_name'], "../images/" . $filename)) {
		echo 1;
	} else {
		echo 0;
	}
} else {
	echo 0;
}

exit;