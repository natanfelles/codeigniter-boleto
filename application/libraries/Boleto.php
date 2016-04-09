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

	protected $taxa_boleto = 2.5;


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


	public function cef($dados = array())
	{
		$this->setup($dados);
		include 'boleto/boleto_cef.php';
	}


	protected function setup($dados = array())
	{
		foreach ($dados as $index => $key)
		{
			$this->$index = $key;
		}
	}


	public function initialize($config = array())
	{
		if (isset($config))
		{
			foreach ($config as $index => $key)
			{
				$this->$index = $key;
			}
		}
	}


}
