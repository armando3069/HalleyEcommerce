<?php
// Setează Bearer token-ul și endpoint-ul
$token = 'e4c867603e15caf2e4dd1c9c8a4bec1392114bf05f708ed769d401bc5bc7b44087560011af4b58604394f6b50589ab6ee9f99c9cd10a4ddf01781345a875de40a67a795b356104dbd271df76c472780bd9c75d62fb1d1b59f629a0f055121194153a94ac0201d184108b859f1e5b38305868f1e2458af287e5f36c34d9007ff6';
$apiUrl = 'http://localhost:1337/api/reviews';

// Funcție pentru a face cereri cURL
function makeRequest($url, $method = 'GET', $data = null) {
    global $token;
    
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        'Authorization: Bearer ' . $token,
        'Content-Type: application/json'
    ]);
    
    if ($method === 'POST') {
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
    } elseif ($method === 'GET') {
        curl_setopt($ch, CURLOPT_HTTPGET, true);
    }
    
    $response = curl_exec($ch);
    
    // Debugging cURL
    if(curl_errno($ch)) {
        echo 'cURL Error:' . curl_error($ch);
    }
    
    curl_close($ch);
    return $response;
}

// Adăugarea unei recenzii
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'add_review') {
    $currentDate = date('Y-m-d H:i:s'); // Obține data și ora curente

    $data = [
        'data' => [
            'product' => $_POST['product_id'],
            'user_rating' => $_POST['rating'],
            'user_name' => $_POST['user_name'],
            'user_review' => $_POST['user_review'],
            'datetime' => $currentDate // Adaugă data curentă
        ]
    ];
    
    $response = makeRequest($apiUrl, 'POST', $data);
    $result = json_decode($response, true);
    $message = isset($result['data']) ? 'Review added successfully!' : 'Error adding review.';
}

// Obținerea recenziilor pentru un produs
$reviews = [];
if (isset($_GET['product_id'])) {
    $productId = intval($_GET['product_id']);
    $response = makeRequest('http://localhost:1337/api/products/' . $productId . '?populate=*', 'GET');
    
    // Debugging API Response
    echo '<pre>';
    //print_r($response);
    echo '</pre>';
    
    $product = json_decode($response, true);
    $reviews = $product['data']['attributes']['reviews'] ?? [];

     $baseUrl = 'http://localhost:1337';  // URL-ul de bază al serverului Strapi
     $imagePath = $product['data']['attributes']['image']['data'][0]['attributes']['url'];
     $fullImageUrl = $baseUrl . $imagePath;

}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product Reviews</title>
    <style>
    body {
        font-family: Arial, sans-serif;
    }

    .container {
        width: 80%;
        margin: 0 auto;
    }

    .form-group {
        margin-bottom: 15px;
    }

    .form-group label {
        display: block;
        margin-bottom: 5px;
    }

    .form-group input,
    .form-group textarea {
        width: 100%;
        padding: 8px;
        box-sizing: border-box;
    }

    .form-group button {
        padding: 10px 15px;
        background-color: #007bff;
        color: white;
        border: none;
        cursor: pointer;
    }

    .reviews {
        margin-top: 20px;
    }

    .review {
        border: 1px solid #ddd;
        padding: 10px;
        margin-bottom: 10px;
    }
    </style>
</head>

<body>
    <div class="container">

        <!-- Section to Display Reviews -->
        <div class="form-group">
            <h2>View Reviews</h2>
            <img src="<?php echo htmlspecialchars($fullImageUrl); ?>" width="150px" alt="Product Image">
            <h1><?php echo htmlspecialchars($product['data']['attributes']['title']); ?></h1>
            <form method="get" action="">
                <label for="view_product_id">Product ID</label>
                <input type="number" id="view_product_id" name="product_id" required>
                <button type="submit">View Reviews</button>
            </form>
        </div>

        <div class="reviews">
            <h2>Reviews:</h2>
            <?php if (isset($reviews['data']) && is_array($reviews['data'])): ?>
            <?php foreach ($reviews['data'] as $review): ?>
            <div class="review">
                <strong><?php echo htmlspecialchars($review['attributes']['user_name']); ?></strong>
                <p>Rating: <?php echo htmlspecialchars($review['attributes']['user_rating']); ?> ⭐</p>
                <p><?php echo htmlspecialchars($review['attributes']['user_review']); ?></p>
                <small>Posted on: <?php echo htmlspecialchars($review['attributes']['datetime']); ?></small>
            </div>
            <?php endforeach; ?>
            <?php else: ?>
            <p>No reviews found for this product.</p>
            <?php endif; ?>
        </div>

        <?php if (empty($reviews) && isset($_GET['product_id'])): ?>
        <p>No reviews found.</p>
        <?php endif; ?>


        <!-- Form to Add a Review -->
        <div class="form-group">
            <h2>Add a Review</h2>
            <form method="post" action="">
                <input type="hidden" name="action" value="add_review">
                <label for="product_id">Product ID</label>
                <input type="number" id="product_id" name="product_id" required>

                <label for="rating">Rating</label>
                <input type="number" id="rating" name="rating" min="1" max="5" required>

                <label for="user_name">Your Name</label>
                <input type="text" id="user_name" name="user_name" required>

                <label for="user_review">Your Review</label>
                <textarea id="user_review" name="user_review" rows="4" required></textarea>

                <button type="submit">Submit Review</button>
            </form>
            <?php if (isset($message)) echo "<p>$message</p>"; ?>
        </div>
    </div>
    </div>
</body>

</html>