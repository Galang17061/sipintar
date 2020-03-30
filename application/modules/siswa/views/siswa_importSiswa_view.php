<!--<script src="<?php echo base_url() ?>assets/js/controllers/membuat_soal.js"></script>-->
<div class='row'>
 <div class='col-md-12'>
  <div class="">
   <div class=""><u>Upload Data Siswa</u></div>
  </div>
  <br>
  <div class="">
   <div class='col-md-12'>
    <form class="form-horizontal" style="">
     <div class='col-md-12'>

      <div class="message">

      </div>

      <div class="control-group">
       <label class="control-label" for="focusedInput">Upload File Data Siswa *csv</label>
       <div class="controls">
              <!--        <input class="input-file soalUpload" id="soalFile" 
type="file" onchange="siswa_data.getUploadedData(this)">-->
        <div class="file-field input-field">
         <div class="">
                <!-- <span>File Upload</span> -->
          <input type="file" id="soalFile" class="soalUpload form-control" onchange="siswa_data.getUploadedData(this)">
         </div>
         <!-- <div class="file-path-wrapper">
                <input class="" type="text">
         </div> -->
        </div>
        &nbsp;<p class='loading_data'></p>
       </div>
      </div>

      <!--      <div class="form-actions">
<button type="button" class="btn btn-primary" onclick="siswa_data.execUploadFileSiswa()">Simpan</button>       
</div>     -->
     </div>
    </form>
   </div>
  </div>
 </div>
</div>