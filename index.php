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

$sql = "SELECT * FROM `puzzle` WHERE `id`=1";
$result = mysqli_query($link, $sql);

if (!$result)
{
	echo 'Error getting puzzle: ' . mysqli_error($link);
	exit();
}
else
{
	$row = mysqli_fetch_array($result);
	$_SESSION['solution'] = $row['letters'];
	$letters = $row['letters'];
	$board = '';
	$scratch = '';
	$territory = '';
	for ($i=0; $i<strlen($letters); $i++) {
		if ($letters[$i] != '*') {
			$board .= '-';
		}
		else {
			$board .= '*';
		}
		$scratch .= ' ';
		$territory .= '0';
	}
	$g = "{'title':\"".$row['title']."\",'board':\"".$board."\",'numbers':\"".$row['numbers']."\",'clues':".$row['clues']."}";
	$sql = "INSERT INTO `current_match` (`board`,`territory`) VALUES '$scratch','$territory'";
	$result = mysqli_query($link, $sql);
	$_SESSION['curr'] = mysqli_insert_id($link);
}

include 'game.html';
exit();
?>
