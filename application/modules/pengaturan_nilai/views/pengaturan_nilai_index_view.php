<div class="row">
        <div class="col-md-12">
                <div class="card">
                        <div class="card-block">
                                <h5 class="m-b-10"><?php echo $title ?></h5>
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
                                                        </button>
                                                <a style="margin-left: 12px;" href="<?php echo base_url() . $module . '/add' ?>"><button class="btn btn-primary">Tambah <i class="icon-plus icon-white"></i></button></a> -->
                                        </div>
                                        <br />

                                        <div class="table-toolbar">
                                                <!-- <input class="form-control" id="search" type="text" value="" placeholder="Pencarian" onkeyup="siswa_data.search(this, event)"> -->
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
                                                                    <th>Status</th>
                                                                    <th>Action</th>
                                                                  </tr>
                                                                </thead>
                                                                <tbody>
                                                                  <?php if (!empty($data_pengaturan_nilai)) { ?>
                                                                    <?php $no = 1; ?>
                                                                    <?php foreach ($data_pengaturan_nilai as $value) { ?>
                                                                      <tr class="odd gradeX">
                                                                      <td><?php echo $no++ ?></td>
                                                                      <td id="nilai_status">Nilai <?php echo $value['show'] == true ? 'Ditampilkan' : 'Tidak Ditampilkan' ?></td>
                                                                      <td class="center">
                                                                        <button id="" 
                                                                                onclick="pengaturan_nilai_data.tampilkan(this, '<?php echo $value['id'] ?>')" class="btn btn-warning">
                                                                        Tampilkan
                                                                        </button>
                                                                        
                                                                        <button id="" 
                                                                                onclick="pengaturan_nilai_data.tidakTampilkan(this, '<?php echo $value['id'] ?>')"
                                                                                class="btn btn-danger">
                                                                        Jangan Tampilkan
                                                                        </button>
                                                                      </td>
                                                                      </tr>
                                                                    <?php } ?>
                                                                    <?php } else { ?>
                                                                    <tr>
                                                                      <td colspan="6">Tidak Ada Data Ditemukan</td>
                                                                    </tr>
                                                                    <?php } ?>
                                                                </tbody>
                                                        </table>
                                                </div>

                                                <!-- <div class="pagination">
                                                        <?php echo $pagination ?>
                                                </div> -->
                                        </div>
                                </div>
                        </div>
                </div>
        </div>
</div>