<?php

namespace Omnipay\CieloTest\Message\Tests;

use Omnipay\CieloTest\Message\AbstractRequest;
use Mockery;
use Omnipay\Tests\TestCase;

/**
 * Classe AbstractRequestTest
 *
 * Esta classe contém os testes unitários para a classe AbstractRequest no namespace de mensagens CieloTest.
 */
class AbstractRequestTest extends TestCase
{
    /** @var AbstractRequest|\Mockery\MockInterface $request */
    private $request;

    /**
     * Configura o ambiente de teste.
     */
    public function setUp(): void
    {
        $this->request = Mockery::mock(AbstractRequest::class)->makePartial();
        $this->request->initialize();
    }

    /**
     * Caso de teste para verificar a URL de endpoint.
     */
    public function testGetEndpoint(): void
    {
        $this->assertStringStartsWith(
            'https://api.cieloecommerce.cielo.com.br/',
            $this->request->getEndpoint()
        );
    }

    /**
     * Caso de teste para definir o ID e a chave do comerciante.
     */
    public function testSetMerchantToData(): void
    {
        $this->request->setMerchantId('123abc');
        $this->request->setMerchantKey('123abc');

        $this->assertSame('123abc', $this->request->getMerchantId());
        $this->assertSame('123abc', $this->request->getMerchantKey());
    }

    /**
     * Caso de teste para definir e obter dados do cliente.
     */
    public function testCustomer(): void
    {
        $this->assertSame(
            $this->request,
            $this->request->setCustomer(['name' => 'Foo', 'email' => 'foo@example.com'])
        );
        $this->assertSame(['name' => 'Foo', 'email' => 'foo@example.com'], $this->request->getCustomer());
    }

    /**
     * Caso de teste para obter dados do cartão.
     */
    public function testCardData(): void
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
