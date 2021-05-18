<!-- Buat template view tampilan halaman Home -->

  <!DOCTYPE html>
  <html lang="en">
  <head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&display=swap" rel="stylesheet">
    <title>Manajemen Keuangan</title>
    <link rel="stylesheet" href="style.css">
  </head>
  <body>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-+0n0xVW2eSR5OomGNYDnhzAbDsOXxcvSN1TPprVMTNDbiYZCxYbOOl7+AMvyTG2x" crossorigin="anonymous">
    <?php echo $this->renderSection('konten'); ?>

    <!-- Optional JavaScript; choose one of the two! -->

    <!-- Option 1: Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-gtEjrD/SeCtmISkJkNUaaKMoLD0//ElJ19smozuHV6z3Iehds+3Ulb9Bn9Plx0x4" crossorigin="anonymous"></script>
    <script src="https://code.iconify.design/1/1.0.7/iconify.min.js"></script>

    <!-- Option 2: Separate Popper and Bootstrap JS -->
    <!--
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.min.js" integrity="sha384-Atwg2Pkwv9vp0ygtn1JAojH0nYbwNJLPhwyoVbhoPwBhjQPR5VtM2+xf0Uwh9KtT" crossorigin="anonymous"></script>
    -->

    <div class="modal fade" id="transaction-modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLabel">Tambah Transaksi</h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
              <form action="/Home/add_trans" method="POST">
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
                        <option selected>--Pilih Jenis Transaksi--</option>
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

    <div class="modal fade" id="supplier-modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLabel">Tambah Supplier</h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
              <form action="/Home/add_supl" method="POST">
                <div class="mb-3">
                    <label for="exampleFormControlInput1" class="form-label">Nama Supplier</label>
                    <input type="text" class="form-control" id="exampleFormControlInput1" name="nama">
                </div>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary">Submit</button>
              </form>
            </div>
          </div>
        </div>
    </div>

    <div class="modal fade" id="product-modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLabel">Tambah Product</h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
              <form action="/Home/add-prod" method="POST">
                <div class="mb-3">
                    <label for="exampleFormControlInput1" class="form-label">Nama Product</label>
                    <input type="text" class="form-control" id="exampleFormControlInput1" name="nama">
                </div>
                <div class="mb-3">
                    <label for="exampleFormControlInput1" class="form-label">Harga Product</label>
                    <input type="text" class="form-control" id="exampleFormControlInput1" name="harga">
                </div>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary">Submit</button>
              </form>
            </div>
          </div>
        </div>
    </div>
  </body>
</html>