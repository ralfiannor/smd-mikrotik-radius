<?php
 $tgl = "25 december 2011";
 $tglformat = date('Y-m-d', strtotime($tgl));
// echo $tglformat; // hasilnya 25-12-09

$elapsedTime = new DateTime($tglformat);
$now         = new DateTime();
echo ($now < $elapsedTime ? 'Tidak ada sisa waktu' : 'Sisa ');
?>