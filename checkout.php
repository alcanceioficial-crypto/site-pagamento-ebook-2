<?php
// CONFIGURAÇÕES ASAAS
$apiKey = "SUA_CHAVE_SANDBOX_AQUI"; 
$apiURL = "https://sandbox.asaas.com/api/v3/payments";

// Dados da cobrança
$data = [
    "billingType" => "PIX",
    "value" => 2.00,
    "description" => "Compra Ebook",
    "dueDate" => date("Y-m-d"),
];

// Requisição CURL
$curl = curl_init();
curl_setopt_array($curl, [
    CURLOPT_URL => $apiURL,
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_POST => true,
    CURLOPT_POSTFIELDS => json_encode($data),
    CURLOPT_HTTPHEADER => [
        "Content-Type: application/json",
        "access_token: $apiKey"
    ],
]);

$response = curl_exec($curl);
curl_close($curl);

$result = json_decode($response, true);

// Se der erro
if(isset($result["errors"])) {
    echo "<pre>";
    print_r($result);
    echo "</pre>";
    exit;
}

// ID da cobrança
$paymentId = $result["id"];

// Redireciona para tela do QR Code
header("Location: retorno.php?id=" . $paymentId);
exit;

?>
