<?php
	require_once('class/session.class.php');
	require_once('class/login.class.php');
	$user_logout = new LOGIN();
	
	if($user_logout->is_loggedin()!="")
	{
		$user_logout->redirect('home.php');
	}
	if(isset($_GET['logout']))
	{
		$user_logout->doLogout();
		$user_logout->redirect('login.php?logout');
	}
