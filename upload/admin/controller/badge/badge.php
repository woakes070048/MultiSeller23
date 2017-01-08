<?php

class Controllerbadgebadge extends Controller
{
    private $error = array();

    public function index()
    {
        $this->load->language('badge/badge');

        $this->document->setTitle($this->language->get('heading_title'));

        $this->load->model('badge/badge');

        $this->getList();
    }

    public function add()
    {
        $this->load->language('badge/badge');

        $this->document->setTitle($this->language->get('heading_title'));

        $this->load->model('badge/badge');

        if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
            $this->model_badge_badge->addbadge($this->request->post);

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

            $this->response->redirect($this->url->link('badge/badge', 'token='.$this->session->data['token'].$url, 'SSL'));
        }

        $this->getForm();
    }

    public function edit()
    {
        $this->load->language('badge/badge');

        $this->document->setTitle($this->language->get('heading_title'));

        $this->load->model('badge/badge');

        if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
            $this->model_badge_badge->editbadge($this->request->get['badge_id'], $this->request->post);

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

            $this->response->redirect($this->url->link('badge/badge', 'token='.$this->session->data['token'].$url, 'SSL'));
        }

        $this->getForm();
    }

    public function delete()
    {
        $this->load->language('badge/badge');

        $this->document->setTitle($this->language->get('heading_title'));

        $this->load->model('badge/badge');

        if (isset($this->request->post['selected']) && $this->validateDelete()) {
            foreach ($this->request->post['selected'] as $badge_id) {
                $this->model_badge_badge->deletebadge($badge_id);
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

            $this->response->redirect($this->url->link('badge/badge', 'token='.$this->session->data['token'].$url, 'SSL'));
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
            'href' => $this->url->link('badge/badge', 'token='.$this->session->data['token'].$url, 'SSL'),
        );

        $data['insert'] = $this->url->link('badge/badge/add', 'token='.$this->session->data['token'].$url, 'SSL');
        $data['delete'] = $this->url->link('badge/badge/delete', 'token='.$this->session->data['token'].$url, 'SSL');

        $data['badges'] = array();

        $filter_data = array(
            'sort' => $sort,
            'order' => $order,
            'start' => ($page - 1) * $this->config->get('config_limit_admin'),
            'limit' => $this->config->get('config_limit_admin'),
        );

        $badge_total = $this->model_badge_badge->getTotalbadges();

        $results = $this->model_badge_badge->getbadges($filter_data);

        $this->load->model('tool/image');

        foreach ($results as $result) {
            $data['badges'][] = array(
                'badge_id' => $result['badge_id'],
                'title' => $result['title'].(($result['badge_id'] == $this->config->get('config_badge_id')) ? $this->language->get('text_default') : null),
                'image' => (is_file(DIR_IMAGE.$result['image']) ? $this->model_tool_image->resize($result['image'], 40, 40) : $this->model_tool_image->resize('no_image.png', 40, 40)),
                'edit' => $this->url->link('badge/badge/edit', 'token='.$this->session->data['token'].'&badge_id='.$result['badge_id'].$url, 'SSL'),
            );
        }

        $data['heading_title'] = $this->language->get('heading_title');

        $data['text_list'] = $this->language->get('text_list');
        $data['text_no_results'] = $this->language->get('text_no_results');
        $data['text_confirm'] = $this->language->get('text_confirm');

        $data['column_title'] = $this->language->get('column_title');
        $data['column_image'] = $this->language->get('column_image');
        $data['column_seller_id'] = $this->language->get('column_seller_id');
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

        $data['sort_title'] = $this->url->link('badge/badge', 'token='.$this->session->data['token'].'&sort=title'.$url, 'SSL');
        $data['sort_image'] = $this->url->link('badge/badge', 'token='.$this->session->data['token'].'&sort=image'.$url, 'SSL');
        $data['sort_seller_id'] = $this->url->link('badge/badge', 'token='.$this->session->data['token'].'&sort=seller_id'.$url, 'SSL');

        $url = '';

        if (isset($this->request->get['sort'])) {
            $url .= '&sort='.$this->request->get['sort'];
        }

        if (isset($this->request->get['order'])) {
            $url .= '&order='.$this->request->get['order'];
        }

        $pagination = new Pagination();
        $pagination->total = $badge_total;
        $pagination->page = $page;
        $pagination->limit = $this->config->get('config_limit_admin');
        $pagination->url = $this->url->link('badge/badge', 'token='.$this->session->data['token'].$url.'&page={page}', 'SSL');

        $data['pagination'] = $pagination->render();

        $data['results'] = sprintf($this->language->get('text_pagination'), ($badge_total) ? (($page - 1) * $this->config->get('config_limit_admin')) + 1 : 0, ((($page - 1) * $this->config->get('config_limit_admin')) > ($badge_total - $this->config->get('config_limit_admin'))) ? $badge_total : ((($page - 1) * $this->config->get('config_limit_admin')) + $this->config->get('config_limit_admin')), $badge_total, ceil($badge_total / $this->config->get('config_limit_admin')));

        $data['sort'] = $sort;
        $data['order'] = $order;

        $data['header'] = $this->load->controller('common/header');
        $data['column_left'] = $this->load->controller('common/column_left');
        $data['footer'] = $this->load->controller('common/footer');

        $this->response->setOutput($this->load->view('badge/badge_list.tpl', $data));
    }

    protected function getForm()
    {
        $data['heading_title'] = $this->language->get('heading_title');

        $data['text_form'] = !isset($this->request->get['badge_id']) ? $this->language->get('text_add') : $this->language->get('text_edit');
        $data['token'] = $this->session->data['token'];
        $data['entry_title'] = $this->language->get('entry_title');
        $data['entry_image'] = $this->language->get('entry_image');
        $data['entry_seller_id'] = $this->language->get('entry_seller_id');
        $data['text_loading'] = $this->language->get('text_loading');
        $data['entry_seller_badge'] = $this->language->get('entry_seller_badge');
        $data['entry_seller'] = $this->language->get('entry_seller');
        $data['help_seller_id'] = $this->language->get('help_seller_id');
        $data['button_seller_add'] = $this->language->get('button_seller_add');
        $data['button_seller_delete'] = $this->language->get('button_seller_delete');
        $data['text_confirm'] = $this->language->get('text_confirm');
        $data['text_badge'] = $this->language->get('text_badge');
        $data['button_save'] = $this->language->get('button_save');
        $data['button_cancel'] = $this->language->get('button_cancel');
        $data['tab_general'] = $this->language->get('tab_general');

        $data['tab_sellerbadge'] = $this->language->get('tab_sellerbadge');

        if (isset($this->request->get['badge_id'])) {
            $data['badge_id'] = $this->request->get['badge_id'];
        } else {
            $data['badge_id'] = 0;
        }

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

        if (isset($this->error['image'])) {
            $data['error_image'] = $this->error['image'];
        } else {
            $data['error_image'] = array();
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
            'href' => $this->url->link('badge/badge', 'token='.$this->session->data['token'].$url, 'SSL'),
        );

        if (!isset($this->request->get['badge_id'])) {
            $data['action'] = $this->url->link('badge/badge/add', 'token='.$this->session->data['token'].$url, 'SSL');
        } else {
            $data['action'] = $this->url->link('badge/badge/edit', 'token='.$this->session->data['token'].'&badge_id='.$this->request->get['badge_id'].$url, 'SSL');
        }

        $data['cancel'] = $this->url->link('badge/badge', 'token='.$this->session->data['token'].$url, 'SSL');

        if (isset($this->request->get['badge_id']) && ($this->request->server['REQUEST_METHOD'] != 'POST')) {
            $badge_info = $this->model_badge_badge->getbadge($this->request->get['badge_id']);
        }

        if (isset($this->request->post['seller_badge'])) {
            $data['seller_id_badge'] = $this->request->post['seller_badge'];
        } elseif (isset($this->request->get['badge_id'])) {
            $data['seller_id_badge'] = $this->model_badge_badge->getsellerbadges($this->request->get['badge_id']);
        } else {
            $data['seller_id_badge'] = array($this->config->get('config_badge_id'));
        }

        $this->load->model('localisation/language');

        $data['languages'] = $this->model_localisation_language->getLanguages();

        if (isset($this->request->post['badge_description'])) {
            $data['badge_description'] = $this->request->post['badge_description'];
        } elseif (isset($this->request->get['badge_id'])) {
            $data['badge_description'] = $this->model_badge_badge->getbadgeDescriptions($this->request->get['badge_id']);
        } else {
            $data['badge_description'] = array();
        }

        if (isset($this->request->post['image'])) {
            $data['image'] = $this->request->post['image'];
        } elseif (!empty($badge_info)) {
            $data['image'] = $badge_info['image'];
        } else {
            $data['image'] = '';
        }

        $this->load->model('tool/image');

        if (isset($this->request->post['image']) && is_file(DIR_IMAGE.$this->request->post['image'])) {
            $data['thumb'] = $this->model_tool_image->resize($this->request->post['image'], 100, 100);
        } elseif (!empty($badge_info) && is_file(DIR_IMAGE.$badge_info['image'])) {
            $data['thumb'] = $this->model_tool_image->resize($badge_info['image'], 100, 100);
        } else {
            $data['thumb'] = $this->model_tool_image->resize('no_image.png', 100, 100);
        }

        $data['placeholder'] = $this->model_tool_image->resize('no_image.png', 100, 100);

        $data['header'] = $this->load->controller('common/header');
        $data['column_left'] = $this->load->controller('common/column_left');
        $data['footer'] = $this->load->controller('common/footer');

        $this->response->setOutput($this->load->view('badge/badge_form.tpl', $data));
    }

    public function sellerbadge()
    {
        $this->load->language('badge/badge');

        $this->load->model('badge/badge');

        if (!empty($this->request->post['seller_id']) && $this->validatesellerbadge()) {
            {

            $this->model_badge_badge->addsellerbadge($this->request->post['seller_id'], $this->request->post['badge_id']);
}
            $data['success'] = $this->language->get('text_success');
        } else {
            $data['success'] = '';
        }

        if (isset($this->error['warning'])) {
            $data['error_warning'] = $this->error['warning'];
        } else {
            $data['error_warning'] = '';
        }

        $data['entry_seller'] = $this->language->get('entry_seller');
        $data['text_no_results'] = $this->language->get('text_no_results');

        $data['button_edit'] = $this->language->get('button_edit');
        $data['column_image'] = $this->language->get('column_image');
        $data['column_name'] = $this->language->get('column_name');
        $data['column_price'] = $this->language->get('column_price');
        $data['column_quantity'] = $this->language->get('column_quantity');
        $data['column_status'] = $this->language->get('column_status');
        $data['column_action'] = $this->language->get('column_action');

        if (isset($this->request->get['page'])) {
            $page = $this->request->get['page'];
        } else {
            $page = 1;
        }

        if (isset($this->request->get['badge_id'])) {
            $data['badge_id'] = $this->request->get['badge_id'];
        } else {
            $data['badge_id'] = 0;
        }

        if (isset($this->request->post['seller_sellerbadge'])) {
            $data['seller_sellerbadge'] = $this->request->post['seller_sellerbadge'];
        } elseif (isset($this->request->get['seller_id'])) {
            $data['seller_sellerbadge'] = $this->model_badge_badge->getsellerbadges($this->request->get['seller_id']);
        } else {
            $data['seller_sellerbadge'] = array($this->config->get('config_sellerbadge_id'));
        }

        $data['sellerbadges'] = array();

        $data['sellers'] = array();

        $this->load->model('tool/image');
        $this->load->model('catalog/product');
        //$badge_total = $this->model_catalog_badge->getTotalbadges();

        $results = $this->model_badge_badge->getsellers($this->request->get['badge_id']);

        foreach ($results as $result) {
            $data['sellers'][] = array(
                'seller_id' => $result['customer_id'],
            'status' => ($result['status'] ? $this->language->get('text_enabled') : $this->language->get('text_disabled')),
                'name' => $result['firstname'].' '.$result['lastname'],
                'edit' => $this->url->link('catalog/badge/edit', 'token='.$this->session->data['token'].'&badge_id='.$result['badge_id'], 'SSL'),
            );
        }

        $badge_total = $this->model_badge_badge->getTotalbadges();

        $pagination = new Pagination();
        $pagination->total = $badge_total;
        $pagination->page = $page;
        $pagination->limit = 10;
        $pagination->url = $this->url->link('badge/badge/sellerbadge', 'token='.$this->session->data['token'].'&badge_id='.$this->request->get['badge_id'].'&page={page}', 'SSL');

        $data['pagination'] = $pagination->render();

        $data['results'] = sprintf($this->language->get('text_pagination'), ($badge_total) ? (($page - 1) * 10) + 1 : 0, ((($page - 1) * 10) > ($badge_total - 10)) ? $badge_total : ((($page - 1) * 10) + 10), $badge_total, ceil($badge_total / 10));

        $this->response->setOutput($this->load->view('badge/badge_sellerbadge.tpl', $data));
    }

    public function sellerbadgedelete()
    {
        $this->load->language('badge/badge');

        $this->load->model('badge/badge');

        if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validatesellerbadge()) {
            if (isset($this->request->post['selected']) && $this->validatesellerbadge()) {
                foreach ($this->request->post['selected'] as $seller_id) {
                    $this->model_badge_badge->deletesellerbadge($seller_id);
                }
            }
            $data['success'] = $this->language->get('text_success');
        } else {
            $data['success'] = '';
        }

        if (isset($this->error['warning'])) {
            $data['error_warning'] = $this->error['warning'];
        } else {
            $data['error_warning'] = '';
        }

        $data['entry_seller'] = $this->language->get('entry_seller');
        $data['text_no_results'] = $this->language->get('text_no_results');

        $data['button_edit'] = $this->language->get('button_edit');
        $data['column_image'] = $this->language->get('column_image');
        $data['column_name'] = $this->language->get('column_name');
        $data['column_price'] = $this->language->get('column_price');
        $data['column_quantity'] = $this->language->get('column_quantity');
        $data['column_status'] = $this->language->get('column_status');
        $data['column_action'] = $this->language->get('column_action');

        if (isset($this->request->get['page'])) {
            $page = $this->request->get['page'];
        } else {
            $page = 1;
        }

        if (isset($this->request->get['badge_id'])) {
            $data['badge_id'] = $this->request->get['badge_id'];
        } else {
            $data['badge_id'] = 0;
        }

        if (isset($this->request->post['seller_sellerbadge'])) {
            $data['seller_sellerbadge'] = $this->request->post['seller_sellerbadge'];
        } elseif (isset($this->request->get['seller_id'])) {
            $data['seller_sellerbadge'] = $this->model_badge_badge->getsellerbadges($this->request->get['seller_id']);
        } else {
            $data['seller_sellerbadge'] = array($this->config->get('config_sellerbadge_id'));
        }

        $data['sellerbadges'] = array();

        $data['badges'] = array();

        $this->load->model('tool/image');
        $this->load->model('catalog/product');
        //$badge_total = $this->model_catalog_badge->getTotalbadges();

        $results = $this->model_badge_badge->getsellers($this->request->get['badge_id']);

        foreach ($results as $result) {
            $data['sellers'][] = array(
                'seller_id' => $result['customer_id'],
            'status' => ($result['status'] ? $this->language->get('text_enabled') : $this->language->get('text_disabled')),
                    'name' => $result['firstname'].' '.$result['lastname'],
                'edit' => $this->url->link('catalog/badge/edit', 'token='.$this->session->data['token'].'&badge_id='.$result['badge_id'], 'SSL'),
            );
        }

        $badge_total = $this->model_badge_badge->getTotalbadges();

        $pagination = new Pagination();
        $pagination->total = $badge_total;
        $pagination->page = $page;
        $pagination->limit = 10;
        $pagination->url = $this->url->link('badge/badge/sellerbadge', 'token='.$this->session->data['token'].'&badge_id='.$this->request->get['badge_id'].'&page={page}', 'SSL');

        $data['pagination'] = $pagination->render();

        $data['results'] = sprintf($this->language->get('text_pagination'), ($badge_total) ? (($page - 1) * 10) + 1 : 0, ((($page - 1) * 10) > ($badge_total - 10)) ? $badge_total : ((($page - 1) * 10) + 10), $badge_total, ceil($badge_total / 10));

        $this->response->setOutput($this->load->view('badge/badge_sellerbadge.tpl', $data));
    }

    protected function validateForm()
    {
        if (!$this->user->hasPermission('modify', 'badge/badge')) {
            $this->error['warning'] = $this->language->get('error_permission');
        }

        foreach ($this->request->post['badge_description'] as $language_id => $seller_id) {
            if ((utf8_strlen($seller_id['title']) < 3) || (utf8_strlen($seller_id['title']) > 32)) {
                $this->error['title'][$language_id] = $this->language->get('error_title');
            }
        }

        return !$this->error;
    }

    protected function validateDelete()
    {
        if (!$this->user->hasPermission('modify', 'badge/badge')) {
            $this->error['warning'] = $this->language->get('error_permission');
        }

        foreach ($this->request->post['selected'] as $badge_id) {
            if ($this->config->get('config_badge_id') == $badge_id) {
                $this->error['warning'] = $this->language->get('error_default');
            }

            $seller_total = $this->model_badge_badge->getTotalsellersBybadgeId($badge_id);

            if ($seller_total) {
                $this->error['warning'] = sprintf($this->language->get('error_seller'), $seller_total);
            }
        }

        return !$this->error;
    }
    protected function validatesellerbadge()
    {
        if (!$this->user->hasPermission('modify', 'badge/badge')) {
            $this->error['warning'] = $this->language->get('error_permission');
        }

        return !$this->error;
    }
}
