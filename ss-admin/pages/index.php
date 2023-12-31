      <?php
        // getting products
        $productCount = 0;
        $data = select('product_id', 'product');
        foreach ($data as $key => $d) {

            $productCount = ++$key;
        }
        $orderCount = 0;
        $orders = select(
            '*',
            'orders',
            "JOIN users ON orders.user_id = users.user_id
    JOIN orderproducts ON orders.order_id = orderproducts.order_id
    JOIN product ON orderproducts.product_id = product.product_id 
    WHERE orders.is_accepted IS NULL AND product.seller_id IS NULL 
    ORDER BY orders.order_id DESC"
        );
        foreach ($orders as $key => $a) {
            $orderCount = ++$key;
        }



        // getting user count
        $userCount = 0;
        $users = select('*', 'users');
        foreach ($users as $key => $a) {
            $userCount = ++$key;
        }


        // getting Total  sales amount
        $totalsales = 0;
        $sales = select('*', 'orders', 'WHERE delivery_date is NOT NULL');
        foreach ($sales as $key => $order) {
            $totalsales += $order['total'];
        }
        ?>





      <?php if ($orderCount > 0) { ?>
          <h5 class="my-4 alert alert-warning ">You have got <?= $orderCount ?> new orders <a href="newOrders" style="text-decoration: none;">View</a></h5>
      <?php } ?>
      <div class="row">
          <div class="col-md-4">
              <a href="./viewUsers.php" class="a-disabled">
                  <div class="card dashboard-box">
                      <div class="icon mt-4 m-auto">
                          <i class="fa-solid fa-users"></i>
                          <span>Users</span>
                      </div>
                      <div class="number mt-3  m-auto"><?= $userCount ?></div>
                  </div>
              </a>
          </div>

          <div class="col-md-4">
              <a href="<?= url('ss-admin/viewProduct.php') ?>" class="a-disabled">
                  <div class="card dashboard-box">
                      <div class="icon mt-4  m-auto">
                          <i class="fa-solid fa-box"></i>
                          <span>Products</span>
                      </div>
                      <div class="number mt-3  m-auto"><?= $productCount ?></div>
                  </div>
              </a>
          </div>

          <div class="col-md-4">
              <a href="<?= url('ss-admin/oldOrders.php') ?>" class="a-disabled">
                  <div class="card dashboard-box">
                      <div class="icon mt-4  m-auto">
                          <i class="fa-solid fa-money-bill"></i> <span>Sales</span>
                      </div>
                      <div class="number mt-3  m-auto"><?= $totalsales ?></div>
                  </div>
              </a>
          </div>

      </div>