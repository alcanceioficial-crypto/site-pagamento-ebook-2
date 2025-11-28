<?php

$apiKey = "aact_hmlg_000MzkwODA2MWY2OGM3MWRlMDU2NWM3MzJlNzZmNGZhZGY6OjgwNGNiMGNmLWQ1MzgtNGI4OC04MzZjLWUwZDE2ZGQxNDUzZjo6JGFhY2hfYWU0ZWIwNWQtNGQ5MS00ZGRmLTg5OTAtMjViMzczNDJkYjhj";
$paymentId = $_GET["id"];

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, "https://sandbox.asaas.com/api/v3/payments/$paymentId");
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, [
    "Content-Type: application/json",
    "access_token: $apiKey"
]);

$resposta = curl_exec($ch);
curl_close($ch);

$resp = json_decode($resposta, true);

echo $resp["status"];


</body>
</html>
