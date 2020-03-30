<html>
 <head>
  <title>Nilai</title>
 </head>
 <style>
  body{
   font-size: 12px;
   font-family: arial;
  }
 </style>
 <body>
  <div class='header'>
   <center><h4>Daftar Nilai pada Ujian <?php echo $ujian['kode_ujian'] ?></h4></center>
  </div>
  <div class='content'>
   <table style="width: 100%;border-collapse: collapse;">
    <thead>
     <tr>
      <th style="border:1px solid #333;">No</th>
      <th style="border:1px solid #333;">Nama</th>
      <th style="border:1px solid #333;">Nis</th>
      <th style="border:1px solid #333;">Jurusan</th>
      <th style="border:1px solid #333;">Nilai</th>
     </tr>
    </thead>
    <tbody>
     <?php if (!empty($data_nilai)) { ?>
      <?php $no = 1; ?>
      <?php foreach ($data_nilai as $value) { ?>
       <tr>
        <td style="border:1px solid #333;"><?php echo $no++ ?></td>
        <td style="border:1px solid #333;"><?php echo $value['siswa'] ?></td>
        <td style="border:1px solid #333;"><?php echo $value['nis'] ?></td>
        <td style="border:1px solid #333;"><?php echo $value['jurusan'] ?></td>
        <td style="border:1px solid #333;"><?php echo number_format($value['nilai'], 2, ',', '.') ?></td>
       </tr>
      <?php } ?>
     <?php } else { ?>
      <tr>
       <td colspan="5">Tidak Ada Data Ditemukan</td>
      </tr>
     <?php } ?>
    </tbody>
   </table>
  </div>
 </body>
</html>
