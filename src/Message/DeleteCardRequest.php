<?php

namespace Omnipay\CieloTest\Message;

/**
 * Classe DeleteCardRequest
 *
 * Esta classe representa uma solicitação de exclusão de cartão no gateway Cielo.
 * 
 * @see \Omnipay\CieloTest\Message\AbstractRequest
 */
class DeleteCardRequest extends AbstractRequest
{
    /**
     * Obtém os dados da solicitação
     *
     * @return array Retorna os dados da solicitação de exclusão de cartão.
     */
    public function getData(): array
    {
        $data = [
            '' => '',
        ];

        return $data;
    }
}
