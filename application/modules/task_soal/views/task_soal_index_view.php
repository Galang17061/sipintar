<input type="hidden" id="ujian" value="<?php echo $ujian ?>" id="" class="form-control" />

<div class="row">
 <div class="col-md-12">
  <div class="card">
   <div class="card-block">
    <h5 class="m-b-10"><a href="#" class="title-content"><?php echo 'Soal' ?></a></h5>
    <ul class="breadcrumb-title b-t-default p-t-10">
     <li class="breadcrumb-item">
      <a href="<?php echo base_url() . 'dashboard' ?>"> <i class="fa fa-home"></i> </a>
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
    <div class="muted pull-left">Data <?php echo 'Soal yang Harus Dikerjakan' ?></div>
    <!-- block -->
    <div class="">
     <div class="table-toolbar">
     </div>
     <br/>
     <hr />

     <div class="message">

     </div>
     <br>
     <div class="data_siswa">
      <div class="data">
       <div class="row">
        <div class="col-md-12 text-right">
         <a href="" class='btn btn-primary' onclick="task_soal_data.submitSoal(this, event)">Submit Pekerjaan</a>
        </div>
       </div>
       <br/>
       <div class="row">
        <div class="col-md-12">
         <div class="content_ujian">
          <?php if (!$siswa_is_submit && $is_exist_ujian && $is_start_ujian) { ?>

           <div id="wizard">
            <ul class="nav nav-tabs md-tabs tabs-left b-none" role="tablist">
             <?php $counter_kategori = 0; ?>
             <?php foreach ($data_soal_ujian as $v_jumlah) { ?>
              <?php $counter_kategori++ ?>
              <li class="nav-item">
               <a class="nav-link <?php echo $counter_kategori == 1 ? 'active' : '' ?>" href="#tab<?php echo $counter_kategori ?>" 
                  data-toggle="tab" role="tab">Soal No. <?php echo $counter_kategori ?></a>
               <div class="slide"></div>
              </li>
             <?php } ?>
            </ul>

            <div class="tab-content tabs-left-content card-block" >
             <?php $no_soal = 1; ?>
             <?php foreach ($data_soal_ujian as $v_data_ujian) { ?>
              <?php $data_soal = $data_soal_ujian; ?>
             <div class="tab-pane <?php echo $no_soal == 1 ? 'active' : '' ?>" id="tab<?php echo $no_soal ?>">         
               <?php foreach ($data_soal as $v_soal) { ?>
                <?php if ($v_soal['soal_id'] == $v_data_ujian['soal_id']) { ?>
                 <div class="row soal">
                  <div class="col-md-12" style="margin-top: 12px;">
                   <h5 style="font-size: 16px;font-weight: bold;">Soal No. <?php echo $no_soal++ ?></h5>
                  </div>                  
                 </div>         
                 <br/>

                 <div class="row">
                  <div class="col-md-12">
                   <?php echo $v_soal['soal'] ?>&nbsp;&nbsp;&nbsp;
                   <?php if ($v_soal['file_soal'] != '') { ?>
                    <?php if ($v_soal['jenis_file'] != 'listening') { ?>
                     <iframe src="<?php echo base_url() . 'files/soal/' . $v_soal['file_soal'] ?>" width="200" height="200"></iframe>&nbsp;&nbsp;&nbsp;
                    <?php } else { ?>
                     <button id="" class="btn btn-success" onclick="task_soal_data.playAudioListening(this,
                                     '<?php echo $v_data_ujian['ujian'] ?>', '<?php echo $v_soal['soal_id'] ?>')">Play Audio </button>
                     (<?php echo $v_soal['file_soal'] ?>)
                     <audio id="_audio">
                      <source src="<?php echo base_url() . 'files/soal/' . $v_soal['file_soal'] . '' ?>" type="audio/ogg">
                      Your browser does not support the audio element.
                     </audio>
                     <br/>
                    <?php } ?>
                   <?php } ?>
                  </div>
                 </div>
                 <br/>

                 <div class="row jawaban">
                  <div class="col-md-12">
                   <div class="row">
                    <div class="col-md-12">
                     <label class="" id="" style="color: #468847;font-size: 14px;">Pilihan Jawaban : </label>&nbsp;                     
                    </div>
                    <?php foreach ($v_soal['list_jawaban'] as $v_answer) { ?>
                     <div class="col-md-12" style="margin-left: 24px;">
                      <label>
                       <input type="radio" id="" name="<?php echo $v_soal['soal_id'] ?>" 
                              soal="<?php echo $v_soal['soal_id'] ?>" 
                              class="radio" 
                              <?php echo $v_answer['jawaban_siswa'] == true ? 'checked' : '' ?>
                              jawaban="<?php echo $v_answer['id'] ?>" 
                              is_true = "<?php echo $v_answer['true_or_false'] ?>"
                              onclick="task_soal_data.answer(this)" />
                       <span><?php echo $v_answer['jawaban'] == '' ? '-' : $v_answer['jawaban'] ?>&nbsp;&nbsp;&nbsp;
                        <?php if ($v_answer['file_jawaban'] != '') { ?>
                         <iframe src="<?php echo base_url() . 'files/jawaban/' . $v_answer['file_jawaban'] ?>" width="200" height="200"></iframe>&nbsp;&nbsp;&nbsp;
                        <?php } ?>
                       </span>
                      </label>
                     </div>                     
                    <?php } ?>                    
                   </div>
                  </div>
                 </div>
<!--                 <div class="row">
                  <div class="col-md-12 text-right">
                   <button id="" class="btn btn-success" 
                           onclick="task_soal_data.answeredSoal(this, 1)">Yakin</button>&nbsp;
                   <button id="" class="btn btn-warning"
                           onclick="task_soal_data.answeredSoal(this, 2)">Ragu</button>
                  </div>
                 </div>
                 <hr/>-->
                <?php } ?>
               <?php } ?>                                                                        
              </div>
             <?php } ?>
             <!--             <ul class="pager wizard">
                           <li class="previous first" style="display:none;"><a href="javascript:void(0);">First</a></li>
                           <li class="previous"><a href="javascript:void(0);">Sebelumnya</a></li>
                           <li class="next last" style="display:none;"><a href="javascript:void(0);">Terakhir</a></li>
                           <li class="next"><a href="javascript:void(0);">Selanjutnya</a></li>
                           <li class="next finish" style="display:none;"><a href="" onclick="task_soal_data.submitSoal(this, event)">Selesai</a></li>
                          </ul>-->
            </div>  
           </div>
          <?php } else { ?>
           <div class="">
            <div class="alert alert-success">
             <button type="button" class="close" data-dismiss="alert">&times;</button>
             <h4>Success</h4>
             Belum Ada Ujian Diadakan
            </div>
           </div>
          <?php } ?>
         </div>
        </div>
       </div>
      </div>        
     </div>

    </div>
   </div>
  </div>
 </div>
</div>
</div>