<?php
class product extends model{
    protected static $returnedMysqlOBJ;
    protected static $OBJ = null;
    protected static $table = ' product ';
    protected static $related = ['product_category' , 'category_id'];
    protected static $subQuery = '';
    protected static $requestQuery = '';

    public static function category(){
        
        return factory::factory(static::class) -> belongsTo( ' INNER ' , ' category ');

        // return (static::makeOBJ()) -> belongsTo( ' INNER ' , ' category ');
    }
}