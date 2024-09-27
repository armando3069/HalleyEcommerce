<?php
session_start();
$pageTitle = 'Homepage';
include 'init.php';

// Verifică dacă s-a selectat o categorie
$category = isset($_GET['category']) ? $_GET['category'] : null;
$battery = isset($_GET['battery']) ? $_GET['battery'] : [];
$screenType = isset($_GET['screen_type']) ? $_GET['screen_type'] : [];

// URL-ul API-ului Strapi cu filtrare pe categorie
$queryParams = [];

if ($category) {
    $queryParams[] = 'filters[categories][$eq]=' . urlencode($category);
}

if (!empty($battery)) {
    $batteryFilters = array_map('urlencode', $battery);
    $queryParams[] = 'filters[battery][$in]=' . implode(',', $batteryFilters);
}

if (!empty($screenType)) {
    $screenTypeFilters = array_map('urlencode', $screenType);
    $queryParams[] = 'filters[screen_type][$in]=' . implode(',', $screenTypeFilters);
}

$queryString = !empty($queryParams) ? '&' . implode('&', $queryParams) : '';
$url = "http://localhost:1337/api/products/?populate=*" . $queryString;

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
?>
<style>
/* Containerul principal */
.smartphones_viewport_container {
    display: flex;
    justify-content: center;
    flex-direction: row;
    padding: 20px;
}

/* Containerul pentru filtrare */
.smartphones_filter-container {
    padding: 20px;
    border-right: 1px solid #ddd;
    margin-right: 20px;
}

/* Stiluri pentru dropdown */
.smartphones_category-select {
    width: 100%;
    padding: 10px;
    border: 1px solid #ddd;
    border-radius: 5px;
    margin-bottom: 20px;
    font-size: 16px;
}

/* Containerul pentru produse */
.smartphones_products-container {
    display: flex;
    flex-wrap: wrap;
    gap: 20px;
    justify-content: space-evenly;
}

.smartphones_product-item {
    flex: 1 1 calc(25% - 20px);
    max-width: calc(25% - 20px);
    background-color: #f9f9f9;
    border: 1px solid #ddd;
    border-radius: 10px;
    padding: 20px;
    text-align: center;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    transition: transform 0.3s ease;
}

.smartphones_product-item:hover {
    transform: scale(1.05);
}

.smartphones_product-image {
    width: 100%;
    height: auto;
    object-fit: contain;
    border-radius: 10px;
}

.smartphones_product-title {
    font-size: 18px;
    margin: 15px 0;
    color: #333;
}

.smartphones_product-price {
    font-size: 22px;
    font-weight: bold;
    color: black;
}

.smartphones_add-to-cart {
    background-color: black;
    color: white;
    border: none;
    padding: 10px 20px;
    border-radius: 5px;
    cursor: pointer;
    margin-top: 10px;
    transition: background-color 0.3s ease;
}

.smartphones_add-to-cart:hover {
    background-color: #2980b9;
}

@media (max-width: 1280px) {
    .smartphones_product-item {
        flex: 1 1 calc(33.333% - 20px);
        max-width: calc(33.333% - 20px);
    }
}

@media (max-width: 951px) {
    .smartphones_product-item {
        flex: 1 1 calc(50% - 20px);
        max-width: calc(50% - 20px);
    }
}

@media (max-width: 690px) {
    .smartphones_viewport_container {
        flex-direction: column;
        align-items: center;
    }
}
</style>

<div class="smartphones_viewport_container">
    <!-- Containerul pentru filtrare -->
    <div class="smartphones_filter-container">
        <div class="accordion" id="filtersAccordion">
            <!-- Filtru pentru Brand -->
            <div class="accordion-item">
                <h2 class="accordion-header" id="headingBrand">
                    <button class="accordion-button" type="button" data-bs-toggle="collapse"
                        data-bs-target="#collapseBrand" aria-expanded="true" aria-controls="collapseBrand">
                        Brand
                    </button>
                </h2>
                <div id="collapseBrand" class="accordion-collapse collapse show" aria-labelledby="headingBrand"
                    data-bs-parent="#filtersAccordion">
                    <div class="accordion-body">
                        <div>
                            <input type="radio" id="all" name="category" value=""
                                <?php if(!isset($_GET['category']) || $_GET['category'] == '') echo 'checked'; ?>>
                            <label for="all">Toate</label>
                        </div>
                        <div>
                            <input type="radio" id="apple" name="category" value="Apple"
                                <?php if(isset($_GET['category']) && $_GET['category'] == 'Apple') echo 'checked'; ?>>
                            <label for="apple">Apple</label>
                        </div>
                        <div>
                            <input type="radio" id="samsung" name="category" value="Samsung"
                                <?php if(isset($_GET['category']) && $_GET['category'] == 'Samsung') echo 'checked'; ?>>
                            <label for="samsung">Samsung</label>
                        </div>
                        <div>
                            <input type="radio" id="xiaomi" name="category" value="Xiaomi"
                                <?php if(isset($_GET['category']) && $_GET['category'] == 'Xiaomi') echo 'checked'; ?>>
                            <label for="xiaomi">Xiaomi</label>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Filtru pentru Capacitate Baterie -->
            <div class="accordion-item">
                <h2 class="accordion-header" id="headingBattery">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                        data-bs-target="#collapseBattery" aria-expanded="false" aria-controls="collapseBattery">
                        Capacitate Baterie
                    </button>
                </h2>
                <div id="collapseBattery" class="accordion-collapse collapse" aria-labelledby="headingBattery"
                    data-bs-parent="#filtersAccordion">
                    <div class="accordion-body">
                        <input type="checkbox" name="battery[]" value="4000mAh"
                            <?php if(isset($_GET['battery']) && in_array('4000mAh', $_GET['battery'])) echo 'checked'; ?>>
                        4000mAh<br>
                        <input type="checkbox" name="battery[]" value="5000mAh"
                            <?php if(isset($_GET['battery']) && in_array('5000mAh', $_GET['battery'])) echo 'checked'; ?>>
                        5000mAh<br>
                        <input type="checkbox" name="battery[]" value="6000mAh"
                            <?php if(isset($_GET['battery']) && in_array('6000mAh', $_GET['battery'])) echo 'checked'; ?>>
                        6000mAh<br>
                    </div>
                </div>
            </div>

            <!-- Filtru pentru Tip Ecran -->
            <div class="accordion-item">
                <h2 class="accordion-header" id="headingScreenType">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                        data-bs-target="#collapseScreenType" aria-expanded="false" aria-controls="collapseScreenType">
                        Tip Ecran
                    </button>
                </h2>
                <div id="collapseScreenType" class="accordion-collapse collapse" aria-labelledby="headingScreenType"
                    data-bs-parent="#filtersAccordion">
                    <div class="accordion-body">
                        <input type="checkbox" name="screen_type[]" value="AMOLED"
                            <?php if(isset($_GET['screen_type']) && in_array('AMOLED', $_GET['screen_type'])) echo 'checked'; ?>>
                        AMOLED<br>
                        <input type="checkbox" name="screen_type[]" value="LCD"
                            <?php if(isset($_GET['screen_type']) && in_array('LCD', $_GET['screen_type'])) echo 'checked'; ?>>
                        LCD<br>
                    </div>
                </div>
            </div>

            <!-- Buton de filtrare -->
            <div class="filter-btn">
                <button type="submit" class="btn btn-primary mt-3">Filtrează</button>
            </div>
        </div>
    </div>

    <!-- Containerul pentru produse -->
    <div class="smartphones_products-container">
        <?php foreach ($products as $product) { ?>
        <div class="smartphones_product-item">
            <img class="smartphones_product-image"
                src="http://localhost:1337<?php echo $product['attributes']['image']['data']['attributes']['url']; ?>"
                alt="<?php echo $product['attributes']['title']; ?>">
            <h3 class="smartphones_product-title"><?php echo $product['attributes']['title']; ?></h3>
            <p class="smartphones_product-price"><?php echo $product['attributes']['price']; ?> Lei</p>
            <button class="smartphones_add-to-cart">Adaugă în coș</button>
        </div>
        <?php } ?>
    </div>
</div>

<?php include $tpl . 'footer.php'; ?>