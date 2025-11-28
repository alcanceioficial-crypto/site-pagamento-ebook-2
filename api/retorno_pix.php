<?php

// Para DEBUG, salvar retorno em arquivo
file_put_contents("retorno.log", json_encode($_POST) . "\n\n", FILE_APPEND);

$status = $_POST["event"] ?? "";

// Asaás envia: PAYMENT_CONFIRMED
if ($status === "PAYMENT_CONFIRMED") {

    // Depois você pode liberar o download real
    file_put_contents("pagamentos_confirmados.txt", json_encode($_POST) . "\n", FILE_APPEND);
}

echo "OK";
