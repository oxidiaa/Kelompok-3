<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Kelompok 3 - Register</title>
  <link rel="stylesheet" href="<?= base_url('assets/css/styles.min.css'); ?>">
</head>

<body>
  <div class="page-wrapper" id="main-wrapper" data-layout="vertical" data-navbarbg="skin6" data-sidebartype="full"
    data-sidebar-position="fixed" data-header-position="fixed">
    <div class="position-relative overflow-hidden radial-gradient min-vh-100 d-flex align-items-center justify-content-center">
      <div class="d-flex align-items-center justify-content-center w-100">
        <div class="row justify-content-center w-100">
          <div class="col-md-8 col-lg-6 col-xxl-3">
            <div class="card mb-0">
              <div class="card-body">
                <a href="<?= base_url(); ?>" class="text-nowrap logo-img text-center d-block py-3 w-100">
                  <img src="<?= base_url('assets/images/logos/logo-light.svg'); ?>" alt="">
                </a>
                <p class="text-center">Create an Account</p>
                <?php if ($this->session->flashdata('error')): ?>
                  <p class="alert text-danger text-center"><?= $this->session->flashdata('error'); ?></p>
                <?php endif; ?>
                <?php if ($this->session->flashdata('success')): ?>
                  <p class="alert text-success text-center"><?= $this->session->flashdata('success'); ?></p>
                <?php endif; ?>
                <form method="POST" action="<?= base_url('login/create_account'); ?>">
                  <div class="mb-3">
                      <label for="username" class="form-label">Username</label>
                      <input type="text" class="form-control" id="username" name="username" value="<?= set_value('username', $this->session->flashdata('username')); ?>" required>
                  </div>
                  <div class="mb-3">
                      <label for="email" class="form-label">Email</label>
                      <input type="email" class="form-control" id="email" name="email" value="<?= set_value('email', $this->session->flashdata('email')); ?>" required>
                  </div>
                  <div class="mb-3">
                      <label for="password" class="form-label">Password</label>
                      <input type="password" class="form-control" id="password" name="password" required>
                  </div>
                  <div class="mb-3">
                      <label for="confirm_password" class="form-label">Confirm Password</label>
                      <input type="password" class="form-control" id="confirm_password" name="confirm_password" required>
                  </div>
                  <div class="mb-3">
                      <label for="role" class="form-label">Role</label>
                      <select class="form-control" id="role" name="role">
                          <option value="2" <?= ($this->session->flashdata('role') == '2' ? 'selected' : ''); ?>>User</option>
                          <option value="1" <?= ($this->session->flashdata('role') == '1' ? 'selected' : ''); ?>>Admin</option>
                      </select>
                  </div>
                  <button type="submit" class="btn btn-primary w-100 py-8 fs-4 mb-4">Register</button>
                  <div class="d-flex align-items-center justify-content-center">
                    <p class="fs-4 mb-0 fw-bold">Already have an account?</p>
                    <a class="text-primary fw-bold ms-2" href="<?= base_url('login'); ?>">Login</a>
                  </div>
                </form>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <script src="<?= base_url('assets/libs/jquery/dist/jquery.min.js'); ?>"></script>
  <script src="<?= base_url('assets/libs/bootstrap/dist/js/bootstrap.bundle.min.js'); ?>"></script>
</body>

</html>
