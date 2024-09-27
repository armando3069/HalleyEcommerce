<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $pageTitle ?></title>
    <!-- <link href="https://stackpath.bootstrapcdn.com/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet"> -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-slider/11.0.2/css/bootstrap-slider.min.css">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <!-- Include FontAwesome for star icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link rel="stylesheet" href="https://unpkg.com/aos@next/dist/aos.css" />

    <link
        href="https://fonts.googleapis.com/css2?family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&display=swap"
        rel="stylesheet">

    <link rel="stylesheet" href="<?php echo $css ?>index.css" />
    <link rel="stylesheet" href="<?php echo $css ?>product.css" />
    <link rel="stylesheet" href="<?php echo $css ?>shopping.css" />
    <link rel="stylesheet" href="<?php echo $css ?>smartphones.css" />

    <style>
    * {
        margin: 0;
    }

    .container-viewport {
        width: 100%;
        max-width: 1600px;
        margin: 0 auto;
        /* padding: 0 20px;  */
    }

    .navy {
        background-color: #ffff;
        width: 100%;
        padding: 20px;
    }

    .nav_container {
        width: 100%;
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-direction: row;

    }

    .left_side_nav {
        display: flex;
        justify-content: center;
        flex-direction: row;
    }

    .middle_side_nav {
        display: flex;
        justify-content: center;
        align-items: center;
        flex-direction: row;
        gap: 20px;
    }

    .middle_side_nav a {
        text-decoration: none;
        color: #000000;
    }

    .middle_side_nav a:hover {
        color: #8fcbff;
    }

    .middle_side_nav p {
        margin: 0;
        font-family: 'Inter';
        font-size: 1.2rem;
        font-weight: 600;
    }

    .navy .bi {
        font-size: 2rem;
        /* Dimensiune mare pentru iconițe */
        color: #000000;
        cursor: pointer;
    }

    .navy .bi:hover {
        color: #8fcbff;
    }

    .nav-link {
        color: #000000;
        font-size: 1rem;
        font-family: "Montserrat";
        font-weight: 600;
    }

    .nav-link:hover {
        color: #8fcbff;
    }

    .nav_img {
        width: 65px;
        height: 22px;
        cursor: pointer;
    }

    .hide_btn {
        display: none;
    }



    @media (max-width: 639px) {
        .hide_btn {
            display: block;
        }

        .middle_side_nav {
            /* display: none; */
            flex-direction: column;
            margin-bottom: 20px;
            margin-top: 20px;
        }

        .right_side_nav {
            /* display: none; */
        }

        .left_side_nav {
            width: 100%;
            justify-content: space-between;
        }

        .nav_container {
            flex-direction: column;
        }
    }
    </style>


</head>

<body>
    <!-- //chihai nicolae
//079988362 maldur sergiu -->
    <div class="container-viewport">

        <nav class="navy ">
            <div class="nav_container">
                <div class="left_side_nav">
                    <a href="../../Halley/index.php">
                        <img src="<?php echo $img; ?>/logo.png" class="nav_img" alt="">
                    </a>
                    <div class="hide_btn">
                        <i class="bi bi-list" id="hide_btn"></i>
                    </div>

                </div>

                <div class="middle_side_nav" id="middle_side">
                    <a href="./index.php">
                        <p>Home</p>
                    </a>
                    <a href="#category_ref">
                        <p>Category</p>
                    </a>
                    <a href="#category_ref">
                        <p>Contact Us</p>
                    </a>
                </div>

                <div class="right_side_nav" id="right_side">
                    <i class="bi bi-person me-3"></i>
                    <a href="../../Halley/shopping-cart.php"><i class="bi bi-cart2"></i></a>
                </div>

            </div>

        </nav>