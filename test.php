<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <style>
    .carousel-inner {
        padding: 1em;
    }

    .card {
        margin: 0 0.5em;
        box-shadow: 2px 6px 8px 0 rgba(22, 22, 26, 0.18);
        border: none;
        height: 600px;
    }

    .carousel-control-prev,
    .carousel-control-next {
        background-color: #e1e1e1;
        width: 6vh;
        height: 6vh;
        border-radius: 50%;
        top: 50%;
        transform: translateY(-50%);
    }

    @media (min-width: 977px) {
        .carousel-item {
            margin-right: 0;
            flex: 0 0 33.333333%;
            display: block;
        }

        .carousel-inner {
            display: flex;
        }
    }

    .card .img-wrapper {
        max-width: 100%;
        height: 30em;
        display: flex;
        justify-content: center;
        align-items: center;
    }

    .card img {
        max-height: 100%;
    }

    @media (max-width: 767px) {
        .card .img-wrapper {
            height: 17em;
        }
    }

    @media (min-width: 768px) {
        .carousel-item {
            margin-right: 0;
            flex: 0 0 50%;
            display: block;
        }

        .carousel-inner {
            display: flex;
        }
    }
    </style>
</head>

<body>
    <?php  
       $start = 0;
    ?>
    <div id="carouselExampleControls" class="carousel">
        <div class="carousel-inner">

            <?php

            // Buclă for
            for ($i = $start; $i < 4; $i++) {
   
                echo'<div class="carousel-item active">';
                echo'<div class="card">';
                    echo'<div class="img-wrapper"><img src="./assets/image/img_0'.$i.'.jpeg" class="d-block w-100" alt="...">';
                echo  '</div>';
                    echo'<div class="card-body">';
                        echo'<h5 class="card-title">Card title 1</h5>';
                        echo '<p class="card-text">Some quick example text to build on the card title and make up the bulk</p>';
                        echo '<a href="#" class="btn btn-primary">Go somewhere</a>';
                    echo'</div>';
                echo'</div>';
            echo'</div>';
            
            } 
            
            ?>
            <!-- 
            <div class="carousel-item active">
                <div class="card">
                    <div class="img-wrapper"><img src="./assets/image/img_01.jpeg" class="d-block w-100" alt="...">
                    </div>
                    <div class="card-body">
                        <h5 class="card-title">Card title 1</h5>
                        <p class="card-text">Some quick example text to build on the card title and make up the bulk
                            of
                            the
                            card's content.</p>
                        <a href="#" class="btn btn-primary">Go somewhere</a>
                    </div>
                </div>
            </div>

            <div class="carousel-item">
                <div class="card">
                    <div class="img-wrapper"><img src="./assets/image/img_02.jpeg" class="d-block w-100" alt="...">
                    </div>
                    <div class="card-body">
                        <h5 class="card-title">Card title 2</h5>
                        <p class="card-text">Some quick example text to build on the card title and make up the bulk
                            of
                            the
                            card's content.</p>
                        <a href="#" class="btn btn-primary">Go somewhere</a>
                    </div>
                </div>
            </div>
            <div class="carousel-item">
                <div class="card">
                    <div class="img-wrapper"><img src="./assets/image/img_03.jpeg " class="d-block w-100" alt="...">
                    </div>
                    <div class="card-body">
                        <h5 class="card-title">Card title 3</h5>
                        <p class="card-text">Some quick example text to build on the card title and make up the bulk
                            of
                            the
                            card's content.</p>
                        <a href="#" class="btn btn-primary">Go somewhere</a>
                    </div>
                </div>
            </div>
            <div class="carousel-item">
                <div class="card">
                    <div class="img-wrapper"><img src="./assets/image/img_04.jpeg" class="d-block w-100" alt="...">
                    </div>
                    <div class="card-body">
                        <h5 class="card-title">Card title 4</h5>
                        <p class="card-text">Some quick example text to build on the card title and make up the bulk
                            of
                            the
                            card's content.</p>
                        <a href="#" class="btn btn-primary">Go somewhere</a>
                    </div>
                </div>
            </div>
            <div class="carousel-item">
                <div class="card">
                    <div class="img-wrapper"><img src="./assets/image/img_05.jpg" class="d-block w-100" alt="...">
                    </div>
                    <div class="card-body">
                        <h5 class="card-title">Card title 5</h5>
                        <p class="card-text">Some quick example text to build on the card title and make up the bulk
                            of
                            the
                            card's content.</p>
                        <a href="#" class="btn btn-primary">Go somewhere</a>
                    </div>
                </div>
            </div>

            <div class="carousel-item">
                <div class="card">
                    <div class="img-wrapper"><img src="./assets/image/img_06.jpeg" class="d-block w-100" alt="...">
                    </div>
                    <div class="card-body">
                        <h5 class="card-title">Card title 5</h5>
                        <p class="card-text">Some quick example text to build on the card title and make up the bulk
                            of
                            the
                            card's content.</p>
                        <a href="#" class="btn btn-primary">Go somewhere</a>
                    </div>
                </div>
            </div>

            <div class="carousel-item">
                <div class="card">
                    <div class="img-wrapper"><img src="./assets/image/img_07.jpeg" class="d-block w-100" alt="...">
                    </div>
                    <div class="card-body">
                        <h5 class="card-title">Card title 5</h5>
                        <p class="card-text">Some quick example text to build on the card title and make up the bulk
                            of
                            the
                            card's content.</p>
                        <a href="#" class="btn btn-primary">Go somewhere</a>
                    </div>
                </div>
            </div>

            <div class="carousel-item">
                <div class="card">
                    <div class="img-wrapper"><img src="./assets/image/img_08.jpeg" class="d-block w-100" alt="...">
                    </div>
                    <div class="card-body">
                        <h5 class="card-title">Card title 5</h5>
                        <p class="card-text">Some quick example text to build on the card title and make up the bulk
                            of
                            the
                            card's content.</p>
                        <a href="#" class="btn btn-primary">Go somewhere</a>
                    </div>
                </div>
            </div> -->

            <!-- Continuă cu mai multe carduri dacă este necesar -->
        </div>

        <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleControls"
            data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Previous</span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleControls"
            data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Next</span>
        </button>
    </div>

    <!-- Scripturi plasate la sfârșit pentru a evita problemele de încărcare -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js"></script>
    <script>
    var multipleCardCarousel = document.querySelector("#carouselExampleControls");

    if (window.matchMedia("(min-width: 768px)").matches) {
        var carousel = new bootstrap.Carousel(multipleCardCarousel, {
            interval: false,
        });
        var carouselWidth = $(".carousel-inner")[0].scrollWidth;
        var cardWidth = $(".carousel-item").width();
        var scrollPosition = 0;

        $("#carouselExampleControls .carousel-control-next").on("click", function() {
            if (scrollPosition < carouselWidth - cardWidth * 4) {
                scrollPosition += cardWidth;
                $("#carouselExampleControls .carousel-inner").animate({
                        scrollLeft: scrollPosition
                    },
                    600
                );
            }
        });

        $("#carouselExampleControls .carousel-control-prev").on("click", function() {
            if (scrollPosition > 0) {
                scrollPosition -= cardWidth;
                $("#carouselExampleControls .carousel-inner").animate({
                        scrollLeft: scrollPosition
                    },
                    600
                );
            }
        });
    } else {
        $(multipleCardCarousel).addClass("slide");
    }
    </script>
</body>

</html>