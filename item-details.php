<?php
// Verifică dacă există ID-ul în URL
if (isset($_GET['id'])) {
    $id = intval($_GET['id']);
    
    // URL-ul pentru cererea API
    $url = "http://localhost:1337/api/blogs/{$id}?populate=*";
    
    // Inițializează cURL
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    
    // Adaugă antetul pentru autentificare, dacă este necesar
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        'Authorization: Bearer f20539fd7ee5dc0910e0f92d3930ce23df348a86ec60a154ca663b324b70861a1ff70b64c998b1f161fd4576d0d3c703e4bc7677664266ae1308a4d858e4713489a1dcd8f4d7562258b9725b96ec5773e76f502b869ac6836debdb6706007df8210613d1a149bf6e8d8dbc41e7008b61a0303476fc9787b67c41bced280815d5',
        'Content-Type: application/json'
    ]);
    
    $response = curl_exec($ch);
    
    if(curl_errno($ch)) {
        echo 'Error:' . curl_error($ch);
    }
    
    curl_close($ch);
    
    // Decode JSON-ul răspunsului
    $data = json_decode($response, true);

    // Verifică dacă datele sunt valide
    if (isset($data['data'])) {
        $item = $data['data'];
        // Extrage URL-urile imaginilor din galerie
        $galleryImages = [];
        if (isset($item['attributes']['galery']['data'])) {
            foreach ($item['attributes']['galery']['data'] as $image) {
                // Verifică existența formatelor și a URL-urilor
                if (isset($image['attributes']['formats']['large']['url'])) {
                    $galleryImages[] = 'http://localhost:1337' . $image['attributes']['formats']['large']['url'];
                } elseif (isset($image['attributes']['url'])) {
                    $galleryImages[] = 'http://localhost:1337' . $image['attributes']['url'];
                }
            }
        }
    } else {
        $item = null;
        $galleryImages = [];
    }
} else {
    echo "No ID provided.";
    $item = null;
    $galleryImages = [];
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Item Details</title>
    <link rel="stylesheet" href="styles.css">
    <!-- Include CSS pentru Fancybox -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fancyapps/ui/dist/fancybox.css" />
    <style>
    .container {
        width: 1200px;
    }

    .containerViewport {
        width: 100%;
        display: flex;
        justify-content: center;

    }

    .image-text-wrap img {
        float: left;
        /* Aliniază imaginea la stânga */
        margin-right: 15px;
        /* Spațiu între imagine și text */
        margin-bottom: 15px;
        /* Spațiu jos pentru layout pe ecrane mici */
    }

    .card-text {
        text-align: justify;
        font-size: 1.2rem;
        /* Justifică textul pentru o prezentare mai plăcută */
    }

    .image-text-wrap:after {
        content: "";
        display: table;
        clear: both;
        /* Curăță flotările pentru a evita problemele de layout */
    }

    .relative_box {
        position: relative;
    }

    .hr_line {
        border-top: 2px solid #B91646;
        width: 100%;
    }

    .galery_box {
        background-color: #B91646;
        color: #ffff;
        font-size: 1.3rem;
        font-weight: 500;
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        padding: 5px 40px;
        width: 120px;
        text-align: center;
        position: relative;
        top: 10px;

    }



    /* 
    .gallery {
        display: flex;
        gap: 10px;
        flex-wrap: wrap;
        justify-content: space-between;
    }

    .gallery-item {
        flex: 1 1 calc(25% - 10px);
        max-width: calc(25% - 10px);
        box-sizing: border-box;
    }

    .gallery-item img {
        width: 100%;
        height: 200px;
        object-fit: cover;
        display: block;
        float: left;
        margin: 5px;
    }
 */

    /* .gallery {
        display: flex;
        flex-wrap: wrap;
        gap: 10px;

    }

    .gallery-item {
        flex: 1 1 calc(33.333% - 10px);

    }

    .gallery-item img {
        width: 100%;
        height: 200px;
        object-fit: cover;
        display: block;
    }

    @media (max-width: 950px) {
        .gallery-item {
            flex: 1 1 calc(33.333% - 10px);

        }
    }

    @media (max-width: 600px) {
        .gallery-item {
            flex: 1 1 calc(50% - 10px);

        }
    } */


    .gallery {
        display: flex;
        flex-wrap: wrap;
        gap: 10px;
        margin-top: 20px;
    }

    .gallery-item {
        flex: 1 1 calc(25% - 10px);
    }

    .gallery-item img {
        max-width: 300px;
        width: 100%;
        height: 200px;
        object-fit: cover;
        display: block;
    }

    @media (max-width: 950px) {
        .gallery-item {
            flex: 1 1 calc(33.333% - 10px);
        }
    }

    @media (max-width: 875px) {
        .gallery-item {
            flex: 1 1 calc(50% - 10px);
        }

        .gallery-item img {
            width: 100%;
            max-width: 500px;

        }
    }


    @media (max-width: 500px) {
        .gallery-item {
            flex: 1 1 100%;
        }

        .gallery-item img {
            width: 100%;
            height: 300px;
            max-width: 500px;

        }
    }
    </style>
</head>

<body>
    <div class="containerViewport">
        <div class="container mt-5">
            <?php if ($item): ?>
            <div class="card mb-3">
                <div class="row g-0">
                    <div class="col-md-4">
                        <?php
                    // Extrage URL-ul imaginii thumbnail
                    $thumbnailUrl = '';
                    if (isset($item['attributes']['content_img']['data']['attributes']['formats']['large']['url'])) {
                        $thumbnailUrl = 'http://localhost:1337' . $item['attributes']['content_img']['data']['attributes']['formats']['large']['url'];
                    }
                    ?>

                    </div>
                    <div class="col-md-8">
                        <div class="card-body">


                            <h1 class="card-title">
                                <?php echo htmlspecialchars($item['attributes']['title']); ?>
                            </h1>

                            <!-- Imaginea și textul înfășurat în jurul imaginii -->
                            <div class="image-text-wrap">
                                <img src="<?php echo htmlspecialchars($thumbnailUrl); ?>" width="300px" height="300px"
                                    class="img-fluid rounded-start float-left" alt="Thumbnail">
                                <p class="card-text"><?php echo htmlspecialchars($item['attributes']['Description']); ?>
                                </p>
                            </div>
                            <!-- Galerie imagini -->
                            <?php if (!empty($galleryImages)): ?>
                            <div class="relative_box">
                                <div class="galery_box">
                                    Galerie foto
                                </div>
                                <hr class="hr_line">
                            </div>
                            <div class="gallery mt-3">
                                <?php foreach ($galleryImages as $galleryImage): ?>
                                <div class="gallery-item">
                                    <a href="<?php echo htmlspecialchars($galleryImage); ?>" data-fancybox="gallery">
                                        <img src="<?php echo htmlspecialchars($galleryImage); ?>" class="img-fluid"
                                            alt="Gallery Image">
                                    </a>
                                </div>
                                <?php endforeach; ?>
                            </div>
                            <?php endif; ?>
                        </div>

                    </div>
                </div>
            </div>
        </div>
        <?php else: ?>
        <p>Item not found.</p>
        <?php endif; ?>
    </div>
    </div>
    <!-- Include JS pentru Fancybox -->
    <script src="https://cdn.jsdelivr.net/npm/@fancyapps/ui/dist/fancybox.umd.js"></script>
</body>

</html>