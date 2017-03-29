<form action="search.php">
    <input type="search" name="q" placeholder="Search">
    <label>Search by:</label>
    <select name="category" placeholder="Category">
        <option value="category">Category</option>
        <option value="college">College</option>
    </select>
    <input type="submit" value="Search">      
</form>
<div id="items-display">
    <div id="categories">
        <h4>Categories</h4><hr>
        <ul>
        <?php
            // set link to pages with products for each categories
            foreach ($categories as $category)
            {
        ?>
            <li><a href="store?category=<?= $category["id"] ?>"><?= $category["name"] ?></a></li>
        <?php
            }
        ?>
        </ul>
        <hr><hr>
        <h4>Colleges</h4><hr>
        <ul>
        <?php
            // set link to pages wtih products posted by user from a particular college
            foreach ($colleges as $college) 
            {
        ?>
        <li><a href="store?college=<?= $college["id"] ?>"><?= $college["name"] ?></a></li>
        <?php
            }
        ?>
        </ul>
    </div>
    <table id="items">
        <?php
            // display products
            $n = 1; // variable to know when to start a new row
            foreach ($products as $product)
            {
                // if it is a start of a new row
                if ($n/4 === 1)
                {
        ?>
                    <tr>
        <?php
                }
        ?>
                    <td>
                        <a href="product?id=<?= $product["id"] ?>">
                            <div class="store-img"><img src="img/<?= $product["image"] ?>"></div>
                            <strong><?= $product["name"] ?></strong><br>
                            Category: <?= $product["category"] ?><br>
                            Price: Rs. <?= $product["price"] ?>
                        </a>    
                    </td>
        <?php
                if ($n/4 === 1)
                {
        ?>
                    </tr>
        <?php
                }
                // update variable
                $n++;
            }
        ?>
    </table>
</div>
