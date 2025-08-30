<?php 
$value = category::where(['category_id' , " '" . $GLOBALS['urlArray'][3] . "' "]) -> with(['product' => ['count(*) ']] , 'categoryProductCount') -> fetch_assoc();
// $value = category::find($GLOBALS['urlArray'][3])-> fetch_assoc();
// $value = category::where($GLOBALS['urlArray'][3]) -> get() -> fetch_assoc();
 ?>

<div style="display: flex;justify-content: center;align-items: center;height: 500px;">
    <form action="http://localhost/ecommerceBuilderAndFacade/updateCategory/<?= $value['category_id'] ?>" method ="post" style="background-color: bisque;padding: 10px;margin: 10px;border-radius: 10px;display: flex;flex-direction: column;align-items: center;">
        <input name = 'title'        placeholder='title'          value='<?= $value['title'] ?>'     
        style="margin: 10px;padding: 5px;border-radius: 10px;border: none;text-align: center;">
        <input name = 'description'      placeholder='description'        value='<?= $value['description'] ?>'     
        style="margin: 10px;padding: 5px;border-radius: 10px;border: none;text-align: center;">
        <button style="margin: 10px;padding: 5px;border-radius: 10px;border: none;background: none;">send</button>
    </form>
</div>