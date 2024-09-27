<?php
// Datele extrase din JSON-ul furnizat
$features = [
    "Generale" => [
        "Producător" => "Samsung",
        "Greutate" => "202 g",
        "Cod model" => "A546",
        "Model" => "Galaxy A54",
        "Culoare" => "Black"
    ],
    "Procesor" => [
        "Model procesor" => "Exynos 1380",
        "Producător procesor" => "Samsung",
        "Frecvența maximă" => "2.4 GHz",
        "Nr. nuclee" => 8,
        "Tehnologie de fabricație" => "5 nm",
        "Model GPU" => "Mali-G68 MP5"
    ],
    "Display" => [
        "Diagonală display" => "6.4\"",
        "Densitate pixeli" => "411 ppi",
        "Always on Display" => "Da",
        "Refresh rate" => "120 Hz",
        "Rezoluție (px)" => "2400 x 1080",
        "Tip display" => "Super AMOLED"
    ],
    "Memorie" => [
        "Capacitatea maximă memorie adițională" => "1 TB",
        "Memorie internă" => "256 GB",
        "Memorie RAM" => "8 GB"
    ],
    "Conectivitate" => [
        "Bluetooth" => "Da",
        "Wi-fi" => "Da",
        "GPS" => "Da",
        "NFC" => "Da",
        "Conector USB" => "USB Type-C 2.0",
        "Port infraroșu" => "Nu",
        "Conector audio 3.5 mm" => "Nu",
        "Versiune Bluetooth" => "v5.3"
    ]
];
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product Details</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@100;200;300;400;500;600;700;800;900&display=swap"
        rel="stylesheet">
    <style>
    body {
        background: #FAFAFA;
    }

    .details-container {
        display: flex;
        justify-content: center;
        align-items: center;
        flex-direction: column;
        background-color: #ffffff;
        padding: 20px;
        border-radius: 8px;
        max-width: 800px;
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
        font-size: 20px;
        font-weight: bold;
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
    </style>
</head>

<body>

    <div class="details-container">
        <div class="tabel_me">
            <h2>Details</h2>

            <!-- Afișarea secțiunilor "Generale" și "Procesor" -->
            <?php foreach (["Generale", "Procesor"] as $section): ?>
            <div class="feature-section">
                <h3><?php echo $section; ?></h3>
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
                    <h3><?php echo $section; ?></h3>
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

    <script>
    document.getElementById('toggle-btn').addEventListener('click', function() {
        var hiddenSections = document.getElementById('hidden-sections');
        var isHidden = hiddenSections.style.display === 'none' || hiddenSections.style.display === '';

        // Schimbă între 'View More' și 'View Less'
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