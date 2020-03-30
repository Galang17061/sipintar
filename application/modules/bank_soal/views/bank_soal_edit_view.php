<script src="<?php echo base_url() . 'assets/js/controllers/membuat_soal_v1.js' ?>"></script>
<div class="row-fluid">
 <div class='span12'>
  <div class='block'>
   <div class="navbar navbar-inner block-header">
    <div class="muted pull-left"><?php echo $title ?>
    </div>
   </div>


   <div class="block-content collapse in">
    <!--<form class="form-horizontal" style="">-->
    <div class='span12'>
     <div class="message">

     </div>
     <input type="hidden" id="id_soal" class="" value="<?php echo $soal_id ?>"/>
     <div class="control-group">
      <label class="control-label" for="focusedInput">Kategori Soal</label>
      <div class="controls">
       <select class="span6 m-wrap required" name="kategori_soal" id="kategori_soal" error="Kategori Soal">
        <option value="">Pilih Kategori Soal</option>
        <?php foreach ($list_kategori_soal as $value) { ?>
         <option value="<?php echo $value['id'] ?>" 
                 <?php echo isset($kategori_soal) ? $kategori_soal == $value['id'] ? 'selected' : '' : '' ?>>
                  <?php echo $value['kategori'] ?>
         </option>
        <?php } ?>
       </select>
      </div>
     </div>

     <div class="control-group">
      <label class="control-label" for="focusedInput">Soal</label>
      <div class="controls">
       <textarea class="required input-xlarge" id="soal" error="Soal"><?php echo $soal ?></textarea>
      </div>
     </div>

     <div class="control-group">
      <div class="controls">
       <input class="input-file soalUpload" id="soalFile" 
              type="file" onchange="upload_data.validationSize(this, 512000)">
              <?php if ($file_soal != '') { ?>
        &nbsp;<a href="#" onclick="bank_soal_data.showFileSoalBefore('<?php echo $file_soal ?>')">Lihat File Sebelumnya</a>
       <?php } ?>
      </div>
     </div>

     <!--Pilihan Ganda-->
     <?php //if ($kategori_ujian == 1) { ?>
     <div class="control-group">
      <label class="control-label" for="focusedInput">Jawaban A</label>
      <div class="controls">
<!--       <input class="input-xlarge focused required jawaban" id="jawaban" type="text" 
              value="<?php echo $jawaban[0]['jawaban'] ?>" 
              placeholder="Jawaban A" 
              jawaban_id="<?php echo $jawaban[0]['soal_has_jawaban_id'] ?>"
              error="Jawaban A" 
              name="answer_a">-->
       <textarea class="input-xlarge focused required jawaban" id="jawaban_a" error="Jawaban A" name="answer_a" jawaban_id="<?php echo $jawaban[0]['soal_has_jawaban_id'] ?>"><?php echo $jawaban[0]['jawaban'] ?></textarea>
      </div>
     </div>

     <div class="control-group">
      <div class="controls">
       <input class="input-file fileUpload" id="fileInput" 
              type="file" onchange="upload_data.validationSize(this, 512000)">
              <?php if ($jawaban[0]['file_jawaban'] != '') { ?>
        &nbsp;<a href="#" onclick="bank_soal_data.showFileAnswerBefore('<?php echo $jawaban[0]['file_jawaban'] ?>',
                  '<?php echo $jawaban[0]['soal_has_jawaban_id'] ?>')">Lihat File Sebelumnya</a>
                <?php } ?>
       &nbsp;
       <input type='radio' name='benar' id='answer_a' class='radio' 
              value='A' <?php echo $jawaban[0]['true_or_false'] == true ? 'checked' : '' ?>/>
       &nbsp;
       Benar
      </div>
     </div>

     <div class="control-group">
      <label class="control-label" for="focusedInput">Jawaban B</label>
      <div class="controls">
<!--       <input class="input-xlarge focused required jawaban" id="jawaban" type="text"                
              placeholder="Jawaban B" error="Jawaban B" 
              name="answer_b" 
              jawaban_id="<?php echo $jawaban[1]['soal_has_jawaban_id'] ?>"
              value="<?php echo $jawaban[1]['jawaban'] ?>">-->
       <textarea class="input-xlarge focused required jawaban" id="jawaban_b" error="Jawaban B" name="answer_b" jawaban_id="<?php echo $jawaban[1]['soal_has_jawaban_id'] ?>"><?php echo $jawaban[1]['jawaban'] ?></textarea>
      </div>
     </div>

     <div class="control-group">
      <div class="controls">
       <input class="input-file fileUpload" id="fileInput" 
              type="file" onchange="upload_data.validationSize(this, 512000)">
              <?php if ($jawaban[1]['file_jawaban'] != '') { ?>
        &nbsp;<a href="#" onclick="bank_soal_data.showFileAnswerBefore('<?php echo $jawaban[1]['file_jawaban'] ?>',
                  '<?php echo $jawaban[1]['soal_has_jawaban_id'] ?>')">Lihat File Sebelumnya</a>
                <?php } ?>
       &nbsp;
       <input type='radio' name='benar' 
              id='answer_b' class='radio' value='B'
              <?php echo $jawaban[1]['true_or_false'] == true ? 'checked' : '' ?>/>
       &nbsp;
       Benar
      </div>
     </div>

     <div class="control-group">
      <label class="control-label" for="focusedInput">Jawaban C</label>
      <div class="controls">
<!--       <input class="input-xlarge focused required jawaban" id="jawaban" type="text"                
              placeholder="Jawaban C" error="Jawaban C" 
              name="answer_c" 
              jawaban_id="<?php echo $jawaban[2]['soal_has_jawaban_id'] ?>"
              value="<?php echo $jawaban[2]['jawaban'] ?>">-->
       <textarea class="input-xlarge focused required jawaban" id="jawaban_c" error="Jawaban C" name="answer_c" jawaban_id="<?php echo $jawaban[2]['soal_has_jawaban_id'] ?>"><?php echo $jawaban[2]['jawaban'] ?></textarea>
      </div>
     </div>

     <div class="control-group">
      <div class="controls">
       <input class="input-file fileUpload" id="fileInput" type="file">
       <?php if ($jawaban[2]['file_jawaban'] != '') { ?>
        &nbsp;<a href="#" onclick="bank_soal_data.showFileAnswerBefore('<?php echo $jawaban[2]['file_jawaban'] ?>',
                  '<?php echo $jawaban[2]['soal_has_jawaban_id'] ?>')">Lihat File Sebelumnya</a>
                <?php } ?>
       &nbsp;
       <input type='radio' name='benar' 
              id='answer_c' class='radio' value='C'
              <?php echo $jawaban[2]['true_or_false'] == true ? 'checked' : '' ?>/>
       &nbsp;
       Benar
      </div>
     </div>

     <div class="control-group">
      <label class="control-label" for="focusedInput">Jawaban D</label>
      <div class="controls">
<!--       <input class="input-xlarge focused required jawaban" id="jawaban" type="text"
              placeholder="Jawaban D" 
              error="Jawaban D" name="answer_d" 
              jawaban_id="<?php echo $jawaban[3]['soal_has_jawaban_id'] ?>"
              value="<?php echo $jawaban[3]['jawaban'] ?>">        -->
       <textarea class="input-xlarge focused required jawaban" id="jawaban_d" error="Jawaban D" name="answer_d" jawaban_id="<?php echo $jawaban[3]['soal_has_jawaban_id'] ?>"><?php echo $jawaban[3]['jawaban'] ?></textarea>
      </div>
     </div>

     <div class="control-group">
      <div class="controls">
       <input class="input-file fileUpload" id="fileInput" type="file">
       <?php if ($jawaban[3]['file_jawaban'] != '') { ?>
        &nbsp;<a href="#" onclick="bank_soal_data.showFileAnswerBefore('<?php echo $jawaban[3]['file_jawaban'] ?>',
                  '<?php echo $jawaban[3]['soal_has_jawaban_id'] ?>')">Lihat File Sebelumnya</a>
                <?php } ?>
       &nbsp;
       <input type='radio' name='benar' id='answer_d' 
              class='radio' value='D'
              <?php echo $jawaban[3]['true_or_false'] == true ? 'checked' : '' ?>/>
       &nbsp;
       Benar
      </div>
     </div>

     <div class="control-group">
      <label class="control-label" for="focusedInput">Jawaban E</label>
      <div class="controls">
<!--       <input class="input-xlarge focused required jawaban" id="jawaban" type="text"
              placeholder="Jawaban E" 
              error="Jawaban E" name="answer_e" 
              jawaban_id="<?php echo $jawaban[4]['soal_has_jawaban_id'] ?>"
              value="<?php echo $jawaban[4]['jawaban'] ?>">        -->
       <textarea class="input-xlarge focused required jawaban" id="jawaban_e" error="Jawaban E" name="answer_e" jawaban_id="<?php echo $jawaban[4]['soal_has_jawaban_id'] ?>"><?php echo $jawaban[4]['jawaban'] ?></textarea>
      </div>
     </div>

     <div class="control-group">
      <div class="controls">
       <input class="input-file fileUpload" id="fileInput" type="file">
       <?php if ($jawaban[4]['file_jawaban'] != '') { ?>
        &nbsp;<a href="#" onclick="bank_soal_data.showFileAnswerBefore('<?php echo $jawaban[4]['file_jawaban'] ?>',
                  '<?php echo $jawaban[4]['soal_has_jawaban_id'] ?>')">Lihat File Sebelumnya</a>
                <?php } ?>
       &nbsp;
       <input type='radio' name='benar' 
              id='answer_e' class='radio' value='E'
              <?php echo $jawaban[4]['true_or_false'] == true ? 'checked' : '' ?>/>
       &nbsp;
       Benar
      </div>
     </div>

     <div class="form-actions">
      <button type="button" class="btn btn-primary" onclick="bank_soal_data.editSoal()">Simpan</button>
      <button type="button" class="btn btn-warning" onclick="bank_soal_data.ambilSimbol()">Ambil Simbol Matematika</button>
      <button type="button" onclick="message.closeDialog()" class="btn">Tutup</button></a>
     </div>     
    </div>
   </div>
  </div>
 </div> 
</div>