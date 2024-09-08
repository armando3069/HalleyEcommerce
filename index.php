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
<div class="space"> </div>
<!------------ white space----------->




<?php
  include $tpl . 'footer.php'; 
?>