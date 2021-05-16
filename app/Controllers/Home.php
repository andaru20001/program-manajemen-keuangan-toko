<?php

namespace App\Controllers;

use App\Models\TableModel;

class Home extends BaseController
{
	public function index(){
		$tableModel = new TableModel();

		// $tanggal = $tableModel->query('SELECT tgl_transaksi FROM transaksi;');
		// $keterangan = $tableModel->query('SELECT keterangan_transaksi FROM transaksi;');
		// $jumlah = $tableModel->query('SELECT jmlh_transaksi FROM transaksi;');
		// $rekening = $tableModel->query('SELECT nama_rekening FROM transaksi INNER JOIN rekening USING(id_rekening);');
		// $jenis = $tableModel->query('SELECT jenis_transaksi FROM transaksi;');

		// $dataTabel = $tableModel->query("SELECT tgl_transaksi, keterangan_transaksi, jmlh_transaksi, nama_rekening, jenis_transaksi from transaksi INNER JOIN rekening using(id_rekening);");
		// dd($dataTabel);

		$db = \Config\Database::connect();
		$dataTabel = $db->query("SELECT tgl_transaksi, keterangan_transaksi, jmlh_transaksi, nama_rekening, jenis_transaksi from transaksi INNER JOIN rekening using(id_rekening);");
		

		$data = [
			// 'tgl' => $tanggal,
			// 'ket' => $keterangan,
			// 'jml' => $jumlah,
			// 'rek' => $rekening,
			// 'jns' => $jenis
			'dataTabel' => $dataTabel
		];

		return view('home', $data);
	}
}
