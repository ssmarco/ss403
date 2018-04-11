<?php

use SilverStripe\CMS\Controllers\ContentController;
use SilverStripe\ORM\DataList;
use SilverStripe\ORM\DataObject;
use SilverStripe\Core\Convert;
use SilverStripe\Control\HTTPResponse;
use SilverStripe\Core\Injector\Injector;
use Marcz\Search\Config;
use Marcz\Search\SearchList;
use Marcz\Search\Processor\Exporter;
use SilverStripe\Core\Environment;
use SilverStripe\Versioned\Versioned;

class PageController extends ContentController
{
    /**
     * An array of actions that can be accessed via a request. Each array element should be an action name, and the
     * permissions or conditions required to allow the user to access it.
     *
     * <code>
     * [
     *     'action', // anyone can access this action
     *     'action' => true, // same as above
     *     'action' => 'ADMIN', // you must have ADMIN permissions to access this action
     *     'action' => '->checkAction' // you can only access this action if $this->checkAction() returns true
     * ];
     * </code>
     *
     * @var array
     */
    private static $allowed_actions = [
        'readjson',
        'ecommerce',
        'categories',
        'sample',
        'marcz',
    ];

    private static $url_handlers = [
        // 'readjson//$Action'  => 'readjson',
        // 'ecommerce//$Action' => 'ecommerce',
        // 'categories//$Action'=> 'categories',
        // 'sample//$Action'    => 'sample',
        // 'marcz//$Action'     => 'marcz',
    ];

    protected function init()
    {
        parent::init();
        // You can include any CSS or JS required by your project here.
        // See: https://docs.silverstripe.org/en/developer_guides/templates/requirements/
    }

    public function marcz()
    {
        // $pages = Page::get();
        // var_dump($pages->count());
        // echo($pages->limit(0, 5)->sql());
        // return;
        // var_dump(Environment::getEnv('SS_ALGOLIA_SEARCH_KEY'));
        // $session = $this->getRequest()->getSession();
        // $session->set('SearchListRememberedClient', 'MongoDB');

        // var_dump($this->search('hello', 'Pages', 'Algolia'));
        $search = $this->createSearch('hello');
        var_dump($search->fetch());

        // $searchList = SearchList::create();
        // $searchList->filter('Keyword', ['charlie', 'sheila', ])
        //     ->exclude('Key');

        // $exporter = Exporter::create();
        // $exporter->export($dataClass);

        // $indices    = Config::config()->get('clients');
        // $inst       = Config::create();

        // var_dump($indices, $searchList, $inst->details(), $exporter);

        // var_dump('get', $session->get('SearchListRememberedClient'));

        exit;
    }

    public function sample()
    {
        $product  = Product::get()->byID(9131042);
        // $product  = Product::get()->byID(1696302);
        // $product  = ProdBrand::get()->byID(36);
        $hasOne   = $product->config()->get('has_one');
        $hasMany  = $product->config()->get('has_many');
        $manyMany = $product->config()->get('many_many');
        $fields   = DataObject::getSchema()->databaseFields(Product::class, $aggregate = false);
        // var_dump($fields);
        // exit;

        $productArray = $product->toMap();
        foreach ($fields as $column => $fieldType) {
            if (in_array($fieldType, ['PrimaryKey'])
                || !isset($productArray[$column])
            ) {
                continue;
            }

            if ($fieldType === 'ForeignKey') {
                $field = Injector::inst()->create($fieldType, $column, $product);
            } else {
                $field = Injector::inst()->create($fieldType);
            }

            $formField = $field->scaffoldFormField();
            $formField->setValue($productArray[$column]);
            $productArray[$column] = $formField->dataValue();
        }

        // foreach ($hasOne as $column => $className) {
        //     $productArray[$column] = $product->{$column}()->getTitle();
        // }

        // foreach ($hasMany as $column => $className) {
        //     $items = [];
        //     foreach ($product->{$column}() as $item) {
        //         $items[] = $item->getTitle();
        //     }
        //     if ($items) {
        //         $productArray[$column] = $items;
        //     }
        // }

        // foreach ($manyMany as $column => $className) {
        //     $items = [];
        //     foreach ($product->{$column}() as $item) {
        //         $items[] = $item->getTitle();
        //     }
        //     if ($items) {
        //         $productArray[$column] = $items;
        //     }
        // }

        $response = new HTTPResponse(Convert::array2json($productArray));
        $response->addHeader('Content-Type', 'application/json; charset=utf-8');
        return $response;
    }

    public function readScratch()
    {
        $file = BASE_PATH . '/wiki-articles-1000.json';
        // $file = 'wiki-articles-1000.json';
        // $adapter = new Local(BASE_PATH);
        // $filesystem = new Filesystem($adapter);
        // $csv = Reader::createFromPath($file)
        //     ->setHeaderOffset(0);
        // $contents = $filesystem->read($file);
        // return $contents;
        // $json = json_decode($filesystem->read($file), true);
        // var_dump($json);
        // exit;
        // foreach ($json as $line) {
        //     var_dump($line);
        // }
    }

    public function readjson()
    {
        $file    = BASE_PATH . '/wiki-articles-1000.json';
        $lines   = file($file);
        $counter = 1000;

        // Loop through our array, show HTML source as HTML source; and line numbers too.
        foreach ($lines as $line_num => $line) {
            // $counter--;
            // $json = json_decode($line, true);
            // parse_str(parse_url($json['url'], PHP_URL_QUERY), $urlQuery);

            // $content        = '<p>%1$s</p><p><a target="_blank" href="%2$s">%2$s</a></p>';
            // $page           = new Page();
            // $page->ID       = $urlQuery['curid'];
            // $page->Title    = $json['title'];
            // $page->ParentID = 2; //About Us page
            // $page->Content  = sprintf($content, $json['body'], $json['url']);
            // $page->write();
            // $page->copyVersionToStage(Versioned::DRAFT, Versioned::LIVE);
            // $page->flushCache();

            // if ($counter < 1) {
            //     break;
            // }
            // echo "Line #<b>{$line_num}</b> : " . var_export($page->toMap()) . "<br />\n";
            // echo "Line #<b>{$line_num}</b> : " . var_export($json) . "<br />\n";
        }
    }

    /**
     * Generating Products DataObject
     */
    public function ecommerce()
    {
        $file    = BASE_PATH . '/ecommerce.json';
        $json    = json_decode(file_get_contents($file));
        $counter = 1000;
        die('not executed');
        foreach ($json as $record) {
            // $counter--;
            // $brand   = $this->getDataObject(ProdBrand::class, $record->brand);
            // $type    = $this->getDataObject(ProdType::class, $record->type);
            // $range   = $this->getDataObject(ProdPriceRange::class, $record->price_range);
            // $product = $this->getDataObject(Product::class, $record->objectID);
            // if (!$product) {
            //     $product               = Product::create();
            //     $product->Name         = $record->name;
            //     $product->Content      = $record->description;
            //     $product->Price        = $record->price;
            //     $product->Image        = $record->image;
            //     $product->Url          = $record->url;
            //     $product->FreeShipping = $record->free_shipping;
            //     $product->Popularity   = $record->popularity;
            //     $product->Rating       = $record->rating;
            //     $product->ID           = $record->objectID;
            //     $product->BrandID      = $brand->ID;
            //     $product->TypeID       = $type->ID;
            //     $product->PriceRangeID = $range->ID;
            //     $product->write();
            // }

            // foreach ($record->categories as $name) {
            //     if ($category = $this->getDataObject(ProdCategory::class, $name)) {
            //         $product->Categories()->add($category->ID);
            //     }
            // }

            // if ($counter < 1) {
            //     break;
            // }
        }

        die('done here');
    }

    /**
     * Ran first to create categories and has_* relatioships
     */
    public function categories()
    {
        $file    = BASE_PATH . '/ecommerce.json';
        $json    = json_decode(file_get_contents($file));

        foreach ($json as $record) {
            // $parentId = 0;
            // foreach ($record->categories as $name) {
            //     $category = $this->getDataObject(ProdCategory::class, $name);
            //     if (!$category) {
            //         $category       = ProdCategory::create();
            //         $category->Name = $name;

            //         if ($parentId) {
            //             $category->ParentID = $parentId;
            //         }

            //         $parentId = $category->write();
            //     }
            // }

            // if (!$this->getDataObject(ProdBrand::class, $record->brand)) {
            //     $brand       = ProdBrand::create();
            //     $brand->Name = $record->brand;
            //     $brand->write();
            // }

            // if (!$this->getDataObject(ProdType::class, $record->type)) {
            //     $type       = ProdType::create();
            //     $type->Name = $record->type;
            //     $type->write();
            // }

            // if (!$this->getDataObject(ProdPriceRange::class, $record->price_range)) {
            //     $range       = ProdPriceRange::create();
            //     $range->Name = $record->price_range;
            //     $range->write();
            // }
        }
        die('done');
    }

    protected function getDataObject($className, $name)
    {
        return DataList::create($className)->filter('Name', $name)->first();
    }
}
