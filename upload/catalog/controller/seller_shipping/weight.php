<?php
class ControllerSellerShippingWeight extends Controller {
	private $error = array();

	public function index() {
		$this->load->language('seller_shipping/weight');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('extension/seller_extension');

		$seller_id = $this->customer->getId();

		if (($this->request->server['REQUEST_METHOD'] == 'POST')) {
			$this->model_extension_seller_extension->editSetting($seller_id,'weight', $this->request->post);

			$this->session->data['success'] = $this->language->get('text_success');

			$this->response->redirect($this->url->link('extension/shipping', '', true));
		}

		$data['heading_title'] = $this->language->get('heading_title');

		$data['text_edit'] = $this->language->get('text_edit');
		$data['text_none'] = $this->language->get('text_none');
		$data['text_enabled'] = $this->language->get('text_enabled');
		$data['text_disabled'] = $this->language->get('text_disabled');

		$data['entry_name'] = $this->language->get('entry_name');
		$data['entry_rate'] = $this->language->get('entry_rate');
		$data['entry_tax_class'] = $this->language->get('entry_tax_class');
		$data['entry_status'] = $this->language->get('entry_status');
		$data['entry_sort_order'] = $this->language->get('entry_sort_order');

		$data['help_rate'] = $this->language->get('help_rate');

		$data['button_save'] = $this->language->get('button_save');
		$data['button_cancel'] = $this->language->get('button_cancel');

		$data['tab_general'] = $this->language->get('tab_general');

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
			'href' => $this->url->link('seller_shipping/weight', '', true)
		);

		$data['action'] = $this->url->link('seller_shipping/weight', '', true);

		$data['cancel'] = $this->url->link('extension/shipping', '', true);

		$this->load->model('extension/seller_extension');

		$geo_zones = $this->model_extension_seller_extension->getGeoZones();

		foreach ($geo_zones as $geo_zone) {
			if (isset($this->request->post['weight_' . $geo_zone['geo_zone_id'] . '_rate'])) {
				$data['weight_' . $geo_zone['geo_zone_id'] . '_rate'] = $this->request->post['weight_' . $geo_zone['geo_zone_id'] . '_rate'];
			} else {
				$data['weight_' . $geo_zone['geo_zone_id'] . '_rate'] = $this->config->get($seller_id.':'.'weight_' . $geo_zone['geo_zone_id'] . '_rate');
			}

			if (isset($this->request->post['weight_' . $geo_zone['geo_zone_id'] . '_status'])) {
				$data['weight_' . $geo_zone['geo_zone_id'] . '_status'] = $this->request->post['weight_' . $geo_zone['geo_zone_id'] . '_status'];
			} else {
				$data['weight_' . $geo_zone['geo_zone_id'] . '_status'] = $this->config->get($seller_id.':'.'weight_' . $geo_zone['geo_zone_id'] . '_status');
			}
		}

		$data['geo_zones'] = $geo_zones;

		if (isset($this->request->post['weight_tax_class_id'])) {
			$data['weight_tax_class_id'] = $this->request->post['weight_tax_class_id'];
		} else {
			$data['weight_tax_class_id'] = $this->config->get($seller_id.':'.'weight_tax_class_id');
		}

		$this->load->model('sellerproduct/tax_class');

		$data['tax_classes'] = $this->model_sellerproduct_tax_class->getTaxClasses();

		if (isset($this->request->post['weight_status'])) {
			$data['weight_status'] = $this->request->post['weight_status'];
		} else {
			$data['weight_status'] = $this->config->get($seller_id.':'.'weight_status');
		}

		if (isset($this->request->post['weight_sort_order'])) {
			$data['weight_sort_order'] = $this->request->post['weight_sort_order'];
		} else {
			$data['weight_sort_order'] = $this->config->get($seller_id.':'.'weight_sort_order');
		}

		if (isset($this->request->post['weight_name'])) {
			$data['weight_name'] = $this->request->post['weight_name'];
		} else {
			$data['weight_name'] = $this->config->get($seller_id.':'.'weight_name');
		}

		$data['column_left'] = $this->load->controller('common/column_left');
		            $data['column_right'] = $this->load->controller('common/column_right');
		            $data['content_top'] = $this->load->controller('common/content_top');
		            $data['content_bottom'] = $this->load->controller('common/content_bottom');
		            $data['footer'] = $this->load->controller('common/footer');
		            $data['header'] = $this->load->controller('common/header');

		$this->response->setOutput($this->load->view('seller_shipping/weight', $data));
	}
}
