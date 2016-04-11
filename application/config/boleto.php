<?php
/**
 * CodeIgniter Boleto
 *
 * @package    CodeIgniter Boleto
 * @author     Natan Felles
 * @link       https://github.com/natanfelles/codeigniter-boleto
 */
defined('BASEPATH') OR exit('No direct script access allowed');

/*
 | -------------------------------------------------------------------
 | PADRÃO
 | -------------------------------------------------------------------
 | TRUE = Usar as configurações desse arquivo
 | FALSE = Não usar as configurações desse arquivo
*/
$config['boleto']['padrao'] = TRUE;

/*
 | -------------------------------------------------------------------
 | BANCO
 | -------------------------------------------------------------------
 | bancoob = Banco Cooperativo do Brasil S/A
 | banespa = Banco do Estado de São Paulo
 | banestes =  Banco do Estado do Espírito Santo
 | bb = Banco do Brasil
 | besc = Banco do Estado de Santa Catarina
 | bradesco = Bradesco
 | cef = Caixa Econômica Federal
 | cef_sigcb = Caixa Econômica Federal SIGCB
 | cef_sinco = Caixa Econômica Federal SINCO
 | hsbc = HSBC Bank Brasil
 | itau = Itaú Unibanco
 | nossacaixa = Banco Nossa Caixa
 | real = Banco Real
 | santander_banespa = Santander Banespa
 | sicredi = Banco Cooperativo Sicredi - BANSICREDI
 | sofisa = Banco Sofisa
 | sudameris = Banco Sudameris
 | unibanco = Unibanco
 */
$config['boleto']['banco'] = 'cef';

/*
 | -------------------------------------------------------------------
 | CEDENTE
 | -------------------------------------------------------------------
 */
$config['boleto']['cedente'] = array(
	'nome'    => 'Natan Felles',
	'cpf_cnpj'    => '000111222-33',
	'agencia' => '1234-8',
	'conta'  => '56789-10',
	'conta_cedente'  => '987654-5',
	'carteira'  => '5',
	'nosso_numero'  => '12345678',
	'endereco' => 'Rua Logo Ali, 777',
	'cidade' => 'Sapiranga',
	'uf' => 'RS',
);

/*
 | -------------------------------------------------------------------
 | DEMONSTRATIVO
 | -------------------------------------------------------------------
 */
$config['boleto']['demonstrativo'] = array(
	'linha1' => 'Pagamento de Compra na Loja Nononononoa',
	'linha2' => 'Mensalidade referente a nonon nonooon nononon <br> Taxa bancária - ',
	'linha3' => 'BoletoPhp - http://www.boletophp.com.br',
);

/*
 | -------------------------------------------------------------------
 | INSTRUÇÕES
 | -------------------------------------------------------------------
 */
$config['boleto']['instrucoes'] = array(
	'linha1' => '- Sr. Caixa, cobrar multa de 5% após o vencimento',
	'linha2' => '- Receber até 10 dias após o vencimento',
	'linha3' => '- Em caso de dúvidas entre em contato conosco: xxxx@xxxx.com.br',
	'linha4' => '- Emitido pelo sistema Projeto BoletoPhp - www.boletophp.com.br',
);

/*
 | -------------------------------------------------------------------
 | LOCAL DAS IMAGENS
 | -------------------------------------------------------------------
 */
$config['boleto']['imagens'] = 'assets/img/boleto';
