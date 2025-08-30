<?php
class category extends model{
    protected $returnedMysqlOBJ;
    // protected $OBJ = null;
    protected $table = 'category';
    protected $related = ['product_category' , 'category_id'];
    protected $subQuery = '';
    protected $requestQuery = '';

    protected function product(array $fields){
        (static::makeOBJ()) -> connectInBase($fields) -> belongsTo('product');
        return static::$OBJ;
    }
}