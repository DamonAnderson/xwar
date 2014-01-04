<?php
session_start();
include 'setup.php';
include 'db.inc.php';

if(!mysqli_select_db($link, 'xwar'))
{
	$error = 'Unable to locate the main database.';
	include 'error.html.php';
	exit();
}

$sql = "SELECT * FROM `current_match` WHERE `id`=".$_SESSION['curr'];
$result = mysqli_query($link, $sql);

if (!$result)
{
	echo 'Error getting puzzle: ' . mysqli_error($link);
	exit();
}
else
{
	$row = mysqli_fetch_array($result);
	echo "{'scratch':\"".$row['board']."\",'territory':\"".$row['territory']."\"}";
}

exit();
?>
