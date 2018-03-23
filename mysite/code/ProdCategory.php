<?php

use SilverStripe\ORM\DataObject;

class ProdCategory extends DataObject
{
    private static $db = [
        'Name' => 'Varchar(255)',
    ];

    private static $has_one = [
        'Parent' => ProdCategory::class,
    ];

    private static $belongs_many_many = [
        'Products' => 'Product.Categories'
    ];

    private static $indexes = [
        'Name'               => true,
        'UniqueProdCategory' => [
            'type'    => 'Unique',
            'columns' => ['Name'],
        ],
    ];
}
