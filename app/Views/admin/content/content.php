<link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/dataTables.bootstrap5.min.css">

<div class="page-heading">
    <h3>Sipemas Statistics</h3>
</div>
<div class="page-content">
    <section class="row">
        <div class="col-12 col-lg-9">
            <div class="row">
                <div class="col-6 col-lg-3 col-md-6">
                    <div class="card">
                        <div class="card-body px-4 py-4-5">
                            <div class="row">
                                <div class="col-md-4 col-lg-12 col-xl-12 col-xxl-5 d-flex justify-content-start ">
                              
                                    <button class="btn btn-primary iconly-boldShow stats-icon purple mb-2 downloadLaporan"></button>
                                </div>
                                <div class="col-md-8 col-lg-12 col-xl-12 col-xxl-7">
                                    <h6 class="text-muted font-semibold">Laporan</h6>
                                    <h6 class="font-extrabold mb-0"><span id="laporanCount"></span></h6>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-6 col-lg-3 col-md-6">
                    <div class="card">
                        <div class="card-body px-4 py-4-5" >
                            <div class="row">
                                <div class="col-md-4 col-lg-12 col-xl-12 col-xxl-5 d-flex justify-content-start ">
                                        <button class="btn btn-primary iconly-boldProfile stats-icon blue mb-2 buttonAdmin" ></button>
                                        
                                </div>

                                <div class="col-md-8 col-lg-12 col-xl-12 col-xxl-7">
                                    <h6 class="text-muted font-semibold">Admin</h6>
                                    <h6 class="font-extrabold mb-0"><span id="adminCount"></h6>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-6 col-lg-3 col-md-6">
                        <div class="card">
                            <div class="card-body px-4 py-4-5">
                                <div class="row">
                                    <div class="col-md-4 col-lg-12 col-xl-12 col-xxl-5 d-flex justify-content-start ">
                                        
                                            <button class="btn btn-primary iconly-boldAdd-User stats-icon green mb-2 buttonUser"></button>

                                    </div>
                                    <div class="col-md-8 col-lg-12 col-xl-12 col-xxl-7">
                                        <h6 class="text-muted font-semibold">User</h6>
                                        <h6 class="font-extrabold mb-0"><span id="userCount"></h6>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-6 col-lg-3 col-md-6">
                            <div class="card">
                                <div class="card-body px-4 py-4-5">
                                    <div class="row">
                                        <div class="col-md-4 col-lg-12 col-xl-12 col-xxl-5 d-flex justify-content-start ">
                                          
                                            <button class="btn btn-primary iconly-boldBookmark stats-icon red mb-2 buttonContent" ></button>
                                        </div>
                                        <div class="col-md-8 col-lg-12 col-xl-12 col-xxl-7">
                                            <h6 class="text-muted font-semibold">Content</h6>
                                            <h6 class="font-extrabold mb-0"><span id="contentCount"></h6>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <div class="card">
                                    <div class="card-header">
                                        <h4>Laporan Pengaduan tahun <?=date('Y')?></h4>
                                    </div>
                                    <div class="card-body">
                                        <div id="chart-profile-visit"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                    </div>
                    <div class="col-12 col-lg-3">
                        <div class="card">
                            <div class="card-body py-4 px-4">
                                <div class="d-flex align-items-center">
                                    <div class="avatar avatar-xl">
                                        <img src="<?=base_url('assets/adm')?>/assets/images/faces/1.jpg" alt="Face 1">
                                    </div>
                                    <div class="ms-3 name">
                                        <h5 class="font-bold"><?php echo $_SESSION['auth']['nama_depan'].' '.$_SESSION['auth']['nama_belakang']?></h5>
                                        <h6 class="text-muted mb-0"><?=$_SESSION['auth']['email']?></h6>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card">
                            <div class="card-header">
                                <h4>Rating Aduan</h4>
                            </div>
                            <div class="card-body">
                                <div id="chart-visitors-profile"></div>
                            </div>
                        </div>
                        
                    </div>
                    <div class="col-12 col-lg-12">
                       <div class="row">

                        <div class="col-12 col-xl-12">
                            <div class="card">
                                <div class="card-header">
                                    <h4>Daftar Pengaduan Belum Dibaca</h4>
                                </div>
                                <div class="card-body">
                                    <button class="btn btn-primary sudahDibaca">Laporan Sudah Dibaca</button>
                                    <button class="btn btn-success sudahDibalas">Laporan Sudah Dibalas</button>
                                    <div class="table-responsive">
                                        <table id="laporanTable" class="table table-hover table-lg">
                                            <thead>
                                                <tr>
                                                    <th>ID Laporan</th>
                                                    <th>Nama</th>
                                                    <th>Jenis Layanan</th>
                                                    <th>Sub Layanan</th>
                                                    <th>Action</th>
                                                    <!-- tambahkan kolom lain sesuai kebutuhan -->
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <!-- data Laporan akan ditampilkan di sini -->
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
        <!-- modal -->
        <!-- Button trigger modal -->


        <!-- Modal -->
        <div class="modal fade" id="modalDibaca" data-bs-focus="false" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
          <div class="modal-dialog modal-xl">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Tabel Laporan Sudah Dibaca</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="table-responsive">
                    <table id="laporanTableDibaca" class="table table-hover table-lg">
                        <thead>
                            <tr>
                                <th>ID Laporan</th>
                                <th>Nama</th>
                                <th>Jenis Layanan</th>
                                <th>Sub Layanan</th>
                                <th>Action</th>
                                <!-- tambahkan kolom lain sesuai kebutuhan -->
                            </tr>
                        </thead>
                        <tbody>
                            <!-- data Laporan akan ditampilkan di sini -->
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="modal-footer">
                Catatan:
            </div>
        </div>
    </div>
</div>
<!-- Button trigger modal -->


<!-- Modal -->
<div class="modal fade" id="modalDibalas" data-bs-focus="false" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-xl">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Tabel Laporan Sudah Dibalas</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
    </div>
    <div class="modal-body">
        <div class="table-responsive">
            <table id="laporanTableDibalas" class="table table-hover table-lg">
                <thead>
                    <tr>
                        <th>ID Laporan</th>
                        <th>Nama</th>
                        <th>Jenis Layanan</th>
                        <th>Sub Layanan</th>
                        <th>Action</th>
                        <!-- tambahkan kolom lain sesuai kebutuhan -->
                    </tr>
                </thead>
                <tbody>
                    <!-- data Laporan akan ditampilkan di sini -->
                </tbody>
            </table>
        </div>
    </div>
    <div class="modal-footer">
        Catatan:
    </div>
</div>
</div>
</div>
<!-- Modal -->
<div class="modal fade" id="modalAdmin" data-bs-focus="false" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-xl">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Tabel Administrator</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
    </div>
    <div class="modal-body">
        <div>
        <button class="btn btn-success tambahAdmin">Tambah</button>
        </div>

        <div class="table-responsive">
            <table id="tableAdmin" class="table table-hover table-lg">
                <thead>
                    <tr>
                        <th>Nama</th>
                        <th>Email</th>
                        <th>Level</th>
                        <th>Status</th>
                        <th>Action</th>
                        <!-- tambahkan kolom lain sesuai kebutuhan -->
                    </tr>
                </thead>
                <tbody>
                    <!-- data Laporan akan ditampilkan di sini -->
                </tbody>
            </table>
        </div>
    </div>
    <div class="modal-footer">
        Catatan:
    </div>
</div>
</div>
</div>
<div class="modal fade" id="modalUser" data-bs-focus="false" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-xl">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Tabel User</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
    </div>
    <div class="modal-body">
        <div>
        </div>

        <div class="table-responsive">
            <table id="tableUser" class="table table-hover table-lg">
                <thead>
                    <tr>
                        <th>Nama</th>
                        <th>Email</th>
                        <th>Action</th>
                        <!-- tambahkan kolom lain sesuai kebutuhan -->
                    </tr>
                </thead>
                <tbody>
                    <!-- data Laporan akan ditampilkan di sini -->
                </tbody>
            </table>
        </div>
    </div>
    <div class="modal-footer">
        Catatan:
    </div>
</div>
</div>
</div>
<!-- modal -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.0/jquery.min.js" integrity="sha512-3gJwYpMe3QewGELv8k/BX9vcqhryRdzRMxVfq6ngyWXwo03GFEzjsUm8Q7RZcHPHksttq7/GFoxjCVUjkjvPdw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
<script src="<?=base_url('assets/adm')?>/assets/extensions/apexcharts/apexcharts.min.js"></script>
<script src="https://cdn.datatables.net/1.13.4/js/dataTables.bootstrap5.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="<?=base_url('assets/adm')?>/assets/js/pages/dashboard.js"></script>
