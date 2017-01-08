<?php

class Controllersellerreviewsellerreview extends Controller
{
    private $error = array();

    public function index()
    {
        $this->load->language('sellerreview/sellerreview');

        $this->document->setTitle($this->language->get('heading_title'));

        $this->load->model('sellerreview/sellerreview');

        $this->getList();
    }

    public function add()
    {
        $this->load->language('sellerreview/sellerreview');

        $this->document->setTitle($this->language->get('heading_title'));

        $this->load->model('sellerreview/sellerreview');

        if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
            $this->model_sellerreview_sellerreview->addsellerreview($this->request->post);

            $this->session->data['success'] = $this->language->get('text_success');

            $url = '';

            if (isset($this->request->get['filter_seller'])) {
                $url .= '&filter_seller='.urlencode(html_entity_decode($this->request->get['filter_seller'], ENT_QUOTES, 'UTF-8'));
            }

            if (isset($this->request->get['filter_customer_name'])) {
                $url .= '&filter_customer_name='.urlencode(html_entity_decode($this->request->get['filter_customer_name'], ENT_QUOTES, 'UTF-8'));
            }

            if (isset($this->request->get['filter_status'])) {
                $url .= '&filter_status='.$this->request->get['filter_status'];
            }

            if (isset($this->request->get['filter_date_added'])) {
                $url .= '&filter_date_added='.$this->request->get['filter_date_added'];
            }

            if (isset($this->request->get['sort'])) {
                $url .= '&sort='.$this->request->get['sort'];
            }

            if (isset($this->request->get['order'])) {
                $url .= '&order='.$this->request->get['order'];
            }

            if (isset($this->request->get['page'])) {
                $url .= '&page='.$this->request->get['page'];
            }

            $this->response->redirect($this->url->link('sellerreview/sellerreview', 'token='.$this->session->data['token'].$url, 'SSL'));
        }

        $this->getForm();
    }

    public function edit()
    {
        $this->load->language('sellerreview/sellerreview');

        $this->document->setTitle($this->language->get('heading_title'));

        $this->load->model('sellerreview/sellerreview');

        if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
            $this->model_sellerreview_sellerreview->editsellerreview($this->request->get['sellerreview_id'], $this->request->post);

            $this->session->data['success'] = $this->language->get('text_success');

            $url = '';

            if (isset($this->request->get['filter_seller'])) {
                $url .= '&filter_seller='.urlencode(html_entity_decode($this->request->get['filter_seller'], ENT_QUOTES, 'UTF-8'));
            }

            if (isset($this->request->get['filter_customer_name'])) {
                $url .= '&filter_customer_name='.urlencode(html_entity_decode($this->request->get['filter_customer_name'], ENT_QUOTES, 'UTF-8'));
            }

            if (isset($this->request->get['filter_status'])) {
                $url .= '&filter_status='.$this->request->get['filter_status'];
            }

            if (isset($this->request->get['filter_date_added'])) {
                $url .= '&filter_date_added='.$this->request->get['filter_date_added'];
            }

            if (isset($this->request->get['sort'])) {
                $url .= '&sort='.$this->request->get['sort'];
            }

            if (isset($this->request->get['order'])) {
                $url .= '&order='.$this->request->get['order'];
            }

            if (isset($this->request->get['page'])) {
                $url .= '&page='.$this->request->get['page'];
            }

            $this->response->redirect($this->url->link('sellerreview/sellerreview', 'token='.$this->session->data['token'].$url, 'SSL'));
        }

        $this->getForm();
    }

    public function delete()
    {
        $this->load->language('sellerreview/sellerreview');

        $this->document->setTitle($this->language->get('heading_title'));

        $this->load->model('sellerreview/sellerreview');

        if (isset($this->request->post['selected']) && $this->validateDelete()) {
            foreach ($this->request->post['selected'] as $sellerreview_id) {
                $this->model_sellerreview_sellerreview->deletesellerreview($sellerreview_id);
            }

            $this->session->data['success'] = $this->language->get('text_success');

            $url = '';

            if (isset($this->request->get['filter_seller'])) {
                $url .= '&filter_seller='.urlencode(html_entity_decode($this->request->get['filter_seller'], ENT_QUOTES, 'UTF-8'));
            }

            if (isset($this->request->get['filter_customer_name'])) {
                $url .= '&filter_customer_name='.urlencode(html_entity_decode($this->request->get['filter_customer_name'], ENT_QUOTES, 'UTF-8'));
            }

            if (isset($this->request->get['filter_status'])) {
                $url .= '&filter_status='.$this->request->get['filter_status'];
            }

            if (isset($this->request->get['filter_date_added'])) {
                $url .= '&filter_date_added='.$this->request->get['filter_date_added'];
            }

            if (isset($this->request->get['sort'])) {
                $url .= '&sort='.$this->request->get['sort'];
            }

            if (isset($this->request->get['order'])) {
                $url .= '&order='.$this->request->get['order'];
            }

            if (isset($this->request->get['page'])) {
                $url .= '&page='.$this->request->get['page'];
            }

            $this->response->redirect($this->url->link('sellerreview/sellerreview', 'token='.$this->session->data['token'].$url, 'SSL'));
        }

        $this->getList();
    }

    protected function getList()
    {
        if (isset($this->request->get['filter_seller'])) {
            $filter_seller = $this->request->get['filter_seller'];
        } else {
            $filter_seller = null;
        }

        if (isset($this->request->get['filter_customer_name'])) {
            $filter_customer_name = $this->request->get['filter_customer_name'];
        } else {
            $filter_customer_name = null;
        }

        if (isset($this->request->get['filter_status'])) {
            $filter_status = $this->request->get['filter_status'];
        } else {
            $filter_status = null;
        }

        if (isset($this->request->get['filter_date_added'])) {
            $filter_date_added = $this->request->get['filter_date_added'];
        } else {
            $filter_date_added = null;
        }

        if (isset($this->request->get['sort'])) {
            $sort = $this->request->get['sort'];
        } else {
            $sort = 'r.date_added';
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

        if (isset($this->request->get['filter_seller'])) {
            $url .= '&filter_seller='.urlencode(html_entity_decode($this->request->get['filter_seller'], ENT_QUOTES, 'UTF-8'));
        }

        if (isset($this->request->get['filter_customer_name'])) {
            $url .= '&filter_customer_name='.urlencode(html_entity_decode($this->request->get['filter_customer_name'], ENT_QUOTES, 'UTF-8'));
        }

        if (isset($this->request->get['filter_status'])) {
            $url .= '&filter_status='.$this->request->get['filter_status'];
        }

        if (isset($this->request->get['filter_date_added'])) {
            $url .= '&filter_date_added='.$this->request->get['filter_date_added'];
        }

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
            'href' => $this->url->link('sellerreview/sellerreview', 'token='.$this->session->data['token'].$url, 'SSL'),
        );

        $data['add'] = $this->url->link('sellerreview/sellerreview/add', 'token='.$this->session->data['token'].$url, 'SSL');
        $data['delete'] = $this->url->link('sellerreview/sellerreview/delete', 'token='.$this->session->data['token'].$url, 'SSL');

        $data['sellerreviews'] = array();

        $filter_data = array(
            'filter_seller' => $filter_seller,
            'filter_customer_name' => $filter_customer_name,
            'filter_status' => $filter_status,
            'filter_date_added' => $filter_date_added,
            'sort' => $sort,
            'order' => $order,
            'start' => ($page - 1) * $this->config->get('config_limit_admin'),
            'limit' => $this->config->get('config_limit_admin'),
        );

        $sellerreview_total = $this->model_sellerreview_sellerreview->getTotalsellerreviews($filter_data);

        $results = $this->model_sellerreview_sellerreview->getsellerreviews($filter_data);

        foreach ($results as $result) {
            $data['sellerreviews'][] = array(
                'sellerreview_id' => $result['sellerreview_id'],
                'name' => $result['title'],
                'customer_name' => $result['customer_name'],
                'rating' => $result['rating'],
                'status' => ($result['status']) ? $this->language->get('text_enabled') : $this->language->get('text_disabled'),
                'date_added' => date($this->language->get('date_format_short'), strtotime($result['date_added'])),
                'edit' => $this->url->link('sellerreview/sellerreview/edit', 'token='.$this->session->data['token'].'&sellerreview_id='.$result['sellerreview_id'].$url, 'SSL'),
            );
        }

        $data['heading_title'] = $this->language->get('heading_title');

        $data['text_list'] = $this->language->get('text_list');
        $data['text_no_results'] = $this->language->get('text_no_results');
        $data['text_confirm'] = $this->language->get('text_confirm');
        $data['text_enabled'] = $this->language->get('text_enabled');
        $data['text_disabled'] = $this->language->get('text_disabled');

        $data['column_seller'] = $this->language->get('column_seller');
        $data['column_customer_name'] = $this->language->get('column_customer_name');
        $data['column_rating'] = $this->language->get('column_rating');
        $data['column_status'] = $this->language->get('column_status');
        $data['column_date_added'] = $this->language->get('column_date_added');
        $data['column_action'] = $this->language->get('column_action');

        $data['entry_seller'] = $this->language->get('entry_seller');
        $data['entry_customer_name'] = $this->language->get('entry_customer_name');
        $data['entry_rating'] = $this->language->get('entry_rating');
        $data['entry_status'] = $this->language->get('entry_status');
        $data['entry_date_added'] = $this->language->get('entry_date_added');

        $data['button_add'] = $this->language->get('button_add');
        $data['button_edit'] = $this->language->get('button_edit');
        $data['button_delete'] = $this->language->get('button_delete');
        $data['button_filter'] = $this->language->get('button_filter');

        $data['token'] = $this->session->data['token'];

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

        $data['sort_seller'] = $this->url->link('sellerreview/sellerreview', 'token='.$this->session->data['token'].'&sort=pd.title'.$url, 'SSL');
        $data['sort_customer_name'] = $this->url->link('sellerreview/sellerreview', 'token='.$this->session->data['token'].'&sort=r.customer_name'.$url, 'SSL');
        $data['sort_rating'] = $this->url->link('sellerreview/sellerreview', 'token='.$this->session->data['token'].'&sort=r.rating'.$url, 'SSL');
        $data['sort_status'] = $this->url->link('sellerreview/sellerreview', 'token='.$this->session->data['token'].'&sort=r.status'.$url, 'SSL');
        $data['sort_date_added'] = $this->url->link('sellerreview/sellerreview', 'token='.$this->session->data['token'].'&sort=r.date_added'.$url, 'SSL');

        $url = '';

        if (isset($this->request->get['filter_seller'])) {
            $url .= '&filter_seller='.urlencode(html_entity_decode($this->request->get['filter_seller'], ENT_QUOTES, 'UTF-8'));
        }

        if (isset($this->request->get['filter_customer_name'])) {
            $url .= '&filter_customer_name='.urlencode(html_entity_decode($this->request->get['filter_customer_name'], ENT_QUOTES, 'UTF-8'));
        }

        if (isset($this->request->get['filter_status'])) {
            $url .= '&filter_status='.$this->request->get['filter_status'];
        }

        if (isset($this->request->get['filter_date_added'])) {
            $url .= '&filter_date_added='.$this->request->get['filter_date_added'];
        }

        if (isset($this->request->get['sort'])) {
            $url .= '&sort='.$this->request->get['sort'];
        }

        if (isset($this->request->get['order'])) {
            $url .= '&order='.$this->request->get['order'];
        }

        $pagination = new Pagination();
        $pagination->total = $sellerreview_total;
        $pagination->page = $page;
        $pagination->limit = $this->config->get('config_limit_admin');
        $pagination->url = $this->url->link('sellerreview/sellerreview', 'token='.$this->session->data['token'].$url.'&page={page}', 'SSL');

        $data['pagination'] = $pagination->render();

        $data['results'] = sprintf($this->language->get('text_pagination'), ($sellerreview_total) ? (($page - 1) * $this->config->get('config_limit_admin')) + 1 : 0, ((($page - 1) * $this->config->get('config_limit_admin')) > ($sellerreview_total - $this->config->get('config_limit_admin'))) ? $sellerreview_total : ((($page - 1) * $this->config->get('config_limit_admin')) + $this->config->get('config_limit_admin')), $sellerreview_total, ceil($sellerreview_total / $this->config->get('config_limit_admin')));

        $data['filter_seller'] = $filter_seller;
        $data['filter_customer_name'] = $filter_customer_name;
        $data['filter_status'] = $filter_status;
        $data['filter_date_added'] = $filter_date_added;

        $data['sort'] = $sort;
        $data['order'] = $order;

        $data['header'] = $this->load->controller('common/header');
        $data['column_left'] = $this->load->controller('common/column_left');
        $data['footer'] = $this->load->controller('common/footer');

        $this->response->setOutput($this->load->view('sellerreview/sellerreview_list.tpl', $data));
    }

    protected function getForm()
    {
        $data['heading_title'] = $this->language->get('heading_title');

        $data['text_form'] = !isset($this->request->get['sellerreview_id']) ? $this->language->get('text_add') : $this->language->get('text_edit');
        $data['text_enabled'] = $this->language->get('text_enabled');
        $data['text_disabled'] = $this->language->get('text_disabled');

        $data['entry_seller'] = $this->language->get('entry_seller');
        $data['entry_customer_name'] = $this->language->get('entry_customer_name');
        $data['entry_rating'] = $this->language->get('entry_rating');
        $data['entry_status'] = $this->language->get('entry_status');
        $data['entry_text'] = $this->language->get('entry_text');

        $data['help_seller'] = $this->language->get('help_seller');

        $data['button_save'] = $this->language->get('button_save');
        $data['button_cancel'] = $this->language->get('button_cancel');

        if (isset($this->error['warning'])) {
            $data['error_warning'] = $this->error['warning'];
        } else {
            $data['error_warning'] = '';
        }

        if (isset($this->error['seller'])) {
            $data['error_seller'] = $this->error['seller'];
        } else {
            $data['error_seller'] = '';
        }

        if (isset($this->error['customer_name'])) {
            $data['error_customer_name'] = $this->error['customer_name'];
        } else {
            $data['error_customer_name'] = '';
        }

        if (isset($this->error['text'])) {
            $data['error_text'] = $this->error['text'];
        } else {
            $data['error_text'] = '';
        }

        if (isset($this->error['rating'])) {
            $data['error_rating'] = $this->error['rating'];
        } else {
            $data['error_rating'] = '';
        }

        $url = '';

        if (isset($this->request->get['filter_seller'])) {
            $url .= '&filter_seller='.urlencode(html_entity_decode($this->request->get['filter_seller'], ENT_QUOTES, 'UTF-8'));
        }

        if (isset($this->request->get['filter_customer_name'])) {
            $url .= '&filter_customer_name='.urlencode(html_entity_decode($this->request->get['filter_customer_name'], ENT_QUOTES, 'UTF-8'));
        }

        if (isset($this->request->get['filter_status'])) {
            $url .= '&filter_status='.$this->request->get['filter_status'];
        }

        if (isset($this->request->get['filter_date_added'])) {
            $url .= '&filter_date_added='.$this->request->get['filter_date_added'];
        }

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
            'href' => $this->url->link('sellerreview/sellerreview', 'token='.$this->session->data['token'].$url, 'SSL'),
        );

        if (!isset($this->request->get['sellerreview_id'])) {
            $data['action'] = $this->url->link('sellerreview/sellerreview/add', 'token='.$this->session->data['token'].$url, 'SSL');
        } else {
            $data['action'] = $this->url->link('sellerreview/sellerreview/edit', 'token='.$this->session->data['token'].'&sellerreview_id='.$this->request->get['sellerreview_id'].$url, 'SSL');
        }

        $data['cancel'] = $this->url->link('sellerreview/sellerreview', 'token='.$this->session->data['token'].$url, 'SSL');

        if (isset($this->request->get['sellerreview_id']) && ($this->request->server['REQUEST_METHOD'] != 'POST')) {
            $sellerreview_info = $this->model_sellerreview_sellerreview->getsellerreview($this->request->get['sellerreview_id']);
        }

        $data['token'] = $this->session->data['token'];

        $this->load->model('seller/seller');

        if (isset($this->request->post['seller_id'])) {
            $data['seller_id'] = $this->request->post['seller_id'];
        } elseif (!empty($sellerreview_info)) {
            $data['seller_id'] = $sellerreview_info['seller_id'];
        } else {
            $data['seller_id'] = '';
        }

        if (isset($this->request->post['seller'])) {
            $data['seller'] = $this->request->post['seller'];
        } elseif (!empty($sellerreview_info)) {
            $data['seller'] = $sellerreview_info['seller'];
        } else {
            $data['seller'] = '';
        }

        if (isset($this->request->post['customer_name'])) {
            $data['customer_name'] = $this->request->post['customer_name'];
        } elseif (!empty($sellerreview_info)) {
            $data['customer_name'] = $sellerreview_info['customer_name'];
        } else {
            $data['customer_name'] = '';
        }

        if (isset($this->request->post['text'])) {
            $data['text'] = $this->request->post['text'];
        } elseif (!empty($sellerreview_info)) {
            $data['text'] = $sellerreview_info['text'];
        } else {
            $data['text'] = '';
        }

        if (isset($this->request->post['rating'])) {
            $data['rating'] = $this->request->post['rating'];
        } elseif (!empty($sellerreview_info)) {
            $data['rating'] = $sellerreview_info['rating'];
        } else {
            $data['rating'] = '';
        }

        if (isset($this->request->post['status'])) {
            $data['status'] = $this->request->post['status'];
        } elseif (!empty($sellerreview_info)) {
            $data['status'] = $sellerreview_info['status'];
        } else {
            $data['status'] = '';
        }

        $data['header'] = $this->load->controller('common/header');
        $data['column_left'] = $this->load->controller('common/column_left');
        $data['footer'] = $this->load->controller('common/footer');

        $this->response->setOutput($this->load->view('sellerreview/sellerreview_form.tpl', $data));
    }

    protected function validateForm()
    {
        if (!$this->user->hasPermission('modify', 'sellerreview/sellerreview')) {
            $this->error['warning'] = $this->language->get('error_permission');
        }

        if (!$this->request->post['seller_id']) {
            $this->error['seller'] = $this->language->get('error_seller');
        }

        if ((utf8_strlen($this->request->post['customer_name']) < 3) || (utf8_strlen($this->request->post['customer_name']) > 64)) {
            $this->error['customer_name'] = $this->language->get('error_customer_name');
        }

        if (utf8_strlen($this->request->post['text']) < 1) {
            $this->error['text'] = $this->language->get('error_text');
        }

        if (!isset($this->request->post['rating']) || $this->request->post['rating'] < 0 || $this->request->post['rating'] > 5) {
            $this->error['rating'] = $this->language->get('error_rating');
        }

        return !$this->error;
    }

    protected function validateDelete()
    {
        if (!$this->user->hasPermission('modify', 'sellerreview/sellerreview')) {
            $this->error['warning'] = $this->language->get('error_permission');
        }

        return !$this->error;
    }
}
