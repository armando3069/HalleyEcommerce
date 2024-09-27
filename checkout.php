<?php
require 'vendor/autoload.php'; // Include autoloader-ul Composer

\Stripe\Stripe::setApiKey('sk_test_51Q26cmAev2naXbW63EwLhSBks2SQwX86OGf2pg5u1bqM1BlPkgNnR0U4mn9gs802dPUkIewGWPbBf70TSITk3axT00p4Qhu3N1'); // Cheia secretă de la Stripe

header('Content-Type: application/json');

// Preia produsele din requestul POST
$input = file_get_contents('php://input');
$cartItems = json_decode($input, true);
//print_r($cartItems);


if (!$cartItems || count($cartItems) === 0) {
    echo json_encode(['error' => 'Coșul este gol']);
    exit;
}
$url = "http://localhost:1337/api/products/?populate=*";


// Token-ul de autorizare (ar trebui păstrat securizat)
$token = "e4c867603e15caf2e4dd1c9c8a4bec1392114bf05f708ed769d401bc5bc7b44087560011af4b58604394f6b50589ab6ee9f99c9cd10a4ddf01781345a875de40a67a795b356104dbd271df76c472780bd9c75d62fb1d1b59f629a0f055121194153a94ac0201d184108b859f1e5b38305868f1e2458af287e5f36c34d9007ff6";

// Pregătește request-ul cURL
$ch = curl_init($url);

// Setează header-ul de autorizare
curl_setopt($ch, CURLOPT_HTTPHEADER, [
    "Authorization: Bearer $token",
    "Content-Type: application/json"
]);

// Returnează rezultatul în loc să-l afișeze direct
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

// Execută request-ul
$response = curl_exec($ch);

// Verifică dacă există erori
if ($response === false) {
    die('Error fetching data: ' . curl_error($ch));
}

// Închide sesiunea cURL
curl_close($ch);

// Decodifică răspunsul JSON
$data = json_decode($response, true);

// Extrage lista de produse
$products = $data['data'];



foreach ($cartItems as $item) {
    foreach ($products as $product) {
        if ($item['id'] == $product['id']) {
            // Extrage titlul, imaginea și alte informații relevante
            $title = $product['attributes']['title'];
            $price = $product['attributes']['price'];
            $imageUrl = $product['attributes']['image']['data'][0]['attributes']['formats']['small']['url'];
            $quantity = $item['quantity'];

            // Adăugare în detaliile coșului
            $cartDetails[] = [
                'title' => $title,
                'image' => $imageUrl,
                'price'=> $price,
                'quantity' => $quantity,
            ];
        }
    }
}


// Creează line_items pentru fiecare produs din coș
$line_items = [];
foreach ($cartDetails as $item) {
    $line_items[] = [
        'price_data' => [
            'currency' => 'usd',
            'product_data' => [
                'name' => 'Produs ' . $item['title'],
                'images' => ['https://darwin.md/images/product/2023/03/darwin-apple-iphone-14-6-gb-512-gb-yellow-214358.webp'], 
            ],
            'unit_amount' => $item['price'] * 100, 
        ],
        'quantity' => $item['quantity'],
    ];
}

// Creează sesiunea de checkout Stripe
try {
    $session = \Stripe\Checkout\Session::create([
        'payment_method_types' => ['card'],
        'line_items' => $line_items,
        'mode' => 'payment',
        'success_url' => 'http://localhost/Halley/success.php',
        'cancel_url' => 'https://example.com/cancel',
    ]);

    echo json_encode(['id' => $session->id]);
} catch (\Stripe\Exception\ApiErrorException $e) {
    echo json_encode(['error' => $e->getMessage()]);
}
?>