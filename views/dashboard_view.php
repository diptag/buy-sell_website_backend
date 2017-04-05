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
                        <td><?= $product["price"] ?></td>
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