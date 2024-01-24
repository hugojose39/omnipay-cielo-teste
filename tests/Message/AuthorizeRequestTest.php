<?php

namespace Hugojose39\OmnipayCieloTeste\Message\Tests;

use Omnipay\Tests\TestCase;
use Hugojose39\OmnipayCieloTeste\Message\AuthorizeRequest;

class AuthorizeRequestTest extends TestCase
{
    private $request;

    public function setUp(): void
    {
        $this->request = new AuthorizeRequest($this->getHttpClient(), $this->getHttpRequest());
        $this->request->initialize(
            [
                'merchant_order_id' => '123456',
                'amount' => '12.00',
                'card' => [
                    'CardNumber' => '1234123412341231',
                    'Holder' => 'Teste Holder',
                    'ExpirationDate' => '03/2019',
                    'SecurityCode' => '262',
                    'SaveCard' => 'true',
                    'Brand' => 'Visa',
                ],
                'customer' => [
                    'Name' => 'Comprador Teste Boleto',
                    'Identity' => '1234567890',
                    'Address' => [
                        'Street' => 'Avenida Marechal Câmara',
                        'Number' => '160',
                        'Complement' => 'Sala 934',
                        'ZipCode' => '22750012',
                        'District' => 'Centro',
                        'City' => 'Rio de Janeiro',
                        'State' => 'RJ',
                        'Country' => 'BRA'
                    ],
                ],
                'payment_method' => 'CreditCard',
                'installments' => 1,
                'soft_descriptor' => 'testeDeApi',
            ],
        );
    }

    public function testGetData()
    {
        $card = [
            'CardNumber' => '1234123412341231',
            'Holder' => 'Teste Holder',
            'ExpirationDate' => '03/2019',
            'SecurityCode' => '262',
            'SaveCard' => 'true',
            'Brand' => 'Visa',
        ];
        $this->request->setCard($card);
        $data = $this->request->getData();

        $this->assertSame(1200, $data['Payment']['Amount']);
        $this->assertSame('CreditCard', $data['Payment']['Type']);
        $this->assertSame(1, $data['Payment']['Installments']);
        $this->assertSame('testeDeApi', $data['Payment']['SoftDescriptor']);
        $this->assertNotNull($data['Payment']['CreditCard']);
        $this->assertNotNull($data['Customer']);
    }

    public function testGetDataForBoletoPaymentMethod()
    {
        $this->request = new AuthorizeRequest($this->getHttpClient(), $this->getHttpRequest());
        $this->request->initialize(
            [
                'merchant_order_id' => '123456',
                'amount' => '12.00',
                'customer' => [
                    'Name' => 'Comprador Teste Boleto',
                    'Identity' => '1234567890',
                    'Address' => [
                        'Street' => 'Avenida Marechal Câmara',
                        'Number' => '160',
                        'Complement' => 'Sala 934',
                        'ZipCode' => '22750012',
                        'District' => 'Centro',
                        'City' => 'Rio de Janeiro',
                        'State' => 'RJ',
                        'Country' => 'BRA'
                    ],
                ],
                'payment_method' => 'Boleto',
                'installments' => 1,
                'soft_descriptor' => 'testeDeApi',
                'provider' => 'Bradesco',
            ],
        );
        $data = $this->request->getData();

        $this->assertSame(1200, $data['Payment']['Amount']);
        $this->assertSame('Boleto', $data['Payment']['Type']);
        $this->assertSame(1, $data['Payment']['Installments']);
        $this->assertSame('testeDeApi', $data['Payment']['SoftDescriptor']);
        $this->assertSame('Bradesco', $data['Payment']['Provider']);
        $this->assertNotNull($data['Customer']);
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

    public function testEndpoint()
    {
        $this->assertSame('https://api.cieloecommerce.cielo.com.br/1/sales', $this->request->getEndpoint());
    }
}
