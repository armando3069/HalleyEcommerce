<?php
session_start();
include 'init.php';
// Setează Bearer token-ul și endpoint-urile
// $token = 'e4c867603e15caf2e4dd1c9c8a4bec1392114bf05f708ed769d401bc5bc7b44087560011af4b58604394f6b50589ab6ee9f99c9cd10a4ddf01781345a875de40a67a795b356104dbd271df76c472780bd9c75d62fb1d1b59f629a0f055121194153a94ac0201d184108b859f1e5b38305868f1e2458af287e5f36c34d9007ff6';
// $apiUrl = 'http://localhost:1337/api/reviews';


include('./key.php'); // import token,apiUrl etc.

///$articles = $STRAPI->getArticles(dsfjksdsdfsd dsf ds fds)

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

// Preluarea ID-ului din URL pentru produs
$product_id = isset($_GET['id']) ? intval($_GET['id']) : 0;

// URL-ul API-ului pentru produsul selectat
$productUrl = "http://localhost:1337/api/products/$product_id?populate=*";

// $array_filter =array(
//     'populate' => '*',
//     'filters' => [
//         'id' => 1
//     ]
//     );
// $string =  http_build_query($array_filter);

// $url."?".$string

// Obținerea detaliilor produsului
$response = makeRequest($productUrl, $token, 'GET', $data);
$product_data = json_decode($response, true)['data']['attributes'];

// Extrage detalii, caracteristici și imagine
$details = $product_data['detail'][0];
$features = $product_data['features'];
$image_url = $product_data['image']['data'][0]['attributes']['url'];

// Obținerea recenziilor pentru produsul selectat
$reviews = [];
$totalRating = 0;
$totalReviews = 0;
$ratings = [1 => 0, 2 => 0, 3 => 0, 4 => 0, 5 => 0];

$response = makeRequest('http://localhost:1337/api/products/' . $product_id . '?populate=*', $token, 'GET');
$product = json_decode($response, true);
$reviews = $product['data']['attributes']['reviews'] ?? [];
$baseUrl = 'http://localhost:1337';  // URL-ul de bază al serverului Strapi
$fullImageUrl = $baseUrl . $image_url;

if (!empty($reviews['data'])) {
    foreach ($reviews['data'] as $review) {
        $rating = intval($review['attributes']['user_rating']);
        $totalRating += $rating;
        $totalReviews++;
        $ratings[$rating]++;
    }
}

$averageRating = $totalReviews > 0 ? round($totalRating / $totalReviews, 1) : 0;
?>


<div class="viewport_container_product">
    <div class="product-detail-container">
        <!-- Afișăm imaginea produsului -->
        <img src="<?php echo 'http://localhost:1337' . $product_data['image']['data'][0]['attributes']['url']; ?>"
            alt="<?php echo $product_data['title']; ?>" class="product-image">

        <div class="main_container">
            <!-- Titlul produsului -->
            <h1 class="product-title"><?php echo $product_data['title']; ?></h1>

            <!-- Prețul produsului -->
            <p class="product-price">$<?php echo $product_data['price']; ?></p>

            <!-- Afișarea culorilor -->
            <div class="colors-container">
                <p>Select Color: </p>
                <?php foreach ($product_data['detail'][0]['colors'] as $index => $color): ?>
                <div class="color-circle" id="color-<?php echo $index; ?>"
                    style="background-color: <?php echo $color; ?>;"
                    onclick="selectColor('<?php echo $color; ?>', <?php echo $index; ?>)">
                </div>
                <?php endforeach; ?>
            </div>

            <!-- Afișarea memoriei -->
            <div class="memory-container">
                <?php foreach ($product_data['detail'][0]['memory'] as $index => $memory): ?>
                <div class="memory-item" id="memory-<?php echo $index; ?>"
                    onclick="selectMemory('<?php echo $memory; ?>', <?php echo $index; ?>)">
                    <?php echo $memory; ?>
                </div>
                <?php endforeach; ?>
            </div>
            <!-- Caracteristicile tehnice -->
            <div class="specs-container">

                <div class="specs_info">
                    <img src="./layout/./img/smartphone-rotate-2-svgrepo-com 2.png" width="24px" height="24px" alt="">
                    <div class="specs_col">
                        <p><strong>Screen Size:</strong></p>
                        <p><?php echo $product_data['detail'][0]['screen_size']; ?></p>
                    </div>
                </div>

                <div class="specs_info">
                    <img src="./layout/./img/smartphone-rotate-2-svgrepo-com 2.png" width="24px" height="24px" alt="">
                    <div class="specs_col">
                        <p><strong>CPU:</strong></p>
                        <p><?php echo $product_data['detail'][0]['cpu']; ?></p>
                    </div>
                </div>

                <div class="specs_info">
                    <img src="./layout/./img/smartphone-rotate-3-svgrepo-com 2.png" width="24px" height="24px" alt="">
                    <div class="specs_col">
                        <p><strong>Number of Cores:</strong></p>
                        <p><?php echo $product_data['detail'][0]['number_of_cores']; ?></p>
                    </div>
                </div>

                <div class="specs_info">
                    <img src="./layout/./img/smartphone-rotate-4-svgrepo-com 2.png" width="24px" height="24px" alt="">
                    <div class="specs_col">
                        <p><strong>Rezoluție:</strong></p>
                        <p><?php echo $product_data['detail'][0]['Rezoluție']; ?></p>
                    </div>
                </div>

                <div class="specs_info">
                    <img src="./layout/./img/smartphone-rotate-5-svgrepo-com 2.png" width="24px" height="24px" alt="">
                    <div class="specs_col">
                        <p><strong>Touchscreen:</strong></p>
                        <p><?php echo $product_data['detail'][0]['Touchscreen']; ?></p>
                    </div>
                </div>

                <div class="specs_info">
                    <img src="./layout/./img/smartphone-rotate-6-svgrepo-com 2.png" width="24px" height="24px" alt="">
                    <div class="specs_col">
                        <p><strong>Battery Capacity:</strong></p>
                        <p><?php echo $product_data['detail'][0]['battery_capacity']; ?></p>
                    </div>
                </div>

            </div>
            <p style="text-align: left;">Enhanced capabilities thanks toan enlarged display of 6.7 inchesand work
                without rechargingthroughout the
                day. Incredible photosas in weak, yesand in bright lightusing the new systemwith two cameras more...
            </p>

            <!-- Butoanele -->
            <div class="btn-col">
                <button class="specs_btn_white">Add to Wishlist</button>
                <button class="specs_btn" onclick="addToCart(<?php echo $product_id; ?>)">Add to Cart</button>
            </div>
        </div>

    </div>
</div>

</div>

<div class="viewport_details">
    <div class="details-container">
        <div class="tabel_me">
            <h2 class="detail_title">Details</h2>
            <p class="detail_info">Just as a book is judged by its cover, the first thing you notice when you pick
                up a
                modern smartphone is
                the display. Nothing surprising, because advanced technologies allow you to practically level the
                display frames and cutouts for the front camera and speaker, leaving no room for bold design
                solutions.
                And how good that in such realities Apple everything is fine with displays. Both critics and mass
                consumers always praise the quality of the picture provided by the products of the Californian
                brand.
                And last year's 6.7-inch Retina panels, which had ProMotion, caused real admiration for many.</p>

            <!-- Afișarea secțiunilor "Generale" și "Procesor" -->
            <?php foreach (["Generale", "Procesor"] as $section): ?>
            <div class="feature-section">
                <h3 class="detail_section_title"><?php echo $section; ?></h3>
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
                    <h3 class="detail_section_title"><?php echo $section; ?></h3>
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
            <!-- <img src="./layout/img/Expand_down_light.png" alt="View More Icon" style="width: 24px; height: 24px; "> -->
        </button>
    </div>

</div>



<div class="viewport_review">


    <div class="container_reviews">
        <div class="card_reviews">

            <div class="rating_container rating_con">
                <h1 class="">
                    <b><span id="average_rating"><?php echo $averageRating; ?></span></b>
                </h1>
                <p><span id="total_review">of <?php echo $totalReviews; ?></span> reviews</p>
                <div class="mb-3">
                    <?php for ($i = 1; $i <= 5; $i++): ?>
                    <i
                        class="fas fa-star <?php echo $i <= $averageRating ? 'text-warning' : 'star-light'; ?> mr-1 main_star"></i>
                    <?php endfor; ?>
                </div>
            </div>

            <div class="progress_container">
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


        <button type="button" name="add_review" id="add_review" data-toggle="modal" data-target="#reviewModal">
            Rate/Review This Product
        </button>

        <div class="comments_container" id="review_content">
            <?php if ($totalReviews > 0): 
                $setStars = [
                    5 => '⭐ ⭐ ⭐ ⭐ ⭐',
                    4 => '⭐ ⭐ ⭐ ⭐',
                    3 => '⭐ ⭐ ⭐',
                    2 => '⭐ ⭐',
                    1 => '⭐'
                ];
             ?>

            <div id="reviews-list" class="comments_list">
                <?php foreach ($reviews['data'] as $index => $review): ?>
                <div class="review" style="display: <?php echo $index < 3 ? 'block' : 'none'; ?>;">
                    <strong><?php echo htmlspecialchars($review['attributes']['user_name']); ?></strong>
                    <p><?php echo $setStars[$review['attributes']['user_rating']]; ?></p>
                    <p><?php echo htmlspecialchars($review['attributes']['user_review']); ?></p>
                    <small>Posted on: <?php echo htmlspecialchars($review['attributes']['datetime']); ?></small>
                </div>
                <?php endforeach; ?>
            </div>

            <?php if ($totalReviews > 3): ?>
            <button id="view-more-btn" class="toggle-btn" onclick="toggleReviews()">View More</button>
            <?php endif; ?>

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
                            <select name="rating" class="form-control" required>
                                <option value="5">5 Stars</option>
                                <option value="4">4 Stars</option>
                                <option value="3">3 Stars</option>
                                <option value="2">2 Stars</option>
                                <option value="1">1 Star</option>
                            </select>
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
</div>

</div>

<?php
  include $tpl . 'footer.php'; 
?>