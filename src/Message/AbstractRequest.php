<?php

namespace Omnipay\CieloTest\Message;

use Omnipay\Common\Message\AbstractRequest as BaseAbstractRequest;

/**
 * Classe Abstrata AbstractRequest
 *
 * Esta classe fornece funcionalidades comuns para todas as solicitações de API do CieloTest.
 * As classes de solicitação concretas estendem esta classe e implementam seus métodos abstratos.
 *
 * @see \Omnipay\Common\Message\AbstractRequest
 */
abstract class AbstractRequest extends BaseAbstractRequest
{
    /**
     * Retorna o endpoint da API com base no modo de teste.
     *
     * @return string URL do endpoint da API
     */
    public function endpoint(): string
    {
        return sprintf('https://%s.cieloecommerce.cielo.com.br/', $this->getTestMode() ? 'apisandbox' : 'api');
    }

    /**
     * Obtém o ID do pedido do comerciante.
     *
     * @return string|null ID do pedido do comerciante
     */
    public function getMerchantOrderId(): ?string
    {
        return $this->getParameter('merchant_order_id');
    }

    /**
     * Define o ID do pedido do comerciante.
     *
     * @param string $value ID do pedido do comerciante
     * @return AbstractRequest
     */
    public function setMerchantOrderId($value): AbstractRequest
    {
        return $this->setParameter('merchant_order_id', $value);
    }

    /**
     * Obtém os dados do cartão.
     *
     * @return array|null Dados do cartão
     */
    public function getCard(): ?array
    {
        return $this->getParameter('card');
    }

    /**
     * Define os dados do cartão.
     *
     * @param array $value Dados do cartão
     * @return AbstractRequest
     */
    public function setCard($value): AbstractRequest
    {
        return $this->setParameter('card', $value);
    }

    /**
     * Obtém o ID do comerciante.
     *
     * @return string|null ID do comerciante
     */
    public function getMerchantId(): ?string
    {
        return $this->getParameter('merchantId');
    }

    /**
     * Define o ID do comerciante.
     *
     * @param string $value ID do comerciante
     * @return AbstractRequest
     */
    public function setMerchantId(string $value): AbstractRequest
    {
        return $this->setParameter('merchantId', $value);
    }

    /**
     * Obtém a chave do comerciante.
     *
     * @return string|null Chave do comerciante
     */
    public function getMerchantKey(): ?string
    {
        return $this->getParameter('merchantKey');
    }

    /**
     * Define a chave do comerciante.
     *
     * @param string $value Chave do comerciante
     * @return AbstractRequest
     */
    public function setMerchantKey(string $value): AbstractRequest
    {
        return $this->setParameter('merchantKey', $value);
    }

    /**
     * Obtém os dados do cliente.
     *
     * @return array|null Dados do cliente
     */
    public function getCustomer(): ?array
    {
        return $this->getParameter('customer');
    }

    /**
     * Define os dados do cliente.
     *
     * @param array $value Dados do cliente
     * @return AbstractRequest
     */
    public function setCustomer($value): AbstractRequest
    {
        return $this->setParameter('customer', $value);
    }

    /**
     * Obtém o método HTTP para a solicitação.
     *
     * @return string Método HTTP (POST)
     */
    public function getHttpMethod(): string
    {
        return 'POST';
    }

    /**
     * Envia os dados da solicitação para o endpoint da API.
     *
     * @param mixed $data Dados da solicitação
     * @return mixed Resposta da API
     */
    public function sendData($data)
    {
        $httpRequest = $this->httpClient->request(
            $this->getHttpMethod(),
            $this->getEndpoint(),
            [
                'Content-Type' => 'application/json',
                'MerchantId' => $this->getMerchantId() ?? '',
                'MerchantKey' => $this->getMerchantKey() ?? '',
            ],
            json_encode($data),
            $this->getOptions()
        );

        $payload = json_decode($httpRequest->getBody()->getContents(), true);

        return $this->response = new Response($this, $payload);
    }

    /**
     * Retorna as opções adicionais da solicitação.
     *
     * @return mixed Opções adicionais da solicitação
     */
    protected function getOptions(): mixed
    {
        return '';
    }

    /**
     * Retorna o endpoint da API.
     *
     * @return string Endpoint da API
     */
    protected function getEndpoint()
    {
        return $this->endpoint();
    }

    /**
     * Cria uma resposta da solicitação.
     *
     * @param mixed $data Dados da resposta
     * @return mixed Resposta da solicitação
     */
    protected function createResponse($data)
    {
        return $this->response = new Response($this, $data);
    }

    /**
     * Retorna os dados do cartão.
     *
     * @return array Dados do cartão
     */
    protected function getCardData(): array
    {
        $data = [];

        $data = $this->getCard();

        return $data;
    }

    /**
     * Retorna os dados do cliente.
     *
     * @return array Dados do cliente
     */
    protected function getCustomerData(): array
    {
        $data = [];

        $data['Customer'] = $this->getCustomer();

        return $data;
    }
}
