<?php
// +----------------------------------------------------------------------+
// | BoletoPhp - Versão Beta                                              |
// +----------------------------------------------------------------------+
// | Este arquivo está disponível sob a Licença GPL disponível pela Web   |
// | em http://pt.wikipedia.org/wiki/GNU_General_Public_License           |
// | Você deve ter recebido uma cópia da GNU Public License junto com     |
// | esse pacote; se não, escreva para:                                   |
// |                                                                      |
// | Free Software Foundation, Inc.                                       |
// | 59 Temple Place - Suite 330                                          |
// | Boston, MA 02111-1307, USA.                                          |
// +----------------------------------------------------------------------+

// +----------------------------------------------------------------------+
// | Originado do Projeto BBBoletoFree que tiveram colaborações de Daniel |
// | William Schultz e Leandro Maniezo que por sua vez foi derivado do	  |
// | PHPBoleto de João Prado Maia e Pablo Martins F. Costa                |
// |                                                                      |
// | Se vc quer colaborar, nos ajude a desenvolver p/ os demais bancos :-)|
// | Acesse o site do Projeto BoletoPhp: www.boletophp.com.br             |
// +----------------------------------------------------------------------+

// +----------------------------------------------------------------------+
// | Equipe Coordenação Projeto BoletoPhp: <boletophp@boletophp.com.br>   |
// | Desenvolvimento Boleto Bradesco: Ramon Soares                        |
// +----------------------------------------------------------------------+

/**
 * Boleto Sofisa para carteira 121
 *
 * @package     BoletoPhp
 * @author      Diego M. Agudo ( diego@agudo.eti.br )
 */


// DADOS DO BOLETO PARA O SEU CLIENTE
$taxa_boleto                        = $this->taxa_boleto;
$data_venc                          = date("d/m/Y", time() + ($this->dias_de_prazo_para_pagamento * 86400));
$valor_cobrado                      = $this->pedido['quantidade'] * $this->pedido['valor_unitario'];
$valor_cobrado                      = str_replace(",", ".",$valor_cobrado);
$valor_boleto                       = number_format($valor_cobrado+$taxa_boleto, 2, ',', '');

$dadosboleto["nosso_numero"]        = $this->cedente['nosso_numero'];                // Nosso numero DV - REGRA: Máximo de 10 caracteres!
$dadosboleto["numero_documento"]    = $this->pedido['numero']; // Num do pedido ou do documento = Nosso numero
$dadosboleto["data_vencimento"]     = $data_venc;                   // Data de Vencimento do Boleto - REGRA: Formato DD/MM/AAAA

$dadosboleto["data_documento"]      = date("d/m/Y");    // Data de processamento do boleto (opcional)
$dadosboleto["data_processamento"]  = date("d/m/Y");    // Data de processamento do boleto (opcional)

$dadosboleto["valor_boleto"]        = $valor_boleto;    // Valor do Boleto - REGRA: Com vírgula e sempre com duas casas depois da virgula

// DADOS DO SEU CLIENTE
$dadosboleto["sacado"] = $this->sacado['nome'];
$dadosboleto["endereco1"] = $this->sacado['endereco'];
$dadosboleto["endereco2"] = "{$this->sacado['cidade']}, {$this->sacado['uf']} -  CEP: {$this->sacado['cep']}";

// INFORMACOES PARA O CLIENTE

$dadosboleto["demonstrativo1"] = $this->demonstrativo['linha1'];
$dadosboleto["demonstrativo2"] = $this->demonstrativo['linha2'] . number_format($taxa_boleto, 2, ',', '');
$dadosboleto["demonstrativo3"] = $this->demonstrativo['linha3'];

$dadosboleto["instrucoes1"] = $this->instrucoes['linha1'];
$dadosboleto["instrucoes2"] = $this->instrucoes['linha2'];
$dadosboleto["instrucoes3"] = $this->instrucoes['linha3'];
$dadosboleto["instrucoes4"] = $this->instrucoes['linha4'];

// DADOS OPCIONAIS DE ACORDO COM O BANCO OU CLIENTE
$dadosboleto["quantidade"] = $this->pedido['quantidade'];
$dadosboleto["valor_unitario"] = $this->pedido['valor_unitario'];
$dadosboleto["aceite"] = $this->pedido['aceite'];
$dadosboleto["especie"] = $this->pedido['especie'];
$dadosboleto["especie_doc"] = $this->pedido['especie_doc'];


// ---------------------- DADOS FIXOS DE CONFIGURAÇÃO DO SEU BOLETO --------------- //


// DADOS DA SUA CONTA
$agencia = explode('-',$this->cedente['agencia']);
$dadosboleto["agencia"]             = $agencia[0];     // Num da agencia, sem digito
$dadosboleto["agencia_dv"]          = $agencia[1];  // Digito do Num da agencia
$conta = explode('-',$this->cedente['conta']);
$dadosboleto["conta"]               = $conta[0];       // Num da conta, sem digito
$dadosboleto["conta_dv"]            = $conta[1];    // Digito do Num da conta

// DADOS PERSONALIZADOS
$conta_cedente = explode('-',$this->cedente['conta_cedente']);
$dadosboleto["conta_cedente"]       = $conta_cedente[0];    // ContaCedente do Cliente, sem digito (Somente Números)
$dadosboleto["conta_cedente_dv"]    = $conta_cedente[1]; // Digito da ContaCedente do Cliente
$dadosboleto["carteira"]            = $this->cedente['carteira'];                    // Código da Carteira: 121

// SEUS DADOS
$dadosboleto["identificacao"] = $this->cedente['nome'];
$dadosboleto["cpf_cnpj"] = $this->cedente['cpf_cnpj'];
$dadosboleto["endereco"] = $this->cedente['endereco'];
$dadosboleto["cidade_uf"] = "{$this->cedente['cidade']} / {$this->cedente['uf']}";
$dadosboleto["cedente"] = $this->cedente['nome'];


// NÃO ALTERAR!
include("include/funcoes_sofisa.php");
include("include/layout_sofisa.php");
?>
