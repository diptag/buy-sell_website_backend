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
    <div id="search-criterias">
        <div class="criteria">
            <h3>CATEGORIES</h3><hr>
            <ul>
                <li><a href="store">All</a></li>
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
        </div>
        <div class="criteria">
            <h3>COLLEGES</h3><hr>
            <ul>
                <li><a href="store">All</a></li>
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
    </div>
    <div id="search_head"><h2><?= $search_head ?></h2></div>
    <table id="items">
        <?php
            // display products
            $n = 1; // variable to know when to start a new row
            foreach ($products as $product)
            {
                // if it is a start of a new row
                if ($n % 3 === 1)
                    echo "<tr>";
        ?>
                    <td>
                        <a href="product?id=<?= $product["id"] ?>">
                            <div class="store-img"><img src="img/<?= $product["image"] ?>"></div>
                            <strong><?= $product["name"] ?></strong><br>
                            Category: <?= $product["category"] ?><br>
                            College: <?= $product["college"] ?><br>
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
                        </a>    
                    </td>
        <?php
                if ($n % 3 === 0)
                    echo "</tr>";
                    
                // update variable
                $n++;
            }
            if (($n - 1) % 3 !== 0)
             echo "</tr>";
        ?>
    </table>
</div>