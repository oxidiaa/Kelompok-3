<div class="container-fluid">
  <div class="col-lg-12">
      <div class="card">
        <div class="card-body">
          <h5 class="card-title">List Data User</h5>

          <!-- Tombol Tambah (Trigger Modal) -->
          <div class="row">
              <div class="col-md-2">
                  <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addUserModal">Tambah</button>
              </div>
              <div class="col-md-3">
                  <input type="text" id="searchUser" class="form-control" placeholder="Cari Username...">
              </div>
          </div>

          <div class="table-responsive">
            <table class="table text-nowrap align-middle mb-0">
              <thead>
                <tr class="border-2 border-bottom border-primary border-0">
                  <th>Username</th>
                  <th>Email</th>
                  <th>Role</th>
                  <th>Nama Karyawan</th>
                  <th></th>
                </tr>
              </thead>
              <tbody id="userTable">
                <?php if (!empty($user_list)): ?>
                  <?php foreach ($user_list as $user): ?>
                    <tr>
                      <td><?= $user->username ?></td>
                      <td><?= $user->email ?></td>
                      <td><?= $user->role == 1 ? "Admin" : "Sales" ?></td>
                      <td><?= $user->nm_karyawan ?></td>
                      <td>
                          <button class="btn btn-primary btn-sm editUser"
                              data-id="<?= $user->id ?>"
                              data-username="<?= $user->username ?>"
                              data-email="<?= $user->email ?>"
                              data-role="<?= $user->role ?>"
                              data-karyawan="<?= $user->fk_karyawan ?>"
                              data-nama="<?= $user->nm_karyawan ?>">
                              Edit
                          </button>
                      </td>
                    </tr>
                  <?php endforeach; ?>
                <?php else: ?>
                  <tr>
                    <td colspan="6" class="text-center text-muted">Data Kosong</td>
                  </tr>
                <?php endif; ?>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
</div>

<!-- Modal Tambah/Edit Data User -->
<div class="modal fade" id="addUserModal" tabindex="-1" aria-labelledby="addUserLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="addUserLabel">Tambah User</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form id="formUser">
        <input type="hidden" id="edit_mode" name="edit_mode" value="0"> <!-- Indikator Edit -->
        <input type="hidden" id="id" name="id"> <!-- Indikator Edit -->

        <div class="modal-body">
          <div class="mb-3">
            <label for="username" class="form-label">Username</label>
            <input type="text" class="form-control" id="username" name="username" required>
          </div>

          <div class="mb-3">
          <label for="password" class="form-label">Password</label>
          <div class="input-group">
            <input type="password" class="form-control" id="password" name="password" required>
            <span class="input-group-text" id="togglePassword">
              <i class="bi bi-eye-slash" id="password-icon"></i>
            </span>
          </div>
        </div>

        <div class="mb-3">
          <label for="password_confirm" class="form-label">Konfirmasi Password</label>
          <div class="input-group">
            <input type="password" class="form-control" id="password_confirm" name="password_confirm" required>
            <span class="input-group-text" id="togglePasswordConfirm">
              <i class="bi bi-eye-slash" id="password-confirm-icon"></i>
            </span>
          </div>
        </div>

          <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="email" class="form-control" id="email" name="email" required>
          </div>

          <div class="mb-3">
            <label for="role" class="form-label">Role</label>
            <select class="form-control" id="role" name="role" required>
              <option value="">Pilih Role</option>
              <option value="1">Admin</option>
              <option value="2">Sales</option>
            </select>
          </div>

          <div class="mb-3">
            <label for="fk_karyawan" class="form-label">Karyawan</label>
            <select class="form-control" id="fk_karyawan" name="fk_karyawan" required>
              <option value="">Pilih Karyawan</option>
              <?php foreach ($karyawan_list as $karyawan): ?>
                <option value="<?= $karyawan->id_karyawan ?>" data-nama="<?= $karyawan->nm_karyawan ?>">
                  <?= $karyawan->id_karyawan." - ".$karyawan->nm_karyawan ?>
                </option>
              <?php endforeach; ?>
            </select>
          </div>

        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Batal</button>
          <button type="submit" class="btn btn-primary">Simpan</button>
        </div>
      </form>
    </div>
  </div>
</div>


<script>
  $(document).ready(function () {
      $("#formUser").submit(function (e) {
          e.preventDefault();
          let password = $("#password").val();
          let passwordConfirm = $("#password_confirm").val();

          // Check if password and confirmation match
          if (password !== passwordConfirm) {
              Swal.fire("Gagal!", "Password dan konfirmasi password tidak cocok.", "error");
              return;
          }

          // Password validation (at least 8 characters, one lowercase, one uppercase, one number, one special character)
          let passwordPattern = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/;
          if (!passwordPattern.test(password)) {
              Swal.fire("Gagal!", "Password harus terdiri dari minimal 8 karakter dengan kombinasi huruf besar, huruf kecil, angka, dan karakter khusus.", "error");
              return;
          }

          let formData = $(this).serialize();

          $.ajax({
              url: "<?= base_url('User/save') ?>",
              type: "POST",
              data: formData,
              dataType: "json",
              success: function (response) {
                  if (response.status === "success") {
                      Swal.fire("Berhasil!", response.message, "success").then(() => {
                          location.reload();
                      });
                  } else {
                      Swal.fire("Gagal!", response.message, "error");
                  }
              },
              error: function (xhr) {
                  console.error(xhr.responseText);
                  Swal.fire("Error!", "Terjadi kesalahan pada server.", "error");
              }
          });
      });

      $(".editUser").click(function () {
          let id = $(this).data("id");
          let username = $(this).data("username");
          let email = $(this).data("email");
          let role = $(this).data("role");
          let karyawan = $(this).data("karyawan");

          $("#id").val(id);
          $("#edit_mode").val(1);
          $("#username").val(username);
          $("#email").val(email);
          $("#role").val(role);
          $("#fk_karyawan").val(karyawan);

          // Clear password and confirm fields when editing
          $("#password").val("");
          $("#password_confirm").val("");

          $("#addUserModal").modal("show");
      });

      $("#addUserModal").on("hidden.bs.modal", function () {
          $("#edit_mode").val(0);
          $("#username").val("");
          $("#password").val("");
          $("#password_confirm").val("");
          $("#email").val("");
          $("#role").val("");
          $("#fk_karyawan").val("");
      });
      // Toggle visibility for password field
      $('#togglePassword').click(function () {
          let passwordField = $('#password');
          let icon = $('#password-icon');
          if (passwordField.attr('type') === 'password') {
              passwordField.attr('type', 'text');
              icon.removeClass('bi-eye-slash').addClass('bi-eye');
          } else {
              passwordField.attr('type', 'password');
              icon.removeClass('bi-eye').addClass('bi-eye-slash');
          }
      });

      // Toggle visibility for password confirmation field
      $('#togglePasswordConfirm').click(function () {
          let passwordConfirmField = $('#password_confirm');
          let icon = $('#password-confirm-icon');
          if (passwordConfirmField.attr('type') === 'password') {
              passwordConfirmField.attr('type', 'text');
              icon.removeClass('bi-eye-slash').addClass('bi-eye');
          } else {
              passwordConfirmField.attr('type', 'password');
              icon.removeClass('bi-eye').addClass('bi-eye-slash');
          }
      });
  });
</script>
