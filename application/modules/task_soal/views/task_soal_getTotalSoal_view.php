<?php if (!$siswa_is_submit && $is_exist_ujian && $is_start_ujian) { ?>
 <ul class="nav nav-list bs-docs-sidenav nav-collapse collapse">
  <li class="active">
   <a href="#">Soal Terjawab</a>
  </li>
  <li>
   <div class="row-fluid">
    <div class="span9">
     <div class="total_soal_content">
      <?php $counter = 1; ?>
      <?php for ($i = 0; $i < $data_total_soal; $i++) { ?>
       <?php //for ($i = 0; $i < 25; $i++) { ?>
       <div class="span2" style="margin-left: 12px;">   
        <div class="content_soal" id="<?php echo $counter ?>">
         <label><?php echo $counter++ ?></label>
        </div>
       </div>
      <?php } ?>
     </div>      
    </div>
   </div> 
  </li>
 </ul> 

 <ul class="nav nav-list bs-docs-sidenav nav-collapse collapse">
  <li class="active">
   <a href="#">Waktu Ujian</a>
  </li>
  <li>
   <div class="clock" style=""></div>
   <br/>
  </li> 
 </ul>
<?php } ?>