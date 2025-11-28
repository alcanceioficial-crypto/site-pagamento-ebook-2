<?php
$apiKey = "aact_hmlg_000MzkwODA2MWY2OGM3MWRlMDU2NWM3MzJlNzZmNGZhZGY6OjgwNGNiMGNmLWQ1MzgtNGI4OC04MzZjLWUwZDE2ZGQxNDUzZjo6JGFhY2hfYWU0ZWIwNWQtNGQ5MS00ZGRmLTg5OTAtMjViMzczNDJkYjhj";
$paymentId = $_GET["id"] ?? null;

if(!$paymentId) exit("ID inválido");

$pixURL = "https://sandbox.asaas.com/api/v3/payments/$paymentId/pixQrCode";

$curl = curl_init();
curl_setopt_array($curl, [
    CURLOPT_URL => $pixURL,
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_HTTPHEADER => [
        "access_token: $apiKey"
    ],
]);

$response = curl_exec($curl);
curl_close($curl);

$result = json_decode($response, true);

?>
<!DOCTYPE html>
<html>
<head>
    <title>Pague o PIX</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<h2>Escaneie o QR Code</h2>

<img src="data:image/png;base64,<?= $result['encodedImage']; ?>" width="250">

<h3>Código copia e cola:</h3>
<textarea style="width:300px;height:120px;"><?= $result['payload']; ?></textarea>

</body>
</html>
