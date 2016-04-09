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
		$this->load->config('boleto');
	}


	public function index()
	{
		$dados['pedido']['quantidade'] = 4;
		$dados['pedido']['valor_unitario'] = 2.5;
		$dados['pedido']['numero'] = 125;

		$dados['sacado']['nome'] = 'João da Silva';
		$dados['sacado']['endereco'] = 'Av. Porto Palmeira';
		$dados['sacado']['cidade'] = 'Sapiranga';
		$dados['sacado']['uf'] = 'RS';
		$dados['sacado']['cep'] = '93800-000';

		$this->boleto->cef();

	}

}
