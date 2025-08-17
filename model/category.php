<?php
class category extends model{
    protected static $returnedMysqlOBJ;
    protected static $OBJ = null;
    protected static $table = 'category';
    protected static $related = ['product_category' , 'category_id'];
    protected static $subQuery = '';
    protected static $requestQuery = '';

    public static function product(array $fields){
        (static::makeOBJ()) -> connectInBase($fields) -> belongsTo('product');
        return static::$OBJ;
    }
}