<?php

namespace Omnipay\CieloTest;

use Omnipay\CieloTest\Message\AcceptNotificationRequest;
use Omnipay\CieloTest\Message\AuthorizeRequest;
use Omnipay\CieloTest\Message\CaptureRequest;
use Omnipay\CieloTest\Message\CompleteAuthorizeRequest;
use Omnipay\CieloTest\Message\CompletePurchaseRequest;
use Omnipay\CieloTest\Message\CreateCardRequest;
use Omnipay\CieloTest\Message\CreateCardTokenRequest;
use Omnipay\CieloTest\Message\DeleteCardRequest;
use Omnipay\CieloTest\Message\FetchTransactionRequest;
use Omnipay\CieloTest\Message\PurchaseRequest;
use Omnipay\CieloTest\Message\RefundRequest;
use Omnipay\CieloTest\Message\UpdateCardRequest;
use Omnipay\CieloTest\Message\VoidRequest;
use Omnipay\Common\AbstractGateway;

/**
 * Gateway CieloTest
 *
 * Exemplo:
 *
 * <code>
 *   // Criar um gateway para o CieloTest
 *   // (rotas para GatewayFactory::create)
 *   $gateway = Omnipay::create('CieloTest');
 *
 *   // Inicializar o gateway
 *   $gateway->initialize(array(
 *       'merchantId' => 'MeuIDComerciante',
 *       'merchantKey' => 'MinhaChaveComerciante',
 *   ));
 *
 *   // Realizar uma transação de autorização no gateway
 *   $transaction = $gateway->authorize(array(
 *       'merchant_order_id'=> '123456',
 *       'amount'           => '10.00',
 *       'soft_descriptor'  => 'test',
 *       'payment_method'   => 'CreditCard',
 *       'installments'     => 5,
 *       'card'             => $card, // $card é um objeto de cartão
 *       'customer'         => $customer, // $customer é um objeto de cliente
 *   ));
 * 
 *   $response = $transaction->send();
 *
 *   if ($response->isSuccessful()) {
 *       echo "Transação de autorização realizada com sucesso!\n";
 *   }
 * </code>
 *
 * Modos de teste:
 *
 * Para utilizar a API da Cielo em diferentes modos, como teste ou produção, é importante estar ciente de que existem endpoints distintos para cada ambiente. 
 * Ao inicializar o gateway, você pode configurar o modo de teste fornecendo o parâmetro testMode como true. 
 * Isso permite que você se conecte aos endpoints de teste, garantindo que as transações ocorram em um ambiente controlado para fins de desenvolvimento e depuração.
 * 
 * Autenticação:
 *
 * A autenticação é feita por meio de um ID de comerciante e uma chave de comerciante
 * definidos como parâmetros ao criar o objeto do gateway.
 *
 * @see \Omnipay\Common\AbstractGateway
 * @see \Omnipay\CieloTest\Message\AbstractRequest
 * @link https://developercielo.github.io/manual/cielo-ecommerce
 */
class Gateway extends AbstractGateway
{
    /**
     * Obtém o nome do gateway
     */
    public function getName()
    {
        return 'CieloTest';
    }

    /**
     * Obtém os parâmetros padrão do gateway
     */
    public function getDefaultParameters(): array
    {
        return [
            'merchantId' => '',
            'merchantKey' => '',
        ];
    }

    /**
     * Obtém o ID do comerciante
     */
    public function getMerchantId(): string
    {
        return $this->getParameter('MerchantId');
    }

    /**
     * Define o ID do comerciante
     *
     * @param string $value O ID do comerciante
     * @return Gateway
     */
    public function setMerchantId(string $value): Gateway
    {
        return $this->setParameter('MerchantId', $value);
    }

    /**
     * Obtém a chave do comerciante
     */
    public function getMerchantKey(): string
    {
        return $this->getParameter('MerchantKey');
    }

    /**
     * Define a chave do comerciante
     *
     * @param string $value A chave do comerciante
     * @return Gateway
     */
    public function setMerchantKey(string $value): Gateway
    {
        return $this->setParameter('MerchantKey', $value);
    }

    // Métodos para realizar diferentes tipos de transações

    /**
     * Inicia uma transação de autorização.
     *
     * @param array $parameters Parâmetros da transação
     * @return AuthorizeRequest Objeto de solicitação de autorização
     */
    public function authorize(array $parameters = []): AuthorizeRequest
    {
        return $this->createRequest(AuthorizeRequest::class, $parameters);
    }

    /**
     * Inicia uma transação de captura.
     *
     * @param array $parameters Parâmetros da transação
     * @return CaptureRequest Objeto de solicitação de captura
     */
    public function capture(array $parameters = []): CaptureRequest
    {
        return $this->createRequest(CaptureRequest::class, $parameters);
    }

    /**
     * Inicia uma transação de compra.
     *
     * @param array $parameters Parâmetros da transação
     * @return PurchaseRequest Objeto de solicitação de compra
     */
    public function purchase(array $parameters = []): PurchaseRequest
    {
        return $this->createRequest(PurchaseRequest::class, $parameters);
    }

    /**
     * Inicia uma transação para criar um token de cartão.
     *
     * @param array $parameters Parâmetros da transação
     * @return CreateCardTokenRequest Objeto de solicitação de criação de token de cartão
     */
    public function createTokenCard(array $parameters = []): CreateCardTokenRequest
    {
        return $this->createRequest(CreateCardTokenRequest::class, $parameters);
    }

    /**
     * Inicia uma transação para aceitar notificações.
     *
     * @param array $parameters Parâmetros da transação
     * @return AcceptNotificationRequest Objeto de solicitação de aceitação de notificações
     */
    public function acceptNotification(array $parameters = []): AcceptNotificationRequest
    {
        return $this->createRequest(AcceptNotificationRequest::class, $parameters);
    }

    /**
     * Inicia uma transação para completar uma autorização.
     *
     * @param array $parameters Parâmetros da transação
     * @return CompleteAuthorizeRequest Objeto de solicitação de conclusão de autorização
     */
    public function completeAuthorize(array $parameters = []): CompleteAuthorizeRequest
    {
        return $this->createRequest(CompleteAuthorizeRequest::class, $parameters);
    }

    /**
     * Inicia uma transação para completar uma compra.
     *
     * @param array $parameters Parâmetros da transação
     * @return CompletePurchaseRequest Objeto de solicitação de conclusão de compra
     */
    public function completePurchase(array $parameters = []): CompletePurchaseRequest
    {
        return $this->createRequest(CompletePurchaseRequest::class, $parameters);
    }

    /**
     * Inicia uma transação para criar um cartão.
     *
     * @param array $parameters Parâmetros da transação
     * @return CreateCardRequest Objeto de solicitação de criação de cartão
     */
    public function createCard(array $parameters = []): CreateCardRequest
    {
        return $this->createRequest(CreateCardRequest::class, $parameters);
    }

    /**
     * Inicia uma transação para excluir um cartão.
     *
     * @param array $parameters Parâmetros da transação
     * @return DeleteCardRequest Objeto de solicitação de exclusão de cartão
     */
    public function deleteCard(array $parameters = []): DeleteCardRequest
    {
        return $this->createRequest(DeleteCardRequest::class, $parameters);
    }

    /**
     * Inicia uma transação para buscar uma transação.
     *
     * @param array $parameters Parâmetros da transação
     * @return FetchTransactionRequest Objeto de solicitação de busca de transação
     */
    public function fetchTransaction(array $parameters = []): FetchTransactionRequest
    {
        return $this->createRequest(FetchTransactionRequest::class, $parameters);
    }

    /**
     * Inicia uma transação de estorno.
     *
     * @param array $parameters Parâmetros da transação
     * @return RefundRequest Objeto de solicitação de estorno
     */
    public function refund(array $parameters = []): RefundRequest
    {
        return $this->createRequest(RefundRequest::class, $parameters);
    }

    /**
     * Inicia uma transação de cancelamento.
     *
     * @param array $parameters Parâmetros da transação
     * @return VoidRequest Objeto de solicitação de cancelamento
     */
    public function void(array $parameters = []): VoidRequest
    {
        return $this->createRequest(VoidRequest::class, $parameters);
    }

    /**
     * Inicia uma transação para atualizar um cartão.
     *
     * @param array $parameters Parâmetros da transação
     * @return UpdateCardRequest Objeto de solicitação de atualização de cartão
     */
    public function updateCard(array $parameters = []): UpdateCardRequest
    {
        return $this->createRequest(UpdateCardRequest::class, $parameters);
    }
}
