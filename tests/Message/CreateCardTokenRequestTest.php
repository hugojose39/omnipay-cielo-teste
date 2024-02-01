<?php

namespace Omnipay\CieloTest\Message\Tests;

use Omnipay\Tests\TestCase;
use Omnipay\CieloTest\Message\CreateCardTokenRequest;

/**
 * Classe CreateCardTokenRequestTest
 *
 * Esta classe contém os testes unitários para a classe CreateCardTokenRequest no namespace de mensagens de teste CieloTest.
 */
class CreateCardTokenRequestTest extends TestCase
{
    /** @var CreateCardTokenRequest $request */
    protected $request;

    /**
     * Configura o ambiente de teste.
     */
    public function setUp(): void
    {
        $this->request = new CreateCardTokenRequest($this->getHttpClient(), $this->getHttpRequest());
    }

    /**
     * Testa o endpoint para criação de token de cartão.
     */
    public function testEndpoint(): void
    {
        $this->assertSame('https://api.cieloecommerce.cielo.com.br/1/card', $this->request->getEndpoint());
    }

    /**
     * Testa o envio bem-sucedido para criação de token de cartão.
     */
    public function testSendSuccess(): void
    {
        $this->setMockHttpResponse('CreateCardTokenSuccess.txt');
        $response = $this->request->send();

        $this->assertTrue($response->isSuccessful());
        $this->assertFalse($response->isRedirect());
        $this->assertNull($response->getTransactionReference());
        $this->assertSame('db62dc71-d07b-4745-9969-42697b988ccb', $response->getCardReference());
        $this->assertNull($response->getMessage());
    }

    /**
     * Testa o envio de erro para criação de token de cartão.
     */
    public function testSendError(): void
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
