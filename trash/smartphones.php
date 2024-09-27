<?php
	//ob_start();
	session_start();
	$pageTitle = 'Homepage';
	include 'init.php';
?>

<?php
// URL-ul API-ului Strapi
$url = "http://localhost:1337/api/products/?populate=*";

// Token-ul de autorizare
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
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Products</title>
    <style>
    /* CSS-ul pentru containerul flex */
    .viewport_container {
        width: 100%;
        display: flex;
        justify-content: center;
        align-items: center;
    }

    .products-container {
        display: flex;
        flex-wrap: wrap;
        gap: 20px;
        justify-content: center;
        padding: 20px;
        max-width: 850px;
        width: 100%;
    }

    /* Stiluri pentru fiecare produs */
    .product-item {
        background-color: #f9f9f9;
        border: 1px solid #ddd;
        border-radius: 10px;
        padding: 20px;
        text-align: center;
        width: 250px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        transition: transform 0.3s ease;
    }

    .product-item:hover {
        transform: scale(1.05);
    }

    /* Stiluri pentru imagine */
    .product-image {
        width: 100%;
        height: auto;
        object-fit: contain;
        border-radius: 10px;
    }

    /* Titlul produsului */
    .product-title {
        font-size: 18px;
        margin: 15px 0;
        color: #333;
    }


    .product-price {
        font-size: 22px;
        font-weight: bold;
        color: black;
    }


    .add-to-cart {
        background-color: black;
        color: white;
        border: none;
        padding: 10px 20px;
        border-radius: 5px;
        cursor: pointer;
        margin-top: 10px;
        transition: background-color 0.3s ease;
    }

    .add-to-cart:hover {
        background-color: #2980b9;
    }
    </style>
</head>

<body>
    <div class="viewport_container">
        <div class="products-container">
            <?php foreach ($products as $product): ?>
            <div class="product-item">

                <img src="<?php echo 'http://localhost:1337' . $product['attributes']['image']['data'][0]['attributes']['url']; ?>"
                    alt="<?php echo $product['attributes']['title']; ?>" class="product-image">


                <h1 class="product-title"><?php echo $product['attributes']['title']; ?></h1>


                <p class="product-price">$<?php echo $product['attributes']['price']; ?></p>


                <button class="add-to-cart">Buy Now</button>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</body>

</html>