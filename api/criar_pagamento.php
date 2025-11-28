<?php

$apiKey = "aact_hmlg_000MzkwODA2MWY2OGM3MWRlMDU2NWM3MzJlNzZmNGZhZGY6OjgwNGNiMGNmLWQ1MzgtNGI4OC04MzZjLWUwZDE2ZGQxNDUzZjo6JGFhY2hfYWU0ZWIwNWQtNGQ5MS00ZGRmLTg5OTAtMjViMzczNDJkYjhj";

$dados = [
    "billingType" => "PIX",
    "name" => "Compra de Ebook",
    "value" => 2.00,
    "dueDate" => date("Y-m-d"),
];

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, "https://sandbox.asaas.com/api/v3/payments");
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($dados));
curl_setopt($ch, CURLOPT_HTTPHEADER, [
    "Content-Type: application/json",
    
    // 🔥 Este é o header correto e compatível:
    "Authorization: Bearer $apiKey"
]);

$resposta = curl_exec($ch);
curl_close($ch);

$resp = json_decode($resposta, true);

if (isset($resp["errors"])) {
    echo "<h2>Erro ao gerar PIX:</h2>";
    print_r($resp);
    exit;
}

$qrCode = $resp["pixQrCode"]["encodedImage"];
$payload = $resp["pixQrCode"]["payload"];
$paymentId = $resp["id"];
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Pagar via PIX</title>
    <link rel="stylesheet" href="../estilo.css">
</head>
<body>

<div class="container">
    <h1>Escaneie o QR Code</h1>

    <img src="data:image/png;base64,<?= $qrCode ?>" width="280">

    <p>Código copia e cola:</p>
    <textarea rows="3" style="width:100%;"><?= $payload ?></textarea>

    <p>Aguardando pagamento...</p>

    <script>
        setInterval(() => {
            fetch("retorno_pix.php?id=<?= $paymentId ?>")
                .then(r => r.text())
                .then(status => {
                    if (status === "CONFIRMED") {
                        window.location.href = "../baixar.php";
                    }
                });
        }, 3000);
    </script>

</div>

</body>
</html>
