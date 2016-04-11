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
// | William Schultz e Leandro Maniezo que por sua vez foi derivado do    |
// | PHPBoleto de João Prado Maia e Pablo Martins F. Costa                |
// |                                                                      |
// | Se vc quer colaborar, nos ajude a desenvolver p/ os demais bancos :-)|
// | Acesse o site do Projeto BoletoPhp: www.boletophp.com.br             |
// +----------------------------------------------------------------------+

// +----------------------------------------------------------------------+
// | Equipe Coordenação Projeto BoletoPhp: <boletophp@boletophp.com.br>   |
// | Desenvolvimento Boleto BANCOOB/SICOOB: Marcelo de Souza              |
// | Ajuste de algumas rotinas: Anderson Nuernberg                        |
// +----------------------------------------------------------------------+


// ------------------------- DADOS DINÂMICOS DO SEU CLIENTE PARA A GERAÇÃO DO BOLETO (FIXO OU VIA GET) -------------------- //
// Os valores abaixo podem ser colocados manualmente ou ajustados p/ formulário c/ POST, GET ou de BD (MySql,Postgre,etc)	//

// DADOS DO BOLETO PARA O SEU CLIENTE
$dias_de_prazo_para_pagamento = $this->dias_de_prazo_para_pagamento;
$taxa_boleto = $this->taxa_boleto;
$data_venc = date("d/m/Y", time() + ($dias_de_prazo_para_pagamento * 86400));  // Prazo de X dias OU informe data: "13/04/2006";
$valor_cobrado = $this->pedido['quantidade'] * $this->pedido['valor_unitario']; // Valor - REGRA: Sem pontos na milhar e tanto faz com "." ou "," ou com 1 ou 2 ou sem casa decimal
$valor_cobrado = str_replace(",", ".",$valor_cobrado);
$valor_boleto=number_format($valor_cobrado+$taxa_boleto, 2, ',', '');

//$dadosboleto["nosso_numero"] = $this->cedente['nosso_numero'];  // Até 8 digitos, sendo os 2 primeiros o ano atual (Ex.: 08 se for 2008)


/*************************************************************************
 * +++
 *************************************************************************/

// http://www.bancoob.com.br/atendimentocobranca/CAS/2_Implanta%C3%A7%C3%A3o_do_Servi%C3%A7o/Sistema_Proprio/DigitoVerificador.htm
// http://blog.inhosting.com.br/calculo-do-nosso-numero-no-boleto-bancoob-sicoob-do-boletophp/
// http://www.samuca.eti.br
//
// http://www.bancoob.com.br/atendimentocobranca/CAS/2_Implanta%C3%A7%C3%A3o_do_Servi%C3%A7o/Sistema_Proprio/LinhaDigitavelCodicodeBarras.htm

// Contribuição de script por:
//
// Samuel de L. Hantschel
// Site: www.samuca.eti.br
//

if(!function_exists('formata_numdoc'))
{
	function formata_numdoc($num,$tamanho)
	{
		while(strlen($num)<$tamanho)
		{
			$num="0".$num;
		}
		return $num;
	}
}

$IdDoSeuSistemaAutoIncremento = '2'; // Deve informar um numero sequencial a ser passada a função abaixo, Até 6 dígitos
$agencia = explode('-',$this->cedente['agencia']);
$agencia = $agencia[0]; // Num da agencia, sem digito
$conta = explode('-',$this->cedente['conta']);
$conta = $conta[0]; // Num da conta, sem digito
$convenio = "56235"; //Número do convênio indicado no frontend

$NossoNumero = formata_numdoc($IdDoSeuSistemaAutoIncremento,7);
$qtde_nosso_numero = strlen($NossoNumero);
$sequencia = formata_numdoc($agencia,4).formata_numdoc(str_replace("-","",$convenio),10).formata_numdoc($NossoNumero,7);
$cont=0;
$calculoDv = '';
for($num=0;$num<=strlen($sequencia);$num++)
{
	$cont++;
	if($cont == 1)
	{
		// constante fixa Sicoob » 3197
		$constante = 3;
	}
	if($cont == 2)
	{
		$constante = 1;
	}
	if($cont == 3)
	{
		$constante = 9;
	}
	if($cont == 4)
	{
		$constante = 7;
		$cont = 0;
	}
	$calculoDv = $calculoDv + (substr($sequencia,$num,1) * $constante);
}
$Resto = $calculoDv % 11;
$Dv = 11 - $Resto;
if ($Dv == 0) $Dv = 0;
if ($Dv == 1) $Dv = 0;
if ($Dv > 9) $Dv = 0;
$dadosboleto["nosso_numero"] = $NossoNumero . $Dv;

/*************************************************************************
 * +++
 *************************************************************************/



$dadosboleto["numero_documento"] = $this->pedido['numero'];	// Num do pedido ou do documento
$dadosboleto["data_vencimento"] = $data_venc; // Data de Vencimento do Boleto - REGRA: Formato DD/MM/AAAA
$dadosboleto["data_documento"] = date("d/m/Y"); // Data de emissão do Boleto
$dadosboleto["data_processamento"] = date("d/m/Y"); // Data de processamento do boleto (opcional)
$dadosboleto["valor_boleto"] = $valor_boleto; 	// Valor do Boleto - REGRA: Com vírgula e sempre com duas casas depois da virgula

// DADOS DO SEU CLIENTE
$dadosboleto["sacado"] = $this->sacado['nome'];
$dadosboleto["endereco1"] = $this->sacado['endereco'];
$dadosboleto["endereco2"] = "{$this->sacado['cidade']}, {$this->sacado['uf']} -  CEP: {$this->sacado['cep']}";

// INFORMACOES PARA O CLIENTE
$dadosboleto["demonstrativo1"] = $this->demonstrativo['linha1'];
$dadosboleto["demonstrativo2"] = $this->demonstrativo['linha2'] . number_format($taxa_boleto, 2, ',', '');
$dadosboleto["demonstrativo3"] = $this->demonstrativo['linha3'];

// INSTRUÇÕES PARA O CAIXA
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
// DADOS ESPECIFICOS DO SICOOB
$dadosboleto["modalidade_cobranca"] = "02";
$dadosboleto["numero_parcela"] = "901";


// DADOS DA SUA CONTA - BANCO SICOOB
$dadosboleto["agencia"] = $this->cedente['agencia']; // Num da agencia, sem digito
$conta = explode('-',$this->cedente['conta']);
$dadosboleto["conta"] = $conta[0]; 	// Num da conta, sem digito

// DADOS PERSONALIZADOS - SICOOB
$dadosboleto["convenio"] = $convenio; // Num do convênio - REGRA: No máximo 7 dígitos
$dadosboleto["carteira"] = $this->cedente['carteira'];

// SEUS DADOS
$dadosboleto["identificacao"] = $this->cedente['nome'];
$dadosboleto["cpf_cnpj"] = $this->cedente['cpf_cnpj'];
$dadosboleto["endereco"] = $this->cedente['endereco'];
$dadosboleto["cidade_uf"] = "{$this->cedente['cidade']} / {$this->cedente['uf']}";
$dadosboleto["cedente"] = $this->cedente['nome'];

// NÃO ALTERAR!
include("include/funcoes_bancoob.php");
include("include/layout_bancoob.php");
?>
