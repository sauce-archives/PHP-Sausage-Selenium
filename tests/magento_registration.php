<?php

require_once 'vendor/autoload.php';

class AccountTestCase extends Sauce\Sausage\WebDriverTestCase
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

    protected $tmpEmail;

    /**
     * testing of Creation and Log-in procedures
     *
     * 1. Create new customer account
     * 2. Logout
     * 3. Login into created customer account
     */
    public function testCreateAndLogin()
    {
        $this->create();

        $this->url('customer/account/logout/');
        sleep(5);// waiting for auto-redirection afte log-out

        $this->login();
    }

    /**
     * testing of ForgotPassword procedure
     *
     * 1. Create new customer account
     * 2. Log-out
     * 3. Move to customer/account/forgotpassword/
     * 4. submit form
     */
    public function testForgotPassword()
    {
        // to ensure that email exists we need to create new account before
        $this->create();

        $this->url('customer/account/logout/');
        sleep(5);// waiting for auto-redirection afte log-out

        $this->url('customer/account/login/');
        $this->assertContains("Customer Login", $this->title());

        $this->byXPath('//*[@id="login-form"]/div/div[2]/div[1]/ul/li[3]/a')->click();
        $this->assertContains("Forgot Your Password", $this->title());

        $this->byId('email_address')->value($this->getTmpEmail());
        $this->byXPath('//*[@id="form-validate"]/div[2]/button')->click();

        sleep(2);
        //$this->assertContains("Customer Login", $this->title());
        $alertMessage = $this->byXPath('//html/body/div/div/div[1]/div/div/div/div[2]')->text();
        $this->assertContains($this->getTmpEmail(), $alertMessage);
    }

    /**
     * Creates a new customer account
     */
    public function create()
    {
        $this->url('customer/account/login/');
        $this->assertContains("Customer Login", $this->title());

        $this->byXPath('//*[contains(@class,"new-users")]/*/a[contains(@class,"button")]')->click();
        sleep(2);
        $this->assertContains("Create New Customer Account", $this->title());

        $this->byId('firstname')->value('John');
        $this->byId('lastname')->value('Doe');
        $this->byId('email_address')->value($this->getTmpEmail());
        $this->byId('password')->value('1q2w3e4r');
        $this->byId('confirmation')->value('1q2w3e4r');

        $this->byXPath('//*[@id="form-validate"]/*/button[contains(@class,"button")]')->click();
        sleep(2);
        $this->assertContains("Account", $this->title());

    }

    /**
     * Log-in with existed (created) customer account
     */
    public function login()
    {
        $this->url('customer/account/login/');
        $this->assertContains("Customer Login", $this->title());

        $this->byId('email')->value($this->getTmpEmail());
        $this->byId('pass')->value('1q2w3e4r');

        $this->byId('send2')->click();
        sleep(2);
        $this->assertContains("Account", $this->title());
    }

    /**
     * Returns generated temp email address
     *
     * @return string
     */
    public function getTmpEmail()
    {
        if (is_null($this->tmpEmail)) {
            $this->tmpEmail =  uniqid('test', true) . '@example.com';
        }

        return $this->tmpEmail;
    }
}
