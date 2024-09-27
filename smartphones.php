<?php
session_start();
$pageTitle = 'Homepage';
include 'init.php';

// Verifică dacă s-a selectat o categorie, baterie, tip ecran și preț maxim
$category = isset($_GET['category']) ? $_GET['category'] : null;
$battery = isset($_GET['battery']) ? $_GET['battery'] : [];
$screenType = isset($_GET['screen_type']) ? $_GET['screen_type'] : [];
$price = isset($_GET['price']) ? (int)$_GET['price'] : null;

// URL-ul API-ului Strapi cu filtrare pe categorie și smartphones
$queryParams = [];

// Filtru pentru categoria "smartphones"
$queryParams[] = 'filters[categories][$eq]=' . urlencode('smartphones');

if ($category) {
    $queryParams[] = 'filters[brand][$eq]=' . urlencode($category);
}

if (!empty($battery)) {
    $batteryFilters = array_map('urlencode', $battery);
    $queryParams[] = 'filters[battery][$in]=' . implode(',', $batteryFilters);
}

if (!empty($screenType)) {
    $screenTypeFilters = array_map('urlencode', $screenType);
    $queryParams[] = 'filters[screen_type][$in]=' . implode(',', $screenTypeFilters);
}

// Adăugarea filtrului de preț
if ($price !== null) {
    $queryParams[] = 'filters[price][$lte]=' . $price;  // Filtru pentru produsele cu preț mai mic sau egal cu valoarea selectată
}

// Crearea query string-ului
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
.accordion-button:not(.collapsed) {
    color: unset;
    background-color: unset;
    /* Dezactivează fundalul activ */
    box-shadow: unset;
    /* Elimină box-shadow-ul */
}

.accordion-item {
    color: var(--bs-accordion-color);
    background-color: var(--bs-accordion-bg);
    border: unset;
    border-bottom: var(--bs-accordion-border-width) solid var(--bs-accordion-border-color);
}


/* Containerul principal */
.smartphones_viewport_container {
    display: flex;
    justify-content: center;
    flex-direction: row;
    padding: 20px;
    position: relative;

}

/* Containerul pentru filtrare */
#smartphones_filter-container {
    padding: 20px;
    margin-right: 20px;
    width: 300px;
}

/* Stiluri pentru dropdown */
.smartphones_category-select {
    width: 100%;
    padding: 10px;
    border-radius: 5px;
    margin-bottom: 20px;
    font-size: 16px;
}

/*-------------- smartpones --------------------*/

.smartphones_products-container {
    display: flex;
    flex-wrap: wrap;
    gap: 20px;
    justify-content: space-evenly;

}

/* Stiluri pentru fiecare produs */
.smartphones_product-item {

    flex: 1 1 calc(33.333% - 20px);
    max-width: calc(33.333% - 20px);

    box-sizing: border-box;
}


@media (max-width: 951px) {
    .smartphones_product-item {
        flex: 1 1 calc(50% - 20px);
        /* 2 produse pe rând */
        max-width: calc(50% - 20px);
    }

    /* .smartphones_filter-container {
        width: 100%;
    } */
}




/* @media (max-width: 500px) {
    .smartphones_product-item {
        flex: 1 1 100%;
        max-width: 100%;
    }
} */







/* Stiluri pentru fiecare produs */
.smartphones_product-item {
    background-color: #f9f9f9;
    border: 1px solid #ddd;
    border-radius: 10px;
    padding: 20px;
    text-align: center;
    /* max-width: 250px; */
    width: 100%;
    height: 380px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    transition: transform 0.3s ease;
}

.smartphones_product-item:hover {
    transform: scale(1.05);
}

/* Stiluri pentru imagine */
.smartphones_product-image {
    width: 80%;
    height: auto;
    object-fit: contain;
    border-radius: 10px;
}

/* Titlul produsului */
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

@media (max-width: 1030px) {
    .viewport_container {
        flex-direction: column;
        justify-content: center;
        align-items: center;
    }
}

.btn_filter {
    background-color: black;
    color: #ffffff;
    font-family: 'Inter';
    font-size: 1rem;
    padding: 10px 20px;
    border: none;
    border-radius: 5px;
    margin-top: 20px;


}

.accordion-button {
    font-family: 'Inter';
    font-size: 1.1rem;
    font-weight: medium;
}

.hidden_filter {
    display: flex;
    justify-content: space-between;
    align-items: center;
    width: 150px;
    height: 50px;
    background: transparent;
    border: 1px solid black;
    border-radius: 5px;
    padding: 0px 10px;
    margin-bottom: 30px;
}

.hidden_txt {
    font-size: 0.9rem;
    font-family: 'Inter';
    font-weight: 400;
    display: flex;
    margin-top: 15px;

}

@media (max-width: 690px) {
    .smartphones_viewport_container {
        flex-direction: column;
        align-items: center;
    }


    #smartphones_filter-container {
        position: absolute;
        width: 100%;
        height: 100%;
        top: 0;
        background-color: white;

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
        font-size: 0.6rem;
    }
}

@media (min-width: 691px) {
    .hidden_filter {
        display: none;
    }
}
</style>


<div class="smartphones_viewport_container">

    <div class="hidden_filter" id="toggleButton">
        <p class="hidden_txt">Filters</p>
        <img class="hidden_img" src="./layout/img/filters.svg" alt="">
    </div>
    <!-- Containerul pentru filtrare -->
    <div class="smartphones_filter-container" id="smartphones_filter-container">

        <div class="hidden_filter" id="Close">
            <img class="hidden_img" src="./layout/img/arrow.svg" alt="">
            <p class="hidden_txt">Close</p>

        </div>

        <form method="GET" action="">
            <div class="accordion" id="filtersAccordion">

                <div class="accordion-item">
                    <h2 class="accordion-header" id="headingPriceRange">
                        <button class="accordion-button" type="button" data-bs-toggle="collapse"
                            data-bs-target="#collapsePriceRange" aria-expanded="true"
                            aria-controls="collapsePriceRange">
                            Price
                        </button>
                    </h2>

                    <div id="collapsePriceRange" class="accordion-collapse collapse show"
                        aria-labelledby="headingPriceRange" data-bs-parent="#filtersAccordion">
                        <div class="accordion-body">

                            <label for="priceRange">Price:</label>
                            <input type="range" id="priceRange" name="price" min="0" max="5000" step="50"
                                value="<?php echo isset($_GET['price']) ? $_GET['price'] : '5000'; ?>"
                                oninput="updatePriceDisplay()">
                            <span id="minPriceOutput"><?php echo isset($_GET['price']) ? $_GET['price'] : '5000'; ?>
                                USD</span>
                            <br>

                        </div>
                    </div>



                    <!-- 
                    <div id="collapsePriceRange" class="accordion-collapse collapse show"
                        aria-labelledby="headingPriceRange" data-bs-parent="#filtersAccordion">
                        <div class="accordion-body">
                            <label for="priceRange">Maximum Price:</label>
                            <input type="range" id="priceRange" name="price" min="0" max="5000" step="50"
                                value="<?php echo isset($_GET['price']) ? $_GET['price'] : '5000'; ?>"
                                oninput="updatePriceDisplay()">
                            <span id="priceOutput"><?php echo isset($_GET['price']) ? $_GET['price'] : '5000'; ?>
                                Lei</span>
                        </div>
                    </div> -->




                </div>
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


                <!-- Filtru pentru Capacitate procesor -->

                <div class="accordion-item">
                    <h2 class="accordion-header" id="headingProcesor">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                            data-bs-target="#collapseProcesor" aria-expanded="false" aria-controls="collapseProcesor">
                            Procesor
                        </button>
                    </h2>
                    <div id="collapseProcesor" class="accordion-collapse collapse" aria-labelledby="headingProcesor"
                        data-bs-parent="#filtersAccordion">
                        <div class="accordion-body">
                            <input type="checkbox" name="battery[]" value="4000mAh"
                                <?php if(isset($_GET['battery']) && in_array('4000mAh', $_GET['battery'])) echo 'checked'; ?>>
                            Snapdrogn 675<br>
                            <input type="checkbox" name="battery[]" value="5000mAh"
                                <?php if(isset($_GET['battery']) && in_array('5000mAh', $_GET['battery'])) echo 'checked'; ?>>
                            Exinos 2000<br>
                            <input type="checkbox" name="battery[]" value="6000mAh"
                                <?php if(isset($_GET['battery']) && in_array('6000mAh', $_GET['battery'])) echo 'checked'; ?>>
                            A15 Bionic<br>
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
                            data-bs-target="#collapseScreenType" aria-expanded="false"
                            aria-controls="collapseScreenType">
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
                    <button type="submit" class="btn_filter">Apply</button>
                </div>
            </div>
        </form>
    </div>

    <!-- Containerul pentru produse -->
    <div class="smartphones_products-container">
        <?php foreach ($products as $product): ?>
        <div class="smartphones_product-item">
            <?php if (isset($product['attributes']['image']['data'][0]['attributes']['url'])): ?>
            <img src="<?php echo 'http://localhost:1337' . $product['attributes']['image']['data'][0]['attributes']['url']; ?>"
                alt="<?php echo $product['attributes']['title']; ?>" class="smartphones_product-image">
            <?php endif; ?>
            <h1 class="smartphones_product-title"><?php echo $product['attributes']['title']; ?></h1>
            <p class="smartphones_product-price">$<?php echo $product['attributes']['price']; ?></p>
            <a href="smartphones_product.php?id=<?php echo $product['id']; ?>" class="smartphones_add-to-cart">Buy
                Now</a>
        </div>
        <?php endforeach; ?>
    </div>
</div>

<script>
document.querySelectorAll('.accordion-header').forEach(header => {
    header.addEventListener('click', () => {
        const body = header.nextElementSibling;
        body.classList.toggle('active');
    });
});


const container = document.getElementById('smartphones_filter-container');
const button = document.getElementById('toggleButton');

button.addEventListener('click', function() {
    if (container.style.display === 'none') {
        container.style.display = 'block'; // Afișează containerul
    } else {
        container.style.display = 'none'; // Ascunde containerul
    }
});


const container2 = document.getElementById('smartphones_filter-container');
const button2 = document.getElementById('Close');

button2.addEventListener('click', function() {
    container2.style.display = 'none'; // Afișează containerul
});


function checkWindowSize() {
    if (window.innerWidth > 690) {
        container.style.display = 'block'; // Afișează containerul dacă dimensiunea ecranului este mai mare de 690px
    } else if (container.style.display !== 'none') {
        container.style.display = 'block'; // Menține afișat dacă nu s-a făcut click pe buton
    }
}

// Ascultă la schimbarea dimensiunii ferestrei
window.addEventListener('resize', checkWindowSize);

// Verifică dimensiunea la încărcare
checkWindowSize();

function updatePriceDisplay() {
    var price = document.getElementById('priceRange').value;
    document.getElementById('priceOutput').innerText = price + " Lei";
}

$(document).ready(function() {
    $('#priceRange').slider({
        min: 0,
        max: 5000,
        step: 50,
        value: [500, 3500], // Interval implicit (min, max)
        tooltip: 'show'
    });
});
</script>
</div>
<?php
  include $tpl . 'footer.php'; 
?>