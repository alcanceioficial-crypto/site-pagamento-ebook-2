<?php

$file = "api/downloads/ebook.pdf";

header("Content-Type: application/pdf");
header("Content-Disposition: attachment; filename=ebook.pdf");
readfile($file);
exit;
