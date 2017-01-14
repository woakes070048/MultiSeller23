<?php

$this->load->model('user/user_group');
$this->model_user_user_group->addPermission($this->user->getGroupId(), 'access', 'badge/badge');
$this->model_user_user_group->addPermission($this->user->getGroupId(), 'access', 'bank/bank');
$this->model_user_user_group->addPermission($this->user->getGroupId(), 'access', 'seller/seller');
$this->model_user_user_group->addPermission($this->user->getGroupId(), 'access', 'seller/setting');
$this->model_user_user_group->addPermission($this->user->getGroupId(), 'access', 'seller/order');
$this->model_user_user_group->addPermission($this->user->getGroupId(), 'access', 'seller/product');
$this->model_user_user_group->addPermission($this->user->getGroupId(), 'access', 'seller/seller_group');
$this->model_user_user_group->addPermission($this->user->getGroupId(), 'access', 'sellerdashboard/customer_online');
$this->model_user_user_group->addPermission($this->user->getGroupId(), 'access', 'sellerdashboard/seller');
$this->model_user_user_group->addPermission($this->user->getGroupId(), 'access', 'sellerdashboard/seller_online');
$this->model_user_user_group->addPermission($this->user->getGroupId(), 'access', 'sellerdashboard/seller');
$this->model_user_user_group->addPermission($this->user->getGroupId(), 'access', 'sellerdashboard/order');
$this->model_user_user_group->addPermission($this->user->getGroupId(), 'access', 'sellerdashboard/seller_group');
$this->model_user_user_group->addPermission($this->user->getGroupId(), 'access', 'sellerreview/sellerreview');

$this->model_user_user_group->addPermission($this->user->getGroupId(), 'modify', 'badge/badge');
$this->model_user_user_group->addPermission($this->user->getGroupId(), 'modify', 'bank/bank');
$this->model_user_user_group->addPermission($this->user->getGroupId(), 'modify', 'seller/seller');
$this->model_user_user_group->addPermission($this->user->getGroupId(), 'modify', 'seller/setting');
$this->model_user_user_group->addPermission($this->user->getGroupId(), 'modify', 'seller/order');
$this->model_user_user_group->addPermission($this->user->getGroupId(), 'modify', 'seller/product');
$this->model_user_user_group->addPermission($this->user->getGroupId(), 'modify', 'seller/seller_group');
$this->model_user_user_group->addPermission($this->user->getGroupId(), 'modify', 'sellerdashboard/customer_online');
$this->model_user_user_group->addPermission($this->user->getGroupId(), 'modify', 'sellerdashboard/seller');
$this->model_user_user_group->addPermission($this->user->getGroupId(), 'modify', 'sellerdashboard/seller_online');
$this->model_user_user_group->addPermission($this->user->getGroupId(), 'modify', 'sellerdashboard/seller');
$this->model_user_user_group->addPermission($this->user->getGroupId(), 'modify', 'sellerdashboard/order');
$this->model_user_user_group->addPermission($this->user->getGroupId(), 'modify', 'sellerdashboard/seller_group');
$this->model_user_user_group->addPermission($this->user->getGroupId(), 'modify', 'sellerreview/sellerreview');
