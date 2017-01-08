<?php

class Modelsellerproductseller extends Model
{
    public function getSellerGroupIdBysellerId()
    {
        $query = $this->db->query('SELECT * FROM '.DB_PREFIX.'customer c 
		LEFT JOIN '.DB_PREFIX.'seller_group sg ON (c.seller_group_id = sg.seller_group_id)
		LEFT JOIN '.DB_PREFIX."seller_group_description sgd ON (c.seller_group_id = sgd.seller_group_id)
		 WHERE c.customer_id =  '".(int) $this->customer->getId()."' 
		 
		 AND sgd.language_id = '".(int) $this->config->get('config_language_id')."'");

        return $query->row;
    }
}
