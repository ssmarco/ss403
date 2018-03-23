<?php

use SilverStripe\ORM\DataObject;

class ProdBrand extends DataObject
{
    private static $db = [
        'Name' => 'Varchar(255)',
    ];

    private static $has_many = [
        'Products' => Product::class,
    ];

    private static $indexes = [
        'Name'            => true,
        'UniqueProdBrand' => [
            'type'    => 'Unique',
            'columns' => ['Name'],
        ],
    ];
}