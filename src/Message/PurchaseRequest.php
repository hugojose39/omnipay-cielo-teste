<?php

namespace Omnipay\CieloTest\Message;

/**
 * Classe PurchaseRequest
 *
 * Esta classe representa uma solicitação de compra no gateway Cielo.
 * 
 * @see \Omnipay\CieloTest\Message\AuthorizeRequest
 */
class PurchaseRequest extends AuthorizeRequest
{
    /**
     * Obtém os dados da solicitação de compra
     *
     * @return array Retorna os dados da solicitação de compra.
     */
    public function getData(): array
    {
        $data = parent::getData();
        $data['Payment']['Capture'] = true;

        return $data;
    }
}
