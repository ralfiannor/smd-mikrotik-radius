<?php
header('Content-Type: application/json');
$linklist=array();
$link=array();
mysql_connect('localhost','root','') or die(mysql_error());
mysql_select_db('radius') or die(mysql_error());
$qr=mysql_query("SELECT * FROM radcheck ") or die(mysql_error());
while($res=mysql_fetch_array($qr))
{
 $link['username']=$res['username'];
 $link['value']=$res['value'];
 array_push($linklist,$link);
}
//print_R($linklist);
echo json_encode($linklist);
?>