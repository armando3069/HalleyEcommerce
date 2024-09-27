<?php
     include('./init.php');
    ?>

<div id="carouselExampleControls" class="carousel">
    <div class="carousel-inner">
        <?php
  			$allItems = getAllFrom('*', 'items', 'where CategoryID = 1', '', 'ItemID');
              foreach ($allItems as $item) {
             ?>
        <div class="carousel-item active">
            <div class="card">
                <div class="img-wrapper">
                    <img src="./assets/image/<?php echo $item['Picture'] ?>" class="d-block w-100" alt="...">
                </div>
                <div class="card-body">
                    <h5 class="card-title"><a href="items.php?itemid= <?php echo $item['itemID'];?>">
                            <?php echo $item['Name'];?>
                        </a>
                    </h5>
                    <h6 class="card-title">Price <?php echo $item['Price']?> MDL</h6>
                    <p class=" card-text"><?php echo $item['Description'] ?></p>
                </div>
            </div>
        </div>
        <?php
             }
            ?>
    </div>

    <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleControls" data-bs-slide="prev">
        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Previous</span>
    </button>
    <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleControls" data-bs-slide="next">
        <span class="carousel-control-next-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Next</span>
    </button>
</div>

<?php
  include $tpl . 'footer.php'; 
  ?>