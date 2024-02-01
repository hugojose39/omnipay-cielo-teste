<?php

namespace Omnipay\CieloTest\Tests;

use Omnipay\CieloTest\Gateway;
use Omnipay\CieloTest\Message\AuthorizeRequest;
use Omnipay\CieloTest\Message\CaptureRequest;
use Omnipay\CieloTest\Message\CreateCardTokenRequest;
use Omnipay\CieloTest\Message\PurchaseRequest;
use Omnipay\Tests\GatewayTestCase;

/**
 * Classe GatewayTest
 *
 * Esta classe contém os testes para a classe Gateway no namespace de testes CieloTest.
 */
class GatewayTest extends GatewayTestCase
{
    /**
     * @var Gateway
     */
    protected $gateway;

    /**
     * Configuração inicial dos testes.
     */
    public function setUp(): void
    {
        parent::setUp();

        $this->gateway = new Gateway($this->getHttpClient(), $this->getHttpRequest());
    }
        
    /**
     * Testa o método authorize().
     */
    public function testAuthorize(): void
    {
        $request = $this->gateway->authorize(['amount' => '10.00']);
        
        $this->assertInstanceOf(AuthorizeRequest::class, $request);
        $this->assertSame('10.00', $request->getAmount());
    }
    
    /**
     * Testa o método capture().
     */
    public function testCapture(): void
    {
        $request = $this->gateway->capture();

        $this->assertInstanceOf(CaptureRequest::class, $request);
    }

    /**
     * Testa o método purchase().
     */
    public function testPurchase(): void
    {
        $request = $this->gateway->purchase(array('amount' => '10.00'));

        $this->assertInstanceOf(PurchaseRequest::class, $request);
        $this->assertSame('10.00', $request->getAmount());
    }

    /**
     * Testa o método createTokenCard().
     */
    public function testCreateCardToken(): void
    {
        $request = $this->gateway->createTokenCard();

        $this->assertInstanceOf(CreateCardTokenRequest::class, $request);
    }
}
