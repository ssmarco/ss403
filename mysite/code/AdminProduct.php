<?php
use SilverStripe\Admin\ModelAdmin;

class AdminProduct extends ModelAdmin
{
    private static $managed_models = [
        Product::class,
    ];

    private static $url_segment = 'products';

    private static $menu_title = 'Products';
}
