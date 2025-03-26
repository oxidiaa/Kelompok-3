<div class="container-fluid">
  <div class="col-lg-12">
      <div class="card">
        <div class="card-body">
          <h5 class="card-title">List Data Pembelian Stok</h5>

          <!-- Tombol Tambah (Trigger Modal) -->
          <div class="row">
              <div class="col-md-2">
                  <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addPembelianModal">Tambah</button>
              </div>
              <div class="col-md-3">
                  <input type="text" id="searchPembelian" class="form-control" placeholder="Cari No. Pesanan...">
              </div>
          </div>

          <div class="table-responsive">
            <table class="table text-nowrap align-middle mb-0">
              <thead>
                <tr class="border-2 border-bottom border-primary border-0">
                  <th scope="col">No Pesanan</th>
                  <th scope="col">Tanggal Pesanan</th>
                  <th scope="col">Status</th>
                  <th scope="col">Tanggal Terima</th>
                  <th scope="col">Tanggal Batal</th>
                  <th scope="col">Keterangan</th>
                  <th scope="col"></th>
                </tr>
              </thead>
              <tbody id="pembelianTable">
                <?php if (!empty($pembelian_stok)): ?>
                  <?php foreach ($pembelian_stok as $pembelian): ?>
                    <tr>
                      <td><?= $pembelian->no_pesan ?></td>
                      <td><?= date('d-m-Y', strtotime($pembelian->tgl_pesan)) ?></td>
                      <td><?= $pembelian->status ?></td>
                      <td><?= $pembelian->tgl_terima ? date('d-m-Y', strtotime($pembelian->tgl_terima)) : '-' ?></td>
                      <td><?= $pembelian->tgl_batal ? date('d-m-Y', strtotime($pembelian->tgl_batal)) : '-' ?></td>
                      <td><?= $pembelian->keterangan ?: '-' ?></td>
                      <td>
                          <button class="btn btn-primary btn-sm editPembelian" 
                              data-id="<?= $pembelian->no_pesan ?>" 
                              data-tgl="<?= $pembelian->tgl_pesan ?>"
                              data-keterangan="<?= $pembelian->keterangan ?>">
                              Edit
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

<!-- Modal Tambah Data -->
<div class="modal fade" id="addPembelianModal" tabindex="-1" aria-labelledby="addPembelianLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="addPembelianLabel">Tambah Pembelian Stok</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form id="formPembelian"> 
        <input type="hidden" id="edit_mode" name="edit_mode" value="0"> <!-- Indikator Edit -->
        <input type="hidden" id="no_pesan" name="no_pesan"> <!-- No Pesanan otomatis dari procedure -->
        <input type="hidden" id="status" name="status" value="Proses"> <!-- Status otomatis -->
        <input type="hidden" id="tgl_terima" name="tgl_terima" value=""> <!-- Tgl Terima NULL -->
        <input type="hidden" id="tgl_batal" name="tgl_batal" value=""> <!-- Tgl Batal NULL -->
        <div class="modal-body">
          <div class="mb-3">
            <label for="tgl_pesan" class="form-label">Tanggal Pesanan</label>
            <input type="date" class="form-control" id="tgl_pesan" name="tgl_pesan" required>
          </div>

          <div class="mb-3">
            <label for="keterangan" class="form-label">Keterangan</label>
            <textarea class="form-control" id="keterangan" name="keterangan" rows="3"></textarea>
          </div>

          <!-- Detail Produk -->
          <h5>Detail Pembelian</h5>
          <table class="table table-bordered" id="detailTable">
            <div class="text-end mt-3">
                <h5>Total Harga : <span id="totalKeseluruhan">0</span></h5>
            </div>
            <thead>
              <tr>
                <th>Kode Produk</th>
                <th>Nama Produk</th>
                <th>Qty</th>
                <th>Harga</th>
                <th>Total</th>
                <th></th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <td>
                  <select class="form-control fk_product" name="fk_product[]">
                    <option value="">Pilih Produk</option>
                    <?php foreach ($products as $product): ?>
                      <option value="<?= $product->kd_product ?>" data-nama="<?= $product->nm_product ?>" data-harga="<?= $product->harga ?>">
                        <?= $product->kd_product ?> - <?= $product->nm_product ?>
                      </option>
                    <?php endforeach; ?>
                  </select>
                </td>
                <td><input type="text" class="form-control nm_product" readonly></td>
                <td><input type="number" class="form-control qty" name="qty[]" min="1"></td>
                <td><input type="text" class="form-control harga" name="harga[]" readonly></td>
                <td><input type="text" class="form-control total_harga" name="total_harga[]" readonly></td>
                <td><button type="button" class="btn btn-danger btn-sm removeDetail">Hapus</button></td>
              </tr>
            </tbody>
          </table>
          <button type="button" class="btn btn-primary btn-sm" id="addDetail">Tambah</button>
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
  $(document).ready(function() {
      // Proses Simpan Data via AJAX
      // Tangani submit form (Tambah & Edit)
      $('#formPembelian').submit(function(e) {
          e.preventDefault();
          let formData = new FormData(this);
          let url = $('#edit_mode').val() == "1" ? "<?= base_url('PembelianStok/update') ?>" : "<?= base_url('PembelianStok/tambah') ?>";

          $.ajax({
              url: url,
              type: "POST",
              data: formData,
              processData: false,
              contentType: false,
              dataType: "json",
              success: function(response) {
                  if (response.status === "success") {
                      Swal.fire("Berhasil!", response.message, "success").then(() => {
                          location.reload();
                      });
                  } else {
                      Swal.fire("Gagal", response.message, "error");
                  }
              },
              error: function(xhr) {
                  console.error(xhr.responseText);
                  Swal.fire("Error!", "Terjadi kesalahan dalam menyimpan data.", "error");
              }
          });
      });

      $(document).on('click', '.editPembelian', function () {
          let noPesan = $(this).data('id');
          let tglPesan = $(this).data('tgl');
          let keterangan = $(this).data('keterangan');

          $('#edit_mode').val(1); // Mode Edit
          $('#no_pesan').val(noPesan);
          $('#tgl_pesan').val(tglPesan);
          $('#keterangan').val(keterangan);

          // Kosongkan detail sebelumnya
          $('#detailTable tbody').empty();

          // Ambil detail pembelian dari database
          $.ajax({
              url: "<?= base_url('PembelianStok/getDetail') ?>",
              type: "POST",
              data: { no_pesan: noPesan },
              dataType: "json",
              success: function(response) {
                  if (response.length > 0) {
                      $.each(response, function(index, detail) {
                          let formattedHarga = parseFloat(detail.harga).toLocaleString('id-ID');
                          let formattedTotal = parseFloat(detail.total_harga).toLocaleString('id-ID');

                          let newRow = `
                          <tr>
                              <td>
                                  <select class="form-control fk_product" name="fk_product[]" required>
                                      ${productOptions}
                                  </select>
                              </td>
                              <td><input type="text" class="form-control nm_product" value="${detail.nm_product}" readonly></td>
                              <td><input type="number" class="form-control qty" name="qty[]" value="${detail.qty}" min="1"></td>
                              <td><input type="text" class="form-control harga" name="harga[]" value="${formattedHarga}" readonly></td>
                              <td><input type="text" class="form-control total_harga" name="total_harga[]" value="${formattedTotal}" readonly></td>
                              <td><button type="button" class="btn btn-danger btn-sm removeDetail">Hapus</button></td>
                          </tr>`;
                          $('#detailTable tbody').append(newRow);

                          // Pilih produk yang sesuai
                          $('#detailTable tbody tr:last-child .fk_product').val(detail.fk_product);
                      });

                      // Update total keseluruhan setelah menambahkan data ke tabel
                      updateTotalKeseluruhan();
                  }
              },
              error: function(xhr) {
                  console.error(xhr.responseText);
              }
          });

          $('#addPembelianModal').modal('show'); // Tampilkan modal
      });

      let productOptions = '';

      function loadProductOptions() {
          $.ajax({
              url: "<?= site_url('PembelianStok/getProducts') ?>",
              type: "GET",
              dataType: "json",
              success: function(data) {
                  productOptions = '<option value="">Pilih Produk</option>';
                  $.each(data, function(index, product) {
                      productOptions += `<option value="${product.kd_product}" data-nama="${product.nm_product}" data-harga="${product.harga_beli}">
                                          ${product.kd_product} - ${product.nm_product}
                                        </option>`;
                  });
                  $('.fk_product').html(productOptions);
              },
              error: function() {
                  console.error("Gagal memuat data produk.");
              }
          });
      }

      loadProductOptions();

      $('#addDetail').click(function() {
          let selectedProducts = [];
          $('.fk_product').each(function() {
              selectedProducts.push($(this).val());
          });

          let newRow = `
          <tr>
              <td>
                  <select class="form-control fk_product" name="fk_product[]">
                      ${productOptions}
                  </select>
              </td>
              <td><input type="text" class="form-control nm_product" readonly></td>
              <td><input type="number" class="form-control qty" name="qty[]" min="1"></td>
              <td><input type="text" class="form-control harga" name="harga[]" readonly></td>
              <td><input type="text" class="form-control total_harga" name="total_harga[]" readonly></td>
              <td><button type="button" class="btn btn-danger btn-sm removeDetail">Hapus</button></td>
          </tr>`;
          $('#detailTable tbody').append(newRow);
      });

      $(document).on('change', '.fk_product', function() {
          let selected = $(this).find(':selected');
          let kodeProduk = selected.val();
          let nama = selected.data('nama') || '';
          let harga = selected.data('harga') || 0;
          let row = $(this).closest('tr');

          let isDuplicate = false;
          $('.fk_product').not(this).each(function() {
              if ($(this).val() === kodeProduk) {
                  isDuplicate = true;
              }
          });

          if (isDuplicate) {
              Swal.fire({
                  title: "Produk Sudah Dipilih!",
                  text: "Produk ini sudah ada dalam daftar.",
                  icon: "warning",
                  confirmButtonText: "OK"
              });
              $(this).val('');
              row.find('.nm_product, .harga, .total_harga').val('');
              return;
          }

          row.find('.nm_product').val(nama);
          row.find('.harga').val(parseFloat(harga).toLocaleString('id-ID'));
          updateTotal(row);
      });

      $(document).on('input', '.qty', function() {
          let row = $(this).closest('tr');
          updateTotal(row);
      });

      function updateTotal(row) {
          let qty = parseFloat(row.find('.qty').val()) || 0;
          let harga = parseFloat(row.find('.harga').val().replace(/[^0-9]/g, '')) || 0;
          let total = qty * harga;
          row.find('.total_harga').val(total.toLocaleString('id-ID'));
          updateTotalKeseluruhan();
      }

      function updateTotalKeseluruhan() {
          let totalKeseluruhan = 0;
          $('.total_harga').each(function() {
              totalKeseluruhan += parseFloat($(this).val().replace(/[^0-9]/g, '')) || 0;
          });
          $('#totalKeseluruhan').text(totalKeseluruhan.toLocaleString('id-ID', {style: 'currency', currency: 'IDR'}));
      }

      $(document).on('click', '.removeDetail', function() {
          $(this).closest('tr').remove();
          updateTotalKeseluruhan();
      });

      $('#addPembelianModal').on('hidden.bs.modal', function () {
          $(this).find('form')[0].reset();
          $('#detailTable tbody').html('');
          $('#totalKeseluruhan').text('0');
      });
  });


</script>
