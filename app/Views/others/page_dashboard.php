<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
  <title>Dashboard</title>
    <?php include '../app/Views/others/layouts/header.php'; ?>

    <body>
    <div id="app">
        <div class="main-wrapper main-wrapper-1">
       

        <!-- navbar -->
        <?php include '../app/Views/others/layouts/topbar.php'; ?>

        <!-- sidbar -->
        <?php include '../app/Views/others/layouts/sidebar.php'; ?>

        <!-- Main Content -->
        <div class="main-content">
        <section class="section">
          <div class="section-header">
            <h1>SIAKAD - Dashboard</h1>
          </div>
		  
		  <br><center><h1>Versi 1.0</h1></center><br>
		  
		  <!--
          <div class="row">
            <div class="col-lg-3 col-md-6 col-sm-6 col-12">
              <div class="card card-statistic-1">
                <div class="card-icon bg-primary">
                  <i class="far fa-user"></i>
                </div>
                <div class="card-wrap">
                  <div class="card-header">
                    <h4>Total Admin</h4>
                  </div>
                  <div class="card-body">
                    10
                  </div>
                </div>
              </div>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-6 col-12">
              <div class="card card-statistic-1">
                <div class="card-icon bg-danger">
                  <i class="far fa-newspaper"></i>
                </div>
                <div class="card-wrap">
                  <div class="card-header">
                    <h4>News</h4>
                  </div>
                  <div class="card-body">
                    42
                  </div>
                </div>
              </div>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-6 col-12">
              <div class="card card-statistic-1">
                <div class="card-icon bg-warning">
                  <i class="far fa-file"></i>
                </div>
                <div class="card-wrap">
                  <div class="card-header">
                    <h4>Reports</h4>
                  </div>
                  <div class="card-body">
                    1,201
                  </div>
                </div>
              </div>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-6 col-12">
              <div class="card card-statistic-1">
                <div class="card-icon bg-success">
                  <i class="fas fa-circle"></i>
                </div>
                <div class="card-wrap">
                  <div class="card-header">
                    <h4>Online Users</h4>
                  </div>
                  <div class="card-body">
                    47
                  </div>
                </div>
              </div>
            </div>                  
          </div>
		  -->
		  
       
		  
          <div class="row">
          
            <div class="col-lg-6 col-md-6 col-12">
              <div class="card">
 				
                <div class="card-body">
				<h4>Jumlah Per-Prodi (All)</h4>
				<ul>
				<?php foreach ($prodi as $dt){
                    echo "<li>".$dt->prodi." = ".$dt->jumlah."</li>";
                }?>
				</ul>
                </div>
				
				
              </div>
            </div>

            <div class="col-lg-6 col-md-8 col-12 col-sm-12">
              <div class="card">				
				
                <div class="card-body p-0">
				<h4>Jumlah Per-Prodi (Aktif)</h4>
				<ul>
				<?php foreach ($mhsAktif as $dt){
                    echo "<li>".$dt->prodi." = ".$dt->jumlah."</li>";
                }?>
				</ul>
                </div>
				
				
				
              </div>
            </div>
         
            
          </div>
		  
		  
		  
		  
        </section>
      </div>

        <!-- Footer -->
        <?php include '../app/Views/others/layouts/footer.php'; ?>
      
    </body>
</html>