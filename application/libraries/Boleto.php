<?php
/**
 * CodeIgniter Boleto
 *
 * @package    CodeIgniter Boleto
 * @author     Natan Felles
 * @link       https://github.com/natanfelles/codeigniter-boleto
 */
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Class Boleto
 */
class Boleto {

	protected $CI;

	protected $banco = '';

	protected $cedente = array(
		'nome'          => '',
		'cpf_cnpj'      => '',
		'agencia'       => '',
		'conta'         => '',
		'conta_cedente' => '',
		'carteira'      => '',
		'nosso_numero'  => '',
		'endereco'      => '',
		'cidade'        => '',
		'uf'            => '',
		'cep'           => '',
	);

	protected $demonstrativo = array(
		'linha1' => '',
		'linha2' => '',
		'linha3' => '',
	);

	protected $instrucoes = array(
		'linha1' => '',
		'linha2' => '',
		'linha3' => '',
		'linha4' => '',
	);

	protected $imagens = '';

	protected $pedido = array(
		'quantidade'     => '',
		'valor_unitario' => '',
		'aceite'         => '',
		'especie'        => 'R$',
		'especie_doc'    => '',
		'numero'         => '',
	);

	protected $sacado = array(
		'nome'          => '',
		'cpf_cnpj'      => '',
		'agencia'       => '',
		'conta'         => '',
		'conta_cedente' => '',
		'carteira'      => '',
		'nosso_numero'  => '',
		'endereco'      => '',
		'cidade'        => '',
		'uf'            => '',
		'cep'           => '',
	);

	protected $dias_de_prazo_para_pagamento = 0;

	protected $taxa_boleto = 0;


	public function __construct()
	{
		$this->CI =& get_instance();
		$this->CI->config->load('boleto');
		$dados = $this->CI->config->item('boleto');
		if ($dados['padrao'] === TRUE)
		{
			$this->setup($dados);
		}
	}


	public function bancoob($dados = array())
	{
		$this->setup($dados);
		include 'boleto/boleto_bancoob.php';
	}


	public function banespa($dados = array())
	{
		$this->setup($dados);
		include 'boleto/boleto_banespa.php';
	}


	public function banestes($dados = array())
	{
		$this->setup($dados);
		include 'boleto/boleto_banestes.php';
	}


	public function bb($dados = array())
	{
		$this->setup($dados);
		include 'boleto/boleto_bb.php';
	}


	public function besc($dados = array())
	{
		$this->setup($dados);
		include 'boleto/boleto_besc.php';
	}


	public function bradesco($dados = array())
	{
		$this->setup($dados);
		include 'boleto/boleto_bradesco.php';
	}


	public function cef($dados = array())
	{
		$this->setup($dados);
		include 'boleto/boleto_cef.php';
	}


	public function cef_sigcb($dados = array())
	{
		$this->setup($dados);
		include 'boleto/boleto_cef_sigcb.php';
	}


	public function cef_sinco($dados = array())
	{
		$this->setup($dados);
		include 'boleto/boleto_cef_sinco.php';
	}


	public function hsbc($dados = array())
	{
		$this->setup($dados);
		include 'boleto/boleto_hsbc.php';
	}


	public function itau($dados = array())
	{
		$this->setup($dados);
		include 'boleto/boleto_itau.php';
	}


	public function nossacaixa($dados = array())
	{
		$this->setup($dados);
		include 'boleto/boleto_nossacaixa.php';
	}


	public function real($dados = array())
	{
		$this->setup($dados);
		include 'boleto/boleto_real.php';
	}


	public function santander_banespa($dados = array())
	{
		$this->setup($dados);
		include 'boleto/boleto_santander_banespa.php';
	}


	public function sicredi($dados = array())
	{
		$this->setup($dados);
		include 'boleto/boleto_sicredi.php';
	}


	public function sofisa($dados = array())
	{
		$this->setup($dados);
		include 'boleto/boleto_sofisa.php';
	}


	public function sudameris($dados = array())
	{
		$this->setup($dados);
		include 'boleto/boleto_sudameris.php';
	}


	public function unibanco($dados = array())
	{
		$this->setup($dados);
		include 'boleto/boleto_unibanco.php';
	}


	protected function setup($dados = array())
	{
		foreach ($dados as $index => $key)
		{
			$this->$index = $key;
		}
	}

}
