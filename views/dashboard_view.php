<?php
    if (count($products) === 0)
    {
?>
        <center><h1>You are yet to upload any product for selling.</h1></center>
<?php
    }
    else
    {
?>
        <center><h2>My Products</h2></center>
        <table id="user-products">
            <tr>
                <th>S. No.</th>
                <th>Title</th>
                <th>Category</th>
                <th>Price</th>
                <th>Sold</th>
            </tr>
            <?php
                
                $n = 1;     //variable for updating serial no.
                foreach ($products as $product)
                {
            ?>
                    <tr>
                        <td><?= $n ?></td>
                        <td><a href="product?id=<?= $product["id"] ?>"><?= $product["name"] ?></a></td>
                        <td><?= $product["category"] ?></td>
                        <td>
                            &#8377; <span><?= $product["price"] ?></span>
                            <!-- Trigger/Open Change Price Modal -->
                            <button class="modal-btn" value="<?= $product["id"] ?>">Change Price</button>
                        </td>
                        <td>
                            <span>
                                <?php
                                    if ($product["sold"] === 'n')
                                    {
                                ?>
                                        <button class="sold-btn" value="<?= $product["id"] ?>">Mark As Sold</button>    
                                <?php
                                    }
                                    else 
                                    {
                                        echo "Yes";
                                    }
                                ?>
                            </span>
                        </td>
                    </tr>
            <?php
                    $n++;
                }
            ?>
        </table>
        
        <!-- Modal Code reference w3schools.com -->
        <!-- The Modal -->
        <div id="price-change-modal" class="modal">
            <!-- Modal content -->
            <div class="modal-content">
                <span class="close">&times;</span><br>
                <form id="price-change-form">
                    Current Price: &#8377; <input type="text" name="old_price" readonly><br><br>
                    New Price: &#8377; <input type="number" name="new_price" min="0" required><br><br>
                    <button type="submit" name="product_id">Change Price</button>
                </form>
            </div>
        </div>
<?php
    }
?>