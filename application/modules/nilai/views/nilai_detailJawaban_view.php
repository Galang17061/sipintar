<div class="row-fluid"> 
 <div class="card">
  <div class="card-content">
<div class="">
    <div class="table-toolbar">
    </div>

    <div class="message">

    </div>
    <div class="data">
     <div class="sticky-table sticky-headers sticky-ltr-cells">
      <table cellpadding="0" cellspacing="0" border="0" class="" id="tabel_nilai">
       <thead>
        <tr class="sticky-row">
         <th>No</th>
         <th>Soal</th>
         <th>Jawaban Anda</th>
          <th>Jawaban Benar</th> 
        </tr>
       </thead>
       <tbody>
        <?php if (!empty($data_jawaban)) { ?>
         <?php $no = 1; ?>
         <?php foreach ($data_jawaban as $value) { ?>
          <tr class="odd gradeX">
           <td><?php echo $no++ ?></td>
           <td><?php echo $value['soal'] ?>
            <?php if ($value['file_soal'] != '') { ?>
             <iframe src="<?php echo base_url() . 'files/soal/' . $value['file_soal'] ?>" width="200" height="200"></iframe>&nbsp;&nbsp;&nbsp;
            <?php } ?>
           </td>
           <td><?php echo $value['jawaban'] ?>
            <?php if ($value['file_jawaban'] != '') { ?>
             <iframe src="<?php echo base_url() . 'files/jawaban/' . $value['file_jawaban'] ?>" width="200" height="200"></iframe>&nbsp;&nbsp;&nbsp;
            <?php } ?>
           </td>
            <td><?php echo $value['jawaban_benar'] ?></td> 
          </tr>
         <?php } ?>
        <?php } else { ?>
         <tr>
          <td colspan="4">Tidak Ada Data Ditemukan</td>
         </tr>
        <?php } ?>
       </tbody>
      </table>
     </div>     
    </div>        
   </div>
  </div>
 </div>
<!-- <div class="block">
  <div class="navbar navbar-inner block-header">
   <div class="muted pull-left">Data Jawaban Anda</div>
  </div>
  <div class="block-content collapse in">
   
  </div>
 </div>-->
</div>