<?php
// Setează Bearer token-ul și endpoint-ul
$token = 'e4c867603e15caf2e4dd1c9c8a4bec1392114bf05f708ed769d401bc5bc7b44087560011af4b58604394f6b50589ab6ee9f99c9cd10a4ddf01781345a875de40a67a795b356104dbd271df76c472780bd9c75d62fb1d1b59f629a0f055121194153a94ac0201d184108b859f1e5b38305868f1e2458af287e5f36c34d9007ff6';
$apiUrl = 'http://localhost:1337/api/reviews';

// Funcție pentru a face cereri cURL
function makeRequest($url, $token, $method = 'GET', $data = null) {
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
    if (curl_errno($ch)) {
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
    
    $response = makeRequest($apiUrl, $token, 'POST', $data);
    $result = json_decode($response, true);
    $message = isset($result['data']) ? 'Review added successfully!' : 'Error adding review.';

    // Redirecționează utilizatorul către aceeași pagină pentru a preveni retrimiterea datelor POST
    header("Location: " . $_SERVER['REQUEST_URI']);
    exit(); // Asigură-te că oprești execuția după redirecționare
}

// Obținerea recenziilor pentru un produs
$reviews = [];
$totalRating = 0;
$totalReviews = 0;
$ratings = [1 => 0, 2 => 0, 3 => 0, 4 => 0, 5 => 0];
print_r($ratings);

if (isset($_GET['product_id'])) {
    $productId = intval($_GET['product_id']);
    $response = makeRequest('http://localhost:1337/api/products/' . $productId . '?populate=*', $token, 'GET');
    
    $product = json_decode($response, true);
    $reviews = $product['data']['attributes']['reviews'] ?? [];
    
    if (!empty($reviews['data'])) {
        foreach ($reviews['data'] as $review) {
            $rating = intval($review['attributes']['user_rating']);
            $totalRating += $rating;
            $totalReviews++;
            $ratings[$rating]++;
        }
    }
    
    $averageRating = $totalReviews > 0 ? round($totalRating / $totalReviews, 1) : 0;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product Review Page</title>
    <!-- Include Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <!-- Include FontAwesome for star icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <style>
    .star-light {
        color: #e4e5e9;
    }

    .text-warning {
        color: #ffc107;
    }

    .progress {
        height: 0.5rem;
    }

    .progress-bar {
        background-color: #ffc107;
    }

    .modal-content {
        border-radius: 10px;
    }

    .card {
        margin-bottom: 20px;
    }

    .star-light {
        color: #e4e5e9;
    }

    .text-warning {
        color: #ffc107;
    }

    .star {
        font-size: 2rem;
        cursor: pointer;
        transition: color 0.2s;
    }
    </style>
</head>

<body>
    <div class="container mt-5">
        <div class="card">
            <div class="card-header" id="product_title">Product Title</div>
            <div class="card-body">
                <div class="row">
                    <div class="col-sm-3 text-center">
                        <img id="product_image" src="<?php echo htmlspecialchars($fullImageUrl); ?>" alt="Product Image"
                            width="230">
                        <button type="button" name="add_review" id="add_review"
                            class="btn btn-primary form-control mt-3" data-toggle="modal" data-target="#reviewModal">
                            Rate/Review This Product
                        </button>
                    </div>
                    <div class="col-sm-4 text-center">
                        <h1 class="text-warning mt-4 mb-4">
                            <b><span id="average_rating"><?php echo $averageRating; ?></span> / 5</b>
                        </h1>
                        <div class="mb-3">
                            <?php for ($i = 1; $i <= 5; $i++): ?>
                            <i
                                class="fas fa-star <?php echo $i <= $averageRating ? 'text-warning' : 'star-light'; ?> mr-1 main_star"></i>
                            <?php endfor; ?>
                        </div>
                        <h3><span id="total_review"><?php echo $totalReviews; ?></span> Reviews</h3>
                    </div>
                    <div class="col-sm-4">
                        <?php 
    // Array pentru a mapa stelele la descrierile textuale
    $descriptions = [
        5 => 'Excellent',
        4 => 'Good',
        3 => 'Average',
        2 => 'Below Average',
        1 => 'Poor'
    ];
    for ($star = 5; $star >= 1; $star--): ?>
                        <div class="mb-2">
                            <span class="text-dark"><?php echo $descriptions[$star]; ?></span>
                            <div class="progress">
                                <div class="progress-bar" role="progressbar"
                                    style="width: <?php echo ($totalReviews > 0) ? ($ratings[$star] / $totalReviews) * 100 : 0; ?>%;"
                                    aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                        </div>
                        <?php endfor; ?>
                    </div>
                </div>
            </div>
        </div>

        <h3 class="mt-3 ml-4">Product Reviews:</h3>
        <div class="mt-3" id="review_content">
            <?php if ($totalReviews > 0): ?>
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
    </div>

    <!-- Modal pentru a adăuga recenzie -->
    <div class="modal fade" id="reviewModal" tabindex="-1" role="dialog" aria-labelledby="reviewModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="reviewModalLabel">Add Review</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form method="POST" action="">
                        <input type="hidden" name="product_id" value="<?php echo $productId; ?>">
                        <input type="hidden" name="action" value="add_review">
                        <div class="form-group">
                            <label for="user_name">Your Name</label>
                            <input type="text" name="user_name" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label for="rating">Rating</label>
                            <div id="rating-stars" class="form-control">
                                <i class="fas fa-star star star-light" data-value="1"></i>
                                <i class="fas fa-star star star-light" data-value="2"></i>
                                <i class="fas fa-star star star-light" data-value="3"></i>
                                <i class="fas fa-star star star-light" data-value="4"></i>
                                <i class="fas fa-star star star-light" data-value="5"></i>
                                <input type="hidden" name="rating" id="rating-input" value="0">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="user_review">Your Review</label>
                            <textarea name="user_review" class="form-control" rows="3" required></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary">Submit Review</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Include Bootstrap JS and jQuery -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

    <!-- Include FontAwesome -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/js/all.min.js"></script>

    <script>
    $(document).ready(function() {
        // La hover, schimbă culoarea stelelor
        $('#rating-stars .star').on('mouseover', function() {
            const rating = $(this).data('value');
            $('#rating-stars .star').each(function() {
                $(this).toggleClass('text-warning', $(this).data('value') <= rating);
            });
        }).on('mouseout', function() {
            const currentRating = $('#rating-input').val();
            $('#rating-stars .star').each(function() {
                $(this).toggleClass('text-warning', $(this).data('value') <= currentRating);
            });
        }).on('click', function() {
            const rating = $(this).data('value');
            $('#rating-input').val(rating);
            $('#rating-stars .star').each(function() {
                $(this).toggleClass('text-warning', $(this).data('value') <= rating);
            });
        });
    });
    </script>
</body>

</html>