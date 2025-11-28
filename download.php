<?php
$paymentId = $_GET["id"] ?? null;

if(!$paymentId) exit("ID inválido");

$pagamentos = file("pagamentos.txt", FILE_IGNORE_NEW_LINES);

if(in_array($paymentId, $pagamentos)) {
    header("Content-Type: application/pdf");
    readfile("ebooks/exemplo.pdf");
    exit;
} else {
    echo "Pagamento ainda não confirmado.";
}
?>
