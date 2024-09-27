<?php
$url = "http://localhost:1337/api/products/?populate=*";
$cartItems = [
    [
        "id" => 1,
        "quantity" => 2,
        "selectedColor" => "",
        "selectedMemory" => "128GB"
    ],
    [
        "id" => 13,
        "quantity" => 2,
        "selectedColor" => "#F7BDB9",
        "selectedMemory" => ""
    ]
];

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




// Iterează prin obiectul coșului pentru a găsi datele produselor
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
                'selectedColor' => $item['selectedColor'],
                'selectedMemory' => $item['selectedMemory']
            ];
        }
    }
}

// Afișare sau prelucrare mai departe a detaliilor din coș
echo "<h1>Detalii Coș</h1>";
foreach ($cartDetails as $cartItem) {
    echo "<div>";
    echo "<h2>{$cartItem['title']}</h2>";
    echo "<img src='{$cartItem['image']}' alt='{$cartItem['title']}' />";
    echo "<p>Cantitate: {$cartItem['quantity']} </p>";
    echo "<p>Pret: $ {$cartItem['price']}</p>";
    echo "<p>Culoare selectată: {$cartItem['selectedColor']}</p>";
    echo "<p>Memorie selectată: {$cartItem['selectedMemory']}</p>";
    echo "<p>Memorie selectată: {$cartItem['selectedMemory']}</p>";

    echo "</div>";
}

?>