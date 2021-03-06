<?php 
    //бекенд каталога
    include($_SERVER['DOCUMENT_ROOT'].'/modules/header_conf.php');
    $response = [
        'products'=>[],
        'pagination'=>[
            'nowPage'=>1,
            'countPage'=> 1
        ]
    ];

    $products_on_page = 3;
    $now_page = 1;

    if(isset($_GET['now_page'])){
        $now_page = (int) $_GET['now_page'];
    }

    if(isset($_GET['id'])){
        $id = $_GET['id'];

        $sql = "SELECT products. * FROM products
        INNER JOIN catalogs_products ON products.id = catalogs_products.product_id
        WHERE catalogs_products.catalog_id = {$id}";
        $result = mysqli_query($db, $sql);

        $count_products = mysqli_num_rows($result);
        $count_page = ceil($count_products / $products_on_page);

        $response['pagination']['countPage'] = $count_page;
        $response['pagination']['nowPage'] = $now_page;

        $after_row = ($now_page - 1) * $products_on_page;

        $sql_products = "SELECT products. * FROM products
        INNER JOIN catalogs_products ON products.id = catalogs_products.product_id
        WHERE catalogs_products.catalog_id = {$id}
        LIMIT {$after_row}, {$products_on_page}
        ";

        $result_products = mysqli_query($db, $sql_products);

        while( $row = mysqli_fetch_assoc($result_products) ){
            $response['products'][] = $row;    
        }
    }

    

    sleep(0);
    echo json_encode($response);

?>

