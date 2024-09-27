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
$details = $product_data['detail'][0];
$features = $product_data['features'];
$image_url = $product_data['image']['data'][0]['attributes']['url'];
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $product_data['title']; ?></title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&display=swap"
        rel="stylesheet">
    <style>
    * {
        margin: 0;
    }

    /* /////////////////////Details///////////////////////////// */
    .viewport_details {
        margin-top: 50px;
        padding-top: 80px;
        padding-bottom: 80px;
        width: 100%;
        display: flex;
        justify-content: center;
        align-items: center;
        background-color: #FAFAFA;
    }

    .details-container {
        display: flex;
        justify-content: center;
        align-items: center;
        flex-direction: column;
        background-color: white;
        padding: 20px;
        border-radius: 8px;
        max-width: 1150px;
        margin: 0 auto;

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

    .detail_info {
        font-family: 'Inter';
        font-size: 0.9rem;
        color: #9D9D9D;
    }

    .detail_title {
        font-family: 'Inter';
        font-size: 1.5rem;
        color: black;
    }

    .detail_section_title {
        font-family: 'Inter';
        font-size: 1.25rem;
        font-weight: 500;
    }


    /* //////////////////////////Details////////////////////////////////////  */


    .viewport_container_product {
        width: 100%;
        display: flex;
        justify-content: center;
        align-items: center;
        margin-top: 50px;
    }

    /* Stiluri pentru detalii produs */
    .product-detail-container {
        /* max-width: 800px; */
        width: 100%;
        /* margin: 0 auto; */
        /* padding: 20px; */
        text-align: center;
        display: flex;
        justify-content: center;
        align-items: center;
        flex-direction: row;
    }

    .product-image {
        width: 500px;
        height: auto;
        object-fit: contain;
    }

    .product-title {
        font-size: 2rem;
        font-weight: bold;
    }

    .product-price {
        font-size: 1.6rem;
        font-weight: bold;
        color: black;
    }

    .colors-container {
        display: flex;
        justify-content: center;

    }

    .color-circle {
        width: 30px;
        height: 30px;
        border-radius: 50%;
        margin: 0 5px;
        border: 1px solid #ddd;
    }

    .color-circle.selected {
        border: 3px solid white;
        outline: 2px solid black;
    }


    /* memory container */
    .memory-container {
        display: flex;
        justify-content: center;
        gap: 16px;
    }


    .memory-item {
        padding: 10px;
        background-color: transparent;
        color: #6F6F6F;
        border-radius: 5px;
        width: 122px;
        height: 48px;
        cursor: pointer;
        border: 1px solid #D5D5D5;
    }


    .memory-item.selected {
        font-weight: bold;
        border: 1px solid black;
        color: black;
    }



    /* memory container */




    .specs-container {
        display: flex;
        justify-content: center;

        align-items: center;
        flex-wrap: wrap;
        text-align: left;
        gap: 16px;
    }

    .specs-container p {
        margin: 5px 0;
    }

    .specs_info {
        display: flex;
        flex-direction: row;
        justify-content: flex-start;
        align-items: center;
        background-color: #F4F4F4;
        width: 168px;
        height: 64px;
        border-radius: 7px;
        font-size: 14px;
        padding-left: 10px;
        gap: 5px;

    }



    .specs_col {
        /* display: flex;
        flex-direction: column;
        justify-content: center;
        margin: 0; */
        line-height: 0.8;
        font-family: "Inter", sans-serif;
    }

    .btn-col {
        width: 100%;
        display: flex;
        flex-direction: row;
        justify-content: center;
        gap: 16px;
    }

    .specs_btn {
        background: black;
        padding: 16px 56px;
        color: #ffffff;
        font-size: 1rem;
        border-radius: 6px;
        font-family: "Inter";
        line-height: 0.8;
        width: 100%;
        cursor: pointer;
    }

    .specs_btn_white {
        background-color: transparent;
        color: black;
        padding: 16px 56px;
        font-size: 1rem;
        border-radius: 6px;
        font-family: "Inter";
        line-height: 0.8;
        border: 1px solid black;
        width: 100%;
        cursor: pointer;

    }

    .main_container {
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: flex-start;
        max-width: 539px;
        gap: 24px;
    }

    @media (max-width: 1035px) {
        .product-detail-container {
            flex-direction: column;
        }

    }


    @media (max-width: 600px) {

        .main_container {
            /* align-items: center; */
            justify-content: space-between;
            max-width: 100%;
            width: 100%;
        }

        .memory-item {}

        .specs_info {
            width: 100%;
            flex: 1 1 calc(33.333% - 10px);
        }

        .memory-container {
            gap: 8px;
            width: 100%;
        }

        .specs-container {
            display: flex;
            justify-content: flex-start;
            align-items: center;
            flex-wrap: wrap;
            text-align: left;
            gap: 8px;
        }

        .product-image {
            width: 100%;
        }

        .btn-col {
            flex-direction: column;
        }

        .product-title {
            text-align: left;
        }

    }




    @media (max-width: 533px) {

        .main_container {
            /* align-items: center; */
            max-width: 100%;
            width: 100%;
        }

        .memory-item {
            /* width: 100%; */

        }

        .specs_info {
            width: 100%;
            flex: 1 1 calc(50% - 10px);
        }

        .memory-container {
            gap: 8px;
        }

        .specs-container {
            display: flex;
            justify-content: flex-start;
            align-items: center;
            flex-wrap: wrap;
            text-align: left;
            gap: 8px;
        }

        .product-image {
            width: 100%;
        }

        .btn-col {
            flex-direction: column;
        }

        .product-title {
            text-align: left;
        }

    }

    /* --------------------------------*/


    /* --------------------------------*/


    /* Alte stiluri aici */
    </style>
</head>

<body>
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
                        <img src="./layout/./img/smartphone-rotate-2-svgrepo-com 2.png" width="24px" height="24px"
                            alt="">
                        <div class="specs_col">
                            <p><strong>Screen Size:</strong></p>
                            <p><?php echo $product_data['detail'][0]['screen_size']; ?></p>
                        </div>
                    </div>

                    <div class="specs_info">
                        <img src="./layout/./img/smartphone-rotate-2-svgrepo-com 2.png" width="24px" height="24px"
                            alt="">
                        <div class="specs_col">
                            <p><strong>CPU:</strong></p>
                            <p><?php echo $product_data['detail'][0]['cpu']; ?></p>
                        </div>
                    </div>

                    <div class="specs_info">
                        <img src="./layout/./img/smartphone-rotate-3-svgrepo-com 2.png" width="24px" height="24px"
                            alt="">
                        <div class="specs_col">
                            <p><strong>Number of Cores:</strong></p>
                            <p><?php echo $product_data['detail'][0]['number_of_cores']; ?></p>
                        </div>
                    </div>

                    <div class="specs_info">
                        <img src="./layout/./img/smartphone-rotate-4-svgrepo-com 2.png" width="24px" height="24px"
                            alt="">
                        <div class="specs_col">
                            <p><strong>Main Camera:</strong></p>
                            <p><?php echo $product_data['detail'][0]['main_camera']; ?></p>
                        </div>
                    </div>

                    <div class="specs_info">
                        <img src="./layout/./img/smartphone-rotate-5-svgrepo-com 2.png" width="24px" height="24px"
                            alt="">
                        <div class="specs_col">
                            <p><strong>Front Camera:</strong></p>
                            <p><?php echo $product_data['detail'][0]['front_camera']; ?></p>
                        </div>
                    </div>

                    <div class="specs_info">
                        <img src="./layout/./img/smartphone-rotate-6-svgrepo-com 2.png" width="24px" height="24px"
                            alt="">
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


    <script>
    let selectedColor = '';
    let selectedMemory = '';

    function selectColor(color, index) {
        // Schimbă stilul pentru culoarea selectată
        document.querySelectorAll('.color-circle').forEach(el => el.classList.remove('selected'));
        document.getElementById(`color-${index}`).classList.add('selected');
        selectedColor = color;
    }

    function selectMemory(memory, index) {
        // Schimbă stilul pentru memoria selectată
        document.querySelectorAll('.memory-item').forEach(el => el.classList.remove('selected'));
        document.getElementById(`memory-${index}`).classList.add('selected');
        selectedMemory = memory;
    }

    function addToCart(productId) {
        let cart = JSON.parse(localStorage.getItem('cart')) || [];
        let existingProduct = cart.find(p => p.id === productId);

        if (existingProduct) {
            existingProduct.quantity += 1;
            existingProduct.selectedColor = selectedColor;
            existingProduct.selectedMemory = selectedMemory;
        } else {
            cart.push({
                id: productId,
                quantity: 1,
                selectedColor: selectedColor,
                selectedMemory: selectedMemory
            });
        }

        localStorage.setItem('cart', JSON.stringify(cart));
        alert('Product added to cart with color: ' + selectedColor + ' and memory: ' + selectedMemory);
    }

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