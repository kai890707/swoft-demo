<?php
use SDPMlab\Anser\Service\ServiceList;

// ServiceList::addLocalService("product_service","10.1.1.3",8081,false);
// ServiceList::addLocalService("order_service","10.1.1.4",8082,false);
// ServiceList::addLocalService("payment_service","10.1.1.5",8083,false);

ServiceList::addLocalService("product_service","140.127.74.162",8081,false);
ServiceList::addLocalService("order_service","140.127.74.163",8082,false);
ServiceList::addLocalService("payment_service","140.127.74.164",8083,false);

?>