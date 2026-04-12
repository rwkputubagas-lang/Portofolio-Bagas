<?php

$apiKey = "20RAN-JITXF-SQPPI-XK5ZX-F0RYF";

$nama = $_POST['nama'];
$total = $_POST['total'];

$merchantRef = "INV-" . time();

$data = [
    'method' => 'QRIS',
    'merchant_ref' => $merchantRef,
    'amount' => $total,
    'customer_name' => $nama,
    'order_items' => [
        [
            'name' => 'Produk Wuku',
            'price' => $total,
            'quantity' => 1
        ]
    ],
    'callback_url' => 'http://localhost/wuku/callback.php',
    'return_url' => 'http://localhost/wuku/sukses.html'
];

$curl = curl_init();

curl_setopt_array($curl, [
    CURLOPT_URL => "https://dash.kiosweb.co/api/transaction/create",
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_POST => true,
    CURLOPT_POSTFIELDS => http_build_query($data),
    CURLOPT_HTTPHEADER => [
        "Authorization: Bearer " . $apiKey
    ],
]);

$response = curl_exec($curl);
curl_close($curl);

$result = json_decode($response, true);

// ambil link pembayaran
$paymentUrl = $result['data']['checkout_url'];

// redirect ke Tripay
header("Location: " . $paymentUrl);
exit;

?>