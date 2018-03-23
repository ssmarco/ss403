<?php

use SilverStripe\ORM\DataExtension;

class ProductExtension extends DataExtension
{
    private static $db = [
        'Description' => 'Varchar(255)',
    ];
}
