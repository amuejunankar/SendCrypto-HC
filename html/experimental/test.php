<?php
require_once('./TCPDF-main/tcpdf.php');


?>


<!DOCTYPE html>
<html>

<head>
  <title>Generate PDF</title>
</head>

<body>
  <form action="generate-pdf.php" method="post">
    <input type="submit" name="download" value="Generate PDF">
  </form>
</body>

</html>