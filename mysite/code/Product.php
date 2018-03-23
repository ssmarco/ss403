<?php

use SilverStripe\ORM\DataObject;

class Product extends DataObject
{
    private static $db = [
        'Name'         => 'Varchar(255)',
        'Content'      => 'HTMLText',
        'Price'        => 'Decimal(5,2)',
        'Image'        => 'Varchar(255)',
        'Url'          => 'Varchar(255)',
        'FreeShipping' => 'Boolean',
        'Popularity'   => 'Int',
        'Rating'       => 'Int',
    ];

    private static $has_one = [
        'Brand'      => ProdBrand::class,
        'Type'       => ProdType::class,
        'PriceRange' => ProdPriceRange::class,
    ];

    private static $many_many = [
        'Categories' => ProdCategory::class
    ];
}
