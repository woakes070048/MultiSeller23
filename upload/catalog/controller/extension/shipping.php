<?php
class ControllerExtensionShipping extends Controller {
	private $error = array();

	public function index() {
		$this->load->language('extension/shipping');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('extension/seller_extension');

		$this->getList();
	}

	public function getList() {
		$data['breadcrumbs'] = array();

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_home'),
			'href' => $this->url->link('common/home', '', true)
		);

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('heading_title'),
			'href' => $this->url->link('extension/shipping', '', true)
		);

		$data['heading_title'] = $this->language->get('heading_title');

		$data['text_list'] = $this->language->get('text_list');
		$data['text_no_results'] = $this->language->get('text_no_results');
		$data['text_confirm'] = $this->language->get('text_confirm');

		$data['column_name'] = $this->language->get('column_name');
		$data['column_shipping_name'] = $this->language->get('column_shipping_name');
		$data['column_status'] = $this->language->get('column_status');
		$data['column_sort_order'] = $this->language->get('column_sort_order');
		$data['column_action'] = $this->language->get('column_action');

		$data['button_edit'] = $this->language->get('button_edit');
		$data['button_install'] = $this->language->get('button_install');
		$data['button_uninstall'] = $this->language->get('button_uninstall');

		if (isset($this->error['warning'])) {
			$data['error_warning'] = $this->error['warning'];
		} else {
			$data['error_warning'] = '';
		}

		if (isset($this->session->data['success'])) {
			$data['success'] = $this->session->data['success'];

			unset($this->session->data['success']);
		} else {
			$data['success'] = '';
		}

		$this->load->model('extension/seller_extension');

		$extensions = $this->model_extension_seller_extension->getInstalled('extension/shipping');

		$data['extensions'] = array();

		$files = glob(DIR_APPLICATION . 'controller/seller_shipping/*.php');

		$seller_id = $this->customer->getId();

		if ($files) {
			foreach ($files as $file) {
				$extension = basename($file, '.php');

				$this->load->language('seller_shipping/' . $extension);

				$data['extensions'][] = array(
					'name'       => $this->language->get('heading_title'),
					'shipping_name' => $this->config->get($seller_id.':'.$extension . '_name'),
					'status'     => $this->config->get($seller_id.':'.$extension . '_status') ? $this->language->get('text_enabled') : $this->language->get('text_disabled'),
					'sort_order' => $this->config->get($seller_id.':'.$extension . '_sort_order'),
					'install'    => $this->url->link('extension/shipping/install',  'extension=' . $extension, true),
					'uninstall'  => $this->url->link('extension/shipping/uninstall', 'extension=' . $extension, true),
					'installed'  => in_array($extension, $extensions),
					'edit'       => $this->url->link('seller_shipping/' . $extension, '', true)
				);
			}
		}

		$data['column_left'] = $this->load->controller('common/column_left');
		$data['column_right'] = $this->load->controller('common/column_right');
		$data['content_top'] = $this->load->controller('common/content_top');
		$data['content_bottom'] = $this->load->controller('common/content_bottom');
		$data['footer'] = $this->load->controller('common/footer');
		$data['header'] = $this->load->controller('common/header');

		$this->response->setOutput($this->load->view('extension/shipping', $data));
	}

	protected function validate() {
		if (!$this->user->hasPermission('modify', 'extension/shipping')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}

		return !$this->error;
	}
}
