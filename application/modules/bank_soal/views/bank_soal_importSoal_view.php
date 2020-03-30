<script src="<?php echo base_url() ?>assets/js/controllers/membuat_soal_v1.js"></script>
<div class='row'>
 <div class='block'>
<!--  <div class="navbar navbar-inner block-header">
   <div class="muted pull-left">Upload Soal</div>
  </div>-->
  <!-- <div class="block-content collapse in"> -->
  <div class='col-md-12'>    
   <form class="form-horizontal" style="">
    <div class='col-md-12'>

     <div class="message">

     </div>

      <div class="control-group">
       <label class="control-label" for="focusedInput">Upload File Soal *csv</label>
       <div class="controls">
              <!--        <input class="input-file soalUpload" id="soalFile" 
type="file" onchange="siswa_data.getUploadedData(this)">-->
        <div class="file-field input-field">
         <div class="">
                <!-- <span>File Upload</span> -->
          <input type="file" id="soalFile" 
                 class="input-file soalUpload form-control" 
                 onchange="bank_soal_data.getUploadedData(this)">
         </div>
         <!-- <div class="file-path-wrapper">
                <input class="" type="text">
         </div> -->
        </div>
        &nbsp;<p class='loading_data'></p>
       </div>
      </div>
     <div class="form-actions text-right">
      <button type="button" class="btn btn-primary" onclick="bank_soal_data.execUploadFileSoal()">Simpan</button>
     </div> 
     
<!--     <div class="control-group content_upload">
      <label class="control-label" for="focusedInput">Upload File Soal *csv</label>
      <div class="controls">
       <input class="input-file soalUpload" id="soalFile" 
              data_file=""
              type="file" onchange="bank_soal_data.getUploadedData(this)">
       &nbsp;<p class='loading_data'></p>
      </div>
     </div>      
     <div class="form-actions">
      <button type="button" class="btn btn-primary" onclick="bank_soal_data.execUploadFileSoal()">Simpan</button>
     </div>    -->
    </div>    
   </form>
   <!-- </div> -->
  </div>
 </div>
</div>