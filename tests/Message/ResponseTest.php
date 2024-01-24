<?php

namespace Hugojose39\OmnipayCieloTeste\Message\Tests;

use Hugojose39\OmnipayCieloTeste\Message\Response;
use Omnipay\Tests\TestCase;

class ResponseTest extends TestCase
{

    public function createResponse($mock)
    {
        return new Response($this->getMockRequest(), json_decode($mock->getBody()->getContents(), true));
    }

    public function testPurchaseBoletoSuccess()
    {
        $httpResponse = $this->getMockHttpResponse('PurchaseBoletoSuccess.txt');
        $response = $this->createResponse($httpResponse);

        $data = $response->getBoleto();

        $this->assertTrue($response->isSuccessful());
        $this->assertFalse($response->isRedirect());
        $this->assertSame('https://transactionsandbox.pagador.com.br/post/pagador/reenvia.asp/7f7ab0ff-d9a4-4b64-9adb-54e1529f3400', $data['boleto_url']);
        $this->assertSame('00091641500000157009999250000000012399999990', $data['boleto_barcode']);
    }

    public function testAuthorizeBoletoSuccess()
    {
        $httpResponse = $this->getMockHttpResponse('AuthorizeBoletoSuccess.txt');
        $response = $this->createResponse($httpResponse);

        $this->assertTrue($response->isSuccessful());
        $this->assertFalse($response->isRedirect());
        $this->assertNotNull($response->getBoleto());
    }

    public function testPurchaseSuccess()
    {
        $httpResponse = $this->getMockHttpResponse('PurchaseSuccess.txt');
        $response = $this->createResponse($httpResponse);

        $this->assertTrue($response->isSuccessful());
        $this->assertFalse($response->isRedirect());
        $this->assertSame('01f2f7ca-958c-4cde-a153-f4bf2fe46697', $response->getTransactionReference());
        $this->assertSame('I7U6PL7WOVYRMJ2HEC2ULI2VH842V', $response->getCardReference()['PaymentAccountReference']);
        $this->assertNull($response->getMessage());
    }

    public function testPurchaseError()
    {
        $httpResponse = $this->getMockHttpResponse('PurchaseError.txt');
        $response = $this->createResponse($httpResponse);

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
