<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
  <title>SIAKAD - Tagihan</title>
  <?php include '../app/Views/others/layouts/header.php'; ?>

<body>
  <div id="app">
    <!-- <div class="main-wrapper main-wrapper-1"> -->

    <!-- navbar -->
    <?php include '../app/Views/others/layouts/topbar.php'; ?>

    <!-- sidbar -->
    <?php include '../app/Views/others/layouts/sidebar.php'; ?>

    <!-- Main Content -->
    <div class="main-content">
      <section class="section">
        <div class="section-header">
          <h1>Penerbitan Data Tagihan</h1>
          <div class="section-header-breadcrumb">
            <div class="breadcrumb-item active"><a href="#">Dashboard</a></div>
            <div class="breadcrumb-item"><a href="/admin/siakad/invoice">Invoice</a></div>
            <div class="breadcrumb-item">Selected</div>
          </div>
        </div>

        <div class="section-body">
          <div class="row">
            <div class="col-12 col-md-12 col-lg-12">
              <div class="card">
                <div class="card-header">
                  <h4>Tagihan Mahasiswa - Fakultas <?= $dataSelected[0]->nama_fakultas ?></h4>
                  <div class="card-header-action">
                    <!--
                    <a class="btn btn-primary" id="btn-add">
                      <i class="fas fa-plus text-white"></i>
                    </a>
				  -->
                  </div>
                </div>
                <div class="card-body">
                  <ul class="nav nav-tabs" id="myTab3" role="tablist">
                    <?php foreach ($dataSelected as $index => $item): ?>
                      <li class="nav-item">
                        <a class="nav-link <?= $index == 0 ? 'active' : '' ?>"
                          id="tab-<?= $item->ID ?>"
                          data-toggle="tab"
                          href="#tab-content-<?= $item->ID ?>"
                          role="tab"
                          aria-controls="tab-content-<?= $item->ID ?>"
                          aria-selected="<?= $index == 0 ? 'true' : 'false' ?>">
                          <?= $item->deskripsi ?>
                        </a>
                      </li>
                    <?php endforeach; ?>
                  </ul>

                  <div class="tab-content" id="myTabContent2">
                    <?php foreach ($dataSelected as $index => $item): ?>
                      <div class="tab-pane fade <?= $index == 0 ? 'show active' : '' ?>"
                        id="tab-content-<?= $item->ID ?>"
                        role="tabpanel"
                        aria-labelledby="tab-<?= $item->ID ?>">
                        <div class="card">
                          <div class="card-body">
                            <div class="table-responsive">
                              <table class="table table-hover">
                                <thead>
                                  <tr>
                                    <th scope="col">
                                      <input type="checkbox" id="select-all-<?= $item->ID ?>" class="select-all-checkbox">
                                    </th>
                                    <th scope="col">No</th>
                                    <th scope="col">NIM</th>
                                    <th scope="col">Nama Mahasiswa</th>
                                    <th scope="col">Prodi</th>
                                    <th scope="col">Angkatan</th>
                                    <th scope="col">Periode</th>
                                    <th scope="col">Nominal</th>
                                  </tr>
                                </thead>
                                <tbody>
                                  <?php
                                  $counter = 1; // Menggunakan variabel untuk nomor urut
                                  foreach ($data as $value) :
                                    // Memastikan data yang ditampilkan sesuai dengan prodi pada tab yang aktif
                                    if ($value->prodi_name == $item->deskripsi) :
                                  ?>
                                      <tr>
                                        <td>
                                          <input type="checkbox" class="row-checkbox-<?= $item->ID ?>"
                                            id="checkbox-<?= $item->ID ?>"
                                            data-unique="<?= $value->Nim ?>-<?= $item->periode ?>"
                                            value='<?= json_encode([
                                                      "nim" => $value->Nim,
                                                      "nama" => $value->NamaLengkap,
                                                      "prodi" => $value->prodi_name,
                                                      "angkatan" => $value->angkatan,
                                                      "periode" => $value->periode,
                                                      "nominal" => $value->nominal
                                                    ], JSON_HEX_APOS | JSON_HEX_QUOT) ?>'>
                                        </td>
                                        <th scope="row"><?= $counter++ ?></th>
                                        <td><?= $value->Nim ?></td>
                                        <td><?= $value->NamaLengkap ?></td>
                                        <td><?= $value->prodi_name ?></td>
                                        <td><?= $value->angkatan ?></td>
                                        <td><?= $value->periode ?></td>
                                        <td><?= 'Rp. ' . number_format($value->nominal ?? 0, 0, ',', '.') ?></td>
                                      </tr>
                                  <?php
                                    endif;
                                  endforeach;
                                  ?>
                                </tbody>
                              </table>
                            </div>
                            <button class="btn btn-primary mt-3" onclick="getSelectedData(this, '<?= $item->ID ?>')">Proses Data</button>

                          </div>
                        </div>
                      </div>
                    <?php endforeach; ?>
                  </div>
                </div>


              </div>
            </div>
          </div>
        </div>
    </div>
    </section>


    <?php include '../app/Views/others/layouts/footer.php'; ?>

    <script>
      const selectedDataStorage = {};

      function updateSelectedData(tabId, data, isSelected) {
        if (isSelected) {
          if (!selectedDataStorage[tabId]) {
            selectedDataStorage[tabId] = new Set();
          }
          selectedDataStorage[tabId].add(data);
        } else {
          selectedDataStorage[tabId]?.delete(data);
        }
      }

      function getSelectedData(button, tabId) {
        try {
          const selectedData = Array.from(selectedDataStorage[tabId] || []).map(item => JSON.parse(item));
          if (selectedData.length === 0) {
            Swal.fire({
              icon: 'warning',
              title: 'Tidak Ada Data',
              text: 'Silakan pilih data terlebih dahulu!',
            });
            return;
          }
          Swal.fire({
            title: 'Konfirmasi Proses',
            text: `Anda akan memproses ${selectedData.length} data. Lanjutkan?`,
            icon: 'question',
            showCancelButton: true,
            confirmButtonText: 'Ya, Proses',
            cancelButtonText: 'Batal',
          }).then((result) => {
            if (result.isConfirmed) {
              button.disabled = true;
              Swal.fire({
                title: 'Sedang diproses...',
                text: 'Mohon tunggu beberapa saat.',
                allowOutsideClick: false,
                didOpen: () => {
                  Swal.showLoading();
                },
              });

              fetch('/admin/siakad/invoice-find/proses', {
                  method: 'POST',
                  headers: {
                    'Content-Type': 'application/json',
                  },
                  body: JSON.stringify(selectedData),
                })
                .then((response) => response.json())
                .then((data) => {
                  Swal.close();
                  button.disabled = false;
                  Swal.fire({
                    icon: 'success',
                    title: 'Berhasil',
                    text: 'Data berhasil diproses!',
                    timer: 3000,
                    timerProgressBar: true,
                    showConfirmButton: false,
                    customClass: {
                      timerProgressBar: 'custom-progress-bar',
                    },
                  });
                  const style = document.createElement('style');
                  style.innerHTML = `
                    .swal2-timer-progress-bar.custom-progress-bar {
                      background-color:rgb(0, 255, 8) !important;
                    }
                  `;
                  document.head.appendChild(style);
                })
                .catch((error) => {
                  console.error('Error:', error);
                  Swal.close();
                  button.disabled = false;
                  Swal.fire({
                    icon: 'error',
                    title: 'Gagal',
                    text: 'Terjadi kesalahan saat memproses data.',
                  });
                });
            }
          });
        } catch (error) {
          console.error('Error parsing selected data:', error);
          Swal.fire({
            icon: 'error',
            title: 'Kesalahan',
            text: 'Terjadi kesalahan saat membaca data.',
          });
        }
      }


      document.addEventListener("DOMContentLoaded", function() {
        const selectedDataStorage = {};
        <?php foreach ($dataSelected as $item): ?>
            (function() {
              const selectAllCheckbox = document.querySelector("#select-all-<?= $item->ID ?>");
              const rowCheckboxes = document.querySelectorAll(".row-checkbox-<?= $item->ID ?>");
              if (selectAllCheckbox) {
                selectAllCheckbox.checked = false;
              }
              selectedDataStorage["<?= $item->ID ?>"] = new Set();
              const loadCheckboxStatus = () => {
                rowCheckboxes.forEach((checkbox) => {
                  const uniqueKey = checkbox.dataset.unique;
                  const isChecked = localStorage.getItem(uniqueKey) === "true";
                  checkbox.checked = isChecked;

                  if (isChecked) {
                    selectedDataStorage["<?= $item->ID ?>"].add(checkbox.value);
                  }
                });
              };
              const saveCheckboxStatus = (checkbox) => {
                const uniqueKey = checkbox.dataset.unique;
                localStorage.setItem(uniqueKey, checkbox.checked);
              };
              selectAllCheckbox?.addEventListener("change", function() {
                const isChecked = this.checked;
                rowCheckboxes.forEach(checkbox => {
                  checkbox.checked = isChecked;
                  saveCheckboxStatus(checkbox);
                  updateSelectedData("<?= $item->ID ?>", checkbox.value, isChecked);
                });
              });
              rowCheckboxes.forEach(checkbox => {
                checkbox.addEventListener("change", function() {
                  saveCheckboxStatus(this);
                  updateSelectedData("<?= $item->ID ?>", this.value, this.checked);
                  if (!this.checked) {
                    selectAllCheckbox.checked = false;
                  } else if (Array.from(rowCheckboxes).every(cb => cb.checked)) {
                    selectAllCheckbox.checked = true;
                  }
                });
              });
              loadCheckboxStatus();
            })();
        <?php endforeach; ?>
      });
    </script>



    <script>
      $(document).ready(function() {
        $('.table').DataTable({
          "paging": true,
          "searching": true,
          "ordering": true,
          "info": true,
          "pageLength": 25 // Set jumlah record per halaman
        });
      });
    </script>

</body>

</html>