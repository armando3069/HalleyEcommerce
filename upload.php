<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Extrage datele din formular
    $title = $_POST['title'];
    $description = $_POST['description'];

    // URL-ul API-ului Strapi pentru a crea o postare nouă
    $apiUrl = "http://localhost:1337/api/blogs";

    // Inițializează cURL pentru crearea postării
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $apiUrl);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POST, true);

    // Construcția payload-ului JSON
    $payload = [
        'data' => [
            'title' => $title,
            'Description' => $description,
        ]
    ];

    // Setează antetul pentru autentificare și tipul de conținut
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        'Authorization: Bearer f20539fd7ee5dc0910e0f92d3930ce23df348a86ec60a154ca663b324b70861a1ff70b64c998b1f161fd4576d0d3c703e4bc7677664266ae1308a4d858e4713489a1dcd8f4d7562258b9725b96ec5773e76f502b869ac6836debdb6706007df8210613d1a149bf6e8d8dbc41e7008b61a0303476fc9787b67c41bced280815d5',
        'Content-Type: application/json'
    ]);

    // Encodează payload-ul în JSON și setează-l ca postfield
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($payload));

    // Execută cererea pentru crearea postării
    $response = curl_exec($ch);
    if (curl_errno($ch)) {
        echo 'Error:' . curl_error($ch);
    } else {
        // Decodează răspunsul
        $result = json_decode($response, true);

        // Verifică dacă cererea a fost efectuată cu succes
        if (isset($result['data']['id'])) {
            $postId = $result['data']['id'];
            echo "Post created successfully with ID: " . $postId;

            // Dacă a fost încărcată o imagine, trimite o cerere pentru a o încărca
            if (!empty($_FILES['image']['tmp_name'])) {
                $imageUrl = "http://localhost:1337/api/upload";

                $imageData = new CURLFile($_FILES['image']['tmp_name'], $_FILES['image']['type'], $_FILES['image']['name']);

                $imagePostFields = [
                    'files' => $imageData,
                    'refId' => $postId, // ID-ul postării nou create
                    'ref' => 'blogs', // Colecția la care se atașează imaginea (corectată pentru colecția "blogs")
                    'field' => 'content_img' // Câmpul care va conține imaginea
                ];

                $chImage = curl_init();
                curl_setopt($chImage, CURLOPT_URL, $imageUrl);
                curl_setopt($chImage, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($chImage, CURLOPT_POST, true);
                curl_setopt($chImage, CURLOPT_POSTFIELDS, $imagePostFields);

                // Setează antetul pentru autentificare
                curl_setopt($chImage, CURLOPT_HTTPHEADER, [
                    'Authorization: Bearer f20539fd7ee5dc0910e0f92d3930ce23df348a86ec60a154ca663b324b70861a1ff70b64c998b1f161fd4576d0d3c703e4bc7677664266ae1308a4d858e4713489a1dcd8f4d7562258b9725b96ec5773e76f502b869ac6836debdb6706007df8210613d1a149bf6e8d8dbc41e7008b61a0303476fc9787b67c41bced280815d5'
                ]);

                $imageResponse = curl_exec($chImage);
                if (curl_errno($chImage)) {
                    echo 'Error uploading image: ' . curl_error($chImage);
                } else {
                    $imageResult = json_decode($imageResponse, true);
                    if (isset($imageResult['data'][0]['id'])) {
                        $imageId = $imageResult['data'][0]['id'];
                        echo "Image uploaded successfully with ID: " . $imageId;

                        // Actualizează postarea cu ID-ul imaginii
                        $updateUrl = "http://localhost:1337/api/blogs/$postId";
                        $updatePayload = [
                            'data' => [
                                'content_img' => $imageId
                            ]
                        ];

                        curl_setopt($chImage, CURLOPT_URL, $updateUrl);
                        curl_setopt($chImage, CURLOPT_CUSTOMREQUEST, "PUT");
                        curl_setopt($chImage, CURLOPT_POSTFIELDS, json_encode($updatePayload));
                        curl_setopt($chImage, CURLOPT_HTTPHEADER, [
                            'Authorization: Bearer f20539fd7ee5dc0910e0f92d3930ce23df348a86ec60a154ca663b324b70861a1ff70b64c998b1f161fd4576d0d3c703e4bc7677664266ae1308a4d858e4713489a1dcd8f4d7562258b9725b96ec5773e76f502b869ac6836debdb6706007df8210613d1a149bf6e8d8dbc41e7008b61a0303476fc9787b67c41bced280815d5',
                            'Content-Type: application/json'
                        ]);

                        $updateResponse = curl_exec($chImage);
                        if(curl_errno($chImage)) {
                            echo 'Error updating post: ' . curl_error($chImage);
                        } else {
                            echo "Post updated with image successfully!";
                        }
                    } else {
                        echo "Failed to upload image.";
                    }
                }
                curl_close($chImage);
            } else {
                echo "No image uploaded.";
            }
        } else {
            echo "Failed to create post.";
        }
    }
    curl_close($ch);
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create New Post</title>
    <link href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
    <script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/js/bootstrap.min.js"></script>
    <script src="//code.jquery.com/jquery-1.11.1.min.js"></script>
</head>

<body>
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <h1>Create a New Post</h1>
                <form action="" method="POST" enctype="multipart/form-data">
                    <div class="form-group">
                        <label for="title">Title <span class="require">*</span></label>
                        <input type="text" class="form-control" name="title" required>
                    </div>
                    <div class="form-group">
                        <label for="description">Description</label>
                        <textarea rows="5" class="form-control" name="description"></textarea>
                    </div>
                    <div class="form-group">
                        <label for="image">Upload Image:</label>
                        <input type="file" id="image" name="image">
                    </div>
                    <div class="form-group">
                        <button type="submit" class="btn btn-primary">Post</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>

</html>