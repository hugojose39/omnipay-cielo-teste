<?php

namespace Omnipay\CieloTest\Message;

/**
 * Classe RefundRequest
 *
 * Esta classe representa uma solicitação de reembolso no gateway Cielo.
 */
class RefundRequest extends AbstractRequest
{
    /**
     * Obtém os dados da solicitação de reembolso.
     *
     * @return array Retorna os dados da solicitação de reembolso.
     */
    public function getData(): array
    {
        $data = [
            '' => '',
        ];

        return $data;
    }
}
