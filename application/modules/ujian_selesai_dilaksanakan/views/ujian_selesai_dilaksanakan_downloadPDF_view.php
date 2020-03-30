<html>
 <head>
  <style>
   body{
    font-family: arial;
   }
  </style>
 </head>
 <body>
  <div class='header'>
   <center><h4>Kode Soal <?php echo $ujian['kode_ujian'] ?></h4></center>
  </div>
  <div class='content'>
   <table style="width: 100%;border-collapse: collapse;">
    <thead>
     <tr>
      <th style="border:1px solid #333;font-size: 12px;">No.</th>
      <th style="border:1px solid #333;font-size: 12px;">Kategori Soal</th>
      <th style="border:1px solid #333;font-size: 12px;">Soal</th>
      <th style="border:1px solid #333;font-size: 12px;">Jawaban Benar</th>
     </tr>
    </thead>
    <tbody>
     <?php $no = 1; ?>
     <?php foreach ($list_soal as $value) { ?>
      <tr>
       <td style="border:1px solid #333;font-size: 12px;">&nbsp;
        <?php echo $no++ ?>
       </td>
       <td style="border:1px solid #333;font-size: 12px;">&nbsp;
        <?php echo $value['kategori'] ?>
       </td>
       <td style="border:1px solid #333;font-size: 12px;">&nbsp;
        <?php echo $value['soal'] ?>
        <?php if ($value['file_soal'] != '') { ?>
         <br>        
         <img src="<?php echo base_url() . 'files/soal/' . $value['file_soal'] ?>" />
        <?php } ?>
       </td>
       <td style="border:1px solid #333;font-size: 12px;">&nbsp;
        <?php echo $value['jawaban_benar'] ?>        
        <?php if ($value['file_jawaban'] != '') { ?>
         <br>        
         <img src="<?php echo base_url() . 'files/jawaban/' . $value['file_jawaban'] ?>" />
        <?php } ?>
       </td>
      </tr>
     <?php } ?>
    </tbody>
   </table>
  </div>
 </body>
</html>