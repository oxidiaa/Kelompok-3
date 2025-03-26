<div class="container-fluid">
  <div class="col-lg-12">
      <div class="card">
        <div class="card-body">
          <h5 class="card-title">List Data Karyawan</h5>

          <!-- Tombol Tambah (Trigger Modal) -->
          <div class="row">
              <div class="col-md-2">
                  <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addKaryawanModal">Tambah</button>
              </div>
              <div class="col-md-3">
                  <input type="text" id="searchKaryawan" class="form-control" placeholder="Cari Nama Karyawan...">
              </div>
          </div>

          <div class="table-responsive">
            <table class="table text-nowrap align-middle mb-0">
              <thead>
                <tr class="border-2 border-bottom border-primary border-0">
                  <th>ID Karyawan</th>
                  <th>Nama</th>
                  <th>Jabatan</th>
                  <th>Tempat Lahir</th>
                  <th>Tanggal Lahir</th>
                  <th>Tanggal Masuk</th>
                  <th>Tanggal Keluar</th>
                  <th></th>
                </tr>
              </thead>
              <tbody id="karyawanTable">
                <?php if (!empty($karyawan_list)): ?>
                  <?php foreach ($karyawan_list as $karyawan): ?>
                    <tr>
                      <td><?= $karyawan->id_karyawan ?></td>
                      <td><?= $karyawan->nm_karyawan ?></td>
                      <td><?= $karyawan->nm_jabatan ?></td>
                      <td><?= $karyawan->tempat_lahir ?></td>
                      <td><?= date('d-m-Y', strtotime($karyawan->tgl_lahir)) ?></td>
                      <td><?= date('d-m-Y', strtotime($karyawan->tgl_masuk)) ?></td>
                      <td><?= $karyawan->tgl_keluar ? date('d-m-Y', strtotime($karyawan->tgl_keluar)) : '-' ?></td>
                      <td>
                          <button class="btn btn-primary btn-sm editKaryawan"
                              data-id="<?= $karyawan->id_karyawan ?>"
                              data-nama="<?= $karyawan->nm_karyawan ?>"
                              data-jabatan="<?= $karyawan->fk_jabatan ?>"
                              data-tempat="<?= $karyawan->tempat_lahir ?>"
                              data-tgllahir="<?= $karyawan->tgl_lahir ?>"
                              data-tglmasuk="<?= $karyawan->tgl_masuk ?>"
                              data-tglkeluar="<?= $karyawan->tgl_keluar ?>">
                              Edit
                          </button>
                      </td>
                    </tr>
                  <?php endforeach; ?>
                <?php else: ?>
                  <tr>
                    <td colspan="8" class="text-center text-muted">Data Kosong</td>
                  </tr>
                <?php endif; ?>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
</div>

<!-- Modal Tambah/Edit Data -->
<div class="modal fade" id="addKaryawanModal" tabindex="-1" aria-labelledby="addKaryawanLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="addKaryawanLabel">Tambah Karyawan</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form id="formKaryawan">
        <input type="hidden" id="edit_mode" name="edit_mode" value="0"> <!-- Indikator Edit -->
        
        <div class="modal-body">
          <div class="mb-3">
            <label for="id_karyawan" class="form-label">Id Karyawan</label>
            <input type="text" class="form-control" id="id_karyawan" name="id_karyawan" required>
          </div>

          <div class="mb-3">
            <label for="nm_karyawan" class="form-label">Nama Karyawan</label>
            <input type="text" class="form-control" id="nm_karyawan" name="nm_karyawan" required>
          </div>

          <div class="mb-3">
            <label for="fk_jabatan" class="form-label">Jabatan</label>
            <select class="form-control" id="fk_jabatan" name="fk_jabatan" required>
              <option value="">Pilih Jabatan</option>
              <?php foreach ($jabatan_list as $jabatan): ?>
                <option value="<?= $jabatan->kd_jabatan ?>"><?= $jabatan->nm_jabatan ?></option>
              <?php endforeach; ?>
            </select>
          </div>

          <div class="mb-3">
            <label for="tempat_lahir" class="form-label">Tempat Lahir</label>
            <input type="text" class="form-control" id="tempat_lahir" name="tempat_lahir">
          </div>

          <div class="mb-3">
            <label for="tgl_lahir" class="form-label">Tanggal Lahir</label>
            <input type="date" class="form-control" id="tgl_lahir" name="tgl_lahir">
          </div>

          <div class="mb-3">
            <label for="tgl_masuk" class="form-label">Tanggal Masuk</label>
            <input type="date" class="form-control" id="tgl_masuk" name="tgl_masuk" required>
          </div>

          <div class="mb-3" id="tgl_keluar_group" style="display: none;">
            <label for="tgl_keluar" class="form-label">Tanggal Keluar</label>
            <input type="date" class="form-control" id="tgl_keluar" name="tgl_keluar">
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
      $("#formKaryawan").submit(function (e) {
          e.preventDefault();
          let formData = $(this).serialize();

          $.ajax({
              url: "<?= base_url('Karyawan/save') ?>",
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

      $(".editKaryawan").click(function () {
          let id = $(this).data("id");
          let nama = $(this).data("nama");
          let jabatan = $(this).data("jabatan");
          let tempat = $(this).data("tempat");
          let tgllahir = $(this).data("tgllahir");
          let tglmasuk = $(this).data("tglmasuk");
          let tglkeluar = $(this).data("tglkeluar");

          $("#edit_mode").val(1); // Set mode edit
          $("#id_karyawan").val(id).prop("readonly", true).addClass("bg-light"); // ID tidak bisa diedit saat edit mode
          $("#nm_karyawan").val(nama);
          $("#fk_jabatan").val(jabatan);
          $("#tempat_lahir").val(tempat);
          $("#tgl_lahir").val(tgllahir);
          $("#tgl_masuk").val(tglmasuk);

          $("#tgl_keluar").val(tglkeluar);
          $("#tgl_keluar_group").show();

          $("#addKaryawanModal").modal("show");
      });

      $("#addKaryawanModal").on("hidden.bs.modal", function () {
          $("#edit_mode").val(0);
          $("#id_karyawan").val("").prop("readonly", false).removeClass("bg-light"); // ID bisa diedit saat tambah baru
          $("#nm_karyawan").val("");
          $("#fk_jabatan").val("");
          $("#tempat_lahir").val("");
          $("#tgl_lahir").val("");
          $("#tgl_masuk").val("");
          $("#tgl_keluar").val("");
          $("#tgl_keluar_group").hide();
      });
  });


</script>
