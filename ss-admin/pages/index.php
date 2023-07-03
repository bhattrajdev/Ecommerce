      <?php
// getting products
      $data = select('product_id','product');
      foreach($data as $key =>$d){

          $productCount = ++$key;
       
      }

?>
      
      
      <div class="row">
            <div class="col-md-4">
                <a href="#" class="a-disabled">
                    <div class="card dashboard-box">
                        <div class="icon mt-4 m-auto">
                            <i class="fa-solid fa-users"></i>
                            <span>Users</span>
                        </div>
                        <div class="number mt-3  m-auto">10000+</div>
                    </div>
                </a>
            </div>

            <div class="col-md-4">
                <a href="<?=url('ss-admin/viewProduct.php')?>" class="a-disabled">
                    <div class="card dashboard-box">
                        <div class="icon mt-4  m-auto">
                            <i class="fa-solid fa-users"></i>
                            <span>Products</span>
                        </div>
                        <div class="number mt-3  m-auto"><?= $productCount?></div>
                    </div>
                </a>
            </div>

            <div class="col-md-4">
                <a href="#" class="a-disabled">
                    <div class="card dashboard-box">
                        <div class="icon mt-4  m-auto">
                            <i class="fa-solid fa-users"></i>
                            <span>Sales</span>
                        </div>
                        <div class="number mt-3  m-auto">10000+</div>
                    </div>
                </a>
            </div>

        </div>