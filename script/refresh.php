<?php
session_set_cookie_params(31536000,"/");
session_start();

if(isset($_POST['ref']))
	 $_SESSION['ref'] = $_POST['ref'];

if(!isset($_SESSION['ref']))
	echo "off";
else
	echo $_SESSION['ref'];