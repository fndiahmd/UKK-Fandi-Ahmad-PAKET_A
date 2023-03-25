<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>Pengaduan Masyarakat</title>
        <link rel="icon" type="image/x-icon" href="<?= base_url() ?>assets/favicon.io" />
        <!-- Core theme CSS (includes Bootstrap)-->
        <link href="<?= base_url() ?>assets/css/styles.css" rel="stylesheet" />
    </head>
        <style>
            .pagination {
                display: flex;
                padding: 1em 0;
            }

            .pagination a,
            .pagination strong {
                border: 1px solid silver;
                border-radius: 8px;
                color: black;
                padding: 0.5em;
                margin-right: 0.5em;
                text-decoration: none;
            }

            .pagination a:hover,
            .pagination strong {
                border: 1px solid #008cba;
                background-color: #008cba;
                color: white;
            }
        </style>
    <body id="page-top">
        <!-- Navigation-->
        <nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top" id="mainNav">
            <div class="container px-4">
                <a class="navbar-brand" href="#page-top"></a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation"><span class="navbar-toggler-icon"></span></button>
                <div class="collapse navbar-collapse" id="navbarResponsive">
                    <ul class="navbar-nav ms-auto">
                        <li class="nav-item"><a class="nav-link" href="#laporan">Laporan dan Tanggapan</a></li>
                        <li class="nav-item"><a class="nav-link" href="#jumlah_laporan">Jumlah Laporan</a></li>
                        <li class="nav-item"><a class="nav-link" href="#tatacarapengaduan">Tata Cara Pengaduan</a></li>
                    </ul>
                </div>
            </div>
        </nav>
        <!-- Header-->
        <header class="bg-primary bg-gradient text-white">
            <div class="container px-4 text-center">
                <h1 class="fw-bolder">Selamat Datang di</h1>
                <p class="lead">Website Pengaduan Masyarakat Cisarua</p>
                <a class="btn btn-lg btn-light" href="<?= base_url('Auth/LoginController') ?>">LOGIN</a>
                <a class="btn btn-lg btn-light" href="<?= base_url('Auth/RegisterController') ?>">REGISTER</a>
            </div>
        </header>
        <!-- About section-->
        <section id="laporan">
            <div class="container px-4">
                <div class="row gx-4 justify-content-center">
                    <div class="col-lg-8">
                        <h2>Laporan dan Tanggapan</h2>
                        <div class="col-md-8">
                            <div class="card-body">
                                <?php foreach ($laporan as $l) :?>
                                <h5 class="card-title">Laporan : <span class="text-dark"><?= $l['isi_laporan'] ?></h5>

                                <p class="card-text"> Status :
                                    <?php
                                    if ($l['status'] == '0') :
                                        echo '<span class="badge badge-secondary">Sedang di verifikasi</span>';
                                    elseif ($l['status'] == 'proses') :
                                        echo '<span class="badge badge-primary">Sedang di proses</span>';
                                    elseif ($l['status'] == 'selesai') :
                                        echo '<span class="badge badge-success">Selesai di kerjakan</span>';
                                    elseif ($l['status'] == 'tolak') :
                                        echo '<span class="badge badge-danger">Pengaduan di tolak</span>';
                                    else :
                                        echo '-';
                                    endif;
                                    ?>
                                </p>

                                <p class="card-text">Tanggapan : <span class="text-success"><?= $l['tanggapan'] ?></span></p>

                                <p class="card-text">Tgl Pengaduan : <span class="text-danger"><?= $l['tgl_pengaduan'] ?></span></p>
                                <p class="card-text">Tgl Tanggapan : <span class="text-danger"><?= $l['tgl_tanggapan'] ?></span></p>
                                <br>
                                <?php endforeach; ?>

                                <?php 
                                echo $this->pagination->create_links();
                                ?>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- Services section-->
        <section class="bg-light" id="jumlah_laporan">
            <div class="container px-4">
                <div class="row gx-4 justify-content-center">
                    <div class="col-lg-8">
                        <h2>Jumlah Laporan</h2>
                        <p class="lead">Jumlah laporan dan tanggapan saat ini:</p>
                        <div class="col-lg-8">
                            <div class="row">

                                <div class="col-lg-4">
                                    <h4>Laporan</h4><br>
                                    <h2><?= number_format($pengaduan) ?></h2>
                                </div>
                                <div class="col-lg-4">
                                    <h4>Tanggapan</h4><br>
                                    <h2><?= number_format($tanggapan) ?></h2>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- Contact section-->
        <section id="tatacarapengaduan">
            <div class="container px-4">
                <div class="row gx-4 justify-content-center">
                    <div class="col-lg-8">
                        <h2>Tata Cara Pengaduan</h2>
                        <p class="lead">Silakan Register terlebih dahulu jika belum memiliki akun</p>
                        <ul>
                            <li>Login kedalam website</li>
                            <li>Klik Pengaduan</li>
                            <li>Kemudian klik Tulis Pengaduan</li>
                            <li>Tulis pengaduan yang ingin anda laporkan dan klik submit</li>
                        </ul>
                    </div>
                </div>
            </div>
        </section>
        <!-- Footer-->
        <footer class="py-5 bg-dark">
            <div class="container px-4"><p class="m-0 text-center text-white">Copyright &copy; 2023</p></div>
        </footer>
        <!-- Bootstrap core JS-->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
        <!-- Core theme JS-->
        <script src="<?= base_url() ?>assets/js/scripts.js"></script>
    </body>
</html>
