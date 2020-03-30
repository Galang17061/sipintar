<div class="row-fluid">
 <div class='span12'>
  <div class='block'>
   <div class="navbar navbar-inner block-header">
    <div class="muted pull-left"><?php echo $title ?>
    </div>
   </div>

   <input type='hidden' name='' id='jawaban_id' class='form-control' value='<?php echo $jawaban_id ?>'/>
   <div class="block-content collapse in">
    <!--<form class="form-horizontal" style="">-->
    <div class='span12'>
     <div class="message">

     </div>

     <div class="control-group">
      <div class="controls">
       <iframe src="<?php echo base_url() . 'files/jawaban/' . $nama_file ?>" width="350" height="350"></iframe>
      </div>
     </div>
     <br/>
     <div class="form-actions">
      <!--<button type="button" class="btn btn-danger" onclick="bank_soal_data.hapusFileAnswer()">Hapus</button>-->
      <!--<button type="button" onclick="message.closeDialog()" class="btn">Tutup</button></a>-->
     </div>     
    </div>
   </div>
  </div>
 </div> 
</div>