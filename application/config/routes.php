<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$route['default_controller'] = 'beranda';
$route['dashboard'] = 'beranda';
$route['login'] = 'login';
//$route['manager-dashboard'] = 'beranda/dsbmng';
$route['operator-dashboard'] = 'beranda/dsbopt';
$route['404_override'] = 'Notfounde';
$route['translate_uri_dashes'] = FALSE;
$route['upload-image'] = 'Upload_image'; 
$route['store-image'] = 'Upload_image/produk_upload';
$route['daftar'] = 'beranda/daftar';
//$route['signature/save/'] = 'signature/save';
$route['signature/save/(:any)/(:any)'] = 'signature/save/$1/$2';


$route['proses-login'] = 'login/actlogin';
$route['user-data'] = 'beranda/userdata';
$route['bahan-baku/masuk'] = 'beranda/bakuin';
$route['bahan-baku/masuk/import'] = 'beranda/bakuimport';

$route['input/bahan-baku'] = 'beranda/baku_input';
$route['input/bahan-bantu'] = 'beranda/bantu_input';
$route['input/sparepart'] = 'beranda/spare_input';
$route['input/produksi'] = 'data/data_produksi';
$route['input/penjualan'] = 'data/penjualan_input';

$route['keuangan/biaya-listrik'] = 'data/biaya_listrik';
$route['keuangan/biaya-penyusutan'] = 'data/biaya_penyusutan';
$route['keuangan/biaya-pemeliharaan'] = 'data/biaya_pemeliharaan';
$route['keuangan/biaya-lain-lain'] = 'data/biaya_pemeliharaan';
$route['keuangan/biaya-cadangan-thr'] = 'data/biaya_cadanganthr';
$route['keuangan/man-power'] = 'data/biaya_manpower';
$route['data/penjualan'] = 'data/datapenjualan';
$route['hutang/customer'] = 'data/hutangcus';
$route['hutang/customer/(:any)'] = 'data/hutangcusid';



$route['input/bahan-baku/(:any)'] = 'beranda/baku_input';
$route['input/bahan-bantu/(:any)'] = 'beranda/bantu_input';
$route['input/sparepart/(:any)'] = 'beranda/spare_input';
$route['input/penjualan/(:any)'] = 'data/penjualan_input';

$route['riwayat-masuk'] = 'beranda/penerimaan_barang';

$route['nota/bahan-baku'] = 'beranda/penerimaan_barang';
$route['nota/bahan-bantu'] = 'beranda/penerimaan_barang';
$route['nota/sparepart'] = 'beranda/penerimaan_barang';
$route['nota/pembelian'] = 'beranda/nota_penerimaan_barang';

$route['stok/bahan-baku'] = 'beranda/stok_baku';
$route['stok/bahan-bantu'] = 'beranda/stok_bantu';
$route['stok/sparepart'] = 'beranda/stok_sparepart';
//$route['nota-tagihan'] = 'beranda/nota_tagihan';

$route['nota-tagihan/bahan-baku'] = 'beranda/nota_tagihan';
$route['nota-tagihan/bahan-bantu'] = 'beranda/nota_tagihan';
$route['nota-tagihan/sparepart'] = 'beranda/nota_tagihan';
$route['nota-tagihan/all'] = 'beranda/nota_tagihan';

$route['nota-tagihan/id/(:any)/1'] = 'beranda/nota_tagihanid';
$route['nota-tagihan/id/(:any)/2'] = 'beranda/nota_tagihanid';
$route['nota-tagihan/id/(:any)/3'] = 'beranda/nota_tagihanid';
$route['nota-tagihan/id/(:any)/4'] = 'beranda/nota_tagihanid';
$route['hutang/supplier'] = 'beranda/nota_tagihan';

$route['bahan-bantu/masuk'] = 'beranda/bantuin';
$route['sparepart/masuk'] = 'beranda/sparepartin';

$route['bahan-baku/keluar'] = 'beranda/bahan_keluar';
$route['bahan-bantu/keluar'] = 'beranda/bahan_keluar';
$route['sparepart/keluar'] = 'beranda/bahan_keluar';

$route['proses-add-user'] = 'proses/adduser';
$route['proses-reset-data'] = 'proses/resetdataapp';
$route['simpan-produksi'] = 'proses/simpanproduksi';
$route['simpan-listrik'] = 'proses/simpanlistrik';
$route['simpan-susut'] = 'proses/simpansusut';
$route['simpan-thr'] = 'proses/simpanthr';
$route['simpan-man'] = 'proses/simpanman';
$route['simpan/pembayarancustomer'] = 'proses/pembayarancustomer';
$route['simpan-produksi-import'] = 'import/importBarangjadi';
$route['simpan-pemeliharaan'] = 'proses/simpanpemeliharaan';
$route['updateharga'] = 'proses/updateharga';
$route['laporan/gain-loss'] = 'reports/laporan';
$route['simpan-notabaru'] = 'reports/simpannota';


/*
| -------------------------------------------------------------------------
| Sample REST API Routes
| -------------------------------------------------------------------------
*/

$route['api/example/users/(:num)'] = 'api/example/users/id/$1'; // Example 4
$route['api/example/users/(:num)(\.)([a-zA-Z0-9_-]+)(.*)'] = 'api/example/users/id/$1/format/$3$4'; // Example 8
