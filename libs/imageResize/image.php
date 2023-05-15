<?php
	require_once("class.image.php");

	$img = new class_image();
    $dirrect = substr($_GET['image'], 11);
	$img->take('/var/www/'.$dirrect.'.'.$_GET['ext'], $_GET['ext'], $_GET['ext']);
	$img->resize($_GET['w'],$_GET['h']);
	$img->output();

