<script src="<?php echo base_url() ?>assets/js/controllers/membuat_soal.js"></script>
<div class='row-fluid'>
 <div class='block'>
  <div class="navbar navbar-inner block-header">
   <div class="muted pull-left">Upload Soal</div>
  </div>
  <div class="block-content collapse in">
   <div class='span12'>    
    <form class="form-horizontal" style="">
     <div class='span12'>

      <div class="message">

      </div>

      <div class="control-group content_upload">
       <label class="control-label" for="focusedInput">Upload File Soal *csv</label>
       <div class="controls">
        <input class="input-file soalUpload" id="soalFile" 
               data_file=""
               type="file" onchange="bank_soal_data.getUploadedData(this)">
        &nbsp;<p class='loading_data'></p>
       </div>
      </div>
      
<!--      <div class="form-actions">
       <button type="button" class="btn btn-primary" onclick="bank_soal_data.execUploadFileSoal()">Simpan</button>       
      </div>     -->
     </div>    
    </form>
   </div>
  </div>
 </div>
</div>