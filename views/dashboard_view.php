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
                        <td><?= $product["name"] ?></td>
                        <td><?= $product["category"] ?></td>
                        <td>
                            &#8377; <?= $product["price"] ?>
                            
                            <!-- Modal Code reference w3schools.com -->
                            <!-- Trigger/Open Change Price Modal -->
                            <button id="price-change-btn" class="modal-btn">Change Price</button>
                                
                            <!-- The Modal -->
                            <div class="modal">
                                <!-- Modal content -->
                                <div id="price-change-modal" class="modal-content">
                                    <span class="close">&times;</span>
                                    Current Price: &#8377; <?= $product["price"] ?><br>
                                    <form class="price-change">
                                        New Price: &#8377; <input type="number" name="price" min="0" required><br>
                                        <input type="submit" value="Change Price">
                                    </form>
                                </div>
                            </div>
                        </td>
                        <td>
                        <?php
                            if ($product["sold"] === 'n')
                                echo "No";
                            else 
                                echo "Yes";
                        ?>
                        </td>
                    </tr>
            <?php
                    $n++;
                }
            ?>
        </table>
<?php
    }
?>