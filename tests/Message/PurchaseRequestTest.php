<?php

namespace Omnipay\CieloTest\Message\Tests;

use Omnipay\Tests\TestCase;
use Omnipay\CieloTest\Message\PurchaseRequest;
use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * Classe PurchaseRequestTest
 *
 * Esta classe contém os testes unitários para a classe PurchaseRequest no namespace de mensagens de teste CieloTest.
 */
class PurchaseRequestTest extends TestCase
{
    /** @var PurchaseRequest $request */
    protected $request;

    /**
     * Configura o ambiente de teste.
     */
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
            ]
        );
    }

    /**
     * Testa se a captura está definida como verdadeira.
     */
    public function testCaptureIsTrue(): void
    {
        $data = $this->request->getData();
        $this->assertSame(true, $data['Payment']['Capture']);
    }

    /**
     * Testa o envio bem-sucedido de uma transação de compra.
     */
    public function testSendSuccess(): void
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

    /**
     * Testa o envio de erro de uma transação de compra.
     */
    public function testSendError(): void
    {
        $this->setMockHttpResponse('PurchaseError.txt');
        $response = $this->request->send();

        $jsonResponse = new JsonResponse(
            [
                'code' => 101,
                'error' => 'MerchantId is required',
            ],
            400,
        );

        $this->assertFalse($response->isSuccessful());
        $this->assertFalse($response->isRedirect());
        $this->assertNull($response->getCardReference());
        $this->assertSame(
            $jsonResponse->getContent(),
            $response->getMessage()->getContent(),
        );
    }
}
