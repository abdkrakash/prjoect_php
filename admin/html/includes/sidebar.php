<aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">
          <div class="app-brand demo">
            <a href="../users/read_users.php" class="app-brand-link">
            
              <span class="app-brand-text demo menu-text fw-bolder ms-2">Juice Corner</span>
            </a>

            <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto d-block d-xl-none">
              <i class="bx bx-chevron-left bx-sm align-middle"></i>
            </a>
          </div>

          <div class="menu-inner-shadow"></div>

          <ul class="menu-inner py-1">
            <!-- Dashboard -->
            <li class="menu-item">
              <a href="../html/index.php" class="menu-link">
                <i class="menu-icon tf-icons bx bx-home-circle"></i>
                <div data-i18n="Analytics">Dashboard</div>
              </a>
            </li>

            <!-- Layouts -->
            <li class="menu-item active" >
              <a href="../users/create_users.php" class="menu-link menu-toggle">
                <i class="menu-icon tf-icons bx bx-layout"></i>
                <div data-i18n="Layouts">user managment</div>
              </a>

              <ul class="menu-sub">
                <li class="menu-item">
                  <a href="../users/read_users.php" class="menu-link">
                    <div data-i18n="Without menu">View Users</div>
                  </a>
                </li>
                <li class="menu-item">
                  <a href="../users/create_user.php" class="menu-link">
                    <div data-i18n="Without navbar">Add new user</div>
                  </a>
                </li>
               
              </ul>
            </li>

           
            <li class="menu-item  ">
              <a href="../Category/read_Category.php" class="menu-link menu-toggle">
                <i class="menu-icon tf-icons bx bx-dock-top"></i>
                <div data-i18n="Account Settings">Category Managment</div>
              </a>

              <ul class="menu-sub">
                
                
                <li class="menu-item">
                  <a href="../Category/read_Category.php" class="menu-link">
                    <div data-i18n="Notifications">View Category</div>
                  </a>
                </li>
                <li class="menu-item">
                  <a href="../Category/create_Category.php" class="menu-link">
                    <div data-i18n="Account">Add New Category</div>
                  </a>
                </li>
              </ul>
            </li>


            <li class="menu-item  ">
              <a href="../juices/read_juices.php" class="menu-link menu-toggle">
                <i class="menu-icon tf-icons bx bx-dock-top"></i>
                <div data-i18n="Account Settings">juices Managment</div>
              </a>
              <ul class="menu-sub">
              <li class="menu-item">
                  <a href="../juices/read_juices.php" class="menu-link">
                    <div data-i18n="Notifications">View juices</div>
                  </a>
                </li>
                <li class="menu-item">
                  <a href="../juices/create_juices.php" class="menu-link">
                    <div data-i18n="Account">Add New juice</div>
                  </a>
                </li>
                
              </ul>
            </li>

            <li class="menu-item  ">
              <a href="../orders/read_orders.php" class="menu-link menu-toggle">
                <i class="menu-icon tf-icons bx bx-dock-top"></i>
                <div data-i18n="Account Settings">Orders Managment</div>
              </a>
              <ul class="menu-sub">
              <li class="menu-item">
                  <a href="../orders/read_orders.php" class="menu-link">
                    <div data-i18n="Notifications">View Orders</div>
                  </a>
                </li>
              
                
              </ul>
            </li>


            <li class="menu-item">
              <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class="menu-icon tf-icons bx bx-lock-open-alt"></i>
                <div data-i18n="Authentications">Authentications</div>
              </a>
              <ul class="menu-sub">
                <li class="menu-item">
                  <a href="/php_mini/juicecorner/login/login.php" class="menu-link" target="_blank">
                    <div data-i18n="Basic">Log Out</div>
                  </a>
                </li>
            
           
          </ul>
        </aside>