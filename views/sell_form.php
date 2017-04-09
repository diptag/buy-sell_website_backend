 <?php
    if (isset($error_msg))
    {
?>
        <div class="error-msg"><?= $error_msg ?></div>
<?php
    }
?>
<form action="sell" method="POST" enctype="multipart/form-data">
    Name: <br><input type="text" name="name" placeholder="Min 4 characters" required><br><br>
    Category: <br>
    <select name="category_id">
            <option value="0" selected disabled>--Select Category--</option>
        <?php
            foreach($categories as $category)
            {
        ?>
            <option value="<?= $category["id"] ?>"><?= $category["name"] ?></option>
        <?php
            }
        ?>
    </select><br><br>
    Description: <br><textarea cols="30" rows="5" maxlength="255" name="description" placeholder="Max lenght 255 characters" required></textarea><br><br>
    Contact Information:<br><textarea cols="30" rows="3" maxlength="255" name="contact" placeholder="Min 4 characters" required></textarea><br><br>
    <input type="radio" name="sell_type" value="sell" checked>Sell <input type="radio" name="sell_type" value="donate">Donate<br>
    Price: <br>&#8377; <input type="number" name="price" min="1" required><br><br>
    Image: (Image should be of JPEG, JPG, PNG and GIF formats and size &lt; 1MB)<br>
    <input type="file" name="image_upload" required><br><br>
    <input type="submit" value="Register Product">           
</form>