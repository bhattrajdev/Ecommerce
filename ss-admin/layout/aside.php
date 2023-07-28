  <!-- top navigation bar -->
  <nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top">
      <div class="container-fluid">
          <button class="navbar-toggler" type="button" data-bs-toggle="offcanvas" data-bs-target="#sidebar" aria-controls="offcanvasExample">
              <span class="navbar-toggler-icon" data-bs-target="#sidebar"></span>
          </button>
          <a class="navbar-brand me-auto ms-lg-0 ms-3 text-uppercase fw-bold" href="<?= url('/ss-admin') ?>"> <img src="<?= url('/public/images/Logo.png') ?>" width="20px" alt=""> Sneaker Station</a>
          <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#topNavBar" aria-controls="topNavBar" aria-expanded="false" aria-label="Toggle navigation">
              <span class="navbar-toggler-icon"></span>
          </button>
          <div class="collapse navbar-collapse" id="topNavBar">
              <form class="d-flex ms-auto my-3 my-lg-0">
                  <div class="input-group">
                  </div>
              </form>
              <ul class="navbar-nav">
                  <li class="nav-item dropdown">
                      <a class="nav-link dropdown-toggle ms-2" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                          <i class="bi bi-person-fill"></i>
                      </a>
                      <ul class="dropdown-menu dropdown-menu-end">
                          <li><a class="dropdown-item" href="<?= url('ss-admin/logout.php') ?>">LOGOUT</a></li>
                      </ul>
                  </li>
              </ul>
          </div>
      </div>
  </nav>
  <!-- top navigation bar -->
  <!-- offcanvas -->
  <div class="offcanvas offcanvas-start sidebar-nav bg-dark text-white" tabindex="-1" id="sidebar">
      <div class="offcanvas-body p-0">
          <nav class="navbar-dark">
              <ul class="navbar-nav">
                  <li>
                      <a href="<?= url('ss-admin') ?>" class="nav-link px-3 active">
                          <span class="me-2"><i class="bi bi-speedometer2"></i></span>
                          <span>Dashboard</span>
                      </a>
                  </li>
                  <li class="my-1">
                      <hr class="dropdown-divider bg-light" />
                  </li>
                  <li>
                      <div class="text-muted small fw-bold text-uppercase px-3 mb-3">
                          Product
                      </div>
                  </li>
                  <li>
                      <a class="nav-link px-3 sidebar-link" data-bs-toggle="collapse" href="#layouts">
                          <span class="me-2"><i class="fa-solid fa-box-open" style="color: #ffffff;"></i></span>
                          <span>Product Management</span>
                          <span class="ms-auto">
                              <span class="right-icon">
                                  <i class="bi bi-chevron-down"></i>
                              </span>
                          </span>
                      </a>
                      <div class="collapse" id="layouts">
                          <ul class="navbar-nav ps-3">
                              <li>
                                  <a href="<?= url('ss-admin/addProduct.php') ?>" class="nav-link px-3">
                                      <span class="me-2"><i class="fa-sharp fa-solid fa-plus" style="color: #ffffff;"></i></span>
                                      <span>Add Product</span>
                                  </a>
                              </li>
                          </ul>
                      </div>
                      <div class="collapse" id="layouts">
                          <ul class="navbar-nav ps-3">
                              <li>
                                  <a href="<?= url('ss-admin/viewProduct.php') ?>" class="nav-link px-3">
                                      <span class="me-2"><i class="fa-sharp fa-solid fa-eye" style="color: #ffffff;"></i></span>
                                      <span>View Product</span>
                                  </a>
                              </li>
                          </ul>
                      </div>
                  </li>
                  <li>
                      <a class="nav-link px-3 sidebar-link" data-bs-toggle="collapse" href="#productvarient">
                          <span class="me-2"><i class="fa-solid fa-chart-simple" style="color: #ffffff;"></i></span>
                          <span>Product Varience</span>
                          <span class="ms-auto">
                              <span class="right-icon">
                                  <i class="bi bi-chevron-down"></i>
                              </span>
                          </span>
                      </a>
                      <div class="collapse" id="productvarient">
                          <ul class="navbar-nav ps-3">
                              <li>
                                  <a href="<?= url('ss-admin/manageBrand.php') ?>" class="nav-link px-3">
                                      <span class="me-2"><i class="fa-sharp fa-solid fa-plus" style="color: #ffffff;"></i></span>
                                      <span>Manage Brand</span>
                                  </a>
                              </li>
                          </ul>
                      </div>
                      <div class="collapse" id="productvarient">
                          <ul class="navbar-nav ps-3">
                              <li>
                                  <a href="<?= url('ss-admin/manageColor.php') ?>" class="nav-link px-3">
                                      <span class="me-2"><i class="fa-solid fa-brush" style="color: #ffffff;"></i></span>
                                      <span>Manage Color</span>
                                  </a>
                              </li>
                          </ul>
                      </div>
                      <div class="collapse" id="productvarient">
                          <ul class="navbar-nav ps-3">
                              <li>
                                  <a href="<?= url('ss-admin/manageSize.php') ?>" class="nav-link px-3">
                                      <span class="me-2"><i class="fa-brands fa-think-peaks" style="color: #ffffff;"></i></span>
                                      <span>Manage Size</span>
                                  </a>
                              </li>
                          </ul>
                      </div>
                  </li>
                  <li class="my-1">
                      <hr class="dropdown-divider bg-light" />
                  </li>
                  <li>
                      <div class="text-muted small fw-bold text-uppercase px-3 mb-3">
                          Orders
                      </div>
                  </li>
                  <li>
                      <a class="nav-link px-3 sidebar-link" data-bs-toggle="collapse" href="#manageorder">
                          <span class="me-2"><i class="fa-solid fa-chart-simple" style="color: #ffffff;"></i></span>
                          <span>Order Management</span>
                          <span class="ms-auto">
                              <span class="right-icon">
                                  <i class="bi bi-chevron-down"></i>
                              </span>
                          </span>
                      </a>
                      <div class="collapse" id="manageorder">
                          <ul class="navbar-nav ps-3">
                              <li>
                                  <a href="<?= url('ss-admin/newOrders.php') ?>" class="nav-link px-3">
                                      <span class="me-2"><i class="fa-solid fa-brush" style="color: #ffffff;"></i></span>
                                      <span>New Orders</span>
                                  </a>
                              </li>
                          </ul>
                      </div>
                      <div class="collapse" id="manageorder">
                          <ul class="navbar-nav ps-3">
                              <li>
                                  <a href="<?= url('ss-admin/orderProgress.php') ?>" class="nav-link px-3">
                                      <span class="me-2"><i class="fa-brands fa-think-peaks" style="color: #ffffff;"></i></span>
                                      <span>Order Progress</span>
                                  </a>
                              </li>
                          </ul>
                      </div>
                      <div class="collapse" id="manageorder">
                          <ul class="navbar-nav ps-3">
                              <li>
                                  <a href="<?= url('ss-admin/oldOrders.php') ?>" class="nav-link px-3">
                                      <span class="me-2"><i class="fa-brands fa-think-peaks" style="color: #ffffff;"></i></span>
                                      <span>Old Orders</span>
                                  </a>
                              </li>
                          </ul>
                      </div>
                  </li>
                  <li class="my-1">
                      <hr class="dropdown-divider bg-light" />
                  </li>
                  <li>
                      <a href="<?= url('ss-admin/viewUsers.php') ?>" class="nav-link px-3">
                          <span class="me-2"><i class="fa-solid fa-users" style="color: #ffffff;"></i></span>
                          <span>User Management</span>
                      </a>
                  </li>
              </ul>
          </nav>
      </div>
  </div>
  <!-- offcanvas -->
  <main class="mt-5 pt-3">
      <div class="container-fluid">
          <div class="row">
              <div class="col-md-12 mt-2" style="color: black;">