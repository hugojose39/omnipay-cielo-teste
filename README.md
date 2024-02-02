# Projeto biblioteca de pagamento no padrão da Omnipay para o Cielo

**Esta seção da documentação destina-se ao desenvolvimento da biblioteca, testes e possíveis problemas. Se você estiver focado apenas na utilização da biblioteca, clique aqui [CieloTest](#omnipay-cielo).**

Baixe o código-fonte em um arquivo zip, ou, se você tiver o Git instalado, use o comando git clone. Escolha a opção que melhor se adapta às suas necessidades - **HTTPS, SSH, GitHub CLI**. Abaixo estão as configurações para o ambiente de desenvolvimento.

## Tecnologias usadas
 * PHP
 * Composer
 * GIT
 * Omnipay Common
 * Omnipay Tests

## Começando

Para começar a utilizar a biblioteca em desenvolvimento, você precisa ter o seguinte configurado:

- PHP: Certifique-se de que o PHP está instalado e disponível no seu sistema. Você pode verificar se o PHP está instalado executando o seguinte comando:
``` bash
$  php --version
```

- Composer: Certifique-se de que o Composer está instalado e disponível no seu sistema. Você pode verificar se o Composer está instalado executando o seguinte comando:
``` bash
$  composer --version
```

## Clonando o projeto

Escolha uma das opções abaixo ou baixe o projeto em formato zip:

``` bash
$    HTTPS - git clone https://github.com/hugojose39/omnipay-cielo-teste.git
$    SSH - git clone git@github.com:hugojose39/omnipay-cielo-teste.git
$    GitHub CLI - gh repo clone hugojose39/omnipay-cielo-teste
```

Quando o projeto estiver em seu computador, acesse sua pasta e execute os comandos no seu terminal:

* O seguinte comando automatiza a instalação das dependências do projeto usando o Composer:

``` bash
$   ./build composer install
```

* O próximo comando executa todos os testes disponíveis:

``` bash
$   ./build composer test
```

* Se preferir executar os testes individualmente, copie o caminho relativo e forneça-o, por exemplo:

``` bash
$   ./build composer test tests/Message/PurchaseRequestTest.php
```

### Possíveis problemas

Durante o processo de configuração e utilização da biblioteca, esteja atento aos seguintes possíveis problemas:

* Tentar utilizar o Composer sem ter o PHP instalado previamente.
* Clonar o projeto sem ter instalado o GIT anteriormente.
* Executar os comandos do Composer fora do diretório do projeto.
* Executar os comandos do Composer sem usar o prefixo "./build".
* Tentar executar um teste individual passando um caminho incorreto.

**Observação: Todas as classes, inclusive os testes, possuem comentários que explicam sua funcionalidade.**

Seguindo esses passos, você terá o código da biblioteca instalado corretamente, com suas dependências e testes executados de maneira apropriada.

Se ocorrerem problemas durante o processo de configuração, verifique se todas as dependências foram instaladas corretamente e se todas as etapas foram seguidas adequadamente.

Agora que você conhece o código por trás da biblioteca, você pode visualizá-lo no Packagist:
[omnipay-cielo-teste](https://packagist.org/packages/hugojose39/omnipay-cielo-teste)

Por fim, sinta-se à vontade para usá-lo em seus projetos Laravel seguindo os passos abaixo.

# Omnipay: Cielo

**Gateway Cielo para biblioteca de processamento de pagamentos Omnipay PHP**

[![Software License](https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square)](LICENSE)

[Omnipay](https://github.com/thephpleague/omnipay) é um sistema de pagamento multigateway independente de estrutura biblioteca de processamento para PHP 5.3+. Este pacote implementa suporte Cielo para Omnipay.

## Instalar

Via Composer

``` bash
$ composer require hugojose39/omnipay-cielo-teste
```

## Uso básico

O seguinte gateway é fornecido por este pacote:

 * [Cielo](https://cielo.com.br/)

Para obter instruções gerais de uso, consulte o [Omnipay](https://github.com/thephpleague/omnipay) principal
repositório.

### Exemplo de transação autorizada com Cartão de crédito
``` php
    // Crie um gateway para o Cielo Gateway
    // (rotas para GatewayFactory::create)
    $gateway = Omnipay::create('CieloTest');
  
    // Inicialize o gateway
    $gateway->initialize([
        'merchantId' => 'MyMerchantId',
        'merchantKey' => 'MyMerchantKey',
    ]);
  
    // Crie um objeto de cartão
    // Ele será usado nos testes
    $card = [
      'CardNumber' =>'4024007197692931',
      'Holder' =>'Teste Holder',
      'ExpirationDate' =>'12/2030',
      'SecurityCode' =>'123',
      'Brand' =>'Visa'
    ];
  
    // Crie um objeto de cliente
    // Ele será usado nos testes
    $customer = [
      'Name' => 'Comprador Teste Cartão de crédito',
      'Identity' => '1234567890',
      'Address' => [
          'Street' => 'Avenida Marechal Câmara',
          'Number' => '160',
          'Complement' => 'Sala 934',
          'ZipCode' => '22750012',
          'District' => 'Centro',
          'City' => 'Rio de Janeiro',
          'State' => 'RJ',
          'Country' => 'BRA'
      ],
    ];
  
    // Faça uma transação autorizada no gateway
    $transaction = $gateway->authorize([
        'merchant_order_id'=> '123456',
        'amount'           => '10.00',
        'soft_descriptor'  => 'test',
        'payment_method'   => 'CreditCard',
        'installments'     => 5,
        'card'             => $card,
        'customer'         => $customer
    ]);
  
    $response = $transaction->send();
  
    if ($response->isSuccessful()) {
        echo "Transação autorizada com sucesso!\n";
        $saleId = $response->getTransactionReference();
        $customerData = $response->getCustomerReference();
        $cardData = $response->getCardReference();
    } else {
        return $response->getMessage();
    }
```

### Exemplo de transação autorizada com Boleto

``` php
    // Crie um gateway para o Cielo Gateway
    // (rotas para GatewayFactory::create)
    $gateway = Omnipay::create('CieloTest');
    // Inicialize o gateway
    $gateway->initialize([
        'merchantId' => 'MyMerchantId',
        'merchantKey' => 'MyMerchantKey',
    ]);

    // Crie um objeto de cliente
    // Ele será usado nos testes
    $customer = [
      'Name' => 'Comprador Teste Boleto',
      'Identity' => '1234567890',
      'Address' => [
          'Street' => 'Avenida Marechal Câmara',
          'Number' => '160',
          'Complement' => 'Sala 934',
          'ZipCode' => '22750012',
          'District' => 'Centro',
          'City' => 'Rio de Janeiro',
          'State' => 'RJ',
          'Country' => 'BRA'
      ],
    ];

    // Faça uma transação autorizada no gateway
    $transaction = $gateway->authorize([
        'merchant_order_id'=> '123456',
        'amount'           => '10.00',
        'provider'         => 'Bradesco',
        'payment_method'   => 'Boleto',
        'customer'         => $customer
    ]);

    $response = $transaction->send();

    if ($response->isSuccessful()) {
        echo "Transação autorizada com sucesso!\n";
        $saleId = $response->getTransactionReference();
        $customerData = $response->getCustomerReference();
        $boletoData = $response->getBoleto();
    } else {
        return $response->getMessage();
    }   
```

### Exemplo de transação com Cartão de crédito
``` php
    // Crie um gateway para o Cielo Gateway
    // (rotas para GatewayFactory::create)
    $gateway = Omnipay::create('CieloTest');
  
    // Inicialize o gateway
    $gateway->initialize([
        'merchantId' => 'MyMerchantId',
        'merchantKey' => 'MyMerchantKey',
    ]);
  
    // Crie um objeto de cartão
    // Ele será usado nos testes
    $card = [
      'CardNumber' =>'4024007197692931',
      'Holder' =>'Teste Holder',
      'ExpirationDate' =>'12/2030',
      'SecurityCode' =>'123',
      'Brand' =>'Visa'
    ];
  
    // Crie um objeto de cliente
    // Ele será usado nos testes
    $customer = [
      'Name' => 'Comprador Teste Cartão de crédito',
      'Identity' => '1234567890',
      'Address' => [
          'Street' => 'Avenida Marechal Câmara',
          'Number' => '160',
          'Complement' => 'Sala 934',
          'ZipCode' => '22750012',
          'District' => 'Centro',
          'City' => 'Rio de Janeiro',
          'State' => 'RJ',
          'Country' => 'BRA'
      ],
    ];
  
    // Faça uma transação no gateway
    $transaction = $gateway->purchase([
        'merchant_order_id'=> '123456',
        'amount'           => '10.00',
        'soft_descriptor'  => 'test',
        'payment_method'   => 'CreditCard',
        'installments'     => 5,
        'card'             => $card,
        'customer'         => $customer
    ]);
  
    $response = $transaction->send();
  
    if ($response->isSuccessful()) {
        echo "Transação efetuada com sucesso!\n";
        $saleId = $response->getTransactionReference();
        $customerData = $response->getCustomerReference();
        $cardData = $response->getCardReference();
    } else {
        return $response->getMessage();
    }
```

### Exemplo de transação com Boleto

``` php
    // Crie um gateway para o Cielo Gateway
    // (rotas para GatewayFactory::create)
    $gateway = Omnipay::create('CieloTest');
    // Inicialize o gateway
    $gateway->initialize([
        'merchantId' => 'MyMerchantId',
        'merchantKey' => 'MyMerchantKey',
    ]);

    // Crie um objeto de cliente
    // Ele será usado nos testes
    $customer = [
      'Name' => 'Comprador Teste Boleto',
      'Identity' => '1234567890',
      'Address' => [
          'Street' => 'Avenida Marechal Câmara',
          'Number' => '160',
          'Complement' => 'Sala 934',
          'ZipCode' => '22750012',
          'District' => 'Centro',
          'City' => 'Rio de Janeiro',
          'State' => 'RJ',
          'Country' => 'BRA'
      ],
    ];

    // Faça uma transação autorizada no gateway
    $transaction = $gateway->purchase([
        'merchant_order_id'=> '123456',
        'amount'           => '10.00',
        'provider'         => 'Bradesco',
        'payment_method'   => 'Boleto',
        'customer'         => $customer
    ]);

    $response = $transaction->send();

    if ($response->isSuccessful()) {
        echo "Transação efetuada com sucesso!\n";
        $saleId = $response->getTransactionReference();
        $customerData = $response->getCustomerReference();
        $boletoData = $response->getBoleto();
    } else {
        return $response->getMessage();
    }
```

### Exemplo de captura de transação
``` php
    // Crie um gateway para o Cielo Gateway
    // (rotas para GatewayFactory::create)
    $gateway = Omnipay::create('CieloTest');
  
    // Inicialize o gateway
    $gateway->initialize([
        'merchantId' => 'MyMerchantId',
        'merchantKey' => 'MyMerchantKey',
    ]);
  
    // Capture uma transação no gateway
    $transaction = $gateway->capture([
        'amount'                => '10.00',
        'transactionReference'  => '123456',
    ]);
  
    $response = $transaction->send();
  
    if ($response->isSuccessful()) {
        echo "Transação capturada com sucesso!\n";
        $saleId = $response->getTransactionReference();
    } else {
        return $response->getMessage();
    }
```

### Exemplo de tokenização do cartão de crédito
``` php
    // Crie um gateway para o Cielo Gateway
    // (rotas para GatewayFactory::create)
    $gateway = Omnipay::create('CieloTest');
  
    // Inicialize o gateway
    $gateway->initialize([
        'merchantId' => 'MyMerchantId',
        'merchantKey' => 'MyMerchantKey',
    ]);
  
    // Capture uma transação no gateway
    $transaction = $gateway->createTokenCard([
        'card' => [
            'CustomerName' => 'Comprador Teste Cielo',
            'CardNumber' => '4024007197692931',
            'Holder' => 'Comprador T Cielo',
            'ExpirationDate' => '12/2030',
            'Brand' => 'Visa',
        ],
    ]);
  
    $response = $transaction->send();
  
    if ($response->isSuccessful()) {
        echo "Token criado com sucesso!\n";
        $cardData = $response->getCardReference();
    } else {
        return $response->getMessage();
    }
```

## Modo de teste

Para utilizar a API da Cielo em diferentes modos, como teste ou produção, é importante estar ciente de que existem endpoints distintos para cada ambiente. Ao inicializar o gateway, você pode configurar o modo de teste fornecendo o parâmetro testMode como true. Isso permite que você se conecte aos endpoints de teste, garantindo que as transações ocorram em um ambiente controlado para fins de desenvolvimento e depuração.

## Licença

Este projeto é licenciado sob a Licença MIT.
