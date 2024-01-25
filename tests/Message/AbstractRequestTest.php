<?php

namespace Omnipay\CieloTest\Message\Tests;

use Omnipay\CieloTest\Message\AbstractRequest;
use Mockery;
use Omnipay\Tests\TestCase;

class AbstractRequestTest extends TestCase
{
    private $request;

    public function setUp(): void
    {
        $this->request = Mockery::mock(AbstractRequest::class)->makePartial();
        $this->request->initialize();
    }

    public function testGetEndpoint()
    {
        $this->assertStringStartsWith('https://api.cieloecommerce.cielo.com.br/', $this->request->getEndpoint());
    }

    public function testSetMerchantToData()
    {
        $data = [];

        $this->request->setMerchantId('123abc');
        $this->request->setMerchantKey('123abc');
        $data = $this->request->insertMerchantToData($data);

        $this->assertArrayHasKey('MerchantId', $data);
        $this->assertArrayHasKey('MerchantKey', $data);
        $this->assertSame('123abc', $data['MerchantId']);
        $this->assertSame('123abc', $data['MerchantKey']);
    }

    public function testCustomer()
    {
        $this->assertSame($this->request, $this->request->setCustomer(['name' => 'Foo', 'email' => 'foo@example.com']));
        $this->assertSame(['name' => 'Foo', 'email' => 'foo@example.com'], $this->request->getCustomer());
    }

    public function testCardData()
    {
        $card = [
            'CustomerName' => 'Comprador Teste Cielo',
            'CardNumber' => '4532117080573700',
            'Holder' => 'Comprador T Cielo',
            'ExpirationDate' => '12/2030',
            'Brand' => 'Visa',
        ];

        $this->request->setCard($card);
        $data = $this->request->getCardData();

        $this->assertSame($card['CardNumber'], $data['CardNumber']);
        $this->assertSame($card['Holder'], $data['Holder']);
        $this->assertSame($card['Brand'], $data['Brand']);
    }
}
