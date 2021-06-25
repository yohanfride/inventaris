<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
  <title>Sistem Inventarisasi - Form Masuk</title>

  <!-- General CSS Files -->
  <link rel="stylesheet" href="<?= base_url()?>assets/css/bootstrap.min.css">
  <link rel="stylesheet" href="<?= base_url()?>assets/node_modules/fontawesome/css/all.css">
   
  <!-- CSS Libraries -->
  <link rel="stylesheet" href="<?= base_url()?>assets/node_modules/bootstrap-social/bootstrap-social.css">

  <!-- Template CSS -->
  <link rel="stylesheet" href="<?= base_url()?>assets/css/style.css">
  <link rel="stylesheet" href="<?= base_url()?>assets/css/components.css">
</head>

<body>
  <div id="app">
    <section class="section">
      <div class="d-flex flex-wrap align-items-stretch">
        <div class="col-lg-4 col-md-6 col-12 order-lg-1 min-vh-100 bg-white">
          <div class="p-4 m-3 mt-5">
            <h4 class="text-dark font-weight-normal">Selamat datang di <span class="font-weight-bold">SISI</span></h4>
            <p class="text-muted">Sistem Inventaris</p>

            <form method="POST" action="<?= base_url()?>auth/dologin" class="needs-validation" novalidate="">
              <?php if($error){ ?>
                    <div class="alert alert-danger alert-dismissible show fade alert-has-icon">
                      <div class="alert-icon"><i class="fa fa-exclamation-triangle"></i></div>
                      <div class="alert-body">
                        <button class="close" data-dismiss="alert">
                          <span>&times;</span>
                        </button>
                        <div class="alert-title">Peringatan</div>
                        <?= $error?>
                      </div>
                    </div>
                    <?php } ?>
              <div class="form-group">
                <label for="username">Username</label>
                <input id="username" type="text" class="form-control" name="username" tabindex="1" required autofocus>
                <div class="invalid-feedback">
                  Masukkan username anda yang telah terdaftar
                </div>
              </div>

              <div class="form-group">
                <div class="d-block">
                  <label for="password" class="control-label">Password</label>
                </div>
                <div class="input-group mb-2">
                  <input id="password" type="password" class="form-control" name="password" tabindex="2" required>
                  <div class="input-group-append">
                    <div class="input-group-text" style="cursor: pointer;" onclick="showpassword('password');"><i id="btn-eye-password" class="fa fa-eye"></i></div>
                  </div>
                </div>
                <div class="invalid-feedback">
                  Masukkan password anda yang telah terdaftar
                </div>
              </div>

              <!-- <div class="form-group">
                <div class="custom-control custom-checkbox">
                  <input type="checkbox" name="remember" class="custom-control-input" tabindex="3" id="remember-me">
                  <label class="custom-control-label" for="remember-me">Remember Me</label>
                </div>
              </div> -->

              <div class="form-group text-right">
                <button type="submit" class="btn btn-primary btn-lg btn-icon icon-right" tabindex="4">
                  Login
                </button>
              </div>
            </form>

          </div>
        </div>
        <div class="col-lg-8 col-12 order-lg-2 order-1 min-vh-100 background-walk-y position-relative overlay-gradient-bottom" data-background="<?= base_url()?>assets/img/SDA.jpg">
          <div class="absolute-bottom-left index-2">
            <div class="text-light p-5 pb-5">
              <div class="mb-2 pb-3">
                <h1 class="mb-2  font-weight-bold">Gereja Santa Maria Annutiata</h1>
                <h5 class="font-weight-normal text-muted-transparent">Sidoarjo, Indonesia</h5>
              </div>
              Sumber <a class="text-light bb" target="_blank" href="https://keuskupansurabaya.org/page/paroki-santa-maria-annuntiata/">Keuskupansurabaya.org</a>
            </div>
          </div>
        </div>
      </div>
    </section>
  </div>

  <!-- General JS Scripts -->
  <script src="<?= base_url()?>assets/js/jquery-3.3.1.min.js"></script>
  <script src="<?= base_url()?>assets/js/popper.min.js"></script>
  <script src="<?= base_url()?>assets/js/bootstrap.min.js"></script>
  <script src="<?= base_url()?>assets/js/jquery.nicescroll.min.js"></script>
  <script src="<?= base_url()?>assets/js/moment.min.js"></script>
  <script src="<?= base_url()?>assets/js/stisla.js"></script>
  <!-- JS Libraies -->

   <!-- JS Libraies -->
  <script src="<?= base_url()?>assets/node_modules/cleave.js/dist/cleave.min.js"></script>
  <script src="<?= base_url()?>assets/node_modules/cleave.js/dist/addons/cleave-phone.us.js"></script>
  <script src="<?= base_url()?>assets/node_modules/jquery-pwstrength/jquery.pwstrength.min.js"></script>
  <script src="<?= base_url()?>assets/node_modules/bootstrap-daterangepicker/daterangepicker.js"></script>
  <script src="<?= base_url()?>assets/node_modules/bootstrap-colorpicker/dist/js/bootstrap-colorpicker.min.js"></script>
  <script src="<?= base_url()?>assets/node_modules/bootstrap-timepicker/js/bootstrap-timepicker.min.js"></script>
  <script src="<?= base_url()?>assets/node_modules/bootstrap-tagsinput/dist/bootstrap-tagsinput.min.js"></script>
  <script src="<?= base_url()?>assets/node_modules/select2/dist/js/select2.full.min.js"></script>
  <script src="<?= base_url()?>assets/node_modules/selectric/public/jquery.selectric.min.js"></script>

  <!-- Template JS File -->
  <script src="<?= base_url()?>assets/js/scripts.js"></script>
  <script src="<?= base_url()?>assets/js/custom.js"></script>

  <!-- Page Specific JS File -->
  <!-- <script src="<?= base_url()?>assets/js/page/forms-advanced-forms.js"></script> -->
  <script type="text/javascript">
    function showpassword(index){
      if($("#"+index).prop("type") == "text"){
        $("#"+index).prop("type", "password");
        $("#btn-eye-"+index).removeClass("text-primary");
      } else {
        $("#"+index).prop("type", "text");
        $("#btn-eye-"+index).addClass("text-primary");
      }
    }
  </script>
</body>
</html>
