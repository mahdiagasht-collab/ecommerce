<?php
class product extends model{
    protected static $returnedMysqlOBJ;
    protected static $OBJ = null;
    protected static $table = ' product ';
    protected static $related = ['product.category' , 'category.id'];
    protected static $relatedClass = 'category';
    protected static $subQuery = '';
    protected static $fields = ['product_id' , 'name' , 'price' , 'category.title product_category' , 'product.description description'];
}