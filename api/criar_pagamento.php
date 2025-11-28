<?php
header("Content-Type: application/json");

// SUA API KEY DO ASAAS - SANDBOX
$api_key = "aact_hmlg_000MzkwODA2MWY2OGM3MWRlMDU2NWM3MzJlNzZmNGZhZGY6OjgwNGNiMGNmLWQ1MzgtNGI4OC04MzZjLWUwZDE2ZGQxNDUzZjo6JGFhY2hfYWU0ZWIwNWQtNGQ5MS00ZGRmLTg5OTAtMjViMzczNDJkYjhj";

// 🔹 Criar um cliente fictício para teste
$clienteData = [
    "name" => "Cliente Teste",
    "cpfCnpj" => "12345678909",
    "email" => "teste@exemplo.com",
    "phone" => "11999999999"
];

$curl = curl_init();

curl_setopt_array($curl, [
    CURLOPT_URL => "https://sandbox.asaas.com/api/v3/customers",
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_POST => true,
    CURLOPT_POSTFIELDS => http_build_query($clienteData),
    CURLOPT_HTTPHEADER => [
        "access_token: $api_key",
        "Content-Type: application/x-www-form-urlencoded"
    ]
]);

$response = curl_exec($curl);
$cliente = json_decode($response, true);

if (isset($cliente["errors"])) {
    echo json_encode(["error" => "Erro ao criar cliente: " . $cliente["errors"][0]["description"]]);
    exit;
}

$customer_id = $cliente["id"];

// 🔹 Criar cobrança PIX
$paymentData = [
    "customer" => $customer_id,
    "billingType" => "PIX",
    "value" => 2.00,
    "dueDate" => date("Y-m-d")
];

curl_setopt_array($curl, [
    CURLOPT_URL => "https://sandbox.asaas.com/api/v3/payments",
    CURLOPT_POSTFIELDS => http_build_query($paymentData)
]);

$response = curl_exec($curl);
$payment = json_decode($response, true);

if (isset($payment["errors"])) {
    echo json_encode(["error" => "Erro ao gerar pagamento: " . $payment["errors"][0]["description"]]);
    exit;
}

$payment_id = $payment["id"];

// 🔹 Gerar QR Code
curl_setopt_array($curl, [
    CURLOPT_URL => "https://sandbox.asaas.com/api/v3/payments/$payment_id/pixQrCode",
    CURLOPT_POST => false
]);

$response = curl_exec($curl);
$pix = json_decode($response, true);

curl_close($curl);

echo json_encode([
    "qrCode" => $pix["encodedImage"],
    "copiaCola" => $pix["payload"]
]);

