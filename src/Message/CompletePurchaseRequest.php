<?php

namespace Omnipay\CieloTest\Message;

/**
 * Classe CompletePurchaseRequest
 *
 * Esta classe representa uma solicitação de conclusão de compra no gateway Cielo.
 * 
 * @see \Omnipay\CieloTest\Message\AbstractRequest
 */
class CompletePurchaseRequest extends AbstractRequest
{
    /**
     * Obtém os dados da solicitação
     *
     * @return array Retorna os dados da solicitação de conclusão de compra.
     */
    public function getData(): array
    {
        $data = [
            '' => '',
        ];

        return $data;
    }
}
