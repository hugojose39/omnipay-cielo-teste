<?php

namespace Omnipay\CieloTest\Message;

use Omnipay\Common\Message\AbstractResponse;
use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * Classe Response
 *
 * Esta classe representa a resposta de uma solicitação no gateway Cielo.
 */
class Response extends AbstractResponse
{
    /**
     * Verifica se a solicitação foi bem-sucedida.
     *
     * @return bool Retorna true se a solicitação foi bem-sucedida, caso contrário, false.
     */
    public function isSuccessful(): bool
    {
        return isset($this->data['MerchantOrderId']) || isset($this->data['CardToken']) || isset($this->data['Status']);
    }

    /**
     * Obtém a referência da transação.
     *
     * @return string|null Retorna a referência da transação, se disponível, caso contrário, null.
     */
    public function getTransactionReference(): ?string
    {
        if (isset($this->data['Payment']['PaymentId'])) {
            return $this->data['Payment']['PaymentId'];
        }

        if (isset($this->data['Tid'])) {
            return $this->data['Tid'];
        }

        return null;
    }

    /**
     * Obtém a referência do cartão.
     *
     * @return mixed Retorna a referência do cartão, se disponível, caso contrário, null.
     */
    public function getCardReference(): mixed
    {
        if (isset($this->data['CardToken'])) {
            return $this->data['CardToken'];
        } elseif (isset($this->data['MerchantOrderId']) && isset($this->data['Payment']['CreditCard'])) {
            return $this->data['Payment']['CreditCard'];
        }

        return null;
    }

    /**
     * Obtém a referência do cliente.
     *
     * @return array|null Retorna a referência do cliente, se disponível, caso contrário, null.
     */
    public function getCustomerReference(): ?array
    {
        if (isset($this->data['MerchantOrderId']) && isset($this->data['Customer'])) {
            return $this->data['Customer'];
        }

        return null;
    }

    /**
     * Obtém a mensagem de erro, se houver.
     *
     * @return JsonResponse|null Retorna a mensagem de erro, se houver, caso contrário, null.
     */
    public function getMessage(): ?JsonResponse
    {
        if (!$this->isSuccessful()) {
            return new JsonResponse([
                'code' => $this->data[0]['Code'], 
                'error' => $this->data[0]['Message'],
            ], 400);
        }

        return null;
    }

    /**
     * Obtém os detalhes do boleto, se houver.
     *
     * @return array|null Retorna os detalhes do boleto, se houver, caso contrário, null.
     */
    public function getBoleto(): ?array
    {
        if (isset($this->data['MerchantOrderId']) && isset($this->data['Payment']['BarCodeNumber'])) {
            return [
                'boleto_url' => $this->data['Payment']['Url'],
                'boleto_barcode' => $this->data['Payment']['BarCodeNumber'],
                'digitable_line' => $this->data['Payment']['DigitableLine'],
                'boleto_expiration_date' => $this->data['Payment']['ExpirationDate'],
            ];
        }

        return null;
    }
}
