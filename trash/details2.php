<?php
// Include fișierele necesare
session_start();
include 'init.php';

// Preluarea ID-ului din URL
$product_id = isset($_GET['id']) ? intval($_GET['id']) : 0;

// URL-ul API-ului pentru produsul selectat
$url = "http://localhost:1337/api/products/$product_id?populate=*";

// Token-ul de autorizare
$token = "e4c867603e15caf2e4dd1c9c8a4bec1392114bf05f708ed769d401bc5bc7b44087560011af4b58604394f6b50589ab6ee9f99c9cd10a4ddf01781345a875de40a67a795b356104dbd271df76c472780bd9c75d62fb1d1b59f629a0f055121194153a94ac0201d184108b859f1e5b38305868f1e2458af287e5f36c34d9007ff6";

// Pregătește request-ul cURL
$ch = curl_init($url);
curl_setopt($ch, CURLOPT_HTTPHEADER, [
    "Authorization: Bearer $token",
    "Content-Type: application/json"
]);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

// Execută request-ul și închide cURL
$response = curl_exec($ch);
curl_close($ch);

// Decodifică răspunsul JSON
$product_data = json_decode($response, true)['data']['attributes'];

// Extrage imaginea, detaliile și alte informații necesare
$title = $product_data['title'];
$price = $product_data['price'];
$details = $product_data['detail'][0];
$features = $product_data['features'];
$image_url = $product_data['image']['data'][0]['attributes']['url'];
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product Details</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@100;200;300;400;500;600;700;800;900&display=swap"
        rel="stylesheet">
    <style>
    body {
        background: #FAFAFA;
    }

    .details-container {
        display: flex;
        justify-content: center;
        align-items: center;
        flex-direction: column;
        background-color: #ffffff;
        padding: 20px;
        border-radius: 8px;
        max-width: 800px;
        margin: 0 auto;
    }

    .product-image {
        width: 200px;
        height: auto;
        margin-bottom: 20px;
    }

    .tabel_me {
        width: 100%;
    }

    h2 {
        margin-bottom: 10px;
    }

    .feature-section {
        margin-bottom: 20px;
    }

    .feature-section h3 {
        margin-bottom: 10px;
        font-size: 20px;
        font-weight: bold;
    }

    .feature-table {
        width: 100%;
        border-collapse: collapse;
    }

    .feature-table td {
        padding: 8px;
        border-bottom: 1px solid #CDCDCD;
    }

    .feature-table td:first-child {
        width: 40%;
    }

    .toggle-btn {
        display: flex;
        text-align: center;
        margin-top: 20px;
        padding: 12px 56px;
        border: 1px solid #545454;
        background-color: transparent;
        color: black;
        cursor: pointer;
        border-radius: 5px;
    }

    .hidden-section {
        display: none;
    }

    .right {
        text-align: right;
        font-family: 'Inter';
        font-weight: 400;
        font-size: 15px;
    }

    .left {
        font-size: 16px;
        font-family: 'Inter';
        font-weight: 400;
    }
    </style>
</head>

<body>

    <div class="details-container">
        <!-- Imaginea produsului -->
        <img src="<?php echo $image_url; ?>" alt="Product Image" class="product-image">

        <!-- Titlul produsului -->
        <h2><?php echo $title; ?></h2>

        <!-- Prețul produsului -->
        <p><strong>Price:</strong> $<?php echo $price; ?></p>

        <!-- Specificațiile produsului -->
        <div class="tabel_me">
            <h2>Details</h2>

            <!-- Afișarea secțiunilor "Generale" și "Procesor" -->
            <?php foreach (["Generale", "Procesor"] as $section): ?>
            <div class="feature-section">
                <h3><?php echo $section; ?></h3>
                <table class="feature-table">
                    <?php foreach ($features[$section] as $key => $value): ?>
                    <tr>
                        <td class="left"><?php echo $key; ?></td>
                        <td class="right"><?php echo $value; ?></td>
                    </tr>
                    <?php endforeach; ?>
                </table>
            </div>
            <?php endforeach; ?>

            <!-- Afișarea celorlalte secțiuni ascunse inițial -->
            <div id="hidden-sections" class="hidden-section">
                <?php foreach (array_slice($features, 2) as $section => $details): ?>
                <div class="feature-section">
                    <h3><?php echo $section; ?></h3>
                    <table class="feature-table">
                        <?php foreach ($details as $key => $value): ?>
                        <tr>
                            <td class="left"><?php echo $key; ?></td>
                            <td class="right"><?php echo $value; ?></td>
                        </tr>
                        <?php endforeach; ?>
                    </table>
                </div>
                <?php endforeach; ?>
            </div>

        </div>

        <!-- Butonul pentru a afișa/restânge detaliile -->
        <button id="toggle-btn" class="toggle-btn">
            View More
        </button>
    </div>

    <script>
    document.getElementById('toggle-btn').addEventListener('click', function() {
        var hiddenSections = document.getElementById('hidden-sections');
        var isHidden = hiddenSections.style.display === 'none' || hiddenSections.style.display === '';

        if (isHidden) {
            hiddenSections.style.display = 'block';
            this.textContent = 'View Less';
        } else {
            hiddenSections.style.display = 'none';
            this.textContent = 'View More';
        }
    });
    </script>

</body>

</html>