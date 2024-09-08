<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Extrage datele din formular
    $title = $_POST['title'];
    $description = $_POST['description'];
    $image = $_FILES['image'];

    // Tokenul de autentificare
    $authToken = "Bearer f20539fd7ee5dc0910e0f92d3930ce23df348a86ec60a154ca663b324b70861a1ff70b64c998b1f161fd4576d0d3c703e4bc7677664266ae1308a4d858e4713489a1dcd8f4d7562258b9725b96ec5773e76f502b869ac6836debdb6706007df8210613d1a149bf6e8d8dbc41e7008b61a0303476fc9787b67c41bced280815d5";

    // URL-ul API-ului Strapi pentru upload și creare postare
    $uploadUrl = "http://localhost:1337/api/upload";
    $postUrl = "http://localhost:1337/api/blogs";

    // Funcție pentru upload imagine și returnarea ID-ului
    function uploadImage($file, $uploadUrl, $authToken) {
        $ch = curl_init();
        $cfile = new CURLFile($file['tmp_name'], $file['type'], $file['name']);
        $data = array('files' => $cfile);

        curl_setopt($ch, CURLOPT_URL, $uploadUrl);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            "Authorization: $authToken",
            "Content-Type: multipart/form-data"
        ));

        $response = curl_exec($ch);
        curl_close($ch);

        $result = json_decode($response, true);

        if (isset($result[0]['id'])) {
            return $result[0]['id'];
        } else {
            return null;
        }
    }

    // 1. Upload Main Image
    $mainImageId = uploadImage($image, $uploadUrl, $authToken);

    // 2. Crearea postării
    $data = [
        'data' => [
            'title' => $title,
            'description' => $description,
            'content_img' => $mainImageId, // ID-ul imaginii încărcate
        ]
    ];

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $postUrl);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array(
        "Authorization: $authToken",
        "Content-Type: application/json"
    ));

    $response = curl_exec($ch);
    curl_close($ch);

    $result = json_decode($response, true);

    if (isset($result['data']['id'])) {
        echo "Post created successfully with ID: " . $result['data']['id'];
    } else {
        echo "Failed to create post.";
        echo "Error: " . $response;
    }
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

                <h1>Creaza un Articol</h1>

                <form action="" method="POST">


                    <div class="form-group">
                        <label for="title">Titlul <span class="require">*</span></label>
                        <input type="text" class="form-control" name="title" />
                    </div>

                    <div class="form-group">
                        <label for="description">Descrierea</label>
                        <textarea rows="5" class="form-control" name="description"></textarea>
                    </div>
                    <div>
                        <label for="image">Upload Content Image:</label>
                        <input type="file" id="image" name="image" require>
                    </div>

                    <div>
                        <label for="image">Upload gallery:</label>
                        <input type="file" id="gallery" name="gallery[]" multiple>
                    </div>

                    <div class="form-group">
                    </div>

                    <div class="form-group">
                        <button type="submit" class="btn btn-primary">
                            Posteaza
                        </button>
                        <a href="./index.php">
                            <button class="btn btn-default" href="./index.php">
                                Cancel
                            </button>
                        </a>
                    </div>

                </form>
            </div>

        </div>
    </div>
</body>

</html>