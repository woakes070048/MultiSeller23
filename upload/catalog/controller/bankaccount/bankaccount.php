<?php

class Controllerbankaccountbankaccount extends Controller
{
    private $error = array();

    public function index()
    {
        if (!$this->customer->isLogged()) {
            $this->session->data['redirect'] = $this->url->link('bankaccount/bankaccount', '', 'SSL');

            $this->response->redirect($this->url->link('account/login', '', 'SSL'));
        }

        $this->load->language('bankaccount/bankaccount');

        $this->document->setTitle($this->language->get('heading_title'));

        $this->load->model('bankaccount/bankaccount');
        if (isset($this->request->get['profile']) && $this->customer->isSeller()) {
            $this->getListForProfile();
        } elseif($this->customer->isSeller()) {
            $this->getList();
        }else {
          $this->response->redirect($this->url->link('account/account', '', 'SSL'));
        }
    }

    public function add()
    {
        if (!$this->customer->isLogged()) {
            $this->session->data['redirect'] = $this->url->link('bankaccount/bankaccount', '', 'SSL');

            $this->response->redirect($this->url->link('account/login', '', 'SSL'));
        }

        $this->load->language('bankaccount/bankaccount');

        $this->document->setTitle($this->language->get('heading_title'));

        $this->document->addScript('catalog/view/javascript/jquery/datetimepicker/moment.min.js');
        $this->document->addScript('catalog/view/javascript/jquery/datetimepicker/bootstrap-datetimepicker.min.js');
        $this->document->addStyle('catalog/view/javascript/jquery/datetimepicker/bootstrap-datetimepicker.min.css');

        $this->load->model('bankaccount/bankaccount');

        if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
            $this->model_bankaccount_bankaccount->addbankaccount($this->request->post);

            $this->session->data['success'] = $this->language->get('text_add');

            // Add to activity log
            $this->load->model('account/activity');

            $activity_data = array(
                'customer_id' => $this->customer->getId(),
                'name' => $this->customer->getFirstName().' '.$this->customer->getLastName(),
            );

            $this->model_account_activity->addActivity('bankaccount_add', $activity_data);

            $this->response->redirect($this->url->link('bankaccount/bankaccount', '', 'SSL'));
        }

        $this->getForm();
    }

    public function edit()
    {
        if (!$this->customer->isLogged()) {
            $this->session->data['redirect'] = $this->url->link('bankaccount/bankaccount', '', 'SSL');

            $this->response->redirect($this->url->link('account/login', '', 'SSL'));
        }

        $this->load->language('bankaccount/bankaccount');

        $this->document->setTitle($this->language->get('heading_title'));

        $this->document->addScript('catalog/view/javascript/jquery/datetimepicker/moment.min.js');
        $this->document->addScript('catalog/view/javascript/jquery/datetimepicker/bootstrap-datetimepicker.min.js');
        $this->document->addStyle('catalog/view/javascript/jquery/datetimepicker/bootstrap-datetimepicker.min.css');

        $this->load->model('bankaccount/bankaccount');

        if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
            $this->model_bankaccount_bankaccount->editbankaccount($this->request->get['bankaccount_id'], $this->request->post);

            $this->session->data['success'] = $this->language->get('text_edit');

            // Add to activity log
            $this->load->model('account/activity');

            $activity_data = array(
                'customer_id' => $this->customer->getId(),
                'name' => $this->customer->getFirstName().' '.$this->customer->getLastName(),
            );

            $this->model_account_activity->addActivity('bankaccount_edit', $activity_data);

            $this->response->redirect($this->url->link('bankaccount/bankaccount', '', 'SSL'));
        }

        $this->getForm();
    }

    public function delete()
    {
        if (!$this->customer->isLogged()) {
            $this->session->data['redirect'] = $this->url->link('bankaccount/bankaccount', '', 'SSL');

            $this->response->redirect($this->url->link('account/login', '', 'SSL'));
        }

        $this->load->language('bankaccount/bankaccount');

        $this->document->setTitle($this->language->get('heading_title'));

        $this->load->model('bankaccount/bankaccount');

        if (isset($this->request->get['bankaccount_id']) && $this->validateDelete()) {
            $this->model_bankaccount_bankaccount->deletebankaccount($this->request->get['bankaccount_id']);

            // Default Shipping bankaccount
            if (isset($this->session->data['shipping_bankaccount']['bankaccount_id']) && ($this->request->get['bankaccount_id'] == $this->session->data['shipping_bankaccount']['bankaccount_id'])) {
                unset($this->session->data['shipping_bankaccount']);
                unset($this->session->data['shipping_method']);
                unset($this->session->data['shipping_methods']);
            }

            // Default Payment bankaccount
            if (isset($this->session->data['payment_bankaccount']['bankaccount_id']) && ($this->request->get['bankaccount_id'] == $this->session->data['payment_bankaccount']['bankaccount_id'])) {
                unset($this->session->data['payment_bankaccount']);
                unset($this->session->data['payment_method']);
                unset($this->session->data['payment_methods']);
            }

            $this->session->data['success'] = $this->language->get('text_delete');

            // Add to activity log
            $this->load->model('account/activity');

            $activity_data = array(
                'customer_id' => $this->customer->getId(),
                'name' => $this->customer->getFirstName().' '.$this->customer->getLastName(),
            );

            $this->model_account_activity->addActivity('bankaccount_delete', $activity_data);

            $this->response->redirect($this->url->link('bankaccount/bankaccount', '', 'SSL'));
        }

        $this->getList();
    }

    protected function getList()
    {
        $data['breadcrumbs'][] = array(
            'text' => $this->language->get('text_home'),
            'href' => $this->url->link('common/home'),
        );

        $data['breadcrumbs'][] = array(
            'text' => $this->language->get('text_account'),
            'href' => $this->url->link('account/account', '', 'SSL'),
        );

        $data['breadcrumbs'][] = array(
            'text' => $this->language->get('heading_title'),
            'href' => $this->url->link('bankaccount/bankaccount', '', 'SSL'),
        );

        $data['heading_title'] = $this->language->get('heading_title');

        $data['text_bankaccount_book'] = $this->language->get('text_bankaccount_book');
        $data['text_empty'] = $this->language->get('text_empty');

        $data['button_new_bankaccount'] = $this->language->get('button_new_bankaccount');
        $data['button_edit'] = $this->language->get('button_edit');
        $data['button_delete'] = $this->language->get('button_delete');
        $data['button_back'] = $this->language->get('button_back');

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

        $data['bankaccounts'] = array();

        $results = $this->model_bankaccount_bankaccount->getbankaccounts();

        foreach ($results as $result) {
            $format = '{firstname} {lastname}'."\n".'{company}'."\n".'{company_id}'."\n".'{bankaccount_1}'."\n".'{bankaccount_2}'."\n".'{city} {postcode}'."\n".'{zone}'."\n".'{country}';

            $find = array(
                '{firstname}',
                '{lastname}',
                '{company}',
                '{company_id}',
                  '{bankaccount_1}',
                  '{bankaccount_2}',
                 '{city}',
                  '{postcode}',
                  '{zone}',
                '{zone_code}',
                  '{country}',
            );

            $replace = array(
                'firstname' => $result['firstname'],
                'lastname' => $result['lastname'],
                'company' => $result['company'],
                'bankaccount_1' => $result['bankaccount_1'],
                'bankaccount_2' => $result['bankaccount_2'],
                'country' => $result['country'],
            );

            $data['bankaccounts'][] = array(
                'bankaccount_id' => $result['bankaccount_id'],
                'bankaccount' => str_replace(array("\r\n", "\r", "\n"), '<br />', preg_replace(array("/\s\s+/", "/\r\r+/", "/\n\n+/"), '<br />', trim(str_replace($find, $replace, $format)))),
                'update' => $this->url->link('bankaccount/bankaccount/edit', 'bankaccount_id='.$result['bankaccount_id'], 'SSL'),
                'delete' => $this->url->link('bankaccount/bankaccount/delete', 'bankaccount_id='.$result['bankaccount_id'], 'SSL'),
            );
        }

        $data['insert'] = $this->url->link('bankaccount/bankaccount/add', '', 'SSL');
        $data['back'] = $this->url->link('account/account', '', 'SSL');

        $data['column_left'] = $this->load->controller('common/column_left');
        $data['column_right'] = $this->load->controller('common/column_right');
        $data['content_top'] = $this->load->controller('common/content_top');
        $data['content_bottom'] = $this->load->controller('common/content_bottom');
        $data['footer'] = $this->load->controller('common/footer');
        $data['header'] = $this->load->controller('common/header');


            $this->response->setOutput($this->load->view('bankaccount/bankaccount_list', $data));

    }

    protected function getListForProfile()
    {
        $data['breadcrumbs'][] = array(
            'text' => $this->language->get('text_home'),
            'href' => $this->url->link('common/home'),
        );

        $data['breadcrumbs'][] = array(
            'text' => $this->language->get('text_account'),
            'href' => $this->url->link('account/account', '', 'SSL'),
        );

        $data['breadcrumbs'][] = array(
            'text' => $this->language->get('heading_title'),
            'href' => $this->url->link('bankaccount/bankaccount', '', 'SSL'),
        );

        $data['heading_title'] = $this->language->get('heading_title');

        $data['text_bankaccount_book'] = $this->language->get('text_bankaccount_book');
        $data['text_empty'] = $this->language->get('text_empty');

        $data['button_new_bankaccount'] = $this->language->get('button_new_bankaccount');
        $data['button_edit'] = $this->language->get('button_edit');
        $data['button_delete'] = $this->language->get('button_delete');
        $data['button_back'] = $this->language->get('button_back');

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

        $data['bankaccounts'] = array();

        $results = $this->model_bankaccount_bankaccount->getbankaccounts();

        foreach ($results as $result) {
            $format = '{firstname} {lastname}'."\n".'{company}'."\n".'{company_id}'."\n".'{bankaccount_1}'."\n".'{bankaccount_2}'."\n".'{city} {postcode}'."\n".'{zone}'."\n".'{country}';

            $find = array(
                '{firstname}',
                '{lastname}',
                '{company}',
                '{company_id}',
                  '{bankaccount_1}',
                  '{bankaccount_2}',
                 '{city}',
                  '{postcode}',
                  '{zone}',
                '{zone_code}',
                  '{country}',
            );

            $replace = array(
                'firstname' => $result['firstname'],
                'lastname' => $result['lastname'],
                'company' => $result['company'],
                'bankaccount_1' => $result['bankaccount_1'],
                'bankaccount_2' => $result['bankaccount_2'],
                'country' => $result['country'],
            );

            $data['bankaccounts'][] = array(
                'bankaccount_id' => $result['bankaccount_id'],
                'bankaccount' => str_replace(array("\r\n", "\r", "\n"), '<br />', preg_replace(array("/\s\s+/", "/\r\r+/", "/\n\n+/"), '<br />', trim(str_replace($find, $replace, $format)))),
                'update' => $this->url->link('bankaccount/bankaccount/edit', 'bankaccount_id='.$result['bankaccount_id'], 'SSL'),
                'delete' => $this->url->link('bankaccount/bankaccount/delete', 'bankaccount_id='.$result['bankaccount_id'], 'SSL'),
            );
        }

        $data['insert'] = $this->url->link('bankaccount/bankaccount/add', '', 'SSL');
        $data['back'] = $this->url->link('account/account', '', 'SSL');

        $data['column_left'] = $this->load->controller('common/column_left');
        $data['column_right'] = $this->load->controller('common/column_right');
        $data['content_top'] = $this->load->controller('common/content_top');
        $data['content_bottom'] = $this->load->controller('common/content_bottom');
        $data['footer'] = $this->load->controller('common/footer');
        $data['header'] = $this->load->controller('common/header');


            $this->response->setOutput($this->load->view('bankaccount/bankaccountforprofile_list', $data));

    }
    protected function getForm()
    {
        $data['breadcrumbs'] = array();

        $data['breadcrumbs'][] = array(
            'text' => $this->language->get('text_home'),
            'href' => $this->url->link('common/home'),
        );

        $data['breadcrumbs'][] = array(
            'text' => $this->language->get('text_account'),
            'href' => $this->url->link('account/account', '', 'SSL'),
        );

        $data['breadcrumbs'][] = array(
            'text' => $this->language->get('heading_title'),
            'href' => $this->url->link('bankaccount/bankaccount', '', 'SSL'),
        );

        if (!isset($this->request->get['bankaccount_id'])) {
            $data['breadcrumbs'][] = array(
                'text' => $this->language->get('text_edit_bankaccount'),
                'href' => $this->url->link('bankaccount/bankaccount/add', '', 'SSL'),
            );
        } else {
            $data['breadcrumbs'][] = array(
                'text' => $this->language->get('text_edit_bankaccount'),
                'href' => $this->url->link('bankaccount/bankaccount/edit', 'bankaccount_id='.$this->request->get['bankaccount_id'], 'SSL'),
            );
        }

        $data['heading_title'] = $this->language->get('heading_title');

        $data['text_edit_bankaccount'] = $this->language->get('text_edit_bankaccount');
        $data['text_yes'] = $this->language->get('text_yes');
        $data['text_no'] = $this->language->get('text_no');
        $data['text_select'] = $this->language->get('text_select');
        $data['text_none'] = $this->language->get('text_none');
        $data['text_loading'] = $this->language->get('text_loading');

        $data['entry_firstname'] = $this->language->get('entry_firstname');
        $data['entry_lastname'] = $this->language->get('entry_lastname');
        $data['entry_company'] = $this->language->get('entry_company');
        $data['entry_company_id'] = $this->language->get('entry_company_id');
        $data['entry_branch_id'] = $this->language->get('entry_branch_id');
        $data['entry_bankaccount_1'] = $this->language->get('entry_bankaccount_1');
        $data['entry_bankaccount_2'] = $this->language->get('entry_bankaccount_2');
        $data['entry_postcode'] = $this->language->get('entry_postcode');
        $data['entry_city'] = $this->language->get('entry_city');
        $data['entry_country'] = $this->language->get('entry_country');
        $data['entry_zone'] = $this->language->get('entry_zone');
        $data['entry_default'] = $this->language->get('entry_default');
        $data['entry_bank'] = $this->language->get('entry_bank');

        $data['button_continue'] = $this->language->get('button_continue');
        $data['button_back'] = $this->language->get('button_back');
        $data['button_upload'] = $this->language->get('button_upload');

        $data['banks'] = $this->model_bankaccount_bankaccount->getbanks();

        if (isset($this->error['firstname'])) {
            $data['error_firstname'] = $this->error['firstname'];
        } else {
            $data['error_firstname'] = '';
        }

        if (isset($this->error['lastname'])) {
            $data['error_lastname'] = $this->error['lastname'];
        } else {
            $data['error_lastname'] = '';
        }

        if (isset($this->error['company_id'])) {
            $data['error_company_id'] = $this->error['company_id'];
        } else {
            $data['error_company_id'] = '';
        }

        if (isset($this->error['branch_id'])) {
            $data['error_branch_id'] = $this->error['branch_id'];
        } else {
            $data['error_branch_id'] = '';
        }

        if (isset($this->error['bankaccount_1'])) {
            $data['error_bankaccount_1'] = $this->error['bankaccount_1'];
        } else {
            $data['error_bankaccount_1'] = '';
        }

        if (isset($this->error['city'])) {
            $data['error_city'] = $this->error['city'];
        } else {
            $data['error_city'] = '';
        }

        if (isset($this->error['postcode'])) {
            $data['error_postcode'] = $this->error['postcode'];
        } else {
            $data['error_postcode'] = '';
        }

        if (isset($this->error['country'])) {
            $data['error_country'] = $this->error['country'];
        } else {
            $data['error_country'] = '';
        }

        if (isset($this->error['zone'])) {
            $data['error_zone'] = $this->error['zone'];
        } else {
            $data['error_zone'] = '';
        }

        if (isset($this->error['bank'])) {
            $data['error_bank'] = $this->error['bank'];
        } else {
            $data['error_bank'] = '';
        }

        if (!isset($this->request->get['bankaccount_id'])) {
            $data['action'] = $this->url->link('bankaccount/bankaccount/add', '', 'SSL');
        } else {
            $data['action'] = $this->url->link('bankaccount/bankaccount/edit', 'bankaccount_id='.$this->request->get['bankaccount_id'], 'SSL');
        }

        if (isset($this->request->get['bankaccount_id']) && ($this->request->server['REQUEST_METHOD'] != 'POST')) {
            $bankaccount_info = $this->model_bankaccount_bankaccount->getbankaccount($this->request->get['bankaccount_id']);
        }

        if (isset($this->request->post['firstname'])) {
            $data['firstname'] = $this->request->post['firstname'];
        } elseif (!empty($bankaccount_info)) {
            $data['firstname'] = $bankaccount_info['firstname'];
        } else {
            $data['firstname'] = '';
        }

        if (isset($this->request->post['lastname'])) {
            $data['lastname'] = $this->request->post['lastname'];
        } elseif (!empty($bankaccount_info)) {
            $data['lastname'] = $bankaccount_info['lastname'];
        } else {
            $data['lastname'] = '';
        }

        if (isset($this->request->post['company'])) {
            $data['company'] = $this->request->post['company'];
        } elseif (!empty($bankaccount_info)) {
            $data['company'] = $bankaccount_info['company'];
        } else {
            $data['company'] = '';
        }
        if (isset($this->request->post['company_id'])) {
            $data['company_id'] = $this->request->post['company_id'];
        } elseif (!empty($bankaccount_info)) {
            $data['company_id'] = $bankaccount_info['company_id'];
        } else {
            $data['company_id'] = '';
        }

        if (isset($this->request->post['bank_id'])) {
            $data['bank_id'] = $this->request->post['bank_id'];
        } elseif (!empty($bankaccount_info)) {
            $data['bank_id'] = $bankaccount_info['bank_id'];
        } else {
            $data['bank_id'] = '';
        }

        if (isset($this->request->post['branch_id'])) {
            $data['branch_id'] = $this->request->post['branch_id'];
        } elseif (!empty($bankaccount_info)) {
            $data['branch_id'] = $bankaccount_info['branch_id'];
        } else {
            $data['branch_id'] = '';
        }

        if (isset($this->request->post['bankaccount_1'])) {
            $data['bankaccount_1'] = $this->request->post['bankaccount_1'];
        } elseif (!empty($bankaccount_info)) {
            $data['bankaccount_1'] = $bankaccount_info['bankaccount_1'];
        } else {
            $data['bankaccount_1'] = '';
        }

        if (isset($this->request->post['bankaccount_2'])) {
            $data['bankaccount_2'] = $this->request->post['bankaccount_2'];
        } elseif (!empty($bankaccount_info)) {
            $data['bankaccount_2'] = $bankaccount_info['bankaccount_2'];
        } else {
            $data['bankaccount_2'] = '';
        }

        if (isset($this->request->post['bank_id'])) {
            $data['bank_id'] = $this->request->post['bank_id'];
        } elseif (!empty($bankaccount_info)) {
            $data['bank_id'] = $bankaccount_info['bank_id'];
        } else {
            $data['bank_id'] = $this->config->get('config_bank_id');
        }

        if (isset($this->request->post['default'])) {
			$data['default'] = $this->request->post['default'];
		} elseif (isset($this->request->get['bankaccount_id'])) {
			$data['default'] = $this->customer->getBankId() == $this->request->get['bankaccount_id'];
		} else {
			$data['default'] = false;
		}
        $data['banks'] = $this->model_bankaccount_bankaccount->getbanks();

        $data['back'] = $this->url->link('bankaccount/bankaccount', '', 'SSL');

        $data['column_left'] = $this->load->controller('common/column_left');
        $data['column_right'] = $this->load->controller('common/column_right');
        $data['content_top'] = $this->load->controller('common/content_top');
        $data['content_bottom'] = $this->load->controller('common/content_bottom');
        $data['footer'] = $this->load->controller('common/footer');
        $data['header'] = $this->load->controller('common/header');


            $this->response->setOutput($this->load->view('bankaccount/bankaccount_form', $data));

    }

    protected function validateForm()
    {
        if ((utf8_strlen(trim($this->request->post['firstname'])) < 1) || (utf8_strlen(trim($this->request->post['firstname'])) > 32)) {
            $this->error['firstname'] = $this->language->get('error_firstname');
        }

        if ((utf8_strlen(trim($this->request->post['lastname'])) < 1) || (utf8_strlen(trim($this->request->post['lastname'])) > 32)) {
            $this->error['lastname'] = $this->language->get('error_lastname');
        }
    /*
        if ((utf8_strlen(trim($this->request->post['bankaccount_1'])) < 3) || (utf8_strlen(trim($this->request->post['bankaccount_1'])) > 128)) {
            $this->error['bankaccount_1'] = $this->language->get('error_bankaccount_1');
        }


        if ((utf8_strlen($this->request->post['company_id']) < 1) || (utf8_strlen($this->request->post['company_id']) > 128)) {
              $this->error['company_id'] = $this->language->get('error_company_id');
        }
    */
        return !$this->error;
    }

    protected function validateDelete()
    {
        //	if ($this->model_bankaccount_bankaccount->getTotalbankaccounts() == 1) {
    //		$this->error['warning'] = $this->language->get('error_delete');
    //	}

        return !$this->error;
    }
}
