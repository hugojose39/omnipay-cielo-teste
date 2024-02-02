<?php

namespace Omnipay\CieloTest\Message\Tests;

use Omnipay\CieloTest\Message\Response;
use Omnipay\Tests\TestCase;
use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * Classe ResponseTest
 *
 * Esta classe contém os testes unitários para a classe Response no namespace de mensagens de teste CieloTest.
 */
class ResponseTest extends TestCase
{
    /**
     * Cria uma instância de Response com base na resposta HTTP fornecida.
     *
     * @param $mock
     * @return Response
     */
    public function createResponse($mock): Response
    {
        return new Response($this->getMockRequest(), json_decode($mock->getBody()->getContents(), true));
    }

    /**
     * Testa o sucesso de uma compra com boleto.
     */
    public function testPurchaseBoletoSuccess(): void
    {
        $httpResponse = $this->getMockHttpResponse('PurchaseBoletoSuccess.txt');
        $response = $this->createResponse($httpResponse);

        $data = $response->getBoleto();

        $this->assertTrue($response->isSuccessful());
        $this->assertFalse($response->isRedirect());
        $this->assertSame('https://transactionsandbox.pagador.com.br/post/pagador/reenvia.asp/7f7ab0ff-d9a4-4b64-9adb-54e1529f3400', $data['boleto_url']);
        $this->assertSame('00091641500000157009999250000000012399999990', $data['boleto_barcode']);
    }

    /**
     * Testa o sucesso de uma autorização com boleto.
     */
    public function testAuthorizeBoletoSuccess(): void
    {
        $httpResponse = $this->getMockHttpResponse('AuthorizeBoletoSuccess.txt');
        $response = $this->createResponse($httpResponse);

        $this->assertTrue($response->isSuccessful());
        $this->assertFalse($response->isRedirect());
        $this->assertNotNull($response->getBoleto());
    }

    /**
     * Testa o sucesso de uma compra.
     */
    public function testPurchaseSuccess(): void
    {
        $httpResponse = $this->getMockHttpResponse('PurchaseSuccess.txt');
        $response = $this->createResponse($httpResponse);

        $this->assertTrue($response->isSuccessful());
        $this->assertFalse($response->isRedirect());
        $this->assertSame('01f2f7ca-958c-4cde-a153-f4bf2fe46697', $response->getTransactionReference());
        $this->assertSame('I7U6PL7WOVYRMJ2HEC2ULI2VH842V', $response->getCardReference()['PaymentAccountReference']);
        $this->assertNull($response->getMessage());
    }

    /**
     * Testa o erro de uma compra.
     */
    public function testPurchaseError(): void
    {
        $httpResponse = $this->getMockHttpResponse('PurchaseError.txt');
        $response = $this->createResponse($httpResponse);

        $jsonResponse = new JsonResponse(
            [
                'code' => 101,
                'error' => 'MerchantId is required',
            ],
            400,
        );

        $this->assertFalse($response->isSuccessful());
        $this->assertFalse($response->isRedirect());
        $this->assertNull($response->getTransactionReference());
        $this->assertNull($response->getCardReference());
        $this->assertSame(
            $jsonResponse->getContent(),
            $response->getMessage()->getContent(),
        );
    }
}
