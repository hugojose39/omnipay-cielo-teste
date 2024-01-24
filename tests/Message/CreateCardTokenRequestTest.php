<?php

namespace Hugojose39\OmnipayCieloTeste\Message\Tests;

use Omnipay\Tests\TestCase;
use Hugojose39\OmnipayCieloTeste\Message\CreateCardTokenRequest;

class CreateCardTokenRequestTest extends TestCase
{
    protected $request;

    public function setUp(): void
    {
        $this->request = new CreateCardTokenRequest($this->getHttpClient(), $this->getHttpRequest());
    }

    public function testEndpoint()
    {
        $this->assertSame('https://api.cieloecommerce.cielo.com.br/1/card', $this->request->getEndpoint());
    }

    public function testSendSuccess()
    {
        $this->setMockHttpResponse('CreateCardTokenSuccess.txt');
        $response = $this->request->send();

        $this->assertTrue($response->isSuccessful());
        $this->assertFalse($response->isRedirect());
        $this->assertNull($response->getTransactionReference());
        $this->assertSame('db62dc71-d07b-4745-9969-42697b988ccb', $response->getCardReference());
        $this->assertNull($response->getMessage());
    }

    public function testSendError()
    {
        $this->setMockHttpResponse('CreateCardTokenError.txt');
        $response = $this->request->send();

        $this->assertFalse($response->isSuccessful());
        $this->assertFalse($response->isRedirect());
        $this->assertNull($response->getTransactionReference());
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
