<?php
class ControllerSellerShippingFlat extends Controller {
	private $error = array();

	public function index() {
		$this->load->language('seller_shipping/flat');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('extension/seller_extension');

		if (!$this->customer->isSeller()) {

								$this->response->redirect($this->url->link('sellerprofile/sellerprofile', '', 'SSL'));
						}

		$seller_id = $this->customer->getId();

		if (($this->request->server['REQUEST_METHOD'] == 'POST')) {
			$this->model_extension_seller_extension->editSetting($seller_id,'flat', $this->request->post);

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
		$data['entry_cost'] = $this->language->get('entry_cost');
		$data['entry_tax_class'] = $this->language->get('entry_tax_class');
		$data['entry_geo_zone'] = $this->language->get('entry_geo_zone');
		$data['entry_status'] = $this->language->get('entry_status');
		$data['entry_sort_order'] = $this->language->get('entry_sort_order');

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
			'href' => $this->url->link('seller_shipping/flat', '', true)
		);

		$data['action'] = $this->url->link('seller_shipping/flat', '', true);

		$data['cancel'] = $this->url->link('extension/shipping', '', true);

		if (isset($this->request->post['flat_cost'])) {
			$data['flat_cost'] = $this->request->post['flat_cost'];
		} else {
			$data['flat_cost'] = $this->config->get($seller_id.':'.'flat_cost');
		}

		if (isset($this->request->post['flat_name'])) {
			$data['flat_name'] = $this->request->post['flat_name'];
		} else {
			$data['flat_name'] = $this->config->get($seller_id.':'.'flat_name');
		}

		if (isset($this->request->post['flat_tax_class_id'])) {
			$data['flat_tax_class_id'] = $this->request->post['flat_tax_class_id'];
		} else {
			$data['flat_tax_class_id'] = $this->config->get($seller_id.':'.'flat_tax_class_id');
		}

		$this->load->model('sellerproduct/tax_class');

		$data['tax_classes'] = $this->model_sellerproduct_tax_class->getTaxClasses();

		if (isset($this->request->post['flat_geo_zone_id'])) {
			$data['flat_geo_zone_id'] = $this->request->post['flat_geo_zone_id'];
		} else {
			$data['flat_geo_zone_id'] = $this->config->get($seller_id.':'.'flat_geo_zone_id');
		}

		$this->load->model('extension/seller_extension');

		$data['geo_zones'] = $this->model_extension_seller_extension->getGeoZones();


		if (isset($this->request->post['flat_status'])) {
			$data['flat_status'] = $this->request->post['flat_status'];
		} else {
			$data['flat_status'] = $this->config->get($seller_id.':'.'flat_status');
		}

		if (isset($this->request->post['flat_sort_order'])) {
			$data['flat_sort_order'] = $this->request->post['flat_sort_order'];
		} else {
			$data['flat_sort_order'] = $this->config->get($seller_id.':'.'flat_sort_order');
		}

		$data['column_left'] = $this->load->controller('common/column_left');
		            $data['column_right'] = $this->load->controller('common/column_right');
		            $data['content_top'] = $this->load->controller('common/content_top');
		            $data['content_bottom'] = $this->load->controller('common/content_bottom');
		            $data['footer'] = $this->load->controller('common/footer');
		            $data['header'] = $this->load->controller('common/header');

            $this->response->setOutput($this->load->view('seller_shipping/flat', $data));

	}
}
