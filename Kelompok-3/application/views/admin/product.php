<div class="container-fluid">
  <div class="col-lg-12">
      <div class="card">
        <div class="card-body">
          <h5 class="card-title">List Data Produk</h5>
          <!-- Tombol Tambah (Trigger Modal) -->
          <div class="row">
              <div class="col-md-2">
                  <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addProductModal">Tambah</button>
              </div>
              <div class="col-md-3">
                  <input type="text" id="searchProduct" class="form-control" placeholder="Cari Nama Produk...">
              </div>
          </div>
          <div class="table-responsive">
            <table class="table text-nowrap align-middle mb-0">
              <thead>
                <tr class="border-2 border-bottom border-primary border-0">
                  <th scope="col">Kode Produk</th>
                  <th scope="col">Nama Produk</th>
                  <th scope="col">Harga Beli</th>
                  <th scope="col">Harga Jual</th>
                  <th scope="col">Satuan</th> <!-- Tambahan Kolom Satuan -->
                  <th scope="col">Keterangan</th> <!-- Tambahan Kolom Keterangan -->
                  <th scope="col">Gambar</th>
                  <th scope="col"></th>
                </tr>
              </thead>
              <tbody id="productTable">
                <?php if (!empty($products)): ?>
                  <?php foreach ($products as $product): ?>
                    <tr>
                      <td><?= $product->kd_product ?></td>
                      <td><?= $product->nm_product ?></td>
                      <td>Rp <?= number_format($product->harga_beli, 0, ',', '.') ?></td>
                      <td>Rp <?= number_format($product->harga_jual, 0, ',', '.') ?></td>
                      <td><?= $product->nm_satuan ?></td> <!-- Tampilkan Nama Satuan -->
                      <td><?= $product->keterangan ?></td> <!-- Tampilkan Keterangan -->
                      <td><img src="<?= base_url('uploads/products/' . $product->image_product) ?>" width="50"></td>
                      <td>
                        <button class="btn btn-primary btn-sm editProduct" 
                              data-id="<?= $product->kd_product ?>" 
                              data-nama="<?= $product->nm_product ?>" 
                              data-beli="<?= $product->harga_beli ?>" 
                              data-jual="<?= $product->harga_jual ?>"
                              data-satuan="<?= $product->fk_satuan ?>" 
                              data-keterangan="<?= $product->keterangan ?>"
                              data-image="<?= $product->image_product ?>"
                              data-active="<?= $product->is_active ?>">
                              Edit
                          </button>
                      <button class="btn btn-danger btn-sm deleteProduct" 
                                data-id="<?= $product->kd_product ?>" 
                                data-nama="<?= $product->nm_product ?>" 
                                data-beli="<?= $product->harga_beli ?>" 
                                data-jual="<?= $product->harga_jual ?>"
                                data-satuan="<?= $product->fk_satuan ?>" 
                                data-keterangan="<?= $product->keterangan ?>"
                                data-image="<?= $product->image_product ?>"
                                data-active="<?= $product->is_active ?>">
                                Hapus
                            </button>
                          
                      </td>
                            

                    </tr>
                  <?php endforeach; ?>
                <?php else: ?>
                  <tr>
                    <td colspan="7" class="text-center text-muted">Data Kosong</td>
                  </tr>
                <?php endif; ?>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
</div>

<!-- Modal Tambah Produk -->
<div class="modal fade" id="addProductModal" tabindex="-1">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Tambah Produk</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <form id="addProductForm" action="<?= base_url('product/simpan'); ?>" method="post" enctype="multipart/form-data">
        <div class="modal-body">
          <div class="mb-3">
            <label class="form-label">Kode Produk</label>
            <input type="text" class="form-control" id="kd_product" name="kd_product" required pattern="^\S+$" title="Kode Outlet tidak boleh mengandung spasi">
            <small class="text-danger" id="error_id_product"></small>
          </div>
          <div class="mb-3">
            <label class="form-label">Nama Produk</label>
            <input type="text" class="form-control" id="nm_product" name="nm_product" required>
          </div>
          <div class="mb-3">
              <label class="form-label">Harga Beli</label>
              <input type="text" class="form-control" id="harga_beli" name="harga_beli" required oninput="formatRupiah(this)">
          </div>
          <div class="mb-3">
              <label class="form-label">Harga Jual</label>
              <input type="text" class="form-control" id="harga_jual" name="harga_jual" required oninput="formatRupiah(this)">
          </div>
          <div class="mb-3">
              <label class="form-label">Status Produk</label>
              <select class="form-control" name="is_active" required>
                  <option value="1">Aktif</option>
                  <option value="0">Tidak Aktif</option>
              </select>
          </div>
          <div class="mb-3">
              <label class="form-label">Satuan</label>
              <select class="form-control" name="fk_satuan" required>
                  <option value="">Pilih Satuan</option>
                  <?php foreach ($satuan as $s): ?>
                      <option value="<?= $s->kd_satuan ?>"><?= $s->nm_satuan ?></option>
                  <?php endforeach; ?>
              </select>
          </div>
          <div class="mb-3">
              <label class="form-label">Keterangan</label>
              <textarea class="form-control" name="keterangan" rows="2"></textarea>
          </div>
          <div class="mb-3">
            <label class="form-label">Gambar Produk</label>
            <input type="file" class="form-control" name="image_product">
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

<!-- Modal Edit Produk -->
<div class="modal fade" id="editProductModal" tabindex="-1">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Edit Produk</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <form id="editProductForm" method="POST" action="<?= base_url('product/update'); ?>" enctype="multipart/form-data">
          <input type="hidden" id="edit_kd_product" name="kd_product">
          <input type="hidden" id="edit_old_image" name="old_image_product"> <!-- Gambar Lama -->
          <div class="modal-body">
            <div class="mb-3">
                <label class="form-label">Nama Produk</label>
                <input type="text" class="form-control" id="edit_nm_product" name="nm_product" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Harga Beli</label>
                <input type="text" class="form-control" id="edit_harga_beli" name="harga_beli" required oninput="formatRupiah(this)">
            </div>
            <div class="mb-3">
                <label class="form-label">Harga Jual</label>
                <input type="text" class="form-control" id="edit_harga_jual" name="harga_jual" required oninput="formatRupiah(this)">
            </div>
            <div class="mb-3">
                <label class="form-label">Status Produk</label>
                <select class="form-control" name="is_active" id="edit_is_active" required>
                    <option value="1">Aktif</option>
                    <option value="0">Tidak Aktif</option>
                </select>
            </div>
            <div class="mb-3">
                <label class="form-label">Satuan</label>
                <select class="form-control" name="fk_satuan" id="edit_fk_satuan" required>
                    <option value="">Pilih Satuan</option>
                    <?php foreach ($satuan as $s): ?>
                        <option value="<?= $s->kd_satuan ?>"><?= $s->nm_satuan ?></option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="mb-3">
                <label class="form-label">Keterangan</label>
                <textarea class="form-control" name="keterangan" id="edit_keterangan" rows="2"></textarea>
            </div>

            <div class="mb-3">
                <label class="form-label">Gambar Produk</label>
                <input type="file" class="form-control" name="image_product">
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
      // Event Submit Tambah Produk dengan AJAX
      $("#addProductForm").on("submit", function (e) {
          e.preventDefault();
          let formData = new FormData(this);

          $.ajax({
              type: "POST",
              url: "<?= base_url('product/simpan') ?>",
              data: formData,
              contentType: false,
              processData: false,
              dataType: "json",
              success: function (response) {
                  if (response.status === "success") {
                      Swal.fire({
                          title: "Produk Ditambahkan!",
                          text: response.message,
                          icon: "success",
                          confirmButtonText: "OK"
                      }).then(() => {
                          $("#addProductModal").modal("hide");
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
              error: function () {
                  Swal.fire({
                      title: "Oops!",
                      text: "Terjadi kesalahan pada server.",
                      icon: "error",
                      confirmButtonText: "Tutup"
                  });
              }
          });
      });

      // Event Klik Tombol Edit Produk
      $(document).on("click", ".editProduct", function () {
          let id = $(this).data("id");
          let nama = $(this).data("nama");
          let beli = $(this).data("beli");
          let jual = $(this).data("jual");
          let satuan = $(this).data("satuan");
          let keterangan = $(this).data("keterangan");
          let image = $(this).data("image");
          let active = $(this).data("active");

          let beli_h = parseFloat(beli).toLocaleString('id-ID');
          let jual_h = parseFloat(jual).toLocaleString('id-ID');

          $("#edit_kd_product").val(id);
          $("#edit_nm_product").val(nama);
          $("#edit_harga_beli").val(beli_h);
          $("#edit_harga_jual").val(jual_h);
          $("#edit_fk_satuan").val(satuan); // Set dropdown satuan
          $("#edit_keterangan").val(keterangan); // Set keterangan
          $("#edit_old_image").val(image);
          $("#edit_is_active").val(active);

          $("#editProductModal").modal("show");
      });

      // Event Submit Edit Produk dengan AJAX
      $("#editProductForm").on("submit", function (e) {
          e.preventDefault();
          let formData = new FormData(this);

          $.ajax({
              type: "POST",
              url: "<?= base_url('product/update') ?>",
              data: formData,
              contentType: false,
              processData: false,
              dataType: "json",
              success: function (response) {
                  if (response.status === "success") {
                      Swal.fire({
                          title: "Berhasil!",
                          text: response.message,
                          icon: "success",
                          confirmButtonText: "OK"
                      }).then(() => {
                          $("#editProductModal").modal("hide");
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
              error: function () {
                  Swal.fire({
                      title: "Oops!",
                      text: "Terjadi kesalahan pada server.",
                      icon: "error",
                      confirmButtonText: "Tutup"
                  });
              }
          });
      });

      // Event Hapus Produk
      $(document).on("click", ".deleteProduct", function() {
          var id = $(this).data("id");
          var nama = $(this).data("nama");

          Swal.fire({
              title: "Hapus Produk?",
              text: "Apakah Anda yakin ingin menghapus produk '" + nama + "'?",
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
                      url: "<?= base_url('product/delete') ?>",
                      data: { kd_product: id },
                      dataType: "json",
                      success: function(response) {
                          if (response.status === "success") {
                              Swal.fire({
                                  title: "Berhasil!",
                                  text: "Produk berhasil dihapus.",
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
                      error: function() {
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

      $("#searchProduct").on("keyup", function () {
          let keyword = $(this).val();

          $.ajax({
              type: "POST",
              url: "<?= base_url('product/search') ?>",
              data: { keyword: keyword },
              success: function (response) {
                  $("#productTable").html(response);
              },
              error: function () {
                  console.error("Terjadi kesalahan dalam mengambil data.");
              }
          });
      });

      // Validasi Kode Outlet tidak boleh ada spasi
      $("#kd_product").on("input", function () {
          let kodeProduct = $(this).val();
          if (kodeProduct.includes(" ")) {
              $("#error_id_product").text("Kode Outlet tidak boleh mengandung spasi!");
              $("#submitBtn").prop("disabled", true);
          } else {
              $("#error_id_product").text("");
              $("#submitBtn").prop("disabled", false);
          }
      });

      $("#addProductForm, #editProductForm").on("submit", function () {
         let hargaBeli = $("#harga_beli, #edit_harga_beli");
         let hargaJual = $("#harga_jual, #edit_harga_jual");

         // Ubah format Rp 10.000 ke 10000 sebelum dikirim
         hargaBeli.val(hargaBeli.val().replace(/\./g, ""));
         hargaJual.val(hargaJual.val().replace(/\./g, ""));
      });

  });



  function formatRupiah(input) {
      let value = input.value.replace(/\D/g, ""); // Hanya angka
      value = new Intl.NumberFormat("id-ID").format(value); // Format ke Rupiah
      input.value = value;
  }
</script>
