<?php $value = footer::where(['id' , " '" . $GLOBALS['urlArray'][3] . "' "]) -> get() -> fetch_assoc(); ?>
['id' , " '" . $GLOBALS['urlArray'][3] . "' "]
<div style="display: flex;justify-content: center;align-items: center;height: 500px;">
    <form action="http://localhost/ecommerce/updateFooter/<?= $value['id'] ?>" method ="post" style="background-color: bisque;padding: 10px;margin: 10px;border-radius: 10px;display: flex;flex-direction: column;align-items: center;">
        <input name = 'copyRight'        placeholder='copyRight'          value='<?= $value['copyRight'] ?>'     
        style="margin: 10px;padding: 5px;border-radius: 10px;border: none;text-align: center;">
        <input name = 'nameDesigner'      placeholder='nameDesigner'        value='<?= $value['nameDesigner'] ?>'     
        style="margin: 10px;padding: 5px;border-radius: 10px;border: none;text-align: center;">
        <button style="margin: 10px;padding: 5px;border-radius: 10px;border: none;background: none;">send</button>
    </form>
</div>