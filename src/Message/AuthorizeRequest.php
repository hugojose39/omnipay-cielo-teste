<?php

namespace Omnipay\CieloTest\Message;

/**
 * Classe AuthorizeRequest
 *
 * Esta classe representa uma solicitação de autorização no gateway Cielo.
 * 
 * @see \Omnipay\CieloTest\Message\AbstractRequest
 */
class AuthorizeRequest extends AbstractRequest
{
    /**
     * Obtém o número de parcelas
     *
     * @return int|null Retorna o número de parcelas ou null se não estiver definido.
     */
    public function getInstallments(): ?int
    {
        return $this->getParameter('installments');
    }

    /**
     * Define o número de parcelas
     *
     * @param int $value O número de parcelas a ser definido.
     * @return AuthorizeRequest Retorna a própria instância do objeto AuthorizeRequest.
     */
    public function setInstallments(int $value): AuthorizeRequest
    {
        return $this->setParameter('installments', (int)$value);
    }

    /**
     * Obtém o descritor suave
     *
     * @return string|null Retorna o descritor suave ou null se não estiver definido.
     */
    public function getSoftDescriptor(): ?string
    {
        return $this->getParameter('soft_descriptor');
    }

    /**
     * Define o descritor suave
     *
     * @param string $value O descritor suave a ser definido.
     * @return AuthorizeRequest Retorna a própria instância do objeto AuthorizeRequest.
     */
    public function setSoftDescriptor(string $value): AuthorizeRequest
    {
        return $this->setParameter('soft_descriptor', substr($value, 0, 13));
    }

    /**
     * Obtém o provedor
     *
     * @return string|null Retorna o provedor ou null se não estiver definido.
     */
    public function getProvider(): ?string
    {
        return $this->getParameter('provider');
    }

    /**
     * Define o provedor
     *
     * @param string $value O provedor a ser definido.
     * @return AuthorizeRequest Retorna a própria instância do objeto AuthorizeRequest.
     */
    public function setProvider(string $value): AuthorizeRequest
    {
        return $this->setParameter('provider', $value);
    }

    /**
     * Obtém os dados da solicitação
     *
     * @return array Retorna os dados da solicitação de autorização.
     */
    public function getData(): array
    {
        $this->validate('amount');

        $data = [];

        $data['MerchantOrderId'] = $this->getMerchantOrderId();
        $data['Payment']['Amount'] = $this->getAmountInteger();
        $data['Payment']['Type'] = $this->getPaymentMethod();
        $data['Payment']['Installments'] = $this->getInstallments();
        $data['Payment']['SoftDescriptor'] = $this->getSoftDescriptor();

        if ($this->getPaymentMethod() && (strtolower($this->getPaymentMethod()) == 'boleto')) {
            $data['Payment']['Provider'] = $this->getProvider();

            $data = array_merge($data, $this->getCustomerData());
        } elseif ($this->getCard()) {
            $data['Payment']['CreditCard'] = $this->getCardData();

            $data = array_merge($data, $this->getCustomerData());
        }

        $data['Payment']['Capture'] = false;

        return $data;
    }

    /**
     * Obtém o endpoint da solicitação
     *
     * @return string Retorna o endpoint da solicitação de autorização.
     */
    public function getEndpoint(): string
    {
        return $this->endpoint().'1/sales';
    }
}
