<?php
class ControllerSellerShippingItem extends Controller {
	private $error = array();

	public function index() {
		$this->load->language('seller_shipping/item');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('extension/seller_extension');

		$seller_id = $this->customer->getId();

		if (($this->request->server['REQUEST_METHOD'] == 'POST')) {
			$this->model_extension_seller_extension->editSetting($seller_id,'item', $this->request->post);

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
			'href' => $this->url->link('seller_shipping/item', '', true)
		);

		$data['action'] = $this->url->link('seller_shipping/item', '', true);

		$data['cancel'] = $this->url->link('extension/shipping', '', true);

		if (isset($this->request->post['item_cost'])) {
			$data['item_cost'] = $this->request->post['item_cost'];
		} else {
			$data['item_cost'] = $this->config->get($seller_id.':'.'item_cost');
		}

		if (isset($this->request->post['item_name'])) {
			$data['item_name'] = $this->request->post['item_name'];
		} else {
			$data['item_name'] = $this->config->get($seller_id.':'.'item_name');
		}		

		if (isset($this->request->post['item_tax_class_id'])) {
			$data['item_tax_class_id'] = $this->request->post['item_tax_class_id'];
		} else {
			$data['item_tax_class_id'] = $this->config->get($seller_id.':'.'item_tax_class_id');
		}

		$this->load->model('sellerproduct/tax_class');

		$data['tax_classes'] = $this->model_sellerproduct_tax_class->getTaxClasses();

		if (isset($this->request->post['item_geo_zone_id'])) {
			$data['item_geo_zone_id'] = $this->request->post['item_geo_zone_id'];
		} else {
			$data['item_geo_zone_id'] = $this->config->get($seller_id.':'.'item_geo_zone_id');
		}

		$this->load->model('extension/seller_extension');

		$data['geo_zones'] = $this->model_extension_seller_extension->getGeoZones();

		if (isset($this->request->post['item_status'])) {
			$data['item_status'] = $this->request->post['item_status'];
		} else {
			$data['item_status'] = $this->config->get($seller_id.':'.'item_status');
		}

		if (isset($this->request->post['item_sort_order'])) {
			$data['item_sort_order'] = $this->request->post['item_sort_order'];
		} else {
			$data['item_sort_order'] = $this->config->get($seller_id.':'.'item_sort_order');
		}

		$data['column_left'] = $this->load->controller('common/column_left');
		            $data['column_right'] = $this->load->controller('common/column_right');
		            $data['content_top'] = $this->load->controller('common/content_top');
		            $data['content_bottom'] = $this->load->controller('common/content_bottom');
		            $data['footer'] = $this->load->controller('common/footer');
		            $data['header'] = $this->load->controller('common/header');

		$this->response->setOutput($this->load->view('seller_shipping/item', $data));
	}
}
