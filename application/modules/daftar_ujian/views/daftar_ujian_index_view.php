
<div class="row">
        <div class="col-md-12">
                <div class="card">
                        <div class="card-block">
                              <a href="#" class="title-content"><h5 class="m-b-10"><?php echo $title ?></h5></a>
                                <ul class="breadcrumb-title b-t-default p-t-10">
                                        <li class="breadcrumb-item">
                                                <a href="index.html"> <i class="fa fa-home"></i> </a>
                                        </li>
                                        <li class="breadcrumb-item"><a href="#!">Data</a>
                                        </li>
                                        <li class="breadcrumb-item"><a href="#!"><?php echo $title ?></a>
                                        </li>
                                </ul>
                        </div>
                </div>
        </div>
</div>

<div class="row">
        <div class="col-md-12">
                <div class="card">
                        <div class="card-body">
                                <!-- block -->
                                <div class="">
                                        <div class="table-toolbar">
                                                        <!-- <button class="btn btn-success" id="" onclick="siswa_data.importSiswa()">
                                                                <i class="mdi mdi-file-excel-box mdi-18px"></i>
                                                                Import Data Siswa
                                                        </button>                                                 -->
                                        </div>
                                        <br />

                                        <div class="table-toolbar">
                                                <input class="form-control" id="search" type="text" value="" placeholder="Pencarian" onkeyup="daftar_ujian_data.search(this, event)">
                                        </div>

                                        <br />
                                        <br />

                                        <div class="message">

                                        </div>
                                        <div class="data_siswa">
                                                <div class="sticky-table sticky-headers sticky-ltr-cells">
                                                        <table cellpadding="0" cellspacing="0" class="table table-bordered" id="example2">
                                                                <thead>
                                                                  <tr class="sticky-row">
                                                                    <th>No</th>
                                                                    <th>Mata Pelajaran</th>
                                                                    <th>Kode Ujian</th>
                                                                    <th>Nama Ujian</th>
                                                                    <th>Tanggal Ujian</th>
                                                                    <th>Waktu Ujian</th>
                                                                    <th>Guru Pengajar</th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                                                  <?php if (!empty($data_daftar_ujian)) { ?>
                                                                  <?php $no = 1; ?>
                                                                  <?php foreach ($data_daftar_ujian as $value) { ?>
                                                                    <tr class="odd gradeX">
                                                                    <td><?php echo $no++ ?></td>
                                                                    <td><?php echo $value['mata_pelajaran'] ?></td>
                                                                    <td class="center"><?php echo $value['kode_ujian'] ?></td>
                                                                    <td class="center"><?php echo $value['nama_ujian'] ?></td>           
                                                                    <td class="center"><?php echo date('d M Y', strtotime($value['tanggal_ujian'])) ?></td>
                                                                    <td class="center"><?php echo $value['waktu_ujian'] ?></td>
                                                                    <td class="center"><?php echo $value['guru'] ?></td>
                                                                    </tr>
                                                                  <?php } ?>
                                                                  <?php } else { ?>
                                                                  <tr>
                                                                    <td colspan="11">Tidak Ada Data Ditemukan</td>
                                                                  </tr>
                                                                  <?php } ?>
                                                                </tbody>
                                                        </table>
                                                </div>

                                                <div class="pagination">
                                                        <!-- <?php echo $pagination ?> -->
                                                </div>
                                        </div>
                                </div>
                        </div>
                </div>
        </div>
</div>