<!-- Buat view tampilan halaman Home -->

<?php echo $this->extend('template'); ?>

<?php echo $this->section('konten'); ?>

<section class="main">
        <div class="top">
          <?php foreach($rek->getResultArray() as $reken) : ?>
            <div class="rek-card">
                <div class="rek-photo">
                    <img src="img/Jenius-512.png" class="rek-profile">
                </div>
                <div class="rek-teks">
                    <h2><?php echo $reken['nama_rekening']; ?></h2>
                    <h3><?php echo $reken['saldo_rekening']; ?></h3>
                </div>
            </div>
          <?php endforeach; ?>
            <div class="list-button">
                <button type="button" data-bs-toggle="modal" data-bs-target="#supplier-modal">
                    <span class="iconify" data-icon="codicon:add" data-inline="false"></span> Supplier
                </button>
                <button type="button" data-bs-toggle="modal" data-bs-target="#product-modal">
                    <span class="iconify" data-icon="codicon:add" data-inline="false"></span> Product
                </button>
                <button type="button" data-bs-toggle="modal" data-bs-target="#transaction-modal"> 
                    <span class="iconify" data-icon="codicon:add" data-inline="false"></span> Transaction
                </button>
            </div>
        </div>

        <div class="trans-table">
            <table class="table">
                <thead>
                  <tr>
                    <th scope="col">No</th>
                    <th scope="col">Tanggal</th>
                    <th scope="col">Keterangan</th>
                    <th scope="col">Rekening</th>
                    <th scope="col">Jenis</th>
                    <th scope="col">Subtotal</th>
                    <th scope="col"></th>
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
    </section>
    
<?php echo $this->endSection(); ?>