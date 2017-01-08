<?php

class Modelsellerreviewsellerreview extends Model
{
    public function addsellerreview($data)
    {
        $this->event->trigger('pre.admin.sellerreview.add', $data);

        $this->db->query('INSERT INTO '.DB_PREFIX."sellerreview SET customer_name = '".$this->db->escape($data['customer_name'])."', seller_id = '".(int) $data['seller_id']."', text = '".$this->db->escape(strip_tags($data['text']))."', rating = '".(int) $data['rating']."', status = '".(int) $data['status']."', date_added = NOW()");

        $sellerreview_id = $this->db->getLastId();

        $this->cache->delete('seller');

        $this->event->trigger('post.admin.sellerreview.add', $sellerreview_id);

        return $sellerreview_id;
    }

    public function editsellerreview($sellerreview_id, $data)
    {
        $this->event->trigger('pre.admin.sellerreview.edit', $data);

        $this->db->query('UPDATE '.DB_PREFIX."sellerreview SET customer_name = '".$this->db->escape($data['customer_name'])."', seller_id = '".(int) $data['seller_id']."', text = '".$this->db->escape(strip_tags($data['text']))."', rating = '".(int) $data['rating']."', status = '".(int) $data['status']."', date_modified = NOW() WHERE sellerreview_id = '".(int) $sellerreview_id."'");

        $this->cache->delete('seller');

        $this->event->trigger('post.admin.sellerreview.edit', $sellerreview_id);
    }

    public function deletesellerreview($sellerreview_id)
    {
        $this->event->trigger('pre.admin.sellerreview.delete', $sellerreview_id);

        $this->db->query('DELETE FROM '.DB_PREFIX."sellerreview WHERE sellerreview_id = '".(int) $sellerreview_id."'");

        $this->cache->delete('seller');

        $this->event->trigger('post.admin.sellerreview.delete', $sellerreview_id);
    }

    public function getsellerreview($sellerreview_id)
    {
        $query = $this->db->query("SELECT DISTINCT *, (SELECT CONCAT(pd.firstname, ' ', pd.lastname) AS title FROM ".DB_PREFIX.'customer pd WHERE pd.customer_id = r.seller_id ) AS seller FROM '.DB_PREFIX."sellerreview r WHERE r.sellerreview_id = '".(int) $sellerreview_id."'");

        return $query->row;
    }

    public function getsellerreviews($data = array())
    {
        $sql = "SELECT r.sellerreview_id, CONCAT(pd.firstname, ' ', pd.lastname) AS title, r.customer_name, r.rating, r.status, r.date_added FROM ".DB_PREFIX.'sellerreview r LEFT JOIN '.DB_PREFIX.'customer pd ON (r.seller_id = pd.customer_id) LEFT JOIN '.DB_PREFIX.'customer_group_description cgd ON (pd.customer_group_id = cgd.customer_group_id) ';

        $sql .= " WHERE cgd.language_id = '".(int) $this->config->get('config_language_id')."'";

        if (!empty($data['filter_seller'])) {
            $sql .= " AND CONCAT(pd.firstname, ' ', pd.lastname) LIKE '%".$this->db->escape($data['filter_seller'])."%'";
        }

        if (!empty($data['filter_customer_name'])) {
            $sql .= " AND r.customer_name LIKE '%".$this->db->escape($data['filter_customer_name'])."%'";
        }

        if (isset($data['filter_status']) && !is_null($data['filter_status'])) {
            $sql .= " AND r.status = '".(int) $data['filter_status']."'";
        }

        if (!empty($data['filter_date_added'])) {
            $sql .= " AND DATE(r.date_added) = DATE('".$this->db->escape($data['filter_date_added'])."')";
        }

        $sort_data = array(
            'pd.firstname',
            'r.customer_name',
            'r.rating',
            'r.status',
            'r.date_added',
        );

        if (isset($data['sort']) && in_array($data['sort'], $sort_data)) {
            $sql .= ' ORDER BY '.$data['sort'];
        } else {
            $sql .= ' ORDER BY r.date_added';
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

    public function getTotalsellerreviews($data = array())
    {
        $sql = 'SELECT COUNT(*) AS total FROM '.DB_PREFIX.'sellerreview r LEFT JOIN '.DB_PREFIX.'customer pd ON (r.seller_id = pd.customer_id) ';

        if (!empty($data['filter_seller'])) {
            $sql .= " AND CONCAT(pd.firstname, ' ', pd.lastname) LIKE '%".$this->db->escape($data['filter_seller'])."%'";
        }

        if (!empty($data['filter_customer_name'])) {
            $sql .= " AND r.customer_name LIKE '%".$this->db->escape($data['filter_customer_name'])."%'";
        }

        if (!empty($data['filter_status'])) {
            $sql .= " AND r.status = '".(int) $data['filter_status']."'";
        }

        if (!empty($data['filter_date_added'])) {
            $sql .= " AND DATE(r.date_added) = DATE('".$this->db->escape($data['filter_date_added'])."')";
        }

        $query = $this->db->query($sql);

        return $query->row['total'];
    }

    public function getTotalsellerreviewsAwaitingApproval()
    {
        $query = $this->db->query('SELECT COUNT(*) AS total FROM '.DB_PREFIX."sellerreview WHERE status = '0'");

        return $query->row['total'];
    }
}
