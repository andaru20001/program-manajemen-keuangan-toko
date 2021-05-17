<!-- Buat view tampilan halaman Home -->
<body>
    <section class="main">
        <div class="top">
            <div class="rek-card">
                <div class="rek-photo">
                    <img src="../../src/" class="rek-profile">
                </div>
                <div class="rek-teks">
                    <h2>Jenius</h2>
                    <h3>Rp 2.000.000</h3>
                </div>
            </div>
        </div>
        <div class="trans-table">
            
        </div>
    </section>
</body>

<?php echo $this->extend('template'); ?>

<?php echo $this->section('konten'); ?>

<div class="container">
  <h1 class="mt-5">Program Manajemen Keuangan Toko</h1>
</div>

<br>

<div class="container" id="transaction_table">
  <div class="row">
    <div class="col">
      <table class="table">
        <thead>
          <tr>
            <th scope="col">No.</th>
            <th scope="col">Tanggal</th>
            <th scope="col">Keterangan</th>
            <th scope="col">Rekening</th>
            <th scope="col">Jenis</th>
            <th scope="col">Sub Total</th>
          </tr>
        </thead>
        <tbody>
          <?php $i = 1 ;?>
          <?php foreach($dataTabel->getResultArray() as $dt) : ?>
          <tr>
            <th scope="row"><?php echo $i++ ;?></th>
            <td><?php echo $dt['tgl_transaksi'] ;?></td>
            <td><?php echo $dt['keterangan_transaksi'] ;?></td>
            <td><?php echo $dt['nama_rekening'] ;?></td>
            <td><?php echo $dt['jenis_transaksi'] ;?></td>
            <td><?php echo $dt['jmlh_transaksi'] ;?></td>
          </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    </div>
  </div>
</div>
<?php echo $this->endSection(); ?>