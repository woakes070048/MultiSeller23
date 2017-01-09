<?php

class Modelsellerseller extends Model
{
    public function getseller($seller_id)
    {
        $query = $this->db->query("SELECT *,  CONCAT(wc.firstname, ' ', wc.lastname) AS title ,
		(SELECT AVG(rating) AS total
		FROM ".DB_PREFIX."sellerreview r1
		WHERE r1.seller_id = '".(int) $seller_id."'
		AND r1.status = '1'
		GROUP BY r1.seller_id) AS rating
		FROM ".DB_PREFIX.'customer wc
		LEFT JOIN '.DB_PREFIX."seller_group wcd
		ON (wc.seller_group_id = wcd.seller_group_id)
		WHERE wc.customer_id = '".(int) $seller_id."'
		");

        return $query->row;
    }
    public function getSellersOnCart()
    {
      $sql = "SELECT *, CONCAT(c.firstname, ' ', c.lastname) AS name,c.customer_id AS seller_id, cgd.name AS seller_group, c.seller_group_id AS seller_group_id
      FROM ".DB_PREFIX."cart ct
      LEFT JOIN ".DB_PREFIX."product_to_seller pts
      ON (ct.product_id = pts.product_id)
      LEFT JOIN ".DB_PREFIX."customer c
      ON (c.customer_id = pts.seller_id)
      LEFT JOIN ".DB_PREFIX."seller_group_description cgd
      ON (c.seller_group_id = cgd.seller_group_id)
      WHERE cgd.language_id = '".(int) $this->config->get('config_language_id')."'
      AND ct.customer_id = '".(int) $this->customer->getID()."'
      GROUP BY c.customer_id
      ";



        $query = $this->db->query($sql);

        return $query->rows;
    }

    public function getsellers($data = array())
    {
        if ($data) {
            $sql = "SELECT *, CONCAT(c.firstname, ' ', c.lastname) AS name, cgd.name AS seller_group FROM ".DB_PREFIX.'customer c LEFT JOIN '.DB_PREFIX."seller_group_description cgd ON (c.seller_group_id = cgd.seller_group_id) WHERE cgd.language_id = '".(int) $this->config->get('config_language_id')."' ";

            $sort_data = array(
                'title',
                'sort_order',
            );

            if (isset($data['sort']) && in_array($data['sort'], $sort_data)) {
                $sql .= ' ORDER BY '.$data['sort'];
            } else {
                $sql .= ' ORDER BY name';
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
        } else {
            $seller_data = $this->cache->get('seller.'.(int) $this->config->get('config_language_id'));

            if (!$seller_data) {
                $query = $this->db->query("
				SELECT *, CONCAT(c.firstname, ' ', c.lastname) AS name, cgd.name AS seller_group FROM ".DB_PREFIX.'customer c LEFT JOIN '.DB_PREFIX."seller_group_description cgd ON (c.seller_group_id = cgd.seller_group_id) WHERE cgd.language_id = '".(int) $this->config->get('config_language_id')."' ORDER BY firstname");

                $seller_data = $query->rows;

                $this->cache->set('seller.'.(int) $this->config->get('config_language_id'), $seller_data);
            }

            return $seller_data;
        }
    }

    public function getProducts($data = array())
    {
        $sql = 'SELECT p.product_id, (SELECT AVG(rating) AS total FROM '.DB_PREFIX."review r1 WHERE r1.product_id = p.product_id AND r1.status = '1' GROUP BY r1.product_id) AS rating, (SELECT price FROM ".DB_PREFIX."product_discount pd2 WHERE pd2.product_id = p.product_id AND pd2.customer_group_id = '".(int) $this->config->get('config_customer_group_id')."' AND pd2.quantity = '1' AND ((pd2.date_start = '0000-00-00' OR pd2.date_start < NOW()) AND (pd2.date_end = '0000-00-00' OR pd2.date_end > NOW())) ORDER BY pd2.priority ASC, pd2.price ASC LIMIT 1) AS discount, (SELECT price FROM ".DB_PREFIX."product_special ps WHERE ps.product_id = p.product_id AND ps.customer_group_id = '".(int) $this->config->get('config_customer_group_id')."' AND ((ps.date_start = '0000-00-00' OR ps.date_start < NOW()) AND (ps.date_end = '0000-00-00' OR ps.date_end > NOW())) ORDER BY ps.priority ASC, ps.price ASC LIMIT 1) AS special";

        $sql .= ' FROM '.DB_PREFIX.'product p';

        $sql .= ' LEFT JOIN '.DB_PREFIX.'product_description pd ON (p.product_id = pd.product_id) LEFT JOIN '.DB_PREFIX.'product_to_store p2s ON (p.product_id = p2s.product_id)  LEFT JOIN '.DB_PREFIX."product_to_seller pta ON (p.product_id = pta.product_id) WHERE pd.language_id = '".(int) $this->config->get('config_language_id')."' AND p.status = '1' AND p.date_available <= NOW() AND p2s.store_id = '".(int) $this->config->get('config_store_id')."'";

        if (!empty($data['filter_seller_id'])) {
            $sql .= " AND pta.seller_id = '".(int) $data['filter_seller_id']."'";
        }

        $sql .= ' GROUP BY p.product_id';

        $sort_data = array(
            'pd.name',
            'p.model',
            'p.quantity',
            'p.price',
            'rating',
            'p.sort_order',
            'p.date_added',
        );

        if (isset($data['sort']) && in_array($data['sort'], $sort_data)) {
            if ($data['sort'] == 'pd.name' || $data['sort'] == 'p.model') {
                $sql .= ' ORDER BY LCASE('.$data['sort'].')';
            } elseif ($data['sort'] == 'p.price') {
                $sql .= ' ORDER BY (CASE WHEN special IS NOT NULL THEN special WHEN discount IS NOT NULL THEN discount ELSE p.price END)';
            } else {
                $sql .= ' ORDER BY '.$data['sort'];
            }
        } else {
            $sql .= ' ORDER BY p.sort_order';
        }

        if (isset($data['order']) && ($data['order'] == 'DESC')) {
            $sql .= ' DESC, LCASE(pd.name) DESC';
        } else {
            $sql .= ' ASC, LCASE(pd.name) ASC';
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

        $product_data = array();

        $query = $this->db->query($sql);

        foreach ($query->rows as $result) {
            $product_data[$result['product_id']] = $this->getProduct($result['product_id']);
        }

        return $product_data;
    }

    public function getTotalProducts($data = array())
    {
        $sql = 'SELECT COUNT(DISTINCT p.product_id) AS total';

        $sql .= ' FROM '.DB_PREFIX.'product p';

        $sql .= ' LEFT JOIN '.DB_PREFIX.'product_description pd ON (p.product_id = pd.product_id) LEFT JOIN '.DB_PREFIX.'product_to_store p2s ON (p.product_id = p2s.product_id)  LEFT JOIN '.DB_PREFIX."product_to_seller pta ON (p.product_id = pta.product_id) WHERE pd.language_id = '".(int) $this->config->get('config_language_id')."' AND p.status = '1' AND p.date_available <= NOW() AND p2s.store_id = '".(int) $this->config->get('config_store_id')."'";

        if (!empty($data['filter_seller_id'])) {
            $sql .= " AND pta.seller_id = '".(int) $data['filter_seller_id']."'";
        }

        $query = $this->db->query($sql);

        return $query->row['total'];
    }

    public function getProduct($product_id)
    {
        $query = $this->db->query('SELECT DISTINCT *, pd.name AS name, p.image, m.name AS manufacturer, (SELECT price FROM '.DB_PREFIX."product_discount pd2 WHERE pd2.product_id = p.product_id AND pd2.customer_group_id = '".(int) $this->config->get('config_customer_group_id')."' AND pd2.quantity = '1' AND ((pd2.date_start = '0000-00-00' OR pd2.date_start < NOW()) AND (pd2.date_end = '0000-00-00' OR pd2.date_end > NOW())) ORDER BY pd2.priority ASC, pd2.price ASC LIMIT 1) AS discount, (SELECT price FROM ".DB_PREFIX."product_special ps WHERE ps.product_id = p.product_id AND ps.customer_group_id = '".(int) $this->config->get('config_customer_group_id')."' AND ((ps.date_start = '0000-00-00' OR ps.date_start < NOW()) AND (ps.date_end = '0000-00-00' OR ps.date_end > NOW())) ORDER BY ps.priority ASC, ps.price ASC LIMIT 1) AS special, (SELECT points FROM ".DB_PREFIX."product_reward pr WHERE pr.product_id = p.product_id AND customer_group_id = '".(int) $this->config->get('config_customer_group_id')."') AS reward, (SELECT ss.name FROM ".DB_PREFIX."stock_status ss WHERE ss.stock_status_id = p.stock_status_id AND ss.language_id = '".(int) $this->config->get('config_language_id')."') AS stock_status, (SELECT wcd.unit FROM ".DB_PREFIX."weight_class_description wcd WHERE p.weight_class_id = wcd.weight_class_id AND wcd.language_id = '".(int) $this->config->get('config_language_id')."') AS weight_class, (SELECT lcd.unit FROM ".DB_PREFIX."length_class_description lcd WHERE p.length_class_id = lcd.length_class_id AND lcd.language_id = '".(int) $this->config->get('config_language_id')."') AS length_class, (SELECT AVG(rating) AS total FROM ".DB_PREFIX."review r1 WHERE r1.product_id = p.product_id AND r1.status = '1' GROUP BY r1.product_id) AS rating, (SELECT COUNT(*) AS total FROM ".DB_PREFIX."review r2 WHERE r2.product_id = p.product_id AND r2.status = '1' GROUP BY r2.product_id) AS reviews, p.sort_order FROM ".DB_PREFIX.'product p LEFT JOIN '.DB_PREFIX.'product_description pd ON (p.product_id = pd.product_id) LEFT JOIN '.DB_PREFIX.'product_to_store p2s ON (p.product_id = p2s.product_id) LEFT JOIN '.DB_PREFIX."manufacturer m ON (p.manufacturer_id = m.manufacturer_id) WHERE p.product_id = '".(int) $product_id."' AND pd.language_id = '".(int) $this->config->get('config_language_id')."' AND p.status = '1' AND p.date_available <= NOW() AND p2s.store_id = '".(int) $this->config->get('config_store_id')."'");

        if ($query->num_rows) {
            return array(
                'product_id' => $query->row['product_id'],
                'name' => $query->row['name'],
                'description' => $query->row['description'],
                'meta_title' => $query->row['meta_title'],
                'meta_description' => $query->row['meta_description'],
                'meta_keyword' => $query->row['meta_keyword'],
                'tag' => $query->row['tag'],
                'model' => $query->row['model'],
                'sku' => $query->row['sku'],
                'upc' => $query->row['upc'],
                'ean' => $query->row['ean'],
                'jan' => $query->row['jan'],
                'isbn' => $query->row['isbn'],
                'mpn' => $query->row['mpn'],
                'location' => $query->row['location'],
                'quantity' => $query->row['quantity'],
                'stock_status' => $query->row['stock_status'],
                'image' => $query->row['image'],
                'manufacturer_id' => $query->row['manufacturer_id'],
                'manufacturer' => $query->row['manufacturer'],
                'price' => ($query->row['discount'] ? $query->row['discount'] : $query->row['price']),
                'special' => $query->row['special'],
                'reward' => $query->row['reward'],
                'points' => $query->row['points'],
                'tax_class_id' => $query->row['tax_class_id'],
                'date_available' => $query->row['date_available'],
                'weight' => $query->row['weight'],
                'weight_class_id' => $query->row['weight_class_id'],
                'length' => $query->row['length'],
                'width' => $query->row['width'],
                'height' => $query->row['height'],
                'length_class_id' => $query->row['length_class_id'],
                'subtract' => $query->row['subtract'],
                'rating' => round($query->row['rating']),
                'reviews' => $query->row['reviews'] ? $query->row['reviews'] : 0,
                'minimum' => $query->row['minimum'],
                'sort_order' => $query->row['sort_order'],
                'status' => $query->row['status'],
                'date_added' => $query->row['date_added'],
                'date_modified' => $query->row['date_modified'],
                'viewed' => $query->row['viewed'],
            );
        } else {
            return false;
        }
    }

    public function getProductsellers($product_id)
    {
        $product_seller_data = array();

        $query = $this->db->query('SELECT * FROM '.DB_PREFIX."product_to_seller WHERE product_id = '".(int) $product_id."'");

        foreach ($query->rows as $result) {
            $product_seller_data[] = $result['seller_id'];
        }

        return $product_seller_data;
    }
    public function getsellerreviewsBysellerId($seller_id, $start = 0, $limit = 20)
    {
        if ($start < 0) {
            $start = 0;
        }

        if ($limit < 1) {
            $limit = 20;
        }

        $query = $this->db->query('SELECT r.sellerreview_id, r.seller_name, r.rating, r.text, p.customer_id, r.date_added FROM '.DB_PREFIX.'sellerreview r LEFT JOIN '.DB_PREFIX."customer p ON (r.seller_id = p.customer_id)  WHERE p.customer_id = '".(int) $seller_id."' AND r.status = '1'  ORDER BY r.date_added DESC LIMIT ".(int) $start.','.(int) $limit);

        return $query->rows;
    }

    public function getTotalsellerreviewsBysellerId($seller_id)
    {
        $query = $this->db->query('
		SELECT COUNT(*) AS total
		FROM '.DB_PREFIX.'sellerreview r
		LEFT JOIN '.DB_PREFIX."customer p ON (r.seller_id = p.customer_id)

		WHERE p.customer_id = '".(int) $seller_id."'


		AND r.status = '1'
		");

        return $query->row['total'];
    }

    public function addsellerReview($seller_id, $data)
    {


        $this->db->query('INSERT INTO '.DB_PREFIX."sellerreview SET seller_name = '".$this->db->escape($data['name'])."', seller_id = '".(int) $seller_id."', customer_id = '".(int) $this->customer->getID()."', text = '".$this->db->escape(strip_tags($data['text']))."', rating = '".(int) $data['rating']."', date_added = NOW()");

        $sellerreview_id = $this->db->getLastId();

        $this->cache->delete('seller');



        return $sellerreview_id;
    }

    public function addHistory($seller_id, $comment)
    {
        $this->db->query('INSERT INTO '.DB_PREFIX."customer_history SET customer_id = '".(int) $seller_id."', comment = '".$this->db->escape(strip_tags($comment))."', date_added = NOW()");
    }

    public function addTransaction($seller_id, $description = '', $amount = '', $order_id)
    {
        $seller_info = $this->getseller($seller_id);

        if ($seller_info) {
            $this->db->query('INSERT INTO '.DB_PREFIX."seller_transaction SET customer_id = '".(int) $seller_id."', order_id = '".(int) $order_id."', description = '".$this->db->escape($description)."', amount = '".(float) $amount."', date_added = NOW()");

            $this->load->language('seller/mail_seller');

            $this->load->model('setting/store');

            $store_info = $this->model_setting_store->getStores();

            if ($store_info) {
                $store_name = $store_info['name'];
            } else {
                $store_name = $this->config->get('config_name');
            }

            $message = sprintf($this->language->get('text_transaction_received'), $this->currency->format($amount, $this->config->get('config_currency')))."\n\n";
            $message .= sprintf($this->language->get('text_transaction_total'), $this->currency->format($this->getTransactionTotal($seller_id), $this->config->get('config_currency')));

            $mail = new Mail();
            $mail->protocol = $this->config->get('config_mail_protocol');
            $mail->parameter = $this->config->get('config_mail_parameter');
            $mail->smtp_hostname = $this->config->get('config_mail_smtp_hostname');
            $mail->smtp_username = $this->config->get('config_mail_smtp_username');
            $mail->smtp_password = html_entity_decode($this->config->get('config_mail_smtp_password'), ENT_QUOTES, 'UTF-8');
            $mail->smtp_port = $this->config->get('config_mail_smtp_port');
            $mail->smtp_timeout = $this->config->get('config_mail_smtp_timeout');
            $mail->setTo($seller_info['email']);
            $mail->setFrom($this->config->get('config_email'));
            $mail->setSender($store_name);
            $mail->setSubject(sprintf($this->language->get('text_transaction_subject'), $this->config->get('config_name')));
            $mail->setText(html_entity_decode($message, ENT_QUOTES, 'UTF-8'));
            $mail->send();
        }
    }

    public function getTransactionTotal($seller_id)
    {
        $query = $this->db->query('SELECT SUM(amount) AS total FROM '.DB_PREFIX."seller_transaction WHERE customer_id = '".(int) $seller_id."'");

        return $query->row['total'];
    }
    public function getTotalsellerRewardsByOrderId($order_id)
    {
        $query = $this->db->query('SELECT COUNT(*) AS total FROM '.DB_PREFIX."customer_reward WHERE order_id = '".(int) $order_id."'");

        return $query->row['total'];
    }
}
