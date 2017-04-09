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
        Seller Contact: <?= $product["contact"] ?><br>
        College: <?= $product["college"] ?><br><br>
        Category: <?= $product["category"] ?><br><br>
        Description: <?= $product["description"] ?><br><br>
        Price:
        <?php 
            if (intval($product["price"]) === 0)
            {
                echo "On Donation";
            }
            else
            {
        ?>
            &#8377; <?= $product["price"] ?>
        <?php
            }
        ?>
        <br><br>
        <a href="store?seller=<?= $product["user_id"] ?>">View other products from this user.</a>
    </div>
<?php
    }
?>