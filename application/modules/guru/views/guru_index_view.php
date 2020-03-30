<div class="row">
        <div class="col-md-12">
                <div class="card">
                        <div class="card-block">
                                <a href="<?php echo base_url().$module ?>" class="title-content"><h5 class="m-b-10"><?php echo $title ?></h5></a>
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
                                        <a href="<?php echo base_url() . $module . '/add' ?>"><button class="btn btn-success">Tambah <i class="icon-plus icon-white"></i></button></a>
                                        </div>
                                        <br />

                                        <div class="table-toolbar">
                                            <input class="form-control" id="search" type="text" value="" 
                                            placeholder="Pencarian" onkeyup="guru_data.search(this, event)">
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
                                                                  <th>Nama</th>
                                                                  <th>Nip</th>
                                                                  <th>Mata Pelajaran</th>
                                                                  <th>Password</th>
                                                                  <th>Action</th>
                                                                  </tr>
                                                                </thead>
                                                                <tbody>
                                                                  <?php if (!empty($data_guru)) { ?>
                                                                  <?php $no = $this->uri->segment(3) +1; ?>
                                                                  <?php foreach ($data_guru as $value) { ?>
                                                                    <tr class="odd gradeX">
                                                                    <td><?php echo $no++ ?></td>
                                                                    <td><?php echo $value['nama'] ?></td>
                                                                    <td><?php echo $value['nip'] ?></td>
                                                                    <td><?php echo $value['mata_pelajaran'] ?></td>
                                                                    <td class="center"><?php echo $value['password'] ?></td>
                                                                    <td class="center">
                                                                      <a href="<?php echo base_url() . $module . '/edit/' . $value['id'] ?>">
                                                                      <i class="icon-edit"></i>
                                                                      </a>                                                                
                                                                      <i class="icon-trash" onclick="guru_data.remove('<?php echo $value['id'] ?>')"></i>           
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
                                                <div class="pagination">
                                                        <?php echo $pagination ?>
                                                </div>
                                        </div>
                                </div>
                        </div>
                </div>
        </div>
</div>