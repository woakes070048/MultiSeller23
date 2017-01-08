<?php

class Modelbadgebadge extends Model
{
    public function addbadge($data)
    {
        $this->db->query('INSERT INTO '.DB_PREFIX."badge SET value = '0'");

        $badge_id = $this->db->getLastId();

        foreach ($data['badge_description'] as $language_id => $seller_id) {
            $this->db->query('INSERT INTO '.DB_PREFIX."badge_description SET badge_id = '".(int) $badge_id."', language_id = '".(int) $language_id."', title = '".$this->db->escape($seller_id['title'])."', image = '".$data['image']."'");
        }

        $this->cache->delete('badge');
    }

    public function editbadge($badge_id, $data)
    {
        $this->db->query('DELETE FROM '.DB_PREFIX."badge_description WHERE badge_id = '".(int) $badge_id."'");

        foreach ($data['badge_description'] as $language_id => $seller_id) {
            $this->db->query('INSERT INTO '.DB_PREFIX."badge_description SET badge_id = '".(int) $badge_id."', language_id = '".(int) $language_id."', title = '".$this->db->escape($seller_id['title'])."', image = '".$data['image']."'");
        }

        $this->cache->delete('badge');
    }

    public function deletebadge($badge_id)
    {
        $this->db->query('DELETE FROM '.DB_PREFIX."badge WHERE badge_id = '".(int) $badge_id."'");
        $this->db->query('DELETE FROM '.DB_PREFIX."badge_description WHERE badge_id = '".(int) $badge_id."'");

        $this->cache->delete('badge');
    }

    public function getbadges($data = array())
    {
        if ($data) {
            $sql = 'SELECT * FROM '.DB_PREFIX.'badge wc LEFT JOIN '.DB_PREFIX."badge_description wcd ON (wc.badge_id = wcd.badge_id) WHERE wcd.language_id = '".(int) $this->config->get('config_language_id')."'";

            $sort_data = array(
                'title',
                'image',
                'seller_id',
            );

            if (isset($data['sort']) && in_array($data['sort'], $sort_data)) {
                $sql .= ' ORDER BY '.$data['sort'];
            } else {
                $sql .= ' ORDER BY title';
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
            $badge_data = $this->cache->get('badge.'.(int) $this->config->get('config_language_id'));

            if (!$badge_data) {
                $query = $this->db->query('SELECT * FROM '.DB_PREFIX.'badge wc LEFT JOIN '.DB_PREFIX."badge_description wcd ON (wc.badge_id = wcd.badge_id) WHERE wcd.language_id = '".(int) $this->config->get('config_language_id')."'");

                $badge_data = $query->rows;

                $this->cache->set('badge.'.(int) $this->config->get('config_language_id'), $badge_data);
            }

            return $badge_data;
        }
    }

    public function getbadge($badge_id)
    {
        $query = $this->db->query('SELECT * FROM '.DB_PREFIX.'badge wc LEFT JOIN '.DB_PREFIX."badge_description wcd ON (wc.badge_id = wcd.badge_id) WHERE wc.badge_id = '".(int) $badge_id."' AND wcd.language_id = '".(int) $this->config->get('config_language_id')."'");

        return $query->row;
    }

    public function getsellers($badge_id)
    {
        $sql = '
		SELECT * FROM '.DB_PREFIX.'customer p 
		
		LEFT JOIN '.DB_PREFIX.'badge_to_seller pts 
		ON (p.customer_id = pts.seller_id)
		';

        $sql .= " WHERE pts.badge_id ='".(int) $badge_id."' ";

        $sql .= ' GROUP BY p.customer_id';

        $query = $this->db->query($sql);

        return $query->rows;
    }

    public function getsellerbadge($badge_id)
    {
        $query = $this->db->query('SELECT * FROM '.DB_PREFIX.'badge_to_seller wc LEFT JOIN '.DB_PREFIX."customer wcd ON (wc.seller_id = wcd.customer_id) WHERE wc.badge_id = '".(int) $badge_id."'");

        return $query->rows;
    }

    public function getbadgeDescriptionByimage($image)
    {
        $query = $this->db->query('SELECT * FROM '.DB_PREFIX."badge_description WHERE image = '".$this->db->escape($image)."' AND language_id = '".(int) $this->config->get('config_language_id')."'");

        return $query->row;
    }

    public function getbadgeDescriptions($badge_id)
    {
        $badge_data = array();

        $query = $this->db->query('SELECT * FROM '.DB_PREFIX."badge_description WHERE badge_id = '".(int) $badge_id."'");

        foreach ($query->rows as $result) {
            $badge_data[$result['language_id']] = array(
                'title' => $result['title'],
                'image' => $result['image'],
            );
        }

        return $badge_data;
    }

    public function getTotalbadges()
    {
        $query = $this->db->query('SELECT COUNT(*) AS total FROM '.DB_PREFIX.'badge');

        return $query->row['total'];
    }

    public function getsellerbadges($badge_id)
    {
        $seller_data = array();

        $query = $this->db->query('SELECT * FROM '.DB_PREFIX."badge_to_seller WHERE badge_id = '".(int) $badge_id."'");

        foreach ($query->rows as $result) {
            $seller_data[] = $result['seller_id'];
        }

        return $seller_data;
    }
    public function addsellerbadge($seller_id, $badge_id)
    {
        $this->db->query('DELETE FROM `'.DB_PREFIX."badge_to_seller` WHERE `seller_id` = '".$seller_id."' AND `badge_id` = '".$badge_id."'");

        $this->db->query('INSERT INTO '.DB_PREFIX."badge_to_seller SET seller_id = '".(int) $seller_id."' , badge_id = '".(int) $badge_id."'");
    }
    public function deletesellerbadge($seller_id)
    {
        $this->db->query('DELETE FROM `'.DB_PREFIX."badge_to_seller` WHERE `seller_id` = '".$seller_id."'");
    }
    public function getTotalsellersBybadgeId($badge_id)
    {
        $query = $this->db->query('SELECT COUNT(*) AS total FROM '.DB_PREFIX."badge_to_seller WHERE badge_id = '".$this->db->escape($badge_id)."'");

        return $query->row['total'];
    }
}
