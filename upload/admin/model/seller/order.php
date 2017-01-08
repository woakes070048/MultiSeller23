<?php

class ModelSellerOrder extends Model
{
    public function getOrder($order_id, $seller_id)
    {
        $order_query = $this->db->query('SELECT * FROM `'.DB_PREFIX."order` o WHERE o.order_id = '".(int) $order_id."'");

        $seller_order_query = $this->db->query("SELECT *, CONCAT(firstname, ' ', lastname) AS seller FROM `".DB_PREFIX."customer`  WHERE customer_id = '".(int) $seller_id."'");

        if ($order_query->num_rows) {
            $reward = 0;

            $order_product_query = $this->db->query('SELECT * FROM '.DB_PREFIX."order_product WHERE order_id = '".(int) $order_id."'");

            foreach ($order_product_query->rows as $product) {
                $reward += $product['reward'];
            }

            $country_query = $this->db->query('SELECT * FROM `'.DB_PREFIX."country` WHERE country_id = '".(int) $order_query->row['payment_country_id']."'");

            if ($country_query->num_rows) {
                $payment_iso_code_2 = $country_query->row['iso_code_2'];
                $payment_iso_code_3 = $country_query->row['iso_code_3'];
            } else {
                $payment_iso_code_2 = '';
                $payment_iso_code_3 = '';
            }

            $zone_query = $this->db->query('SELECT * FROM `'.DB_PREFIX."zone` WHERE zone_id = '".(int) $order_query->row['payment_zone_id']."'");

            if ($zone_query->num_rows) {
                $payment_zone_code = $zone_query->row['code'];
            } else {
                $payment_zone_code = '';
            }

            $country_query = $this->db->query('SELECT * FROM `'.DB_PREFIX."country` WHERE country_id = '".(int) $order_query->row['shipping_country_id']."'");

            if ($country_query->num_rows) {
                $shipping_iso_code_2 = $country_query->row['iso_code_2'];
                $shipping_iso_code_3 = $country_query->row['iso_code_3'];
            } else {
                $shipping_iso_code_2 = '';
                $shipping_iso_code_3 = '';
            }

            $zone_query = $this->db->query('SELECT * FROM `'.DB_PREFIX."zone` WHERE zone_id = '".(int) $order_query->row['shipping_zone_id']."'");

            if ($zone_query->num_rows) {
                $shipping_zone_code = $zone_query->row['code'];
            } else {
                $shipping_zone_code = '';
            }

            $this->load->model('localisation/language');

            $language_info = $this->model_localisation_language->getLanguage($order_query->row['language_id']);

            if ($language_info) {
                $language_code = $language_info['code'];

                $language_directory = $language_info['directory'];
            } else {
                $language_code = '';

                $language_directory = '';
            }

            if ($order_query->row['affiliate_id']) {
                $affiliate_id = $order_query->row['affiliate_id'];
            } else {
                $affiliate_id = 0;
            }

            $this->load->model('marketing/affiliate');

            $affiliate_info = $this->model_marketing_affiliate->getAffiliate($affiliate_id);

            if ($affiliate_info) {
                $affiliate_firstname = $affiliate_info['firstname'];
                $affiliate_lastname = $affiliate_info['lastname'];
            } else {
                $affiliate_firstname = '';
                $affiliate_lastname = '';
            }

            $this->load->model('localisation/language');

            $language_info = $this->model_localisation_language->getLanguage($order_query->row['language_id']);

            if ($language_info) {
                $language_code = $language_info['code'];

                $language_directory = $language_info['directory'];
            } else {
                $language_code = '';

                $language_directory = '';
            }

            return array(
                'order_id' => $order_query->row['order_id'],
                'invoice_no' => $order_query->row['invoice_no'],
                'invoice_prefix' => $order_query->row['invoice_prefix'],
                'store_id' => $order_query->row['store_id'],
                'store_name' => $order_query->row['store_name'],
                'store_url' => $order_query->row['store_url'],
                'customer_id' => $seller_order_query->row['customer_id'],
                'seller' => $seller_order_query->row['seller'],
                'customer_group_id' => $seller_order_query->row['customer_group_id'],
                'firstname' => $seller_order_query->row['firstname'],
                'lastname' => $seller_order_query->row['lastname'],
                'email' => $seller_order_query->row['email'],
                'telephone' => $seller_order_query->row['telephone'],
                'customer_email' => $order_query->row['email'],
                'customer_telephone' => $order_query->row['telephone'],
                'fax' => $seller_order_query->row['fax'],
                'custom_field' => json_decode($order_query->row['custom_field'], true),
                'payment_firstname' => $order_query->row['payment_firstname'],
                'payment_lastname' => $order_query->row['payment_lastname'],
                'payment_company' => $order_query->row['payment_company'],
                'payment_address_1' => $order_query->row['payment_address_1'],
                'payment_address_2' => $order_query->row['payment_address_2'],
                'payment_postcode' => $order_query->row['payment_postcode'],
                'payment_city' => $order_query->row['payment_city'],
                'payment_zone_id' => $order_query->row['payment_zone_id'],
                'payment_zone' => $order_query->row['payment_zone'],
                'payment_zone_code' => $payment_zone_code,
                'payment_country_id' => $order_query->row['payment_country_id'],
                'payment_country' => $order_query->row['payment_country'],
                'payment_iso_code_2' => $payment_iso_code_2,
                'payment_iso_code_3' => $payment_iso_code_3,
                'payment_address_format' => $order_query->row['payment_address_format'],
                'payment_custom_field' => json_decode($order_query->row['payment_custom_field'], true),
                'payment_method' => $order_query->row['payment_method'],
                'payment_code' => $order_query->row['payment_code'],
                'shipping_firstname' => $order_query->row['shipping_firstname'],
                'shipping_lastname' => $order_query->row['shipping_lastname'],
                'shipping_company' => $order_query->row['shipping_company'],
                'shipping_address_1' => $order_query->row['shipping_address_1'],
                'shipping_address_2' => $order_query->row['shipping_address_2'],
                'shipping_postcode' => $order_query->row['shipping_postcode'],
                'shipping_city' => $order_query->row['shipping_city'],
                'shipping_zone_id' => $order_query->row['shipping_zone_id'],
                'shipping_zone' => $order_query->row['shipping_zone'],
                'shipping_zone_code' => $shipping_zone_code,
                'shipping_country_id' => $order_query->row['shipping_country_id'],
                'shipping_country' => $order_query->row['shipping_country'],
                'shipping_iso_code_2' => $shipping_iso_code_2,
                'shipping_iso_code_3' => $shipping_iso_code_3,
                'shipping_address_format' => $order_query->row['shipping_address_format'],
                'shipping_custom_field' => json_decode($order_query->row['shipping_custom_field'], true),
                'shipping_method' => $order_query->row['shipping_method'],
                'shipping_code' => $order_query->row['shipping_code'],
                'comment' => $order_query->row['comment'],
                'total' => $order_query->row['total'],
                'reward' => $reward,
                'order_status_id' => $order_query->row['order_status_id'],
                'affiliate_id' => $order_query->row['affiliate_id'],
                'affiliate_firstname' => $affiliate_firstname,
                'affiliate_lastname' => $affiliate_lastname,
                'commission' => $order_query->row['commission'],
                'language_id' => $order_query->row['language_id'],
                'language_code' => $language_code,
                'language_directory' => $language_directory,
                'currency_id' => $order_query->row['currency_id'],
                'currency_code' => $order_query->row['currency_code'],
                'currency_value' => $order_query->row['currency_value'],
                'ip' => $order_query->row['ip'],
                'forwarded_ip' => $order_query->row['forwarded_ip'],
                'user_agent' => $order_query->row['user_agent'],
                'accept_language' => $order_query->row['accept_language'],
                'date_added' => $order_query->row['date_added'],
                'date_modified' => $order_query->row['date_modified'],
            );
        } else {
            return;
        }
    }

    public function getOrders($data = array())
    {
        $sql = "
		SELECT *, SUM(op.total) as totals,o.order_id as order_id,o.date_added,c.customer_id as seller_id, CONCAT(c.firstname, ' ', c.lastname) AS seller,c.customer_id as customer_id ,
		(SELECT os.name FROM ".DB_PREFIX."order_status os
		WHERE os.order_status_id = o.order_status_id
		AND os.language_id = '".(int) $this->config->get('config_language_id')."') AS status
		FROM `".DB_PREFIX.'customer` c
		LEFT JOIN  `'.DB_PREFIX.'product_to_seller` cp ON (c.customer_id = cp.seller_id)
		LEFT JOIN  `'.DB_PREFIX.'order_product` op ON (cp.product_id = op.product_id)
		LEFT JOIN  `'.DB_PREFIX.'order` o ON (op.order_id = o.order_id)
		';

        if (isset($data['filter_order_status']) && !is_null($data['filter_order_status'])) {
            $sql .= " WHERE o.order_status_id = '".(int) $data['filter_order_status']."'";
        } else {
            $sql .= " WHERE o.order_status_id > '0'";
        }

        if (!empty($data['filter_order_id'])) {
            $sql .= " AND o.order_id = '".(int) $data['filter_order_id']."'";
        }

        if (!empty($data['filter_seller'])) {
            $sql .= " AND CONCAT(c.firstname, ' ', c.lastname) LIKE '%".$this->db->escape($data['filter_seller'])."%'";
        }

        if (!empty($data['filter_date_added'])) {
            $sql .= " AND DATE(o.date_added) = DATE('".$this->db->escape($data['filter_date_added'])."')";
        }

        if (!empty($data['filter_date_modified'])) {
            $sql .= " AND DATE(o.date_modified) = DATE('".$this->db->escape($data['filter_date_modified'])."')";
        }

        if (!empty($data['filter_order_settlement'])) {
            $sql .= " AND DATE(oss.order_settlement) = DATE('".$this->db->escape($data['filter_order_settlement'])."')";
        }

        if (!empty($data['filter_total'])) {
            $sql .= " AND op.total = '".(float) $data['filter_total']."'";
        }
        // get only order that seller have product in
        //	$sql .= " AND o.order_id  IN (SELECT order_id FROM " . DB_PREFIX . "order_product WHERE  product_id IN (SELECT product_id FROM product_to_seller ))";

        $sort_data = array(
            'o.order_id',
            'customer',
            'status',
            'seller',
            'o.date_added',
            'o.date_modified',
            'oss.settlement',
            'totals',
        );

        $sql .= ' GROUP BY c.customer_id ,op.order_id';

        if (isset($data['sort']) && in_array($data['sort'], $sort_data)) {
            $sql .= ' ORDER BY '.$data['sort'];
        } else {
            $sql .= ' ORDER BY o.order_id';
        }

        if (isset($data['order']) && ($data['order'] == 'DESC')) {
            $sql .= ' DESC';
        } else {
            $sql .= ' ASC';
        }

        if (isset($data['start']) || isset($data['limit'])) {
            if ($data['start'] < 0) {
                $data['start'] = 0;
            }

            if ($data['limit'] < 1) {
                $data['limit'] = 20;
            }

            $sql .= ' LIMIT '.(int) $data['start'].','.(int) $data['limit'];
        }

        $query = $this->db->query($sql);

        return $query->rows;
    }
    public function getSellrOrdersettlement($order_id, $seller_id)
    {
        $sql = '
		SELECT oss.settlement FROM `'.DB_PREFIX."order_seller_settlement` oss
		WHERE oss.order_id = '".(int) $order_id."'
		AND oss.seller_id = '".(int) $seller_id."'
		AND oss.settlement = '1'
		";

        $query = $this->db->query($sql);

        return $query->row;
    }

    public function AddSellrOrdersettlement($order_id, $seller_id)
    {
        $this->db->query('
			DELETE FROM '.DB_PREFIX."order_seller_settlement
			WHERE order_id = '".$order_id."'
			AND seller_id = '".(int) $seller_id."'
			");

        $this->db->query('INSERT INTO '.DB_PREFIX."order_seller_settlement
			SET order_id = '".$order_id."',
			seller_id = '".(int) $seller_id."',
			settlement = '1',
			date_added = NOW()");
    }

    public function CancelSellrOrdersettlement($order_id, $seller_id)
    {
      $this->db->query('
    DELETE FROM '.DB_PREFIX."order_seller_settlement
    WHERE order_id = '".$order_id."'
    AND seller_id = '".(int) $seller_id."'
    ");

    }

    public function getOrderProducts($order_id, $seller_id)
    {
        //$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "order_product WHERE order_id = '" . (int)$order_id . "'");
            $query = $this->db->query('SELECT * FROM '.DB_PREFIX."order_product WHERE order_id = '".(int) $order_id."' AND product_id IN (SELECT product_id FROM ".DB_PREFIX."product_to_seller WHERE seller_id = '".(int) $seller_id."')");

        return $query->rows;
    }

    public function getOrderOption($order_id, $order_option_id)
    {
        $query = $this->db->query('SELECT * FROM '.DB_PREFIX."order_option WHERE order_id = '".(int) $order_id."' AND order_option_id = '".(int) $order_option_id."'");

        return $query->row;
    }

    public function getOrderOptions($order_id, $order_product_id)
    {
        $query = $this->db->query('SELECT * FROM '.DB_PREFIX."order_option WHERE order_id = '".(int) $order_id."' AND order_product_id = '".(int) $order_product_id."'");

        return $query->rows;
    }

    public function getOrderVouchers($order_id)
    {
        $query = $this->db->query('SELECT * FROM '.DB_PREFIX."order_voucher WHERE order_id = '".(int) $order_id."'");

        return $query->rows;
    }

    public function getOrderVoucherByVoucherId($voucher_id)
    {
        $query = $this->db->query('SELECT * FROM `'.DB_PREFIX."order_voucher` WHERE voucher_id = '".(int) $voucher_id."'");

        return $query->row;
    }

    public function getOrderTotals($order_id,$seller_id)
    {
        $query = $this->db->query('SELECT * FROM '.DB_PREFIX."order_total WHERE order_id = '".(int) $order_id."' AND seller_id = '".(int) $seller_id."' ORDER BY sort_order");

        return $query->rows;
    }

    public function getOrderTotalsTotal($order_id,$seller_id)
    {
        $query = $this->db->query('SELECT SUM(value) as totals FROM '.DB_PREFIX."order_total WHERE order_id = '".(int) $order_id."' AND seller_id = '".(int) $seller_id."'");

        return $query->row['totals'];
    }

    public function getTotalOrders($data = array())
    {
        $sql = 'SELECT COUNT(*) AS total FROM `'.DB_PREFIX.'order` o';

        if (!empty($data['filter_order_status'])) {
            $implode = array();

            $order_statuses = explode(',', $data['filter_order_status']);

            foreach ($order_statuses as $order_status_id) {
                $implode[] = "order_status_id = '".(int) $order_status_id."'";
            }

            if ($implode) {
                $sql .= ' WHERE ('.implode(' OR ', $implode).')';
            }
        } else {
            $sql .= " WHERE order_status_id > '0'";
        }

        if (!empty($data['filter_order_id'])) {
            $sql .= " AND order_id = '".(int) $data['filter_order_id']."'";
        }

        if (!empty($data['filter_seller'])) {
            $sql .= " AND CONCAT(firstname, ' ', lastname) LIKE '%".$this->db->escape($data['filter_seller'])."%'";
        }

        if (!empty($data['filter_date_added'])) {
            $sql .= " AND DATE(date_added) = DATE('".$this->db->escape($data['filter_date_added'])."')";
        }

        if (!empty($data['filter_date_modified'])) {
            $sql .= " AND DATE(date_modified) = DATE('".$this->db->escape($data['filter_date_modified'])."')";
        }

        if (!empty($data['filter_total'])) {
            $sql .= " AND total = '".(float) $data['filter_total']."'";
        }

        $sql .= 'AND o.order_id IN (SELECT op.order_id  FROM `'.DB_PREFIX.'product_to_seller` cp
		LEFT JOIN  `'.DB_PREFIX.'order_product` op ON (cp.product_id = op.product_id))';

        $query = $this->db->query($sql);

        return $query->row['total'];
    }

    public function getTotalOrdersByStoreId($store_id)
    {
        $query = $this->db->query('SELECT COUNT(*) AS total FROM `'.DB_PREFIX."order` WHERE store_id = '".(int) $store_id."'");

        return $query->row['total'];
    }

    public function getTotalOrdersByOrderStatusId($order_status_id)
    {
        $query = $this->db->query('SELECT COUNT(*) AS total FROM `'.DB_PREFIX."order` WHERE order_status_id = '".(int) $order_status_id."' AND order_status_id > '0'");

        return $query->row['total'];
    }

    public function getTotalOrdersByProcessingStatus()
    {
        $implode = array();

        $order_statuses = $this->config->get('config_processing_status');

        foreach ($order_statuses as $order_status_id) {
            $implode[] = "order_status_id = '".(int) $order_status_id."'";
        }

        if ($implode) {
            $query = $this->db->query('SELECT COUNT(*) AS total FROM `'.DB_PREFIX.'order` WHERE '.implode(' OR ', $implode).'');

            return $query->row['total'];
        } else {
            return 0;
        }
    }

    public function getTotalOrdersByCompleteStatus()
    {
        $implode = array();

        $order_statuses = $this->config->get('config_complete_status');

        foreach ($order_statuses as $order_status_id) {
            $implode[] = "order_status_id = '".(int) $order_status_id."'";
        }

        if ($implode) {
            $query = $this->db->query('SELECT COUNT(*) AS total FROM `'.DB_PREFIX.'order` WHERE '.implode(' OR ', $implode).'');

            return $query->row['total'];
        } else {
            return 0;
        }
    }

    public function getTotalOrdersByLanguageId($language_id)
    {
        $query = $this->db->query('SELECT COUNT(*) AS total FROM `'.DB_PREFIX."order` WHERE language_id = '".(int) $language_id."' AND order_status_id > '0'");

        return $query->row['total'];
    }

    public function getTotalOrdersByCurrencyId($currency_id)
    {
        $query = $this->db->query('SELECT COUNT(*) AS total FROM `'.DB_PREFIX."order` WHERE currency_id = '".(int) $currency_id."' AND order_status_id > '0'");

        return $query->row['total'];
    }

    public function createInvoiceNo($order_id,$seller_id)
    {
        $order_info = $this->getOrder($order_id,$seller_id);

        if ($order_info && !$order_info['invoice_no']) {
            $query = $this->db->query('SELECT MAX(invoice_no) AS invoice_no FROM `'.DB_PREFIX."order` WHERE invoice_prefix = '".$this->db->escape($order_info['invoice_prefix'])."'");

            if ($query->row['invoice_no']) {
                $invoice_no = $query->row['invoice_no'] + 1;
            } else {
                $invoice_no = 1;
            }

            $this->db->query('UPDATE `'.DB_PREFIX."order` SET invoice_no = '".(int) $invoice_no."', invoice_prefix = '".$this->db->escape($order_info['invoice_prefix'])."' WHERE order_id = '".(int) $order_id."'");

            return $order_info['invoice_prefix'].$invoice_no;
        }
    }

    public function getOrderHistories($order_id, $seller_id, $start = 0, $limit = 10)
    {
        if ($start < 0) {
            $start = 0;
        }

        if ($limit < 1) {
            $limit = 10;
        }

        $query = $this->db->query('SELECT oh.date_added, os.name AS status, oh.comment, oh.notify FROM '.DB_PREFIX.'order_sellerhistory oh LEFT JOIN '.DB_PREFIX."order_status os ON oh.order_status_id = os.order_status_id WHERE oh.order_id = '".(int) $order_id."' AND oh.seller_id = '".(int) $seller_id."' AND os.language_id = '".(int) $this->config->get('config_language_id')."' ORDER BY oh.date_added ASC LIMIT ".(int) $start.','.(int) $limit);

        return $query->rows;
    }

    public function getTotalOrderHistories($order_id, $seller_id)
    {
        $query = $this->db->query('SELECT COUNT(*) AS total FROM '.DB_PREFIX."order_sellerhistory WHERE order_id = '".(int) $order_id."' AND seller_id = '".(int) $seller_id."' ");

        return $query->row['total'];
    }

    public function getTotalOrderHistoriesByOrderStatusId($order_status_id)
    {
        $query = $this->db->query('SELECT COUNT(*) AS total FROM '.DB_PREFIX."order_sellerhistory WHERE order_status_id = '".(int) $order_status_id."'");

        return $query->row['total'];
    }

    public function getEmailsByProductsOrdered($products, $start, $end)
    {
        $implode = array();

        foreach ($products as $product_id) {
            $implode[] = "op.product_id = '".(int) $product_id."'";
        }

        $query = $this->db->query('SELECT DISTINCT email FROM `'.DB_PREFIX.'order` o LEFT JOIN '.DB_PREFIX.'order_product op ON (o.order_id = op.order_id) WHERE ('.implode(' OR ', $implode).") AND o.order_status_id <> '0' LIMIT ".(int) $start.','.(int) $end);

        return $query->rows;
    }

    public function getTotalEmailsByProductsOrdered($products)
    {
        $implode = array();

        foreach ($products as $product_id) {
            $implode[] = "op.product_id = '".(int) $product_id."'";
        }

        $query = $this->db->query('SELECT DISTINCT email FROM `'.DB_PREFIX.'order` o LEFT JOIN '.DB_PREFIX.'order_product op ON (o.order_id = op.order_id) WHERE ('.implode(' OR ', $implode).") AND o.order_status_id <> '0'");

        return $query->row['total'];
    }

    public function getOrderBySeller($seller_id, $order_id)
    {
        $sql = '
		SELECT *, SUM(op.total) as totals
		FROM `'.DB_PREFIX.'product_to_seller` cp
		LEFT JOIN  `'.DB_PREFIX.'order_product` op ON (cp.product_id = op.product_id)
		LEFT JOIN  `'.DB_PREFIX."order` o ON (op.order_id = o.order_id)
		WHERE op.order_id = '".$order_id."'
		AND cp.seller_id = '".$seller_id."'";

        // get only order that seller have product in
        //	$sql .= " AND o.order_id  IN (SELECT order_id FROM " . DB_PREFIX . "order_product WHERE  product_id IN (SELECT product_id FROM product_to_seller ))";

        //$sql .= " GROUP BY c.customer_id ,op.order_id";

        $query = $this->db->query($sql);

        return $query->row;
    }

    public function addOrderHistory($seller_id, $order_id, $settlement = true, $order_status_id, $comment = '', $notify = false)
    {
        $this->event->trigger('pre.order.history.add', $order_id);

        $order_info = $this->getOrder($order_id, $seller_id);

        if ($order_info) {
            // Fraud Detection
            $this->load->model('seller/seller');

            $customer_info = $this->model_seller_seller->getSeller($order_info['customer_id']);

            if ($customer_info && $customer_info['safe']) {
                $safe = true;
            } else {
                $safe = false;
            }

            if ($this->config->get('config_fraud_detection')) {
                $this->load->model('checkout/fraud');

                $risk_score = $this->model_checkout_fraud->getFraudScore($order_info);

                if (!$safe && $risk_score > $this->config->get('config_fraud_score')) {
                    $order_status_id = $this->config->get('config_fraud_status_id');
                }
            }

            // Ban IP
            if (!$safe) {
                $status = false;

                if ($order_info['customer_id']) {
                    $results = $this->model_account_customer->getIps($order_info['customer_id']);

                    foreach ($results as $result) {
                        if ($this->model_account_customer->isBanIp($result['ip'])) {
                            $status = true;

                            break;
                        }
                    }
                } else {
                    $status = $this->model_account_customer->isBanIp($order_info['ip']);
                }

                if ($status) {
                    $order_status_id = $this->config->get('config_order_status_id');
                }
            }

            $this->db->query('UPDATE `'.DB_PREFIX."order` SET order_status_id = '".(int) $order_status_id."', date_modified = NOW() WHERE order_id = '".(int) $order_id."'");

            $this->db->query('INSERT INTO '.DB_PREFIX."order_sellerhistory SET order_id = '".(int) $order_id."', order_status_id = '".(int) $order_status_id."', notify = '".(int) $notify."', seller_id = '".(int) $seller_id."',settlement = '".(int) $settlement."',comment = '".$this->db->escape($comment)."', date_added = NOW()");

            // If current order status is not processing or complete but new status is processing or complete then commence completing the order
            if (!in_array($order_info['order_status_id'], array_merge($this->config->get('config_processing_status'), $this->config->get('config_complete_status'))) || in_array($order_status_id, array_merge($this->config->get('config_processing_status'), $this->config->get('config_complete_status')))) {
                // Stock subtraction
                $order_product_query = $this->db->query('SELECT * FROM '.DB_PREFIX."order_product WHERE order_id = '".(int) $order_id."'");

                foreach ($order_product_query->rows as $order_product) {
                    $this->db->query('UPDATE '.DB_PREFIX.'product SET quantity = (quantity - '.(int) $order_product['quantity'].") WHERE product_id = '".(int) $order_product['product_id']."' AND subtract = '1'");

                    $order_option_query = $this->db->query('SELECT * FROM '.DB_PREFIX."order_option WHERE order_id = '".(int) $order_id."' AND order_product_id = '".(int) $order_product['order_product_id']."'");

                    foreach ($order_option_query->rows as $option) {
                        $this->db->query('UPDATE '.DB_PREFIX.'product_option_value SET quantity = (quantity - '.(int) $order_product['quantity'].") WHERE product_option_value_id = '".(int) $option['product_option_value_id']."' AND subtract = '1'");
                    }
                }

                // Add commission if sale is linked to affiliate referral.
                if ($order_info['affiliate_id'] && $this->config->get('config_affiliate_auto')) {
                    $this->load->model('affiliate/affiliate');

                    $this->model_affiliate_affiliate->addTransaction($order_info['affiliate_id'], $order_info['commission'], $order_id);
                }
            }

            // If old order status is the processing or complete status but new status is not then commence restock, and remove coupon, voucher and reward history
            if (in_array($order_info['order_status_id'], array_merge($this->config->get('config_processing_status'), $this->config->get('config_complete_status'))) && !in_array($order_status_id, array_merge($this->config->get('config_processing_status'), $this->config->get('config_complete_status')))) {
                // Restock
                $product_query = $this->db->query('SELECT * FROM '.DB_PREFIX."order_product WHERE order_id = '".(int) $order_id."'");

                foreach ($product_query->rows as $product) {
                    $this->db->query('UPDATE `'.DB_PREFIX.'product` SET quantity = (quantity + '.(int) $product['quantity'].") WHERE product_id = '".(int) $product['product_id']."' AND subtract = '1'");

                    $option_query = $this->db->query('SELECT * FROM '.DB_PREFIX."order_option WHERE order_id = '".(int) $order_id."' AND order_product_id = '".(int) $product['order_product_id']."'");

                    foreach ($option_query->rows as $option) {
                        $this->db->query('UPDATE '.DB_PREFIX.'product_option_value SET quantity = (quantity + '.(int) $product['quantity'].") WHERE product_option_value_id = '".(int) $option['product_option_value_id']."' AND subtract = '1'");
                    }
                }

                // Remove coupon, vouchers and reward points history
                $this->load->model('account/order');

                $order_totals = $this->model_account_order->getOrderTotals($order_id);

                foreach ($order_totals as $order_total) {
                    $this->load->model('total/'.$order_total['code']);

                    if (method_exists($this->{'model_total_'.$order_total['code']}, 'unconfirm')) {
                        $this->{'model_total_'.$order_total['code']}->unconfirm($order_id);
                    }
                }

                // Remove commission if sale is linked to affiliate referral.
                if ($order_info['affiliate_id']) {
                    $this->load->model('affiliate/affiliate');

                    $this->model_affiliate_affiliate->deleteTransaction($order_id);
                }
            }

            $this->cache->delete('product');

            // If order status is 0 then becomes greater than 0 send main html email
            if (!$order_info['order_status_id'] && $order_status_id) {
                // Check for any downloadable products
                $download_status = false;

                $order_product_query = $this->db->query('SELECT * FROM '.DB_PREFIX."order_product WHERE order_id = '".(int) $order_id."'");

                foreach ($order_product_query->rows as $order_product) {
                    // Check if there are any linked downloads
                    $product_download_query = $this->db->query('SELECT COUNT(*) AS total FROM `'.DB_PREFIX."product_to_download` WHERE product_id = '".(int) $order_product['product_id']."'");

                    if ($product_download_query->row['total']) {
                        $download_status = true;
                    }
                }

                // Load the language for any mails that might be required to be sent out
                $language = new Language($order_info['language_directory']);
                $language->load('mail/order');

                $order_status_query = $this->db->query('SELECT * FROM '.DB_PREFIX."order_status WHERE order_status_id = '".(int) $order_status_id."' AND language_id = '".(int) $order_info['language_id']."'");

                if ($order_status_query->num_rows) {
                    $order_status = $order_status_query->row['name'];
                } else {
                    $order_status = '';
                }

                $subject = sprintf($language->get('text_new_subject'), $order_info['store_name'], $order_id);

                // HTML Mail
                $data = array();

                $data['title'] = sprintf($language->get('text_new_subject'), html_entity_decode($order_info['store_name'], ENT_QUOTES, 'UTF-8'), $order_id);

                $data['text_greeting'] = sprintf($language->get('text_new_greeting'), html_entity_decode($order_info['store_name'], ENT_QUOTES, 'UTF-8'));
                $data['text_link'] = $language->get('text_new_link');
                $data['text_download'] = $language->get('text_new_download');
                $data['text_order_detail'] = $language->get('text_new_order_detail');
                $data['text_instruction'] = $language->get('text_new_instruction');
                $data['text_order_id'] = $language->get('text_new_order_id');
                $data['text_date_added'] = $language->get('text_new_date_added');
                $data['text_payment_method'] = $language->get('text_new_payment_method');
                $data['text_shipping_method'] = $language->get('text_new_shipping_method');
                $data['text_email'] = $language->get('text_new_email');
                $data['text_telephone'] = $language->get('text_new_telephone');
                $data['text_ip'] = $language->get('text_new_ip');
                $data['text_order_status'] = $language->get('text_new_order_status');
                $data['text_payment_address'] = $language->get('text_new_payment_address');
                $data['text_shipping_address'] = $language->get('text_new_shipping_address');
                $data['text_product'] = $language->get('text_new_product');
                $data['text_model'] = $language->get('text_new_model');
                $data['text_quantity'] = $language->get('text_new_quantity');
                $data['text_price'] = $language->get('text_new_price');
                $data['text_total'] = $language->get('text_new_total');
                $data['text_footer'] = $language->get('text_new_footer');

                $data['logo'] = $this->config->get('config_url').'image/'.$this->config->get('config_logo');
                $data['store_name'] = $order_info['store_name'];
                $data['store_url'] = $order_info['store_url'];
                $data['customer_id'] = $order_info['customer_id'];
                $data['link'] = $order_info['store_url'].'index.php?route=account/order/info&order_id='.$order_id;

                if ($download_status) {
                    $data['download'] = $order_info['store_url'].'index.php?route=account/download';
                } else {
                    $data['download'] = '';
                }

                $data['order_id'] = $order_id;
                $data['date_added'] = date($language->get('date_format_short'), strtotime($order_info['date_added']));
                $data['payment_method'] = $order_info['payment_method'];
                $data['shipping_method'] = $order_info['shipping_method'];
                $data['email'] = $order_info['email'];
                $data['telephone'] = $order_info['telephone'];
                $data['ip'] = $order_info['ip'];
                $data['order_status'] = $order_status;

                if ($comment && $notify) {
                    $data['comment'] = nl2br($comment);
                } else {
                    $data['comment'] = '';
                }

                if ($order_info['payment_address_format']) {
                    $format = $order_info['payment_address_format'];
                } else {
                    $format = '{firstname} {lastname}'."\n".'{company}'."\n".'{address_1}'."\n".'{address_2}'."\n".'{city} {postcode}'."\n".'{zone}'."\n".'{country}';
                }

                $find = array(
                    '{firstname}',
                    '{lastname}',
                    '{company}',
                    '{address_1}',
                    '{address_2}',
                    '{city}',
                    '{postcode}',
                    '{zone}',
                    '{zone_code}',
                    '{country}',
                );

                $replace = array(
                    'firstname' => $order_info['payment_firstname'],
                    'lastname' => $order_info['payment_lastname'],
                    'company' => $order_info['payment_company'],
                    'address_1' => $order_info['payment_address_1'],
                    'address_2' => $order_info['payment_address_2'],
                    'city' => $order_info['payment_city'],
                    'postcode' => $order_info['payment_postcode'],
                    'zone' => $order_info['payment_zone'],
                    'zone_code' => $order_info['payment_zone_code'],
                    'country' => $order_info['payment_country'],
                );

                $data['payment_address'] = str_replace(array("\r\n", "\r", "\n"), '<br />', preg_replace(array("/\s\s+/", "/\r\r+/", "/\n\n+/"), '<br />', trim(str_replace($find, $replace, $format))));

                if ($order_info['shipping_address_format']) {
                    $format = $order_info['shipping_address_format'];
                } else {
                    $format = '{firstname} {lastname}'."\n".'{company}'."\n".'{address_1}'."\n".'{address_2}'."\n".'{city} {postcode}'."\n".'{zone}'."\n".'{country}';
                }

                $find = array(
                    '{firstname}',
                    '{lastname}',
                    '{company}',
                    '{address_1}',
                    '{address_2}',
                    '{city}',
                    '{postcode}',
                    '{zone}',
                    '{zone_code}',
                    '{country}',
                );

                $replace = array(
                    'firstname' => $order_info['shipping_firstname'],
                    'lastname' => $order_info['shipping_lastname'],
                    'company' => $order_info['shipping_company'],
                    'address_1' => $order_info['shipping_address_1'],
                    'address_2' => $order_info['shipping_address_2'],
                    'city' => $order_info['shipping_city'],
                    'postcode' => $order_info['shipping_postcode'],
                    'zone' => $order_info['shipping_zone'],
                    'zone_code' => $order_info['shipping_zone_code'],
                    'country' => $order_info['shipping_country'],
                );

                $data['shipping_address'] = str_replace(array("\r\n", "\r", "\n"), '<br />', preg_replace(array("/\s\s+/", "/\r\r+/", "/\n\n+/"), '<br />', trim(str_replace($find, $replace, $format))));

                $this->load->model('tool/upload');

                // Products
                $data['products'] = array();

                foreach ($order_product_query->rows as $product) {
                    $option_data = array();

                    $order_option_query = $this->db->query('SELECT * FROM '.DB_PREFIX."order_option WHERE order_id = '".(int) $order_id."' AND order_product_id = '".(int) $product['order_product_id']."'");

                    foreach ($order_option_query->rows as $option) {
                        if ($option['type'] != 'file') {
                            $value = $option['value'];
                        } else {
                            $upload_info = $this->model_tool_upload->getUploadByCode($option['value']);

                            if ($upload_info) {
                                $value = $upload_info['name'];
                            } else {
                                $value = '';
                            }
                        }

                        $option_data[] = array(
                            'name' => $option['name'],
                            'value' => (utf8_strlen($value) > 20 ? utf8_substr($value, 0, 20).'..' : $value),
                        );
                    }

                    $data['products'][] = array(
                        'name' => $product['name'],
                        'model' => $product['model'],
                        'option' => $option_data,
                        'quantity' => $product['quantity'],
                        'price' => $this->currency->format($product['price'] + ($this->config->get('config_tax') ? $product['tax'] : 0), $order_info['currency_code'], $order_info['currency_value']),
                        'total' => $this->currency->format($product['total'] + ($this->config->get('config_tax') ? ($product['tax'] * $product['quantity']) : 0), $order_info['currency_code'], $order_info['currency_value']),
                    );
                }

                // Vouchers
                $data['vouchers'] = array();

                $order_voucher_query = $this->db->query('SELECT * FROM '.DB_PREFIX."order_voucher WHERE order_id = '".(int) $order_id."'");

                foreach ($order_voucher_query->rows as $voucher) {
                    $data['vouchers'][] = array(
                        'description' => $voucher['description'],
                        'amount' => $this->currency->format($voucher['amount'], $order_info['currency_code'], $order_info['currency_value']),
                    );
                }

                $html = $this->load->view('mail/order.tpl', $data);

                // Can not send confirmation emails for CBA orders as email is unknown
                $this->load->model('payment/amazon_checkout');

                if (!$this->model_payment_amazon_checkout->isAmazonOrder($order_info['order_id'])) {
                    // Text Mail
                    $text = sprintf($language->get('text_new_greeting'), html_entity_decode($order_info['store_name'], ENT_QUOTES, 'UTF-8'))."\n\n";
                    $text .= $language->get('text_new_order_id').' '.$order_id."\n";
                    $text .= $language->get('text_new_date_added').' '.date($language->get('date_format_short'), strtotime($order_info['date_added']))."\n";
                    $text .= $language->get('text_new_order_status').' '.$order_status."\n\n";

                    if ($comment && $notify) {
                        $text .= $language->get('text_new_instruction')."\n\n";
                        $text .= $comment."\n\n";
                    }

                    // Products
                    $text .= $language->get('text_new_products')."\n";

                    foreach ($order_product_query->rows as $product) {
                        $text .= $product['quantity'].'x '.$product['name'].' ('.$product['model'].') '.html_entity_decode($this->currency->format($product['total'] + ($this->config->get('config_tax') ? ($product['tax'] * $product['quantity']) : 0), $order_info['currency_code'], $order_info['currency_value']), ENT_NOQUOTES, 'UTF-8')."\n";

                        $order_option_query = $this->db->query('SELECT * FROM '.DB_PREFIX."order_option WHERE order_id = '".(int) $order_id."' AND order_product_id = '".$product['order_product_id']."'");

                        foreach ($order_option_query->rows as $option) {
                            if ($option['type'] != 'file') {
                                $value = $option['value'];
                            } else {
                                $upload_info = $this->model_tool_upload->getUploadByCode($option['value']);

                                if ($upload_info) {
                                    $value = $upload_info['name'];
                                } else {
                                    $value = '';
                                }
                            }

                            $text .= chr(9).'-'.$option['name'].' '.(utf8_strlen($value) > 20 ? utf8_substr($value, 0, 20).'..' : $value)."\n";
                        }
                    }

                    foreach ($order_voucher_query->rows as $voucher) {
                        $text .= '1x '.$voucher['description'].' '.$this->currency->format($voucher['amount'], $order_info['currency_code'], $order_info['currency_value']);
                    }

                    $text .= "\n";

                    $text .= $language->get('text_new_order_total')."\n";

                    foreach ($order_total_query->rows as $total) {
                        $text .= $total['title'].': '.html_entity_decode($this->currency->format($total['value'], $order_info['currency_code'], $order_info['currency_value']), ENT_NOQUOTES, 'UTF-8')."\n";
                    }

                    $text .= "\n";

                    if ($order_info['customer_id']) {
                        $text .= $language->get('text_new_link')."\n";
                        $text .= $order_info['store_url'].'index.php?route=account/order/info&order_id='.$order_id."\n\n";
                    }

                    if ($download_status) {
                        $text .= $language->get('text_new_download')."\n";
                        $text .= $order_info['store_url'].'index.php?route=account/download'."\n\n";
                    }

                    // Comment
                    if ($order_info['comment']) {
                        $text .= $language->get('text_new_comment')."\n\n";
                        $text .= $order_info['comment']."\n\n";
                    }

                    $text .= $language->get('text_new_footer')."\n\n";

                    $mail = new Mail();
                    $mail->protocol = $this->config->get('config_mail_protocol');
                    $mail->parameter = $this->config->get('config_mail_parameter');
                    $mail->smtp_hostname = $this->config->get('config_mail_smtp_hostname');
                    $mail->smtp_username = $this->config->get('config_mail_smtp_username');
                    $mail->smtp_password = html_entity_decode($this->config->get('config_mail_smtp_password'), ENT_QUOTES, 'UTF-8');
                    $mail->smtp_port = $this->config->get('config_mail_smtp_port');
                    $mail->smtp_timeout = $this->config->get('config_mail_smtp_timeout');
                    $mail->setTo($order_info['email']);
                    $mail->setFrom($this->config->get('config_email'));
                    $mail->setSender($order_info['store_name']);
                    $mail->setSubject($subject);
                    $mail->setHtml($html);
                    $mail->setText($text);
                    $mail->send();
                }

                // Admin Alert Mail
                if ($this->config->get('config_order_mail')) {
                    $subject = sprintf($language->get('text_new_subject'), html_entity_decode($this->config->get('config_name'), ENT_QUOTES, 'UTF-8'), $order_id);

                    // HTML Mail
                    $data['text_greeting'] = $language->get('text_new_received');
                    if ($comment) {
                        if ($order_info['comment']) {
                            $data['comment'] = nl2br($comment).'<br/><br/>'.$order_info['comment'];
                        } else {
                            $data['comment'] = nl2br($comment);
                        }
                    } else {
                        if ($order_info['comment']) {
                            $data['comment'] = $order_info['comment'];
                        } else {
                            $data['comment'] = '';
                        }
                    }
                    $data['text_download'] = '';

                    $data['text_footer'] = '';

                    $data['text_link'] = '';
                    $data['link'] = '';
                    $data['download'] = '';

                    if (file_exists(DIR_TEMPLATE.$this->config->get('config_template').'/template/mail/order.tpl')) {
                        $html = $this->load->view($this->config->get('config_template').'/template/mail/order.tpl', $data);
                    } else {
                        $html = $this->load->view('default/template/mail/order.tpl', $data);
                    }

                    // Text
                    $text = $language->get('text_new_received')."\n\n";
                    $text .= $language->get('text_new_order_id').' '.$order_id."\n";
                    $text .= $language->get('text_new_date_added').' '.date($language->get('date_format_short'), strtotime($order_info['date_added']))."\n";
                    $text .= $language->get('text_new_order_status').' '.$order_status."\n\n";
                    $text .= $language->get('text_new_products')."\n";

                    foreach ($order_product_query->rows as $product) {
                        $text .= $product['quantity'].'x '.$product['name'].' ('.$product['model'].') '.html_entity_decode($this->currency->format($product['total'] + ($this->config->get('config_tax') ? ($product['tax'] * $product['quantity']) : 0), $order_info['currency_code'], $order_info['currency_value']), ENT_NOQUOTES, 'UTF-8')."\n";

                        $order_option_query = $this->db->query('SELECT * FROM '.DB_PREFIX."order_option WHERE order_id = '".(int) $order_id."' AND order_product_id = '".$product['order_product_id']."'");

                        foreach ($order_option_query->rows as $option) {
                            if ($option['type'] != 'file') {
                                $value = $option['value'];
                            } else {
                                $value = utf8_substr($option['value'], 0, utf8_strrpos($option['value'], '.'));
                            }

                            $text .= chr(9).'-'.$option['name'].' '.(utf8_strlen($value) > 20 ? utf8_substr($value, 0, 20).'..' : $value)."\n";
                        }
                    }

                    foreach ($order_voucher_query->rows as $voucher) {
                        $text .= '1x '.$voucher['description'].' '.$this->currency->format($voucher['amount'], $order_info['currency_code'], $order_info['currency_value']);
                    }

                    $text .= "\n";

                    $text .= $language->get('text_new_order_total')."\n";

                    foreach ($order_total_query->rows as $total) {
                        $text .= $total['title'].': '.html_entity_decode($this->currency->format($total['value'], $order_info['currency_code'], $order_info['currency_value']), ENT_NOQUOTES, 'UTF-8')."\n";
                    }

                    $text .= "\n";

                    if ($order_info['comment']) {
                        $text .= $language->get('text_new_comment')."\n\n";
                        $text .= $order_info['comment']."\n\n";
                    }

                    $mail = new Mail();
                    $mail->protocol = $this->config->get('config_mail_protocol');
                    $mail->parameter = $this->config->get('config_mail_parameter');
                    $mail->smtp_hostname = $this->config->get('config_mail_smtp_hostname');
                    $mail->smtp_username = $this->config->get('config_mail_smtp_username');
                    $mail->smtp_password = html_entity_decode($this->config->get('config_mail_smtp_password'), ENT_QUOTES, 'UTF-8');
                    $mail->smtp_port = $this->config->get('config_mail_smtp_port');
                    $mail->smtp_timeout = $this->config->get('config_mail_smtp_timeout');
                    $mail->setTo($this->config->get('config_email'));
                    $mail->setFrom($this->config->get('config_email'));
                    $mail->setReplyTo($order_info['email']);
                    $mail->setSender($order_info['store_name']);
                    $mail->setSubject($subject);
                    $mail->setHtml($html);
                    $mail->setText(html_entity_decode($text, ENT_QUOTES, 'UTF-8'));
                    $mail->send();

                    // Send to additional alert emails
                    $emails = explode(',', $this->config->get('config_mail_alert'));

                    foreach ($emails as $email) {
                        if ($email && preg_match('/^[^\@]+@.*\.[a-z]{2,6}$/i', $email)) {
                            $mail->setTo($email);
                            $mail->send();
                        }
                    }
                }
            }

            // If order status is not 0 then send update text email
            if ($order_info['order_status_id'] && $order_status_id) {
                $language = new Language($order_info['language_directory']);

                $language->load('mail/order');

                $subject = sprintf($language->get('text_update_subject'), html_entity_decode($order_info['store_name'], ENT_QUOTES, 'UTF-8'), $order_id);

                $message = $language->get('text_update_order').' '.$order_id."\n";
                $message .= $language->get('text_update_date_added').' '.date($language->get('date_format_short'), strtotime($order_info['date_added']))."\n\n";

                $order_status_query = $this->db->query('SELECT * FROM '.DB_PREFIX."order_status WHERE order_status_id = '".(int) $order_status_id."' AND language_id = '".(int) $order_info['language_id']."'");

                if ($order_status_query->num_rows) {
                    $message .= $language->get('text_update_order_status')."\n\n";
                    $message .= $order_status_query->row['name']."\n\n";
                }

                if ($order_info['customer_id']) {
                    $message .= $language->get('text_update_link')."\n";
                    $message .= $order_info['store_url'].'index.php?route=account/order/info&order_id='.$order_id."\n\n";
                }

                if ($notify && $comment) {
                    $message .= $language->get('text_update_comment')."\n\n";
                    $message .= $comment."\n\n";
                }

                $message .= $language->get('text_update_footer');

                $mail = new Mail();
                $mail->protocol = $this->config->get('config_mail_protocol');
                $mail->parameter = $this->config->get('config_mail_parameter');
                $mail->smtp_hostname = $this->config->get('config_mail_smtp_hostname');
                $mail->smtp_username = $this->config->get('config_mail_smtp_username');
                $mail->smtp_password = html_entity_decode($this->config->get('config_mail_smtp_password'), ENT_QUOTES, 'UTF-8');
                $mail->smtp_port = $this->config->get('config_mail_smtp_port');
                $mail->smtp_timeout = $this->config->get('config_mail_smtp_timeout');
                $mail->setTo($order_info['email']);
                $mail->setFrom($this->config->get('config_email'));
                $mail->setSender($order_info['store_name']);
                $mail->setSubject($subject);
                $mail->setText(html_entity_decode($message, ENT_QUOTES, 'UTF-8'));
                $mail->send();
            }

            // If order status in the complete range create any vouchers that where in the order need to be made available.
            if (in_array($order_info['order_status_id'], $this->config->get('config_complete_status'))) {
                // Send out any gift voucher mails
                $this->load->model('checkout/voucher');

                $this->model_checkout_voucher->confirm($order_id);
            }
        }

        $this->event->trigger('post.order.history.add', $order_id);
    }

    public function getSellerOrder($order_id,$seller_id) {
		$order_query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "order` o WHERE o.order_id = '" . (int)$order_id . "'");

		$seller_order_query = $this->db->query("SELECT *, CONCAT(firstname, ' ', lastname) AS seller FROM `" . DB_PREFIX . "customer`  WHERE customer_id = '" . (int)$seller_id . "'");

		if ($order_query->num_rows) {
			$reward = 0;

			$order_product_query = $this->db->query("SELECT * FROM " . DB_PREFIX . "order_product WHERE order_id = '" . (int)$order_id . "'");

			foreach ($order_product_query->rows as $product) {
				$reward += $product['reward'];
			}

			$country_query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "country` WHERE country_id = '" . (int)$order_query->row['payment_country_id'] . "'");

			if ($country_query->num_rows) {
				$payment_iso_code_2 = $country_query->row['iso_code_2'];
				$payment_iso_code_3 = $country_query->row['iso_code_3'];
			} else {
				$payment_iso_code_2 = '';
				$payment_iso_code_3 = '';
			}

			$zone_query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "zone` WHERE zone_id = '" . (int)$order_query->row['payment_zone_id'] . "'");

			if ($zone_query->num_rows) {
				$payment_zone_code = $zone_query->row['code'];
			} else {
				$payment_zone_code = '';
			}

			$country_query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "country` WHERE country_id = '" . (int)$order_query->row['shipping_country_id'] . "'");

			if ($country_query->num_rows) {
				$shipping_iso_code_2 = $country_query->row['iso_code_2'];
				$shipping_iso_code_3 = $country_query->row['iso_code_3'];
			} else {
				$shipping_iso_code_2 = '';
				$shipping_iso_code_3 = '';
			}

			$zone_query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "zone` WHERE zone_id = '" . (int)$order_query->row['shipping_zone_id'] . "'");

			if ($zone_query->num_rows) {
				$shipping_zone_code = $zone_query->row['code'];
			} else {
				$shipping_zone_code = '';
			}


			$this->load->model('localisation/language');

			$language_info = $this->model_localisation_language->getLanguage($order_query->row['language_id']);

			if ($language_info) {
				$language_code = $language_info['code'];

				$language_directory = $language_info['directory'];
			} else {
				$language_code = '';

				$language_directory = '';
			}

			return array(
				'order_id'                => $order_query->row['order_id'],
				'invoice_no'              => $order_query->row['invoice_no'],
				'invoice_prefix'          => $order_query->row['invoice_prefix'],
				'store_id'                => $order_query->row['store_id'],
				'store_name'              => $order_query->row['store_name'],
				'store_url'               => $order_query->row['store_url'],
				'customer_id'             => $seller_order_query->row['customer_id'],
				'seller'                => $seller_order_query->row['seller'],
				'customer_group_id'       => $seller_order_query->row['customer_group_id'],
				'firstname'               => $seller_order_query->row['firstname'],
				'lastname'                => $seller_order_query->row['lastname'],
				'email'                   => $seller_order_query->row['email'],
				'telephone'               => $seller_order_query->row['telephone'],
				'fax'                     => $seller_order_query->row['fax'],
				'custom_field'            => json_decode($order_query->row['custom_field'],true),
				'payment_firstname'       => $order_query->row['payment_firstname'],
				'payment_lastname'        => $order_query->row['payment_lastname'],
				'payment_company'         => $order_query->row['payment_company'],
				'payment_address_1'       => $order_query->row['payment_address_1'],
				'payment_address_2'       => $order_query->row['payment_address_2'],
				'payment_postcode'        => $order_query->row['payment_postcode'],
				'payment_city'            => $order_query->row['payment_city'],
				'payment_zone_id'         => $order_query->row['payment_zone_id'],
				'payment_zone'            => $order_query->row['payment_zone'],
				'payment_zone_code'       => $payment_zone_code,
				'payment_country_id'      => $order_query->row['payment_country_id'],
				'payment_country'         => $order_query->row['payment_country'],
				'payment_iso_code_2'      => $payment_iso_code_2,
				'payment_iso_code_3'      => $payment_iso_code_3,
				'payment_address_format'  => $order_query->row['payment_address_format'],
				'payment_custom_field'    => json_decode($order_query->row['payment_custom_field'],true),
				'payment_method'          => $order_query->row['payment_method'],
				'payment_code'            => $order_query->row['payment_code'],
				'shipping_firstname'      => $order_query->row['shipping_firstname'],
				'shipping_lastname'       => $order_query->row['shipping_lastname'],
				'shipping_company'        => $order_query->row['shipping_company'],
				'shipping_address_1'      => $order_query->row['shipping_address_1'],
				'shipping_address_2'      => $order_query->row['shipping_address_2'],
				'shipping_postcode'       => $order_query->row['shipping_postcode'],
				'shipping_city'           => $order_query->row['shipping_city'],
				'shipping_zone_id'        => $order_query->row['shipping_zone_id'],
				'shipping_zone'           => $order_query->row['shipping_zone'],
				'shipping_zone_code'      => $shipping_zone_code,
				'shipping_country_id'     => $order_query->row['shipping_country_id'],
				'shipping_country'        => $order_query->row['shipping_country'],
				'shipping_iso_code_2'     => $shipping_iso_code_2,
				'shipping_iso_code_3'     => $shipping_iso_code_3,
				'shipping_address_format' => $order_query->row['shipping_address_format'],
				'shipping_custom_field'   => json_decode($order_query->row['shipping_custom_field'],true),
				'shipping_method'         => $order_query->row['shipping_method'],
				'shipping_code'           => $order_query->row['shipping_code'],
				'comment'                 => $order_query->row['comment'],
				'total'                   => $order_query->row['total'],
				'reward'                  => $reward,
				'order_status_id'         => $order_query->row['order_status_id'],

				'commission'              => $order_query->row['commission'],
				'language_id'             => $order_query->row['language_id'],
				'language_code'           => $language_code,
				'language_directory'      => $language_directory,
				'currency_id'             => $order_query->row['currency_id'],
				'currency_code'           => $order_query->row['currency_code'],
				'currency_value'          => $order_query->row['currency_value'],
				'ip'                      => $order_query->row['ip'],
				'forwarded_ip'            => $order_query->row['forwarded_ip'],
				'user_agent'              => $order_query->row['user_agent'],
				'accept_language'         => $order_query->row['accept_language'],
				'date_added'              => $order_query->row['date_added'],
				'date_modified'           => $order_query->row['date_modified']
			);
		} else {
			return;
		}
	}


		public function addSellerOrderHistory($order_id, $order_status_id, $comment = '', $notify = false, $override = false,$seller_id) {
		$this->event->trigger('pre.order.sellerhistory.add', $order_id);

		$order_info = $this->getSellerOrder($order_id,$seller_id);

		if ($order_info) {


			$this->db->query("INSERT INTO " . DB_PREFIX . "order_sellerhistory SET order_id = '" . (int)$order_id . "', order_status_id = '" . (int)$order_status_id . "', notify = '" . (int)$notify . "', seller_id = '" . (int)$seller_id . "', comment = '" . $this->db->escape($comment) . "', date_added = NOW()");

      // notify Seller
      if ($notify = 6) {
          $language = new Language($order_info['language_directory']);

          $language->load('seller/mail_seller');

          $subject = sprintf($language->get('text_update_subject'), html_entity_decode($order_info['store_name'], ENT_QUOTES, 'UTF-8'), $order_id);

          $message = $language->get('text_update_order').' '.$order_id."\n";
          $message .= $language->get('text_update_date_added').' '.date($this->language->get('date_format_short'), strtotime($order_info['date_added']))."\n\n";

          $order_status_query = $this->db->query('SELECT * FROM '.DB_PREFIX."order_status WHERE order_status_id = '".(int) $order_status_id."' AND language_id = '".(int) $order_info['language_id']."'");

          if ($order_status_query->num_rows) {
              $message .= $language->get('text_update_order_status')."\n\n";
              $message .= $order_status_query->row['name']."\n\n";
          }

          if ($order_info['customer_id']) {
              $message .= $language->get('text_update_link')."\n";
              $message .= $order_info['store_url'].'index.php?route=order/order/info&order_id='.$order_id."\n\n";
          }

          if ($notify && $comment) {
              $message .= $language->get('text_update_comment')."\n\n";
              $message .= $comment."\n\n";
          }

          $message .= $language->get('text_update_footer');

          $mail = new Mail();
          $mail->protocol = $this->config->get('config_mail_protocol');
          $mail->parameter = $this->config->get('config_mail_parameter');
          $mail->smtp_hostname = $this->config->get('config_mail_smtp_hostname');
          $mail->smtp_username = $this->config->get('config_mail_smtp_username');
          $mail->smtp_password = html_entity_decode($this->config->get('config_mail_smtp_password'), ENT_QUOTES, 'UTF-8');
          $mail->smtp_port = $this->config->get('config_mail_smtp_port');
          $mail->smtp_timeout = $this->config->get('config_mail_smtp_timeout');
          $mail->setTo($order_info['email']);
          $mail->setFrom($this->config->get('config_email'));
          $mail->setSender($order_info['store_name']);
          $mail->setSubject($subject);
          $mail->setText(html_entity_decode($message, ENT_QUOTES, 'UTF-8'));
          $mail->send();
      }

		$this->event->trigger('post.order.sellerhistory.add', $order_id);
  }
	}
}
