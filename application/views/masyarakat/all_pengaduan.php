<!-- Begin Page Content -->
<div class="container-fluid">
    
    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800"><?= $title; ?></h1>

    <?= $this->session->flashdata('msg_all_pengaduan'); ?>

    <div class="table-responsive">
        <table class="table">
            <thead class="thead-dark">
                <tr>
                    <th scope="col">No</th>
                    <!-- <th scope="col">Nama</th> -->
                    <th scope="col">Isi Laporan</th>
                    <th scope="col">Tgl Melapor</th>
                    <th scope="col">Foto</th>
                    <th scope="col">Status</th>
                    <th scope="col">Lihat Detail</th>
                </tr>
            </thead>
            <tbody>
                <?php $no = 1; ?>
                <?php foreach ($data_spengaduan as $dsp) : ?>
                    <tr>
                        <th scope="row"><?= $no++; ?></th>
                        <!-- <td><?= $dsp['nama']; ?></td> -->
                        <td><?= $dsp['isi_laporan']; ?></td>
                        <td><?= $dsp['tgl_pengaduan']; ?></td>
                        <td>
                            <img width="100" src="<?= base_url() ?>assets/uploads/<?= $dsp['foto']; ?>" alt="">
                        </td>
                        <td>


                            <?php
                            if ($dsp['status'] == '0') {
                                echo '<span class="badge badge-secondary">Sedang di verifikasi</span>';
                            } elseif ($dsp['status'] == 'proses') {
                                echo '<span class="badge badge-primary">Sedang di proses</span>';
                            } elseif ($dsp['status'] == 'selesai') {
                                echo '<span class="badge badge-success">Selesai</span>';
                            } elseif ($dsp['status'] == 'tolak') {
                                echo '<span class="badge badge-danger">Pengaduan ditolak</span>';
                            } else {
                                echo '-';
                            }
                            ?>
                        </td>

                        <td class="text-center">
                            <a href="<?= base_url('Masyarakat/PengaduanController/all_pengaduan_detail/' . $dsp['id_pengaduan']) ?>" class="btn btn-success"><i class="fas fa-fw fa-eye"></i></a>
                        </td>

                      


                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

</div>
<!-- /.container-fluid -->