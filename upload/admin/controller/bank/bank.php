<?php

class Controllerbankbank extends Controller
{
    private $error = array();

    public function index()
    {
        $this->load->language('bank/bank');

        $this->document->setTitle($this->language->get('heading_title'));

        $this->load->model('bank/bank');

        $this->getList();
    }

    public function add()
    {
        $this->load->language('bank/bank');

        $this->document->setTitle($this->language->get('heading_title'));

        $this->load->model('bank/bank');

        if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
            $this->model_bank_bank->addbank($this->request->post);

            $this->session->data['success'] = $this->language->get('text_success');

            $url = '';

            if (isset($this->request->get['sort'])) {
                $url .= '&sort='.$this->request->get['sort'];
            }

            if (isset($this->request->get['order'])) {
                $url .= '&order='.$this->request->get['order'];
            }

            if (isset($this->request->get['page'])) {
                $url .= '&page='.$this->request->get['page'];
            }

            $this->response->redirect($this->url->link('bank/bank', 'token='.$this->session->data['token'].$url, 'SSL'));
        }

        $this->getForm();
    }

    public function edit()
    {
        $this->load->language('bank/bank');

        $this->document->setTitle($this->language->get('heading_title'));

        $this->load->model('bank/bank');

        if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
            $this->model_bank_bank->editbank($this->request->get['bank_id'], $this->request->post);

            $this->session->data['success'] = $this->language->get('text_success');

            $url = '';

            if (isset($this->request->get['sort'])) {
                $url .= '&sort='.$this->request->get['sort'];
            }

            if (isset($this->request->get['order'])) {
                $url .= '&order='.$this->request->get['order'];
            }

            if (isset($this->request->get['page'])) {
                $url .= '&page='.$this->request->get['page'];
            }

            $this->response->redirect($this->url->link('bank/bank', 'token='.$this->session->data['token'].$url, 'SSL'));
        }

        $this->getForm();
    }

    public function delete()
    {
        $this->load->language('bank/bank');

        $this->document->setTitle($this->language->get('heading_title'));

        $this->load->model('bank/bank');

        if (isset($this->request->post['selected']) && $this->validateDelete()) {
            foreach ($this->request->post['selected'] as $bank_id) {
                $this->model_bank_bank->deletebank($bank_id);
            }

            $this->session->data['success'] = $this->language->get('text_success');

            $url = '';

            if (isset($this->request->get['sort'])) {
                $url .= '&sort='.$this->request->get['sort'];
            }

            if (isset($this->request->get['order'])) {
                $url .= '&order='.$this->request->get['order'];
            }

            if (isset($this->request->get['page'])) {
                $url .= '&page='.$this->request->get['page'];
            }

            $this->response->redirect($this->url->link('bank/bank', 'token='.$this->session->data['token'].$url, 'SSL'));
        }

        $this->getList();
    }

    protected function getList()
    {
        if (isset($this->request->get['sort'])) {
            $sort = $this->request->get['sort'];
        } else {
            $sort = 'title';
        }

        if (isset($this->request->get['order'])) {
            $order = $this->request->get['order'];
        } else {
            $order = 'ASC';
        }

        if (isset($this->request->get['page'])) {
            $page = $this->request->get['page'];
        } else {
            $page = 1;
        }

        $url = '';

        if (isset($this->request->get['sort'])) {
            $url .= '&sort='.$this->request->get['sort'];
        }

        if (isset($this->request->get['order'])) {
            $url .= '&order='.$this->request->get['order'];
        }

        if (isset($this->request->get['page'])) {
            $url .= '&page='.$this->request->get['page'];
        }

        $data['breadcrumbs'] = array();

        $data['breadcrumbs'][] = array(
            'text' => $this->language->get('text_home'),
            'href' => $this->url->link('common/dashboard', 'token='.$this->session->data['token'], 'SSL'),
        );

        $data['breadcrumbs'][] = array(
            'text' => $this->language->get('heading_title'),
            'href' => $this->url->link('bank/bank', 'token='.$this->session->data['token'].$url, 'SSL'),
        );

        $data['insert'] = $this->url->link('bank/bank/add', 'token='.$this->session->data['token'].$url, 'SSL');
        $data['delete'] = $this->url->link('bank/bank/delete', 'token='.$this->session->data['token'].$url, 'SSL');

        $data['bankes'] = array();

        $filter_data = array(
            'sort' => $sort,
            'order' => $order,
            'start' => ($page - 1) * $this->config->get('config_limit_admin'),
            'limit' => $this->config->get('config_limit_admin'),
        );

        $bank_total = $this->model_bank_bank->getTotalbankes();

        $results = $this->model_bank_bank->getbankes($filter_data);

        foreach ($results as $result) {
            $data['bankes'][] = array(
                'bank_id' => $result['bank_id'],
                'title' => $result['title'].(($result['bank_id'] == $this->config->get('config_bank_id')) ? $this->language->get('text_default') : null),

                'edit' => $this->url->link('bank/bank/edit', 'token='.$this->session->data['token'].'&bank_id='.$result['bank_id'].$url, 'SSL'),
            );
        }

        $data['heading_title'] = $this->language->get('heading_title');

        $data['text_list'] = $this->language->get('text_list');
        $data['text_no_results'] = $this->language->get('text_no_results');
        $data['text_confirm'] = $this->language->get('text_confirm');

        $data['column_title'] = $this->language->get('column_title');
        $data['column_unit'] = $this->language->get('column_unit');
        $data['column_value'] = $this->language->get('column_value');
        $data['column_action'] = $this->language->get('column_action');

        $data['button_add'] = $this->language->get('button_add');
        $data['button_edit'] = $this->language->get('button_edit');
        $data['button_delete'] = $this->language->get('button_delete');

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

        if (isset($this->request->post['selected'])) {
            $data['selected'] = (array) $this->request->post['selected'];
        } else {
            $data['selected'] = array();
        }

        $url = '';

        if ($order == 'ASC') {
            $url .= '&order=DESC';
        } else {
            $url .= '&order=ASC';
        }

        if (isset($this->request->get['page'])) {
            $url .= '&page='.$this->request->get['page'];
        }

        $data['sort_title'] = $this->url->link('bank/bank', 'token='.$this->session->data['token'].'&sort=title'.$url, 'SSL');
        $data['sort_unit'] = $this->url->link('bank/bank', 'token='.$this->session->data['token'].'&sort=unit'.$url, 'SSL');
        $data['sort_value'] = $this->url->link('bank/bank', 'token='.$this->session->data['token'].'&sort=value'.$url, 'SSL');

        $url = '';

        if (isset($this->request->get['sort'])) {
            $url .= '&sort='.$this->request->get['sort'];
        }

        if (isset($this->request->get['order'])) {
            $url .= '&order='.$this->request->get['order'];
        }

        $pagination = new Pagination();
        $pagination->total = $bank_total;
        $pagination->page = $page;
        $pagination->limit = $this->config->get('config_limit_admin');
        $pagination->url = $this->url->link('bank/bank', 'token='.$this->session->data['token'].$url.'&page={page}', 'SSL');

        $data['pagination'] = $pagination->render();

        $data['results'] = sprintf($this->language->get('text_pagination'), ($bank_total) ? (($page - 1) * $this->config->get('config_limit_admin')) + 1 : 0, ((($page - 1) * $this->config->get('config_limit_admin')) > ($bank_total - $this->config->get('config_limit_admin'))) ? $bank_total : ((($page - 1) * $this->config->get('config_limit_admin')) + $this->config->get('config_limit_admin')), $bank_total, ceil($bank_total / $this->config->get('config_limit_admin')));

        $data['sort'] = $sort;
        $data['order'] = $order;

        $data['header'] = $this->load->controller('common/header');
        $data['column_left'] = $this->load->controller('common/column_left');
        $data['footer'] = $this->load->controller('common/footer');

        $this->response->setOutput($this->load->view('bank/bank_list.tpl', $data));
    }

    protected function getForm()
    {
        $data['heading_title'] = $this->language->get('heading_title');

        $data['text_form'] = !isset($this->request->get['bank_id']) ? $this->language->get('text_add') : $this->language->get('text_edit');

        $data['entry_title'] = $this->language->get('entry_title');
        $data['entry_unit'] = $this->language->get('entry_unit');
        $data['entry_value'] = $this->language->get('entry_value');

        $data['help_value'] = $this->language->get('help_value');

        $data['button_save'] = $this->language->get('button_save');
        $data['button_cancel'] = $this->language->get('button_cancel');

        if (isset($this->error['warning'])) {
            $data['error_warning'] = $this->error['warning'];
        } else {
            $data['error_warning'] = '';
        }

        if (isset($this->error['title'])) {
            $data['error_title'] = $this->error['title'];
        } else {
            $data['error_title'] = array();
        }

        if (isset($this->error['unit'])) {
            $data['error_unit'] = $this->error['unit'];
        } else {
            $data['error_unit'] = array();
        }

        $url = '';

        if (isset($this->request->get['sort'])) {
            $url .= '&sort='.$this->request->get['sort'];
        }

        if (isset($this->request->get['order'])) {
            $url .= '&order='.$this->request->get['order'];
        }

        if (isset($this->request->get['page'])) {
            $url .= '&page='.$this->request->get['page'];
        }

        $data['breadcrumbs'] = array();

        $data['breadcrumbs'][] = array(
            'text' => $this->language->get('text_home'),
            'href' => $this->url->link('common/dashboard', 'token='.$this->session->data['token'], 'SSL'),
        );

        $data['breadcrumbs'][] = array(
            'text' => $this->language->get('heading_title'),
            'href' => $this->url->link('bank/bank', 'token='.$this->session->data['token'].$url, 'SSL'),
        );

        if (!isset($this->request->get['bank_id'])) {
            $data['action'] = $this->url->link('bank/bank/add', 'token='.$this->session->data['token'].$url, 'SSL');
        } else {
            $data['action'] = $this->url->link('bank/bank/edit', 'token='.$this->session->data['token'].'&bank_id='.$this->request->get['bank_id'].$url, 'SSL');
        }

        $data['cancel'] = $this->url->link('bank/bank', 'token='.$this->session->data['token'].$url, 'SSL');

        if (isset($this->request->get['bank_id']) && ($this->request->server['REQUEST_METHOD'] != 'POST')) {
            $bank_info = $this->model_bank_bank->getbank($this->request->get['bank_id']);
        }

        $this->load->model('localisation/language');

        $data['languages'] = $this->model_localisation_language->getLanguages();

        if (isset($this->request->post['bank_description'])) {
            $data['bank_description'] = $this->request->post['bank_description'];
        } elseif (isset($this->request->get['bank_id'])) {
            $data['bank_description'] = $this->model_bank_bank->getbankDescriptions($this->request->get['bank_id']);
        } else {
            $data['bank_description'] = array();
        }

        if (isset($this->request->post['value'])) {
            $data['value'] = $this->request->post['value'];
        } elseif (!empty($bank_info)) {
            $data['value'] = $bank_info['value'];
        } else {
            $data['value'] = '';
        }

        $data['header'] = $this->load->controller('common/header');
        $data['column_left'] = $this->load->controller('common/column_left');
        $data['footer'] = $this->load->controller('common/footer');

        $this->response->setOutput($this->load->view('bank/bank_form.tpl', $data));
    }

    protected function validateForm()
    {
        if (!$this->user->hasPermission('modify', 'bank/bank')) {
            $this->error['warning'] = $this->language->get('error_permission');
        }

        foreach ($this->request->post['bank_description'] as $language_id => $value) {
            if ((utf8_strlen($value['title']) < 3) || (utf8_strlen($value['title']) > 32)) {
                $this->error['title'][$language_id] = $this->language->get('error_title');
            }
        }

        return !$this->error;
    }

    protected function validateDelete()
    {
        if (!$this->user->hasPermission('modify', 'bank/bank')) {
            $this->error['warning'] = $this->language->get('error_permission');
        }

        $this->load->model('bank/bank');

        foreach ($this->request->post['selected'] as $bank_id) {
            if ($this->config->get('config_bank_id') == $bank_id) {
                $this->error['warning'] = $this->language->get('error_default');
            }

            $product_total = $this->model_bank_bank->getTotalcustomersBybankId($bank_id);

            if ($product_total) {
                $this->error['warning'] = sprintf($this->language->get('error_product'), $product_total);
            }
        }

        return !$this->error;
    }
}
