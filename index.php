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
<style>
.landing_viewport {
    width: 100%;
    display: flex;
    justify-content: center;
    background-color: #383836;
}

.landing_part {
    display: flex;
    flex-direction: row;
    justify-content: space-between;
    align-items: center;
    width: 1120px;
    background-color: #383836;
}

.landing_container {
    display: flex;
    flex-direction: column;
}

.landing_title {
    font-size: 96px;
    font-family: 'Inter';
    font-weight: 100;
    color: white;
}

.span_title {
    font-family: 'Inter';
    font-weight: 600;
}

.landing_subtitle {
    color: #909090;
    font-family: 'Inter';
}

.landing_btn {
    border: 1px solid white;
    border-radius: 6px;
    font-family: 'Inter';
    font-weight: medium;
    color: white;
    font-size: 1rem;
    height: 54px;
    width: 200px;
    background-color: transparent;
    cursor: pointer;

}


.macbook_btn {
    border: 1px solid black;
    border-radius: 6px;
    font-family: 'Inter';
    font-weight: medium;
    color: black;
    font-size: 1rem;
    height: 54px;
    width: 200px;
    background-color: transparent;
    cursor: pointer;
}


.gadges_viewport {
    width: 100%;
    display: flex;
    justify-content: center;

}

.gadges_container {
    display: flex;
    flex-direction: row;
    width: 100%;
}

.macbook_cont {
    padding-left: 100px;
    display: flex;
    justify-content: space-between;
    align-items: center;
    position: relative;
    background-color: #EDEDED;
    width: 100%;
}

.macbook_title {
    font-size: 80px;
    font-family: 'Inter';
    font-weight: 10;
    line-height: 0.9;
}

.macbook_span {
    font-family: 'Inter';
    font-weight: 600;

}

.subtitle {
    color: #909090;
    font-size: 1.1rem;
}

.macbook_text {
    width: 400px;
}

.macbook_img {
    position: relative;
    /* background-image: url('./layout/img/Macbook_crop.svg');
    background-repeat: no-repeat;
    width: 100%;
    height: 100%; */
}


.device_cont {
    display: flex;
    flex-direction: column;

    width: 100%;
}

.playstation_cont {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding-right: 100px;

}

.playstation_text {
    width: 400px;
    font-family: 'Inter';

}

.playstation_title {
    font-size: 3rem;
}


.playstation_cont img {
    width: 60%;
}


.apple_cont {
    display: flex;
    flex-direction: row;
}

.applePods_cont {
    display: flex;
    justify-content: space-between;
    align-items: center;
    background-color: #EDEDED;
    flex-direction: row;
    width: 100%;

}

.apple_title {
    color: white;
    font-family: 'Inter';
    font-weight: 100;

}



.apple_title_black {
    color: black;
    font-family: 'Inter';
    font-weight: 100;

}


.apple_title_span {
    font-family: 'Inter';
    font-weight: 600;
}

.appleVisionPro_cont {
    display: flex;
    justify-content: space-between;
    flex-direction: row;
    align-items: center;
    background-color: #353535;
    width: 100%;

}

.link_decoration {
    text-decoration: none;
    color: white;
}

.link_decoration:hover {
    text-decoration: none;
    color: white;
}

.link_decoration:active {
    text-decoration: none;
    color: white;
}

@media (max-width: 1159px) {
    .gadges_container {
        flex-direction: column;
    }
}


@media (max-width: 956px) {
    .apple_cont {
        flex-direction: column;
    }

    .landing_part {
        flex-direction: column;
        margin-top: 50px;
    }

}

@media (max-width: 1392px) {
    .macbook_text {
        width: 100%;
    }

    .macbook_cont {
        padding-left: 50px;

    }

    .playstation_title {
        font-size: 2.1rem;
    }

    .playstation_cont img {
        width: 45%;
    }
}

/* /////////////////////////////////////////////////////////////////////////////////////// */
@media (max-width: 430px) {
    .playstation_text {
        width: 100%;
    }

}

@media (max-width: 700px) {

    .landing_title {
        font-size: 72px;
        text-align: center;
    }


    .landing_container {
        flex-direction: column;
        align-items: center;
        text-align: center;
    }

    .playstation_cont {
        flex-direction: column;
        padding: 30px 0;
    }

    .playstation_text {
        display: flex;
        justify-content: center;
        align-items: center;
        flex-direction: column;
        text-align: center;

    }



    .playstation_cont img {
        width: 300px;
        padding-top: 30px;
    }

    .appleVisionPro_cont {
        flex-direction: column;

    }

    .applePods_text {
        display: flex;
        justify-content: center;
        align-items: center;
        flex-direction: column;
        font-size: 34px;
        padding-bottom: 30px;
        color: black;
    }

    .applePods_cont {
        flex-direction: column;
    }

    .landing_part img {
        width: 80%;
    }



    .macbook_cont {
        flex-direction: column-reverse;
        align-items: center;
        padding: 30px 0;

    }

    .macbook_text {
        display: flex;
        align-items: center;
        justify-content: center;
        flex-direction: column;
        width: 350px;
        text-align: center;
    }

    .macbook_title {
        font-size: 50px;
    }
}


/* //////////////////////////////////////////////////////////////////////// */
/* Styles Category  */
/* //////////////////////////////////////////////////////////////////////// */
.viewport_category {
    width: 100%;
    display: flex;
    justify-content: center;
    align-items: center;
    flex-direction: column;
    background-color: #FAFAFA;
}

.category_container {
    display: flex;
    justify-content: center;
    align-items: center;
    flex-direction: column;
    max-width: 1120px;
    width: 100%;
    gap: 32px;
    padding: 80px 20px;
}

.category_container a:hover,
a:visited,
a:link,
a:active {
    text-decoration: none;
    color: black;
}

.category_item_title {
    display: flex;
    width: 100%;
}

.category_item {
    display: flex;
    justify-content: center;
    align-items: center;
    flex-direction: column;
    width: calc(13% - 0px);
    /* Implicit, 3 pe rând */
    height: 128px;
    border: none;
    border-radius: 15px;
    background-color: #EDEDED;
}

.category_items {
    display: flex;
    justify-content: center;
    flex-direction: row;
    flex-wrap: wrap;
    gap: 32px;
    width: 100%;

}

.category_item p {
    margin: 0;
}


.category_item_txt {
    display: flex;
    flex-direction: column;
    margin: 0;

}

/* La ecrane de 1160px, afișează 3 elemente */
@media (max-width: 1160px) {
    .category_item {
        width: calc(33.33% - 32px);
        /* 3 pe rând */
    }
}

/* La ecrane de 700px, afișează 2 elemente */
@media (max-width: 700px) {
    .category_item {
        width: calc(50% - 32px);
        /* 2 pe rând */
    }

    .category_items {
        gap: 16px;
    }
}

/* La ecrane mai mici, afișează un element pe rând */
/* @media (max-width: 500px) {
    .category_item {
        width: 100%;
    }
} */






/* //////////////////////////////////////////////////////////////////////// */
/* Styles Category  */
/* //////////////////////////////////////////////////////////////////////// */
</style>
</div>

<div class="landing_viewport">
    <div class="landing_part">
        <div class="landing_container">
            <h2 class="landing_subtitle">Pro.Beyond</h2>
            <h1 class="landing_title">IPhone 14<span class="span_title"> Pro</span></h1>
            <h5 class="landing_subtitle">Created to change everything for the better. For everyone</h5>
            <button class="landing_btn"> <a class="link_decoration" href="./smartphones_product.php?id=4">Shop
                    Now</a></button>
        </div>
        <img src="./layout/img/Iphone Image.png" alt="">
    </div>
</div>




<div class="gadges_viewport">

    <div class="gadges_container">



        <div class="device_cont">

            <div class="playstation_cont">
                <img src="./layout/img/PlayStation_crop.svg" id="playstation" alt="">
                <div class="playstation_text">
                    <h1 class="playstation_title">Playstation 5</h1>
                    <p class="subtitle">Incredibly powerful CPUs, GPUs, and an SSD with integrated I/O will redefine
                        your PlayStation
                        experience.</p>
                </div>
            </div>


            <div class="apple_cont">
                <div class="applePods_cont">
                    <img src="./layout/img/hero__gnfk5g59t0qe_xlarge_2x 1_crop.svg" id="airpods" alt="">
                    <div class="applePods_text">
                        <h1 class="apple_title_black">Apple
                            AirPods <span class="apple_title_span">Max</span></h1>
                        <p class="subtitle">Computational audio. Listen, it's powerful</p>
                    </div>

                </div>

                <div class="appleVisionPro_cont">
                    <img src="./layout/img/image 36_crop.svg" id="vision" alt="">
                    <div class="applePods_text">
                        <h1 class="apple_title">Apple
                            Vision <span class="apple_title_span">Pro</span></h1>
                        <p class="subtitle">Computational audio. Listen, it's powerful</p>
                    </div>
                </div>
            </div>

        </div>



        <div class="macbook_cont">
            <div class="macbook_text">
                <h1 class="macbook_title">Macbook <span class="macbook_span">Air</span></h1>
                <p class="subtitle">The new 15‑inch MacBook Air makes room for more of what you love with a spacious
                    Liquid Retina
                    display.
                </p>
                <button class="macbook_btn">Shop Now</button>
            </div>
            <img src="./layout/img/MacBook_crop.svg" class="macbook_img" id="macbook_img" alt="">
        </div>


    </div>

</div>
<!------------ white space ----------->
<!-- <div class="space"> </div> -->
<!------------ white space----------->

<div class="viewport_category">

    <div class="category_container" id="category_ref">
        <div class="category_item_title">
            <h3>Browse By Category</h3>
        </div>
        <div class="category_items">


            <!-- <div class="category_item"> -->
            <a href="./smartphones.php" class="category_item">
                <img src="./layout/img/icon/Phones.svg" alt="">
                <p>Phones</p>
            </a>
            <!-- </div> -->



            <a href="./watch.php" class="category_item">
                <img src="./layout/img/icon/Smart Watches.svg" alt="">
                <p>Smart Watches</p>
            </a>


            <div class="category_item">
                <img src="./layout/img/icon/Cameras.svg" alt="">
                <p>Cameras</p>
            </div>

            <div class="category_item">
                <img src="./layout/img/icon/Headphones.svg" alt="">
                <p>Headphones</p>
            </div>

            <div class="category_item">
                <img src="./layout/img/icon/Computers.svg" alt="">
                <p>Computers</p>
            </div>

            <div class="category_item">
                <img src="./layout/img/icon/Gaming.svg" alt="">
                <p>Gaming</p>
            </div>
        </div>


    </div>
</div>

<!------------ white space ----------->
<div class="space"> </div>
<!------------ white space----------->




<div class="banner">
    <img src="./layout/img/Banner 2.svg" width="100%" alt="">
</div>

</div>


<?php
  include $tpl . 'footer.php'; 
?>