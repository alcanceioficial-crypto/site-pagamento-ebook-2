<?php
// Recebe JSON do Asaas
$dados = json_decode(file_get_contents("php://input"), true);

if ($dados["event"] == "PAYMENT_CONFIRMED") {

    $paymentId = $dados["payment"]["id"];

    // Salva em arquivo de pagamentos liberados
    file_put_contents("pagamentos.txt", $paymentId . PHP_EOL, FILE_APPEND);
}

http_response_code(200);
echo "OK";
