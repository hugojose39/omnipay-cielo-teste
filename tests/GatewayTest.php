<?php

namespace Hugojose39\OmnipayCieloTeste\Tests;

use Hugojose39\OmnipayCieloTeste\Gateway;
use Hugojose39\OmnipayCieloTeste\Message\AuthorizeRequest;
use Hugojose39\OmnipayCieloTeste\Message\CaptureRequest;
use Hugojose39\OmnipayCieloTeste\Message\CreateCardTokenRequest;
use Hugojose39\OmnipayCieloTeste\Message\PurchaseRequest;
use Omnipay\Tests\GatewayTestCase;

class GatewayTest extends GatewayTestCase
{
    protected $gateway;

    public function setUp(): void
    {
        parent::setUp();

        $this->gateway = new Gateway($this->getHttpClient(), $this->getHttpRequest());
    }
        
    public function testAuthorize()
    {
        $request = $this->gateway->authorize(['amount' => '10.00']);
        
        $this->assertInstanceOf(AuthorizeRequest::class, $request);
        $this->assertSame('10.00', $request->getAmount());
    }
    
    public function testCapture()
    {
        $request = $this->gateway->capture();

        $this->assertInstanceOf(CaptureRequest::class, $request);
    }

    public function testPurchase()
    {
        $request = $this->gateway->purchase(array('amount' => '10.00'));

        $this->assertInstanceOf(PurchaseRequest::class, $request);
        $this->assertSame('10.00', $request->getAmount());
    }

    
    public function testCreateCardToken()
    {
        $request = $this->gateway->createTokenCard();

        $this->assertInstanceOf(CreateCardTokenRequest::class, $request);
    }
}