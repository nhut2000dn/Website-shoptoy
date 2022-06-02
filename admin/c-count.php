<?php
  $query_count_account  = 'SELECT * FROM account';
  $result_count_account = mysqli_query($connection,$query_count_account) or die ("loi".mysqli_error($connection));
  $count_account = mysqli_num_rows($result_count_account);

  $query_count_species  = 'SELECT * FROM pd_species';
  $result_count_species = mysqli_query($connection,$query_count_species) or die ("loi".mysqli_error($connection));
  $count_species = mysqli_num_rows($result_count_species);

  $query_count_material  = 'SELECT * FROM pd_material';
  $result_count_material = mysqli_query($connection,$query_count_material) or die ("loi".mysqli_error($connection));
  $count_material = mysqli_num_rows($result_count_material);

  $query_count_ideal_for  = 'SELECT * FROM pd_ideal_for';
  $result_count_ideal_for = mysqli_query($connection,$query_count_ideal_for) or die ("loi".mysqli_error($connection));
  $count_ideal_for = mysqli_num_rows($result_count_ideal_for);

  $query_count_r_age  = 'SELECT * FROM pd_recommended_age';
  $result_count_r_age = mysqli_query($connection,$query_count_r_age) or die ("loi".mysqli_error($connection));
  $count_r_age = mysqli_num_rows($result_count_r_age);

  $query_count_product  = 'SELECT product.id AS id_pd, product.name_pd, product.image_pd, product.describe_pd,
    product.Material_pd, product.amount_pd, product.price_pd, product.species_pd, pd_species.id AS id_species, pd_species.name_species AS nameSpecies
    FROM product, pd_species 
    WHERE pd_species.id = product.species_pd';
  $result_count_product = mysqli_query($connection,$query_count_product) or die ("loi".mysqli_error($connection));
  $count_product = mysqli_num_rows($result_count_product);

  $query_count_order = 'SELECT order_product.id AS orderId, order_product.id_account, order_product.created_date, order_product.date_of_delivery,
  order_product.address, order_product.phone_number, order_product.pay, account.id AS accountID, account.first_name AS hoAccount, account.last_name AS tenAccount 
  FROM order_product, account 
  WHERE order_product.id_account = account.id';
  $result_count_order = mysqli_query($connection,$query_count_order) or die ("loi".mysqli_error($connection));
  $count_order = mysqli_num_rows($result_count_order);

  $query_count_comment  = 'SELECT pd_comments.id AS idComments, pd_comments.id_pd, pd_comments.id_account, pd_comments.comment_content,
    pd_comments.status, account.id ,account.first_name, account.last_name, product.id ,product.name_pd, product.image_pd 
    FROM pd_comments, account, product 
    WHERE pd_comments.id_account = account.id AND pd_comments.id_pd = product.id AND pd_comments.status = 0';
  $result_count_comment = mysqli_query($connection,$query_count_comment) or die ("loi".mysqli_error($connection));
  $count_comment = mysqli_num_rows($result_count_comment);

  $query_count_contact  = 'SELECT * FROM shop_toy.contact;';
  $result_count_contact = mysqli_query($connection,$query_count_contact) or die ("loi".mysqli_error($connection));
  $count_contact = mysqli_num_rows($result_count_contact);
  
  $query_count_out_stock  = 'SELECT product.id AS id_pd, product.name_pd, product.image_pd, product.describe_pd,
    product.Material_pd, product.amount_pd, product.price_pd, product.species_pd, pd_species.id AS id_species, pd_species.name_species AS nameSpecies
    FROM product, pd_species 
    WHERE pd_species.id = product.species_pd AND product.amount_pd = 0';
  $result_count_out_stock = mysqli_query($connection,$query_count_out_stock) or die ("loi".mysqli_error($connection));
  $count_out_stock = mysqli_num_rows($result_count_out_stock);
?>