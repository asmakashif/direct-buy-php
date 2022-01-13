<?php
//creating connection to database

$con=mysqli_connect("localhost:3306","direcbuy_directbuy","Default!@#123",$db2) or die(mysqli_error());

//create a empty table with the column structure of basetable_direcbuy

$create_qry="CREATE TABLE cart_details LIKE direcbuy_directbuy.cart_details;";
mysqli_query($con,$create_qry);

$create_qry="CREATE TABLE category LIKE direcbuy_directbuy.category;";
mysqli_query($con,$create_qry);

$create_qry="CREATE TABLE customers LIKE direcbuy_directbuy.customers;";
mysqli_query($con,$create_qry);

$create_qry="CREATE TABLE customer_address LIKE direcbuy_directbuy.customer_address;";
mysqli_query($con,$create_qry);

$create_qry="CREATE TABLE customer_default_store LIKE direcbuy_directbuy.customer_default_store;";
mysqli_query($con,$create_qry);

$create_qry="CREATE TABLE cust_payment_details LIKE direcbuy_directbuy.cust_payment_details;";
mysqli_query($con,$create_qry);

$create_qry="CREATE TABLE order_items LIKE direcbuy_directbuy.order_items;";
mysqli_query($con,$create_qry);

$create_qry="CREATE TABLE payment_integration LIKE direcbuy_directbuy.payment_integration;";
mysqli_query($con, $create_qry) or die("database error:". mysqli_error($con));

$create_qry="CREATE TABLE payment_provider LIKE direcbuy_directbuy.payment_provider;";
mysqli_query($con, $create_qry) or die("database error:". mysqli_error($con));

$create_qry="CREATE TABLE shop_details LIKE direcbuy_directbuy.shop_details;";
mysqli_query($con,$create_qry);

$create_qry="CREATE TABLE shop_detail_type LIKE direcbuy_directbuy.shop_detail_type;";
mysqli_query($con,$create_qry);

$create_qry="CREATE TABLE shop_payment_info LIKE direcbuy_directbuy.shop_payment_info;";
mysqli_query($con,$create_qry);

$create_qry="CREATE TABLE shop_types LIKE direcbuy_directbuy.shop_types;";
mysqli_query($con,$create_qry);

$create_qry="CREATE TABLE tbl_products LIKE direcbuy_directbuy.temp_str_config;";
mysqli_query($con,$create_qry);

$create_qry="CREATE TABLE tbl_user LIKE direcbuy_directbuy.tbl_user;";
mysqli_query($con,$create_qry);

$create_qry="CREATE TABLE temp_str_config LIKE direcbuy_directbuy.temp_str_config;";
mysqli_query($con,$create_qry);


// query to copy table with all its  data
$copy_qry1="INSERT category SELECT * FROM direcbuy_directbuy.category;";
mysqli_query($con,$copy_qry1);

$copy_qry1="INSERT payment_integration SELECT * FROM direcbuy_directbuy.payment_integration;";
mysqli_query($con,$copy_qry1);

$copy_qry2="INSERT payment_provider SELECT * FROM direcbuy_directbuy.payment_provider;";
mysqli_query($con,$copy_qry2);

$copy_qry3="INSERT shop_details SELECT * FROM direcbuy_directbuy.shop_details;";
mysqli_query($con,$copy_qry3);

$copy_qry4="INSERT shop_detail_type SELECT * FROM direcbuy_directbuy.shop_detail_type;";
mysqli_query($con,$copy_qry4);

// $copy_qry5="INSERT shop_payment_info SELECT * FROM direcbuy_directbuy.shop_payment_info;";
// mysqli_query($con,$copy_qry5);

$copy_qry6="INSERT shop_types SELECT * FROM direcbuy_directbuy.shop_types;";
mysqli_query($con,$copy_qry6);

$copy_qry7="INSERT tbl_user SELECT * FROM direcbuy_directbuy.tbl_user;";
mysqli_query($con,$copy_qry7) or die("database error:". mysqli_error($con));

$copy_qry="INSERT tbl_products SELECT * FROM direcbuy_directbuy.temp_str_config WHERE temp_shopId ='$shopId';";
mysqli_query($con,$copy_qry);

$copy_qry="INSERT temp_str_config SELECT * FROM direcbuy_directbuy.temp_str_config WHERE temp_shopId ='$shopId';";
mysqli_query($con,$copy_qry);

?>

