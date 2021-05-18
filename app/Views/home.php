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
                    <h3><?php $convert = number_format($reken['saldo_rekening'], 2, '.', ','); echo "Rp. " . $convert ;?></h3>
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
                    <td><?php $convert = number_format($dt['jmlh_transaksi'], 2, '.', ','); echo "Rp. " . $convert ;?></td>
                    <td><button type="button" data-bs-toggle="modal" data-bs-target="#edit-modal-<?php echo $dt["id_transaksi"]?>" class="edit-button"><span class="iconify" data-icon="ant-design:edit-outlined" data-inline="false"></button> </span> <a href="/Home/delete_trans/<?php echo $dt["id_transaksi"]?>"><span class="iconify" data-icon="fluent:delete-20-filled" data-inline="false"></span></a></td>
                  </tr>
                  <?php endforeach; ?>
                </tbody>
              </table>
        </div>
    </section>

    <?php foreach($dataTabel->getResultArray() as $dt) : ?>
        <div class="modal fade" id="edit-modal-<?php echo $dt["id_transaksi"] ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Edit Transaksi</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
              </div>
              <div class="modal-body">
                <form action="/Home/edit_trans/<?php echo $dt["id_transaksi"] ?>" method="POST">
                  <?php echo csrf_field(); ?>
                  <div class="mb-3">
                      <label for="exampleFormControlInput1" class="form-label">Tanggal</label>
                      <input type="date" class="form-control" id="exampleFormControlInput1" placeholder="name@example.com" name="tgl">
                  </div>
                  <div class="mb-3">
                      <label for="exampleFormControlTextarea1" class="form-label">Keterangan</label>
                      <textarea class="form-control" id="exampleFormControlTextarea1" rows="3" name="ket"></textarea>
                  </div>
                  <div class="mb-3">
                      <label for="exampleFormControlTextarea1" class="form-label">Rekening</label>
                      <select class="form-select" aria-label="Default select example" name="rek">
                          <option selected>--Pilih Rekening--</option>
                          <?php $i = 1; foreach ($rek->getResultArray() as $reken) : ?>
                          <option value="<?php echo $reken["nama_rekening"] ?>"><?php echo $reken['nama_rekening'] ?></option>
                          <?php endforeach; ?>
                      </select>
                  </div>
                  <div class="mb-3">
                      <label for="exampleFormControlInput1" class="form-label">Produk (Untuk pemasukan, kosongkan jika pengeluaran)</label>
                      <!-- <input type="text" class="form-control" id="exampleFormControlInput1" name="idp"> -->
                      <select class="form-select" aria-label="Default select example" name="prd">
                          <option selected>--Pilih Produk--</option>
                          <?php $i = 1; foreach ($prod->getResultArray() as $prd) : ?>
                          <option value="<?php echo $prd["nama_produk"] ?>"><?php echo $prd['nama_produk'] ?></option>
                          <?php endforeach; ?>
                      </select>
                  </div>
                  <div class="mb-3">
                      <label for="exampleFormControlInput1" class="form-label">Supplier (Untuk pengeluaran, kosongkan jika pemasukan)</label>
                      <!-- <input type="text" class="form-control" id="exampleFormControlInput1" name="ids"> -->
                      <select class="form-select" aria-label="Default select example" name="spl">
                          <option selected>--Pilih Supplier--</option>
                          <?php $i = 1; foreach ($supl->getResultArray() as $spl) : ?>
                          <option value="<?php echo $spl["nama_supplier"];?>"><?php echo $spl['nama_supplier'] ?></option>
                          <?php endforeach; ?>
                      </select>
                  </div>
                  <div class="mb-3">
                      <label for="exampleFormControlInput1" class="form-label">Jenis Transaksi</label>
                      <!-- <input type="text" class="form-control" id="exampleFormControlInput1" name="ids"> -->
                      <select class="form-select" aria-label="Default select example" name="jns">
                          <option>--Pilih Jenis Transaksi--</option>
                          <option value="Pemasukan">Pemasukan</option>
                          <option value="Pengeluaran">Pengeluaran</option>
                      </select>
                  </div>
                  <div class="mb-3">
                      <label for="exampleFormControlInput1" class="form-label">Sub Total</label>
                      <input type="number" class="form-control" id="exampleFormControlInput1" name="sbt">
                  </div>
                  <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                  <button type="submit" class="btn btn-primary">Submit</button>
                </form>
              </div>
            </div>
          </div>
      </div>
  <?php endforeach; ?>
    
<?php echo $this->endSection(); ?>