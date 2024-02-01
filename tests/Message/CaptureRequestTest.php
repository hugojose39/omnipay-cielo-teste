<?php

namespace Omnipay\CieloTest\Message\Tests;

use Omnipay\CieloTest\Message\CaptureRequest;
use Omnipay\Tests\TestCase;

/**
 * Classe CaptureRequestTest
 *
 * Esta classe contém os testes unitários para a classe CaptureRequest no namespace de mensagens de teste CieloTest.
 */
class CaptureRequestTest extends TestCase
{
    /** @var CaptureRequest $request */
    private $request;

    /**
     * Configura o ambiente de teste.
     */
    public function setUp(): void
    {
        $this->request = new CaptureRequest($this->getHttpClient(), $this->getHttpRequest());
        $this->request->setTransactionReference(111111);
    }

    /**
     * Testa o endpoint da captura.
     */
    public function testEndpoint(): void
    {
        $this->assertSame('https://api.cieloecommerce.cielo.com.br/1/sales/111111/capture', $this->request->getEndpoint());
    }

    /**
     * Testa o envio de uma captura com sucesso.
     */
    public function testSendSuccess(): void
    {
        $this->setMockHttpResponse('CaptureSuccess.txt');
        $response = $this->request->send();

        $this->assertTrue($response->isSuccessful());
        $this->assertFalse($response->isRedirect());
        $this->assertSame('0719094510712', $response->getTransactionReference());
        $this->assertNull($response->getMessage());
    }

    /**
     * Testa o envio de uma captura com erro.
     */
    public function testSendError(): void
    {
        $this->setMockHttpResponse('CaptureError.txt');
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

