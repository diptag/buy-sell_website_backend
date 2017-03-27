<?php
    // check if data has been found or not
    if (isset($msg))
    {
?>
    <h2><?= $msg."  ".$_GET["id"] ?></h2>
<?php
    }
    
    // else display product data
    else
    {
?>
    <div id="img-display">
        <img src="img/<?= $product["image"] ?>">
    </div><br>
    <div id="product-details">
        <h2><?= $product["name"] ?></h2>
        Sold By: <?= $_SESSION["name"] ?><br>
        Email: <?= $product["email"] ?><br><br>
        Category: <?= $product["category"] ?><br><br>
        Description: <?= $product["description"] ?><br><br>
        Price: Rs.<?= $product["price"] ?>
    </div>
<?php
    }
?>
