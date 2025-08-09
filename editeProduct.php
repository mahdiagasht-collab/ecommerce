<?php $value = product::where($GLOBALS['urlArray'][3]) -> get() -> fetch_assoc(); ?>
<?php $result = category::all(); ?>

<div style="display: flex;justify-content: center;align-items: center;height: 500px;">
    <form action="http://localhost/ecommerce/updateProduct/<?= $value['id'] ?>" method ="post" style="background-color: bisque;padding: 10px;margin: 10px;border-radius: 10px;display: flex;flex-direction: column;align-items: center;">
        <input name = 'name'        placeholder='name'          value='<?= $value['name'] ?>'     
        style="margin: 10px;padding: 5px;border-radius: 10px;border: none;text-align: center;">
        <input name = 'price'      placeholder='price'        value='<?= $value['price'] ?>'     
        style="margin: 10px;padding: 5px;border-radius: 10px;border: none;text-align: center;">
        <input name = 'description'  placeholder='description'    value='<?= $value['description'] ?>'
        style="margin: 10px;padding: 5px;border-radius: 10px;border: none;text-align: center;">
        <select name="category" style="margin: 10px;padding: 5px;border-radius: 10px;border: none;text-align: center;width: 90%;">
            <?php
            while ($valueCategoryIdAndTitle = $result -> fetch_assoc()) {
                ?>
                <option value="<?= $valueCategoryIdAndTitle['id'] ?>">
                    <?= $valueCategoryIdAndTitle['title'] ?>
                </option>
                <?php
            }
            ?>
        </select>
        <button style="margin: 10px;padding: 5px;border-radius: 10px;border: none;background: none;">send</button>
    </form>
</div>