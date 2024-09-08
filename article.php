<?php
	//ob_start();
	session_start();
	$pageTitle = 'Homepage';
	include 'init.php';
?>


<!------------ Landing carousel----------->

<!-- <div id="carouselExampleIndicators" class="carousel slide" data-bs-ride="carousel"> -->
<!-- <ol class="carousel-indicators">
        <li data-bs-target="#carouselExampleIndicators" data-bs-slide-to="0" class="active"></li>
        <li data-bs-target="#carouselExampleIndicators" data-bs-slide-to="1"></li>
        <li data-bs-target="#carouselExampleIndicators" data-bs-slide-to="2"></li>
      </ol> -->
<!-- <div class="carousel-inner">
        <div class="carousel-item active">
            <img class="d-block w-100" src="<?php //echo $img; ?>/men_carousel.jpg" alt="First slide">
        </div>
        <div class="carousel-item">
            <img class="d-block w-100" src="<?php //echo $img; ?>/men_carousel2.jpg" alt="First slide">
        </div>
        <div class="carousel-item">
            <img class="d-block w-100" src="<?php //echo $img; ?>/men_carousel.jpg" alt="First slide">
        </div>
    </div>
    <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-bs-slide="prev">
        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
    </a>
    <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-bs-slide="next">
        <span class="carousel-control-next-icon" aria-hidden="true"></span>
    </a>
</div> -->

<!------------  Landing carousel----------->


<!------------ white space ----------->
<!-- <div class="space"> </div> -->
<!------------ white space----------->

<?php
// URL-ul API-ului Strapi
$url = 'http://localhost:1337/api/blogs?populate=*';

// Inițializează cURL
$ch = curl_init($url);

// Setează opțiunile cURL
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); 
curl_setopt($ch, CURLOPT_HTTPHEADER, [
    'Content-Type: application/json',
    'Authorization: Bearer f20539fd7ee5dc0910e0f92d3930ce23df348a86ec60a154ca663b324b70861a1ff70b64c998b1f161fd4576d0d3c703e4bc7677664266ae1308a4d858e4713489a1dcd8f4d7562258b9725b96ec5773e76f502b869ac6836debdb6706007df8210613d1a149bf6e8d8dbc41e7008b61a0303476fc9787b67c41bced280815d5'
]);

// Execută cererea și obține răspunsul
$response = curl_exec($ch);

// Verifică dacă au apărut erori
if ($response === false) {
    $error = curl_error($ch);
    curl_close($ch);
    die('cURL Error: ' . $error);
}

// Închide sesiunea cURL
curl_close($ch);

// Decodarea răspunsului JSON
$data = json_decode($response, true);

//print_r($data);

?>
<div class="custom-container mt-5">
    <?php foreach ($data['data'] as $item): ?>
    <?php
        // Extrage URL-ul imaginii medium
        $mediumImageUrl = '';
        if (isset($item['attributes']['content_img']['data']['attributes']['formats']['medium']['url'])) {
            $mediumImageUrl = 'http://localhost:1337' . $item['attributes']['content_img']['data']['attributes']['formats']['medium']['url'];
        }
        // Extrage ID-ul articolului
        $itemId = $item['id'];
        ?>
    <div class="custom-card mb-3">
        <div class="custom-card-body">
            <img src="<?php echo htmlspecialchars($mediumImageUrl); ?>" class="custom-card-img" alt="Image">
            <div class="custom-text-container">
                <!-- Link către pagina de detalii -->
                <a href="item-details.php?id=<?php echo htmlspecialchars($itemId); ?>"
                    class="custom-card-title titlul_content"><?php echo htmlspecialchars($item['attributes']['title']); ?></a>

                <!-- <p class="custom-card-description"><?php echo htmlspecialchars($item['attributes']['Description']); ?> -->
                </p>
            </div>
        </div>
    </div>
    <?php endforeach; ?>
</div>




<?php
  include $tpl . 'footer.php'; 
?>