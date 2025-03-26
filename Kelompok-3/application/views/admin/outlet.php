<div class="container-fluid">
  <div class="col-lg-12">
      <div class="card">
        <div class="card-body">
          <h5 class="card-title">List Data Outlet</h5>
          <!-- Tombol Tambah (Trigger Modal) -->
          <div class="row">
              <div class="col-md-2">
                  <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addOutletModal">Tambah</button>
              </div>
              <div class="col-md-3">
                  <input type="text" id="searchOutlet" class="form-control" placeholder="Cari Nama Outlet...">
              </div>
          </div>
          <div class="table-responsive">
            <table class="table text-nowrap align-middle mb-0">
              <thead>
                <tr class="border-2 border-bottom border-primary border-0">
                  <th scope="col">ID Outlet</th>
                  <th scope="col">Nama Outlet</th>
                  <th scope="col">Alamat</th>
                  <th scope="col">No. Telepon</th>
                  <th scope="col"></th>
                </tr>
              </thead>
              <tbody id="outletTable">
                <?php if (!empty($outlets)): ?>
                  <?php foreach ($outlets as $outlet): ?>
                    <tr>
                      <td><?= $outlet->id_outlet ?></td>
                      <td><?= $outlet->nm_outlet ?></td>
                      <td><?= $outlet->alamat_outlet ?></td>
                      <td><?= $outlet->no_telp_outlet ?></td>
                      <td>
                          <button class="btn btn-primary btn-sm editOutlet" 
                              data-id="<?= $outlet->id_outlet ?>" 
                              data-nama="<?= $outlet->nm_outlet ?>" 
                              data-alamat="<?= $outlet->alamat_outlet ?>" 
                              data-telp="<?= $outlet->no_telp_outlet ?>">
                              Edit
                          </button>
                          <button class="btn btn-danger btn-sm deleteOutlet" 
                              data-id="<?= $outlet->id_outlet ?>" 
                              data-nama="<?= $outlet->nm_outlet ?>">
                              Hapus
                          </button>
                      </td>

                    </tr>
                  <?php endforeach; ?>
                <?php else: ?>
                  <tr>
                    <td colspan="4" class="text-center text-muted">Data Kosong</td>
                  </tr>
                <?php endif; ?>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
</div>

<!-- Modal Tambah Outlet -->
<div class="modal fade" id="addOutletModal" tabindex="-1" aria-labelledby="addOutletModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="addOutletModalLabel">Tambah Outlet</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form id="addOutletForm" action="<?= base_url('outlet/simpan'); ?>" method="post">
        <div class="modal-body">
          <div class="mb-3">
            <label for="id_outlet" class="form-label">Kode Outlet</label>
            <input type="text" class="form-control" id="id_outlet" name="id_outlet" required pattern="^\S+$" title="Kode Outlet tidak boleh mengandung spasi">
            <small class="text-danger" id="error_id_outlet"></small>
          </div>
          <div class="mb-3">
            <label for="nm_outlet" class="form-label">Nama Outlet</label>
            <input type="text" class="form-control" id="nm_outlet" name="nm_outlet" required>
          </div>
          <div class="mb-3">
            <label for="alamat_outlet" class="form-label">Alamat Outlet</label>
            <textarea class="form-control" id="alamat_outlet" name="alamat_outlet" rows="2" required></textarea>
          </div>
          <div class="mb-3">
            <label for="no_telp_outlet" class="form-label">No. HP</label>
            <input type="text" class="form-control" id="no_telp_outlet" name="no_telp_outlet" required>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Batal</button>
          <button type="submit" class="btn btn-primary" id="submitBtn">Simpan</button>
        </div>
      </form>
    </div>
  </div>
</div>

<!-- Modal Edit Outlet -->
<div class="modal fade" id="editOutletModal" tabindex="-1">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Edit Outlet</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <form id="editOutletForm" method="POST" action="<?= base_url('outlet/update'); ?>">
        <div class="modal-body">
          <input type="hidden" id="edit_id_outlet" name="id_outlet">
          <div class="mb-3">
            <label class="form-label">Nama Outlet</label>
            <input type="text" class="form-control" id="edit_nm_outlet" name="nm_outlet" required>
          </div>
          <div class="mb-3">
            <label class="form-label">Alamat</label>
            <textarea class="form-control" id="edit_alamat_outlet" name="alamat_outlet" required></textarea>
          </div>
          <div class="mb-3">
            <label class="form-label">No. Telepon</label>
            <input type="text" class="form-control" id="edit_no_telp_outlet" name="no_telp_outlet" required>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Tutup</button>
          <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
        </div>
      </form>
    </div>
  </div>
</div>

<script>

  $(document).ready(function () {
      // Event Submit Tambah Outlet dengan AJAX
      $("#addOutletForm").on("submit", function (e) {
          e.preventDefault();
          $.ajax({
              type: "POST",
              url: "<?= base_url('outlet/simpan') ?>",
              data: $(this).serialize(),
              dataType: "json",
              success: function (response) {
                  if (response.status === "success") {
                      Swal.fire({
                          title: "Outlet Ditambahkan!",
                          text: response.message,
                          icon: "success",
                          confirmButtonText: "OK"
                      }).then(() => {
                          $("#addOutletModal").modal("hide");
                          location.reload();
                      });
                  } else {
                      Swal.fire({
                          title: "Gagal!",
                          text: response.message,
                          icon: "error",
                          confirmButtonText: "Coba Lagi"
                      });
                  }
              },
              error: function (xhr) {
                  Swal.fire({
                      title: "Oops!",
                      text: "Terjadi kesalahan pada server.",
                      icon: "error",
                      confirmButtonText: "Tutup"
                  });
              }
          });
      });

      // Event Klik Tombol Edit
      $(document).on("click", ".editOutlet", function () {
          let id_outlet = $(this).data("id");
          let nama_outlet = $(this).data("nama");
          let alamat_outlet = $(this).data("alamat");
          let telp_outlet = $(this).data("telp");

          // Isi form modal edit dengan data outlet
          $("#edit_id_outlet").val(id_outlet);
          $("#edit_nm_outlet").val(nama_outlet);
          $("#edit_alamat_outlet").val(alamat_outlet);
          $("#edit_no_telp_outlet").val(telp_outlet);

          // Tampilkan modal edit
          $("#editOutletModal").modal("show");
      });

      // Event Submit Edit Outlet dengan AJAX
      $("#editOutletForm").on("submit", function (e) {
          e.preventDefault();
          $.ajax({
              type: "POST",
              url: "<?= base_url('outlet/update') ?>",
              data: $(this).serialize(),
              dataType: "json",
              success: function (response) {
                  if (response.status === "success") {
                      Swal.fire({
                          title: "Berhasil!",
                          text: response.message,
                          icon: "success",
                          confirmButtonText: "OK"
                      }).then(() => {
                          $("#editOutletModal").modal("hide");
                          location.reload();
                      });
                  } else {
                      Swal.fire({
                          title: "Gagal!",
                          text: response.message,
                          icon: "error",
                          confirmButtonText: "Coba Lagi"
                      });
                  }
              },
              error: function (xhr) {
                  Swal.fire({
                      title: "Oops!",
                      text: "Terjadi kesalahan pada server.",
                      icon: "error",
                      confirmButtonText: "Tutup"
                  });
                  console.error("Error:", xhr.responseText);
              }
          });
      });

      $(document).on("click", ".deleteOutlet", function() {
          var id_outlet = $(this).data("id");
          var nama_outlet = $(this).data("nama");

          Swal.fire({
              title: "Hapus Outlet?",
              text: "Apakah Anda yakin ingin menghapus outlet '" + nama_outlet + "'?",
              icon: "warning",
              showCancelButton: true,
              confirmButtonColor: "#d33",
              cancelButtonColor: "#3085d6",
              confirmButtonText: "Ya, Hapus!",
              cancelButtonText: "Batal"
          }).then((result) => {
              if (result.isConfirmed) {
                  $.ajax({
                      type: "POST",
                      url: "<?= base_url('outlet/delete') ?>",
                      data: { id_outlet: id_outlet },
                      dataType: "json",
                      success: function(response) {
                          if (response.status === "success") {
                              Swal.fire({
                                  title: "Berhasil!",
                                  text: "Outlet berhasil dihapus.",
                                  icon: "success",
                                  confirmButtonText: "OK"
                              }).then(() => {
                                  location.reload();
                              });
                          } else {
                              Swal.fire({
                                  title: "Gagal!",
                                  text: response.message,
                                  icon: "error",
                                  confirmButtonText: "OK"
                              });
                          }
                      },
                      error: function(xhr) {
                          Swal.fire({
                              title: "Oops!",
                              text: "Terjadi kesalahan pada server.",
                              icon: "error",
                              confirmButtonText: "Tutup"
                          });
                      }
                  });
              }
          });
      });

      $("#searchOutlet").on("keyup", function () {
          let keyword = $(this).val();

          $.ajax({
              type: "POST",
              url: "<?= base_url('outlet/search') ?>",
              data: { keyword: keyword },
              success: function (response) {
                  $("#outletTable").html(response);
              },
              error: function () {
                  console.error("Terjadi kesalahan dalam mengambil data.");
              }
          });
      });

      // Validasi Kode Outlet tidak boleh ada spasi
      $("#id_outlet").on("input", function () {
          let kodeOutlet = $(this).val();
          if (kodeOutlet.includes(" ")) {
              $("#error_id_outlet").text("Kode Outlet tidak boleh mengandung spasi!");
              $("#submitBtn").prop("disabled", true);
          } else {
              $("#error_id_outlet").text("");
              $("#submitBtn").prop("disabled", false);
          }
      });
  });

</script>

