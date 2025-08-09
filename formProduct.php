<?php
$result = category::select(['id' , 'title']) -> get();
?>
<div style="display: flex;justify-content: center;align-items: center;height: 500px;">
    <form action="http://localhost/ecommerce/getFormProduct" method ="post" style="background-color: bisque;padding: 10px;margin: 10px;border-radius: 10px;display: flex;flex-direction: column;align-items: center;">
        <input name = 'name' placeholder='name' style="margin: 10px;padding: 5px;border-radius: 10px;border: none;text-align: center;">
        <input name = 'price' placeholder='price' style="margin: 10px;padding: 5px;border-radius: 10px;border: none;text-align: center;">
        <input name = 'description' placeholder='description' style="margin: 10px;padding: 5px;border-radius: 10px;border: none;text-align: center;">
        <select name="category" style="margin: 10px;padding: 5px;border-radius: 10px;border: none;text-align: center;width: 90%;">
            <?php
            while ($value = $result -> fetch_assoc()) {
                ?>
                <option value="<?= $value['id']; ?>">
                    <?= $value['title']; ?>
                </option>
                <?php
            }
            ?>
        </select>
        <button style="margin: 10px;padding: 5px;border-radius: 10px;border: none;background: none;">send</button>
    </form>
</div>