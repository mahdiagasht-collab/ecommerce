<?php $value = user::where($GLOBALS['urlArray'][3]) -> get() -> fetch_assoc(); ?>

<div style="display: flex;justify-content: center;align-items: center;height: 500px;">
    <form action="http://localhost/ecommerceBuilderAndFacade/updateUser/<?= $value['id'] ?>" method ="post" style="background-color: bisque;padding: 10px;margin: 10px;border-radius: 10px;display: flex;flex-direction: column;align-items: center;">
        <input name = 'name'        placeholder='name'          value='<?= $value['name'] ?>'     
        style="margin: 10px;padding: 5px;border-radius: 10px;border: none;text-align: center;">
        <input name = 'family'      placeholder='family'        value='<?= $value['family'] ?>'     
        style="margin: 10px;padding: 5px;border-radius: 10px;border: none;text-align: center;">
        <input name = 'phonNumber'  placeholder='phonNumber'    value='<?= $value['phonNumber'] ?>'     
        style="margin: 10px;padding: 5px;border-radius: 10px;border: none;text-align: center;">
        <button style="margin: 10px;padding: 5px;border-radius: 10px;border: none;background: none;">send</button>
    </form>
</div>