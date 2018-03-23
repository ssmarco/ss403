<?php

use SilverStripe\ORM\DataObject;

class ProdType extends DataObject
{
    private static $db = [
        'Name' => 'Varchar(255)',
    ];

    private static $has_many = [
        'Products' => Product::class,
    ];

    private static $indexes = [
        'Name'           => true,
        'UniqueProdType' => [
            'type'    => 'Unique',
            'columns' => ['Name'],
        ],
    ];
}
