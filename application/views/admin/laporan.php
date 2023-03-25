<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800"><?= $title; ?></h1>

    <?= validation_errors('<div class="alert alert-danger alert-dismissible fade show" role="alert">', '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
  </div>') ?>
    <!-- <?= $this->session->flashdata('msg'); ?> -->


    <!-- Page Heading -->

    <div class="table-responsive">
        <table class="table">
            <thead class="thead-dark">
                <tr>
                    <th scope="col">No</th>
                    <th scope="col">Nama</th>
                    <th scope="col">NIK</th>
                    <th scope="col">Laporan</th>
                    <th scope="col">TGL P</th>
                    <th scope="col">Status</th>
                    <th scope="col">Tanggapan</th>
                    <th scope="col">TGL T</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $no = 1;
                foreach ($data_pengaduan as $l) :
                ?>
                    <tr>
                        <th scope="row"><?= $no++; ?></th>
                        <td><?= $l['nama']; ?></td>
                        <td><?= $l['nik']; ?></td>
                        <td><?= $l['isi_laporan']; ?></td>
                        <td><?= $l['tgl_pengaduan']; ?></td>
                        <td>
                            <?php
                            if ($l['status'] == '0') {
                                echo '<span class="badge badge-secondary">Sedang di verifikasi</span>';
                            } elseif ($l['status'] == 'proses') {
                                echo '<span class="badge badge-primary">Sedang di proses</span>';
                            } elseif ($l['status'] == 'selesai') {
                                echo '<span class="badge badge-success">Selesai dikerjakan</span>';
                            } elseif ($l['status'] == 'tolak') {
                                echo '<span class="badge badge-danger">Pengaduan Ditolak</span>';
                            } else {
                                echo '-';
                            }
                            ?>
                        </td>
                        <td><?= $l['tanggapan'] == NULL ? '-' : $l['tanggapan']; ?></td>
                        <td><?= $l['tgl_tanggapan'] == NULL ? '-' : $l['tgl_tanggapan']; ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <a target="_blank" href="<?= base_url('Admin/LaporanController/generate_laporan') ?>" class="btn btn-primary mt-2">Download</a>

    <!-- <?= $dp['status']; ?> -->
    <!-- /.container-fluid -->
</div>