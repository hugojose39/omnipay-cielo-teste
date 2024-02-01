<?php

namespace Omnipay\CieloTest\Message;

/**
 * Classe FetchTransactionRequest
 *
 * Esta classe representa uma solicitação para recuperar detalhes de uma transação no gateway Cielo.
 * 
 * @see \Omnipay\CieloTest\Message\AbstractRequest
 */
class FetchTransactionRequest extends AbstractRequest
{
    /**
     * Obtém os dados da solicitação
     *
     * @return array Retorna os dados da solicitação para recuperar detalhes da transação.
     */
    public function getData(): array
    {
        $data = [];

        return $data;
    }
}
