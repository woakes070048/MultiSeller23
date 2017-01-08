<?php
class ControllerSellerprofileMap extends Controller {
	public function index() {
		$this->load->language('sellerprofile/map');

		$data['heading_title'] = $this->language->get('heading_title');

		$data['text_order'] = $this->language->get('text_order');
		$data['text_sale'] = $this->language->get('text_sale');

		$data['token'] = $this->session->data['token'];

		return $this->load->view('sellerprofile/map', $data);
	}

	public function map() {
		$json = array();

		$this->load->model('sellerreport/sale');

		$results = $this->model_sellerreport_sale->getSellerTotalOrdersByCountry();

		foreach ($results as $result) {
			$json[strtolower($result['iso_code_2'])] = array(
				'total'  => $result['total'],
				'amount' => $this->currency->format($result['amount']+$result['seller_shipping_total'], $this->config->get('config_currency'))
			);
		}

		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($json));
	}
}
