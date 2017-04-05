<?php
    // check if data has been found or not
    if (isset($msg))
    {
?>
    <h2><?= $msg ?></h2>
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
        Seller: <?= $product["user_name"] ?><br>
        College: <?= $product["college"] ?><br>
        Email: <?= $product["email"] ?><br><br>
        Category: <?= $product["category"] ?><br><br>
        Description: <?= $product["description"] ?><br><br>
        Price: &#8377; <?= $product["price"] ?>
    </div>
<?php
    }
?>