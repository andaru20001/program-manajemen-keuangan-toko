<?php

namespace App\Controllers;

use App\Models\TableModel;
use CodeIgniter\Database\Query;

class Home extends BaseController
{
	public function index(){
		$db = \Config\Database::connect();
		$dataTabel = $db->query("SELECT id_transaksi, tgl_transaksi, keterangan_transaksi, jmlh_transaksi, nama_rekening, jenis_transaksi from transaksi INNER JOIN rekening using(id_rekening);");
		$rekening = $db->query("SELECT nama_rekening, saldo_rekening FROM rekening;");
		$produk = $db->query("SELECT nama_produk FROM produk;");
		$supplier = $db->query("SELECT nama_supplier FROM supplier;");

		$data = [
			'dataTabel' => $dataTabel,
			'rek' => $rekening,
			'prod' => $produk,
			'supl' => $supplier
		];

		return view('home', $data);
	}

	public function add_trans(){
		$tgl = isset($_POST["tgl"]) ? $_POST["tgl"] : NULL;
		$ket = isset($_POST["ket"]) ? $_POST["ket"] : NULL;
		$rek = isset($_POST["rek"]) ? $_POST["rek"] : NULL;
		$prd = isset($_POST["prd"]) ? $_POST["prd"] : NULL;
		$spl = isset($_POST["spl"]) ? $_POST["spl"] : NULL;
		$sbt = isset($_POST["sbt"]) ? $_POST["sbt"] : NULL;
		$jns = isset($_POST["jns"]) ? $_POST["jns"] : NULL;

		$db = \Config\Database::connect();
		$db->query("INSERT INTO transaksi (tgl_transaksi, jmlh_transaksi, keterangan_transaksi, jenis_transaksi, id_produk, id_supplier, id_rekening) VALUES ('$tgl', '$sbt', '$ket', '$jns', (SELECT id_produk FROM produk WHERE nama_produk='$prd'), (SELECT id_supplier FROM supplier WHERE nama_supplier='$spl'), (SELECT id_rekening FROM rekening WHERE nama_rekening='$rek'));");

		// INI BLOK KODE UPDATE SALDO REKENING, BISA DIPAKE DI FUNGSI EDIT DAN DELETE NANTI
		$msk = $db->query("SELECT jmlh_transaksi FROM transaksi INNER JOIN rekening WHERE jenis_transaksi='Pemasukan' AND nama_rekening='$rek'");
		$klr = $db->query("SELECT jmlh_transaksi FROM transaksi INNER JOIN rekening WHERE jenis_transaksi='Pengeluaran' AND nama_rekening='$rek'");
		$pemasukan = 0;
		$pengeluaran = 0;
		foreach($msk->getResultArray() as $mskval){
			$backup1 = $pemasukan;
			$pemasukan = $backup1 + $mskval['jmlh_transaksi'];
		}
		foreach($klr->getResultArray() as $klrval){
			$backup2 = $pengeluaran;
			$pengeluaran = $backup2 + $klrval['jmlh_transaksi'];
		}	
		
		$jml = $pemasukan - $pengeluaran;

		$db->query("UPDATE rekening SET saldo_rekening='$jml' WHERE nama_rekening='$rek'");
		// AKHIR DARI BLOK KODE UPDATE SALDO REKENING

		return redirect()->to('/Home');
	}

	public function add_supl(){
		$nama = isset($_POST["nama"]) ? $_POST["nama"] : NULL;

		$db = \Config\Database::connect();
		$db->query("INSERT INTO supplier (nama_supplier) VALUES ('$nama');");

		return redirect()->to('/Home');
	}

	public function add_prod(){
		$nama = isset($_POST["nama"]) ? $_POST["nama"] : NULL;
		$harga = isset($_POST["harga"]) ? $_POST["harga"] : NULL;

		$db = \Config\Database::connect();
		$db->query("INSERT INTO produk (nama_produk) VALUES ('$nama');");
		$db->query("INSERT INTO produk (harga_produk) VALUES ('$harga');");

		return redirect()->to('/Home');
	}

	public function delete_trans($id){
		$db = \Config\Database::connect();
		$transaksi = $db->query("SELECT id_rekening, jmlh_transaksi, jenis_transaksi FROM transaksi WHERE id_transaksi = '$id';");
		$idRek = NULL;
		$jmlhTrx = NULL;
		$jenisTRX = NULL;
		foreach($transaksi->getResultArray() as $trx){
			$idRek = $trx["id_rekening"];
			$jmlhTrx = $trx["jmlh_transaksi"];
			$jenisTRX = $trx["jenis_transaksi"];
		}
		$rekening = $db->query("SELECT saldo_rekening FROM rekening WHERE id_rekening = '$idRek';");
		$saldoRek = NULL;
		foreach($rekening->getResultArray() as $rek){
			$saldoRek = $rek["saldo_rekening"];
		}

		if($jenisTRX === "Pengeluaran" ){
			$saldo_akhir = $jmlhTrx + $saldoRek;
			$db->query("UPDATE rekening SET saldo_rekening = '$saldo_akhir' WHERE id_rekening = '$idRek';");
		}else{
			$saldo_akhir = $saldoRek - $jmlhTrx;
			$db->query("UPDATE rekening SET saldo_rekening = '$saldo_akhir' WHERE id_rekening = '$idRek';");
		}

		$db->query("DELETE FROM transaksi WHERE id_transaksi = '$id';");
		return redirect()->to('/Home');
	}

	public function edit_trans($id){
		$tgl = isset($_POST["tgl"]) ? $_POST["tgl"] : NULL;
		$ket = isset($_POST["ket"]) ? $_POST["ket"] : NULL;
		$rek = isset($_POST["rek"]) ? $_POST["rek"] : NULL;
		$prd = isset($_POST["prd"]) ? $_POST["prd"] : NULL;
		$spl = isset($_POST["spl"]) ? $_POST["spl"] : NULL;
		$sbt = isset($_POST["sbt"]) ? $_POST["sbt"] : NULL;
		$jns = isset($_POST["jns"]) ? $_POST["jns"] : NULL;

		$db = \Config\Database::connect();
		$db->query("UPDATE transaksi SET tgl_transaksi = '$tgl', jmlh_transaksi = '$sbt', keterangan_transaksi='$ket', jenis_transaksi = '$jns', id_produk = (SELECT id_produk FROM produk WHERE nama_produk='$prd'), id_supplier = (SELECT id_supplier FROM supplier WHERE nama_supplier='$spl'),id_rekening = (SELECT id_rekening FROM rekening WHERE nama_rekening='$rek') WHERE id_transaksi = '$id';");

		// INI BLOK KODE UPDATE SALDO REKENING, BISA DIPAKE DI FUNGSI EDIT DAN DELETE NANTI
		$msk = $db->query("SELECT jmlh_transaksi FROM transaksi INNER JOIN rekening WHERE jenis_transaksi='Pemasukan' AND nama_rekening='$rek'");
		$klr = $db->query("SELECT jmlh_transaksi FROM transaksi INNER JOIN rekening WHERE jenis_transaksi='Pengeluaran' AND nama_rekening='$rek'");
		$pemasukan = 0;
		$pengeluaran = 0;
		foreach($msk->getResultArray() as $mskval){
			$backup1 = $pemasukan;
			$pemasukan = $backup1 + $mskval['jmlh_transaksi'];
		}
		foreach($klr->getResultArray() as $klrval){
			$backup2 = $pengeluaran;
			$pengeluaran = $backup2 + $klrval['jmlh_transaksi'];
		}	
		
		$jml = $pemasukan - $pengeluaran;

		$db->query("UPDATE rekening SET saldo_rekening='$jml' WHERE nama_rekening='$rek'");
		// AKHIR DARI BLOK KODE UPDATE SALDO REKENING

		return redirect()->to('/Home');
	}
}
