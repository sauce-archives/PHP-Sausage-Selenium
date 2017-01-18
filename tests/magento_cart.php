<?php

require_once 'vendor/autoload.php';

class MagentoCart extends Sauce\Sausage\WebDriverTestCase
{
    protected $base_url = 'http://127.0.0.1/';

    public static $browsers = [
        [
            'browserName' => 'chrome',
            'desiredCapabilities' => [
                'version' => '45.0',
                'platform' => 'OS X 10.10',
            ],
        ],
    ];

    /**
     * Testing of add product to cart procedure
     *
     * 1. Select and click sale button (Home Page)
     * 2. Check if it's the product page
     * 3. Select and click sale button
     * 4. Check if it's the checkout page
     */
    public function testAddProductToCart()
    {
        // Purchase by homepage
        $this->byCssSelector('#home-intro .btn-buy')->click();

        // Validate Product Page
        $body = $this->byXPath('//html/body');
        $this->assertContains('catalog-product-view', $body->attribute('class'));

        // Purchase by product page
        $this->byCssSelector('#product_addtocart_form #product-shop .btn-buy')->click();

        // Validate Checkout Page (Product added successfully)
        $body = $this->byXPath('//html/body');
        $this->assertContains('mp-checkout-index-index', $body->attribute('class'));
    }
}
