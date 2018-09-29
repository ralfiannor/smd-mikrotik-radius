<?php
set_include_path(get_include_path() . PATH_SEPARATOR . "class/dompdf");

require_once "dompdf_config.inc.php";

$dompdf = new DOMPDF();

$html = <<<'ENDHTML'
<html>
 <body>
  <h1>Hello Dompdf</h1>
 </body>
</html>
ENDHTML;

$dompdf->load_html($html);
$dompdf->render();

//$dompdf->stream("hello.pdf");


?>