<?php

class Controllersellerseller extends Controller
{
    public function index()
    {
        $this->load->language('seller/seller');

        $this->load->model('seller/seller');

        $this->load->model('tool/image');

        $this->document->setTitle($this->language->get('heading_title'));

        $data['heading_title'] = $this->language->get('heading_title');

        $data['text_index'] = $this->language->get('text_index');
        $data['text_empty'] = $this->language->get('text_empty');

        $data['button_continue'] = $this->language->get('button_continue');

        $data['breadcrumbs'] = array();

        $data['breadcrumbs'][] = array(
            'text' => $this->language->get('text_home'),
            'href' => $this->url->link('common/home'),
        );

        $data['breadcrumbs'][] = array(
            'text' => $this->language->get('text_brand'),
            'href' => $this->url->link('seller/seller'),
        );

        $data['categories'] = array();

        $results = $this->model_seller_seller->getsellers();

        foreach ($results as $result) {
            if (is_numeric(utf8_substr($result['name'], 0, 1))) {
                $key = '0 - 9';
            } else {
                $key = utf8_substr(utf8_strtoupper($result['name']), 0, 1);
            }

            if (!isset($data['categories'][$key])) {
                $data['categories'][$key]['name'] = $key;
            }

            $data['categories'][$key]['seller'][] = array(
                'name' => $result['name'],
                'href' => $this->url->link('seller/seller/info', 'seller_id='.$result['customer_id']),
            );
        }

        $data['continue'] = $this->url->link('common/home');

        $data['column_left'] = $this->load->controller('common/column_left');
        $data['column_right'] = $this->load->controller('common/column_right');
        $data['content_top'] = $this->load->controller('common/content_top');
        $data['content_bottom'] = $this->load->controller('common/content_bottom');
        $data['footer'] = $this->load->controller('common/footer');
        $data['header'] = $this->load->controller('common/header');


            $this->response->setOutput($this->load->view('seller/seller_list', $data));

    }

    public function info()
    {
        $this->load->language('seller/seller');

        $this->load->model('seller/seller');

        $this->load->model('catalog/product');

        $this->load->model('tool/image');

        $data['sellerreviewstatus'] = $this->config->get('config_sellerreview');

        // Captcha
            if ($this->config->get('config_sellerreview') && $this->config->get($this->config->get('config_captcha').'_status')) {
                $data['captcha'] = $this->load->controller('captcha/'.$this->config->get('config_captcha'));
            } else {
                $data['captcha'] = '';
            }

        if ($this->config->get('config_sellerreview_guest') || $this->customer->isLogged()) {
            $data['sellerreviewguest'] = true;
        } else {
            $data['sellerreviewguest'] = false;
        }
        $data['text_seller_login'] = sprintf($this->language->get('text_seller_login'), $this->url->link('account/login', '', 'SSL'), $this->url->link('account/register', '', 'SSL'));

        $data['seller_id'] = (int) $this->request->get['seller_id'];
        $data['text_write'] = $this->language->get('text_write');
        $data['tab_sellerreview'] = $this->language->get('tab_sellerreview');
        $data['entry_name'] = $this->language->get('entry_name');
        $data['text_loading'] = $this->language->get('text_loading');
        $data['entry_sellerreview'] = $this->language->get('entry_sellerreview');
        $data['entry_rating'] = $this->language->get('entry_rating');
        $data['entry_good'] = $this->language->get('entry_good');
        $data['entry_bad'] = $this->language->get('entry_bad');
        $data['text_products_number'] = $this->language->get('text_products_number');
        $data['text_seller_years'] = $this->language->get('text_seller_years');
        $data['entry_captcha'] = $this->language->get('entry_captcha');
        $data['text_note'] = $this->language->get('text_note');

        if (isset($this->request->get['seller_id'])) {
            $seller_id = (int) $this->request->get['seller_id'];
        } else {
            $seller_id = 0;
        }

        if (isset($this->request->get['sort'])) {
            $sort = $this->request->get['sort'];
        } else {
            $sort = 'p.sort_order';
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

        if (isset($this->request->get['limit'])) {
    			$limit = (int)$this->request->get['limit'];
    		} else {
    			$limit = (int)$this->config->get($this->config->get('config_theme') . '_product_limit');
    		}

        $data['breadcrumbs'] = array();

        $data['breadcrumbs'][] = array(
            'text' => $this->language->get('text_home'),
            'href' => $this->url->link('common/home'),
        );

        $data['breadcrumbs'][] = array(
            'text' => $this->language->get('text_brand'),
            'href' => $this->url->link('seller/seller'),
        );

        $seller_info = $this->model_seller_seller->getseller($seller_id);

        if ($seller_info) {
            $this->document->setTitle($seller_info['title']);
            $this->document->addLink($this->url->link('seller/seller/info', 'seller_id='.$this->request->get['seller_id']), 'canonical');

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

            if (isset($this->request->get['limit'])) {
                $url .= '&limit='.$this->request->get['limit'];
            }

            $data['breadcrumbs'][] = array(
                'text' => $seller_info['title'],
                'href' => $this->url->link('seller/seller/info', 'seller_id='.$this->request->get['seller_id'].$url),
            );

            $data['heading_title'] = $seller_info['title'];
            $data['seller_name'] = $seller_info['title'];
            $this->load->model('tool/image');
            if ($this->config->get('config_sellerprofileimage')) {
                $data['sellerprofileimage'] = '1';
            } else {
                $data['sellerprofileimage'] = '0';
            }

            if ($seller_info['image']) {
                $data['seller_image'] = $this->model_tool_image->resize($seller_info['image'], 150, 150);
            } else {
                $data['seller_image'] = $this->model_tool_image->resize('placeholder.png', 150, 150);
            }

            function GetAge($dob)
            {
                    $dob=explode("-",$dob);
                    $curMonth = date("m");
                    $curDay = date("j");
                    $curYear = date("Y");
                    $age = $curYear - $dob[0];
                    if($curMonth<$dob[1] || ($curMonth==$dob[1] && $curDay<$dob[2]))
                            $age--;
                    return $age+1;
            }

            $data['seller_date_added'] =  getAge(date('Y-m-d', strtotime($seller_info['seller_date_added'])));

            if ($seller_info['banner']) {
                $data['seller_banner'] = $this->model_tool_image->resize($seller_info['banner'], 975, 300);
            } else {
                $data['seller_banner'] = $this->model_tool_image->resize('placeholder.png', 150, 150);
            }

            $data['seller_rating'] = (int) $seller_info['rating'];
            $data['sellertwitter'] = $seller_info['twitter'];
            $data['sellergoogleplus'] = $seller_info['googleplus'];
            $data['sellerfacebook'] = $seller_info['facebook'];
            $data['sellerinstagram'] = $seller_info['instagram'];
            $data['seller_description'] =  html_entity_decode($seller_info['description'], ENT_QUOTES, 'UTF-8');

            $data['text_empty'] = $this->language->get('text_empty');
            $data['text_quantity'] = $this->language->get('text_quantity');
            $data['text_seller'] = $this->language->get('text_seller');
            $data['text_model'] = $this->language->get('text_model');
            $data['text_price'] = $this->language->get('text_price');
            $data['text_tax'] = $this->language->get('text_tax');
            $data['text_points'] = $this->language->get('text_points');
            $data['text_compare'] = sprintf($this->language->get('text_compare'), (isset($this->session->data['compare']) ? count($this->session->data['compare']) : 0));
            $data['text_sort'] = $this->language->get('text_sort');
            $data['text_limit'] = $this->language->get('text_limit');

            $data['button_cart'] = $this->language->get('button_cart');
            $data['button_wishlist'] = $this->language->get('button_wishlist');
            $data['button_compare'] = $this->language->get('button_compare');
            $data['button_continue'] = $this->language->get('button_continue');
            $data['button_list'] = $this->language->get('button_list');
            $data['button_grid'] = $this->language->get('button_grid');

            $data['compare'] = $this->url->link('seller/compare');

            $data['products'] = array();

            $filter_data = array(
                'filter_seller_id' => $seller_id,
                'sort' => $sort,
                'order' => $order,
                'start' => ($page - 1) * $limit,
                'limit' => $limit,
            );

            $data['seller_products_total'] =  $product_total = $this->model_seller_seller->getTotalProducts($filter_data);

            $results = $this->model_seller_seller->getProducts($filter_data);

            foreach ($results as $result) {
              if ($result['image']) {
                $image = $this->model_tool_image->resize($result['image'], $this->config->get($this->config->get('config_theme') . '_image_product_width'), $this->config->get($this->config->get('config_theme') . '_image_product_height'));
              } else {
                $image = $this->model_tool_image->resize('placeholder.png', $this->config->get($this->config->get('config_theme') . '_image_product_width'), $this->config->get($this->config->get('config_theme') . '_image_product_height'));
              }

              if ($this->customer->isLogged() || !$this->config->get('config_customer_price')) {
                $price = $this->currency->format($this->tax->calculate($result['price'], $result['tax_class_id'], $this->config->get('config_tax')), $this->session->data['currency']);
              } else {
                $price = false;
              }

                if ((float) $result['special']) {
                    $special = $this->currency->format($this->tax->calculate($result['special'], $result['tax_class_id'], $this->config->get('config_tax')), $this->session->data['currency']);
                } else {
                    $special = false;
                }

                if ($this->config->get('config_tax')) {
                    $tax = $this->currency->format((float) $result['special'] ? $result['special'] : $result['price'], $this->session->data['currency']);
                } else {
                    $tax = false;
                }

                if ($this->config->get('config_review_status')) {
                    $rating = (int) $result['rating'];
                } else {
                    $rating = false;
                }

                $data['products'][] = array(
                    'product_id' => $result['product_id'],
                    'thumb' => $image,
                    'name' => $result['name'],
                    'description' => utf8_substr(strip_tags(html_entity_decode($result['description'], ENT_QUOTES, 'UTF-8')), 0, $this->config->get('config_product_description_length')).'..',
                    'price' => $price,
                    'special' => $special,
                    'tax' => $tax,
                    'rating' => $result['rating'],
                    'href' => $this->url->link('product/product', '&product_id='.$result['product_id'].$url),
                );
            }

            $url = '';

            if (isset($this->request->get['limit'])) {
                $url .= '&limit='.$this->request->get['limit'];
            }

            $data['sorts'] = array();

            $data['sorts'][] = array(
                'text' => $this->language->get('text_default'),
                'value' => 'p.sort_order-ASC',
                'href' => $this->url->link('seller/seller/info', 'seller_id='.$this->request->get['seller_id'].'&sort=p.sort_order&order=ASC'.$url),
            );

            $data['sorts'][] = array(
                'text' => $this->language->get('text_name_asc'),
                'value' => 'pd.name-ASC',
                'href' => $this->url->link('seller/seller/info', 'seller_id='.$this->request->get['seller_id'].'&sort=pd.name&order=ASC'.$url),
            );

            $data['sorts'][] = array(
                'text' => $this->language->get('text_name_desc'),
                'value' => 'pd.name-DESC',
                'href' => $this->url->link('seller/seller/info', 'seller_id='.$this->request->get['seller_id'].'&sort=pd.name&order=DESC'.$url),
            );

            $data['sorts'][] = array(
                'text' => $this->language->get('text_price_asc'),
                'value' => 'p.price-ASC',
                'href' => $this->url->link('seller/seller/info', 'seller_id='.$this->request->get['seller_id'].'&sort=p.price&order=ASC'.$url),
            );

            $data['sorts'][] = array(
                'text' => $this->language->get('text_price_desc'),
                'value' => 'p.price-DESC',
                'href' => $this->url->link('seller/seller/info', 'seller_id='.$this->request->get['seller_id'].'&sort=p.price&order=DESC'.$url),
            );

            if ($this->config->get('config_review_status')) {
                $data['sorts'][] = array(
                    'text' => $this->language->get('text_rating_desc'),
                    'value' => 'rating-DESC',
                    'href' => $this->url->link('seller/seller/info', 'seller_id='.$this->request->get['seller_id'].'&sort=rating&order=DESC'.$url),
                );

                $data['sorts'][] = array(
                    'text' => $this->language->get('text_rating_asc'),
                    'value' => 'rating-ASC',
                    'href' => $this->url->link('seller/seller/info', 'seller_id='.$this->request->get['seller_id'].'&sort=rating&order=ASC'.$url),
                );
            }

            $data['sorts'][] = array(
                'text' => $this->language->get('text_model_asc'),
                'value' => 'p.model-ASC',
                'href' => $this->url->link('seller/seller/info', 'seller_id='.$this->request->get['seller_id'].'&sort=p.model&order=ASC'.$url),
            );

            $data['sorts'][] = array(
                'text' => $this->language->get('text_model_desc'),
                'value' => 'p.model-DESC',
                'href' => $this->url->link('seller/seller/info', 'seller_id='.$this->request->get['seller_id'].'&sort=p.model&order=DESC'.$url),
            );

            $url = '';

            if (isset($this->request->get['sort'])) {
                $url .= '&sort='.$this->request->get['sort'];
            }

            if (isset($this->request->get['order'])) {
                $url .= '&order='.$this->request->get['order'];
            }

            $data['limits'] = array();

          	$limits = array_unique(array($this->config->get($this->config->get('config_theme') . '_product_limit'), 25, 50, 75, 100));

            sort($limits);

            foreach ($limits as $value) {
                $data['limits'][] = array(
                    'text' => $value,
                    'value' => $value,
                    'href' => $this->url->link('seller/seller/info', 'seller_id='.$this->request->get['seller_id'].$url.'&limit='.$value),
                );
            }

            $url = '';

            if (isset($this->request->get['sort'])) {
                $url .= '&sort='.$this->request->get['sort'];
            }

            if (isset($this->request->get['order'])) {
                $url .= '&order='.$this->request->get['order'];
            }

            if (isset($this->request->get['limit'])) {
                $url .= '&limit='.$this->request->get['limit'];
            }

            $pagination = new Pagination();
            $pagination->total = $product_total;
            $pagination->page = $page;
            $pagination->limit = $limit;
            $pagination->url = $this->url->link('seller/seller/info', 'seller_id='.$this->request->get['seller_id'].$url.'&page={page}');

            $data['pagination'] = $pagination->render();

            $data['results'] = sprintf($this->language->get('text_pagination'), ($product_total) ? (($page - 1) * $limit) + 1 : 0, ((($page - 1) * $limit) > ($product_total - $limit)) ? $product_total : ((($page - 1) * $limit) + $limit), $product_total, ceil($product_total / $limit));

            $data['sort'] = $sort;
            $data['order'] = $order;
            $data['limit'] = $limit;

            $data['continue'] = $this->url->link('common/home');

            $data['column_left'] = $this->load->controller('common/column_left');
            $data['column_right'] = $this->load->controller('common/column_right');
            $data['content_top'] = $this->load->controller('common/content_top');
            $data['content_bottom'] = $this->load->controller('common/content_bottom');
            $data['footer'] = $this->load->controller('common/footer');
            $data['header'] = $this->load->controller('common/header');


                $this->response->setOutput($this->load->view('seller/seller_info', $data));

        } else {
            $url = '';

            if (isset($this->request->get['seller_id'])) {
                $url .= '&seller_id='.$this->request->get['seller_id'];
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

            if (isset($this->request->get['limit'])) {
                $url .= '&limit='.$this->request->get['limit'];
            }

            $data['breadcrumbs'][] = array(
                'text' => $this->language->get('text_error'),
                'href' => $this->url->link('seller/seller/info', $url),
            );

            $this->document->setTitle($this->language->get('text_error'));

            $data['heading_title'] = $this->language->get('text_error');

            $data['text_error'] = $this->language->get('text_error');

            $data['button_continue'] = $this->language->get('button_continue');

            $data['continue'] = $this->url->link('common/home');

            $this->response->addHeader($this->request->server['SERVER_PROTOCOL'].' 404 Not Found');

            $data['header'] = $this->load->controller('common/header');
            $data['footer'] = $this->load->controller('common/footer');
            $data['column_left'] = $this->load->controller('common/column_left');
            $data['column_right'] = $this->load->controller('common/column_right');
            $data['content_top'] = $this->load->controller('common/content_top');
            $data['content_bottom'] = $this->load->controller('common/content_bottom');


                $this->response->setOutput($this->load->view('error/not_found', $data));

        }
    }

    public function autocomplete()
    {
        $json = array();

        if (isset($this->request->get['filter_name'])) {
            $this->load->model('seller/seller');

            $filter_data = array(
                'filter_name' => $this->request->get['filter_name'],
                'start' => 0,
                'limit' => 5,
            );

            $results = $this->model_seller_seller->getsellers($filter_data);

            foreach ($results as $result) {
                $json[] = array(
                    'seller_id' => $result['seller_id'],
                    'name' => strip_tags(html_entity_decode($result['title'], ENT_QUOTES, 'UTF-8')),
                );
            }
        }

        $sort_order = array();

        foreach ($json as $key => $value) {
            $sort_order[$key] = $value['name'];
        }

        array_multisort($sort_order, SORT_ASC, $json);

        $this->response->addHeader('Content-Type: application/json');
        $this->response->setOutput(json_encode($json));
    }

    public function sellerreview()
    {
        $this->load->language('seller/seller');

        $this->load->model('seller/seller');

        $data['text_no_sellerreviews'] = $this->language->get('text_no_sellerreviews');

        if (isset($this->request->get['page'])) {
            $page = $this->request->get['page'];
        } else {
            $page = 1;
        }

        $data['sellerreviews'] = array();

        $sellerreview_total = $this->model_seller_seller->getTotalsellerreviewsBysellerId($this->request->get['seller_id']);

        $results = $this->model_seller_seller->getsellerreviewsBysellerId($this->request->get['seller_id'], ($page - 1) * 5, 5);

        foreach ($results as $result) {
            $data['sellerreviews'][] = array(
                'customer_name' => $result['customer_name'],
                'text' => nl2br($result['text']),
                'rating' => (int) $result['rating'],
                'date_added' => date($this->language->get('date_format_short'), strtotime($result['date_added'])),
            );
        }

        $pagination = new Pagination();
        $pagination->total = $sellerreview_total;
        $pagination->page = $page;
        $pagination->limit = 5;
        $pagination->url = $this->url->link('seller/seller/sellerreview', 'seller_id='.$this->request->get['seller_id'].'&page={page}');

        $data['pagination'] = $pagination->render();

        $data['results'] = sprintf($this->language->get('text_pagination'), ($sellerreview_total) ? (($page - 1) * 5) + 1 : 0, ((($page - 1) * 5) > ($sellerreview_total - 5)) ? $sellerreview_total : ((($page - 1) * 5) + 5), $sellerreview_total, ceil($sellerreview_total / 5));


            $this->response->setOutput($this->load->view('seller/seller_review', $data));

    }

    public function write()
    {
        $this->load->language('seller/seller');

        $json = array();

        if ($this->request->server['REQUEST_METHOD'] == 'POST') {
            if ((utf8_strlen($this->request->post['name']) < 3) || (utf8_strlen($this->request->post['name']) > 25)) {
                $json['error'] = $this->language->get('error_name');
            }

            if ((utf8_strlen($this->request->post['text']) < 25) || (utf8_strlen($this->request->post['text']) > 1000)) {
                $json['error'] = $this->language->get('error_text');
            }

            if (empty($this->request->post['rating']) || $this->request->post['rating'] < 0 || $this->request->post['rating'] > 5) {
                $json['error'] = $this->language->get('error_rating');
            }

            if ($this->config->get('config_sellerreview') && $this->config->get($this->config->get('config_captcha').'_status')) {
                $captcha = $this->load->controller('captcha/'.$this->config->get('config_captcha').'/validate');

                if ($captcha) {
                    $json['error'] = $captcha;
                }
            }

            unset($this->session->data['captcha']);

            if (!isset($json['error'])) {
                $this->load->model('seller/seller');

                $this->model_seller_seller->addsellerReview($this->request->get['seller_id'], $this->request->post);

                $json['success'] = $this->language->get('text_success');
            }
        }

        $this->response->addHeader('Content-Type: application/json');
        $this->response->setOutput(json_encode($json));
    }
}
