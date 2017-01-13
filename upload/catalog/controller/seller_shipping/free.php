<?php
class ControllerSellerShippingFree extends Controller {
	private $error = array();

	public function index() {
		$this->load->language('seller_shipping/free');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('extension/seller_extension');
		
		if (!$this->customer->isSeller()) {

								$this->response->redirect($this->url->link('sellerprofile/sellerprofile', '', 'SSL'));
						}

		$seller_id = $this->customer->getId();

		if (($this->request->server['REQUEST_METHOD'] == 'POST')) {
			$this->model_extension_seller_extension->editSetting($seller_id,'free', $this->request->post);

			$this->session->data['success'] = $this->language->get('text_success');

			$this->response->redirect($this->url->link('extension/shipping', '', true));
		}

		$data['heading_title'] = $this->language->get('heading_title');

		$data['text_edit'] = $this->language->get('text_edit');
		$data['text_enabled'] = $this->language->get('text_enabled');
		$data['text_disabled'] = $this->language->get('text_disabled');
		$data['text_all_zones'] = $this->language->get('text_all_zones');
		$data['text_none'] = $this->language->get('text_none');

		$data['entry_name'] = $this->language->get('entry_name');
		$data['entry_total'] = $this->language->get('entry_total');
		$data['entry_geo_zone'] = $this->language->get('entry_geo_zone');
		$data['entry_status'] = $this->language->get('entry_status');
		$data['entry_sort_order'] = $this->language->get('entry_sort_order');

		$data['help_total'] = $this->language->get('help_total');

		$data['button_save'] = $this->language->get('button_save');
		$data['button_cancel'] = $this->language->get('button_cancel');

		if (isset($this->error['warning'])) {
			$data['error_warning'] = $this->error['warning'];
		} else {
			$data['error_warning'] = '';
		}

		$data['breadcrumbs'] = array();

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_home'),
			'href' => $this->url->link('common/home', '', true)
		);

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_shipping'),
			'href' => $this->url->link('extension/shipping', '', true)
		);

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('heading_title'),
			'href' => $this->url->link('seller_shipping/free', '', true)
		);

		$data['action'] = $this->url->link('seller_shipping/free', '', true);

		$data['cancel'] = $this->url->link('extension/shipping', '', true);

		if (isset($this->request->post['free_total'])) {
			$data['free_total'] = $this->request->post['free_total'];
		} else {
			$data['free_total'] = $this->config->get($seller_id.':'.'free_total');
		}

		if (isset($this->request->post['free_geo_zone_id'])) {
			$data['free_geo_zone_id'] = $this->request->post['free_geo_zone_id'];
		} else {
			$data['free_geo_zone_id'] = $this->config->get($seller_id.':'.'free_geo_zone_id');
		}

		$this->load->model('extension/seller_extension');

		$data['geo_zones'] = $this->model_extension_seller_extension->getGeoZones();

		if (isset($this->request->post['free_status'])) {
			$data['free_status'] = $this->request->post['free_status'];
		} else {
			$data['free_status'] = $this->config->get($seller_id.':'.'free_status');
		}

		if (isset($this->request->post['free_sort_order'])) {
			$data['free_sort_order'] = $this->request->post['free_sort_order'];
		} else {
			$data['free_sort_order'] = $this->config->get($seller_id.':'.'free_sort_order');
		}

		if (isset($this->request->post['free_name'])) {
			$data['free_name'] = $this->request->post['free_name'];
		} else {
			$data['free_name'] = $this->config->get($seller_id.':'.'free_name');
		}

		$data['column_left'] = $this->load->controller('common/column_left');
            $data['column_right'] = $this->load->controller('common/column_right');
            $data['content_top'] = $this->load->controller('common/content_top');
            $data['content_bottom'] = $this->load->controller('common/content_bottom');
            $data['footer'] = $this->load->controller('common/footer');
            $data['header'] = $this->load->controller('common/header');

		$this->response->setOutput($this->load->view('seller_shipping/free', $data));
	}

}
