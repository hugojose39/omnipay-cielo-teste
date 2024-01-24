<?php

namespace Hugojose39\OmnipayCieloTeste\Message\Tests;

use Hugojose39\OmnipayCieloTeste\Message\PurchaseRequest;
use Omnipay\Tests\TestCase;

class PurchaseRequestTest extends TestCase
{
    protected $request;

    public function setUp(): void
    {
        $this->request = new PurchaseRequest($this->getHttpClient(), $this->getHttpRequest());
        $this->request->initialize(
            [
                'merchant_order_id' => '123456',
                'amount' => '10.00',
                'payment_method' => 'CreditCard',
                'card' => [
                    'CardNumber' => '1234123412341231',
                    'Holder' => 'Teste Holder',
                    'ExpirationDate' => '03/2019',
                    'SecurityCode' => '262',
                    'SaveCard' => 'true',
                    'Brand' => 'Visa',
                ],
            ],
        );
    }

    public function testCaptureIsTrue()
    {
        $data = $this->request->getData();
        $this->assertSame(true, $data['Payment']['Capture']);
    }

    public function testSendSuccess()
    {
        $this->setMockHttpResponse('PurchaseSuccess.txt');
        $response = $this->request->send();

        $this->assertTrue($response->isSuccessful());
        $this->assertFalse($response->isRedirect());
        $this->assertSame('01f2f7ca-958c-4cde-a153-f4bf2fe46697', $response->getTransactionReference());
        $this->assertSame('I7U6PL7WOVYRMJ2HEC2ULI2VH842V', $response->getCardReference()['PaymentAccountReference']);
        $this->assertSame('Paulo Henrique', $response->getCustomerReference()['Name']);
        $this->assertNull($response->getBoleto());
        $this->assertNull($response->getMessage());
    }

    public function testSendError()
    {
        $this->setMockHttpResponse('PurchaseError.txt');
        $response = $this->request->send();

        $this->assertFalse($response->isSuccessful());
        $this->assertFalse($response->isRedirect());
        $this->assertNull($response->getCardReference());
        $this->assertSame(
            [
                'code' => 101,
                'error' => 'MerchantId is required',
            ],
            $response->getMessage(),
        );
    }
}
