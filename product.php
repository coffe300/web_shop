<?php
    $include_conf = [
        'title'=>'Карточка товара',
        'css'=> '/css/product.css',
        'js'=> '/scripts/product.js'
    ];
    include($_SERVER['DOCUMENT_ROOT'].'/modules/header.php');
    $template = [];
    
    if(isset($_GET['id'])){
        $id = $_GET['id'];
        $sql_product = "SELECT * FROM products WHERE id = {$id}";
        $result_product = mysqli_query($db, $sql_product);
        $template = mysqli_fetch_assoc($result_product);

        $template['sizes'] = [];

        $sql_sizes = "SELECT sizes.id, sizes.size, sizes_products.quantity FROM sizes 
        INNER JOIN sizes_products on sizes_products.size_id = sizes.id
        WHERE sizes_products.product_id = {$id}";
        $result_sizes = mysqli_query($db, $sql_sizes);

        $count_rows_sizes = mysqli_num_rows($result_sizes);
        for($i = 0; $i < $count_rows_sizes; $i++){
            $template['sizes'][] = mysqli_fetch_assoc($result_sizes);
        }

        // while($row = mysqli_fetch_assoc($result_sizes)){
        //     $template['sizes'][] = $row;
        // }

        d($template);
    }
?>
<div class="product">
    <div class="product-photo" style="background-image: url(<?=$template['photo']?>)"></div>
    <h1 class="product-h1"><?=$template['name']?></h1>
    <div class="product-sku">Артикул: <?=$template['sku']?></div>
    <div class="product-price"><?=$template['price']?> руб. </div>
    <p class="product-description"><?=$template['description']?></p>
    <div class="product-sizes">
        <h2 class="product-sizes-h2">Размеры:</h2>
        <div class="product-sizes-box">
            <div class="product-sizes-box-item">
                <?php foreach($template['sizes'] as $result_sizes): ?>
                    <p class=""><?=$result_sizes['size']?></p>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
    <div class="product-addtocart" data-product-id="<?=$template['id']?>">Добавить в корзину</div>
</div>
<?php 
    include($_SERVER['DOCUMENT_ROOT'].'/modules/footer.php');
?>
    
