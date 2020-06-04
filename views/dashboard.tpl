<div class="container-fluid">
  <div class="row">
    [+include file="sidebar.tpl"+]

    <main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-4">
    <!-- SIMIL BRADCUMBS -->
      <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2" style="color:white;">Dashboard</h1>
        <div class="btn-toolbar mb-2 mb-md-0">
          <div class="btn-group mr-2">
            <a class="btn btn-sm btn-outline-secondary" href="/mvc/controller/users/add.php">Add User</a>
          	<a class="btn btn-sm btn-outline-secondary" href="/mvc/controller/company/add.php">Add Company</a>
            <a class="btn btn-sm btn-outline-secondary" href="/mvc/controller/site/add.php">Add Site</a>
            <a class="btn btn-sm btn-outline-secondary" href="/mvc/controller/menu/add.php">Add Menu</a>
            <a class="btn btn-sm btn-outline-secondary" href="/mvc/controller/order/add.php">Add Order</a>
          </div>
          <!--<div class="btn-group mr-2">
            <button type="button" class="btn btn-sm btn-outline-secondary">Share</button>
            <button type="button" class="btn btn-sm btn-outline-secondary">Export</button>
          </div>-->
          <!--<button type="button" class="btn btn-sm btn-outline-secondary dropdown-toggle">
            <span data-feather="calendar"></span>
            This week
          </button>-->
        </div>
      </div>

      [+if isset($content)+]
        [+include file=$content+]
      [+/if+]
      
    </main>
  </div>
</div>