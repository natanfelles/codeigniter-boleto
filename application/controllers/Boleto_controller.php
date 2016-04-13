<?php
/**
 * CodeIgniter Boleto
 *
 * @package    CodeIgniter Boleto
 * @author     Natan Felles
 * @link       https://github.com/natanfelles/codeigniter-boleto
 */
defined('BASEPATH') OR exit('No direct script access allowed');

class Boleto_controller extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->library('boleto');
	}


	public function index()
	{
		$dados = array(
			// Informações necessárias para todos os bancos
			'dias_de_prazo_para_pagamento' => 5,
			'taxa_boleto'                  => 1,
			'pedido'                       => array(
				'nome'           => 'Serviços de Desenvolvimento Web',
				'quantidade'     => '10',
				'valor_unitario' => '80',
				'numero'         => 10000000025,
				'aceite'         => 'N',
				'especie'        => 'R$',
				'especie_doc'    => 'DM',
			),
			'sacado'                       => array(
				'nome'     => 'João da Silva',
				'endereco' => 'Av. Meninas Bonitas, 777',
				'cidade'   => 'Sapiranga',
				'uf'       => 'RS',
				'cep'      => '93816-630',
			),
			// Informações necessárias que são específicas do Banco do Brasil
			'variacao_carteira'            => '019',
			'contrato'                     => 999999,
			'convenio'                     => 7777777,
		);

		// Gera o boleto
		$this->boleto->bb($dados);
	}

}
