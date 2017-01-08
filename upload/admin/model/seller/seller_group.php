<?php

class ModelSellersellerGroup extends Model
{
    public function addsellerGroup($data)
    {
        $this->db->query('INSERT INTO '.DB_PREFIX."seller_group SET  sort_order = '".(int) $data['sort_order']."',product_limit = '".(int) $data['product_limit']."' ,subscription_duration = '".(int) $data['subscription_duration']."' ,subscription_price = '".(int) $data['subscription_price']."',commission = '".(int) $data['commission']."',fee = '".(int) $data['fee']."', status = '".(int) $data['status']."', product_status = '".(int) $data['product_status']."'");

        $seller_group_id = $this->db->getLastId();

        foreach ($data['seller_group_description'] as $language_id => $value) {
            $this->db->query('INSERT INTO '.DB_PREFIX."seller_group_description SET seller_group_id = '".(int) $seller_group_id."', language_id = '".(int) $language_id."', name = '".$this->db->escape($value['name'])."', description = '".$this->db->escape($value['description'])."'");
        }

        if (isset($data['seller_group_category'])) {
            foreach ($data['seller_group_category'] as $category_id) {
                $this->db->query('INSERT INTO '.DB_PREFIX."category_to_seller_group SET seller_group_id = '".(int) $seller_group_id."', category_id = '".(int) $category_id."'");
            }
        }
    }

    public function editsellerGroup($seller_group_id, $data)
    {
        $this->db->query('UPDATE '.DB_PREFIX."seller_group SET sort_order = '".(int) $data['sort_order']."',product_limit = '".(int) $data['product_limit']."' ,subscription_duration = '".(int) $data['subscription_duration']."' ,subscription_price = '".(int) $data['subscription_price']."',commission = '".(int) $data['commission']."',fee = '".(int) $data['fee']."', status = '".(int) $data['status']."', product_status = '".(int) $data['product_status']."' WHERE seller_group_id = '".(int) $seller_group_id."'");

        $this->db->query('DELETE FROM '.DB_PREFIX."seller_group_description WHERE seller_group_id = '".(int) $seller_group_id."'");

        foreach ($data['seller_group_description'] as $language_id => $value) {
            $this->db->query('INSERT INTO '.DB_PREFIX."seller_group_description SET seller_group_id = '".(int) $seller_group_id."', language_id = '".(int) $language_id."', name = '".$this->db->escape($value['name'])."', description = '".$this->db->escape($value['description'])."'");
        }

        $this->db->query('DELETE FROM '.DB_PREFIX."category_to_seller_group WHERE seller_group_id = '".(int) $seller_group_id."'");

        if (isset($data['seller_group_category'])) {
            foreach ($data['seller_group_category'] as $category_id) {
                $this->db->query('INSERT INTO '.DB_PREFIX."category_to_seller_group SET seller_group_id = '".(int) $seller_group_id."', category_id = '".(int) $category_id."'");
            }
        }
    }

    public function deletesellerGroup($seller_group_id)
    {
        $this->db->query('DELETE FROM '.DB_PREFIX."seller_group WHERE seller_group_id = '".(int) $seller_group_id."'");
        $this->db->query('DELETE FROM '.DB_PREFIX."seller_group_description WHERE seller_group_id = '".(int) $seller_group_id."'");
    }

    public function getsellerGroup($seller_group_id)
    {
        $query = $this->db->query('SELECT DISTINCT * FROM '.DB_PREFIX.'seller_group cg LEFT JOIN '.DB_PREFIX."seller_group_description cgd ON (cg.seller_group_id = cgd.seller_group_id) WHERE cg.seller_group_id = '".(int) $seller_group_id."' AND cgd.language_id = '".(int) $this->config->get('config_language_id')."'");

        return $query->row;
    }

    public function getsellerGroups($data = array())
    {
        $sql = 'SELECT * FROM '.DB_PREFIX.'seller_group cg LEFT JOIN '.DB_PREFIX."seller_group_description cgd ON (cg.seller_group_id = cgd.seller_group_id) WHERE cgd.language_id = '".(int) $this->config->get('config_language_id')."'";

        $sort_data = array(
            'cgd.name',
            'cg.sort_order',
            'cg.status',
            'cg.product_status',
            'cg.subscription_duration',
            'cg.product_limit',
            'cg.subscription_price',
        );

        if (isset($data['sort']) && in_array($data['sort'], $sort_data)) {
            $sql .= ' ORDER BY '.$data['sort'];
        } else {
            $sql .= ' ORDER BY cgd.name';
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

    public function getsellerGroupDescriptions($seller_group_id)
    {
        $seller_group_data = array();

        $query = $this->db->query('SELECT * FROM '.DB_PREFIX."seller_group_description WHERE seller_group_id = '".(int) $seller_group_id."'");

        foreach ($query->rows as $result) {
            $seller_group_data[$result['language_id']] = array(
                'name' => $result['name'],
                'description' => $result['description'],
            );
        }

        return $seller_group_data;
    }

    public function getTotalsellerGroups()
    {
        $query = $this->db->query('SELECT COUNT(*) AS total FROM '.DB_PREFIX.'seller_group');

        return $query->row['total'];
    }

        
    public function getTotalStoresBysellerGroupId($seller_group_id)
    {
        $query = $this->db->query('SELECT COUNT(*) AS total FROM '.DB_PREFIX."setting WHERE `key` = 'config_seller_group_id' AND `value` = '".(int) $seller_group_id."' AND store_id != '0'");

        return $query->row['total'];
    }

    public function getsellergroupCategories($seller_group_id)
    {
        $product_category_data = array();

        $query = $this->db->query('SELECT * FROM '.DB_PREFIX."category_to_seller_group WHERE seller_group_id = '".(int) $seller_group_id."'");

        foreach ($query->rows as $result) {
            $product_category_data[] = $result['category_id'];
        }

        return $product_category_data;
    }
}
