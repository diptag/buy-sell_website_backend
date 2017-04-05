 <?php
    if (isset($error_msg))
    {
?>
        <div class="error-msg"><?= $error_msg ?></div>
<?php
    }
?>
<form action="sell" method="POST" enctype="multipart/form-data">
    Name: <input type="text" name="name" required><br>
    Description: <textarea cols="30" rows="5" maxlength="255" name="description" required></textarea><br>
    Category: <select name="category_id">
                <?php
            foreach($categories as $category)
            {
        ?>
            <option value="<?= $category["id"] ?>"><?= $category["name"] ?></option>
        <?php
            }
        ?>
    </select><br>
    Price: &#8377; <input type="number" name="price" min="0" required><br>
    Image: (Image should be of JPEG, JPG, PNG and GIF formats and size &lt; 1MB)<br>
    <input type="file" name="image_upload" required><br>
    <input type="submit" value="Register Product">           
</form>