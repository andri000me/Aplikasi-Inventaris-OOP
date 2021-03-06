<?php
	session_start();

	include '../../function/f_peminjaman.php';

	$peminjaman = new Peminjaman();

	if (isset($_POST['submit'])) {
		$barang  		   = $_POST['barang'];
		$jumlah 		   = $_POST['jumlah'];
		$tanggal_pinjam    = $_POST['tanggal_pinjam'];
		$pegawai 		   = $_POST['pegawai'];

        $stok = $peminjaman->getStok($barang);

		if($stok < 1) {                                                                                                                                                                                              
            echo "<script>alert('Data Tidak Boleh Kosong');window.location.href='add_peminjaman.php';</script>";
		}else if($stok > 1){

			foreach ($stok as $row) {
				if($row['jumlah'] >= $jumlah){
					$peminjaman->peminjamBarang($barang, $jumlah, $tanggal_pinjam, $pegawai);
			}else{
				echo "<script>alert('Stok Barang Kurang');window.location.href='add_peminjaman.php';</script>";
			}
		}	
	}

	}	

?>

<!DOCTYPE html>
<html>
<head>
	<title>Peminjaman | Inventaris</title>

	<!-- Custom CSS -->
	<link rel="stylesheet" href="../../assets/css/style.css">
</head>
<body>

<div class="navbar">
			
			</div>
		
			<!-- ================= navbar sidebar ================= -->
			<?php include '../../page/peminjam/menu.php' ?>
			<!-- ========= end sidebar =========== -->

	<!-- ========= body ================= -->
	<div class="container">

        <!-- ============================ TAMBAH DATA PEMINJAMAN ==================================== -->
		<div class="section">
				<div class="text-table">
						<h4>Tambah Data Peminjaman</h4>
				</div>

				<hr class="line">

				<div class="form-section">						
						<form method="post">	
						
							<!-- ======================================== form 1 =============================================== -->
                            <div style="width: 45%">

                            <div class="form-input">
										<label class="form-lb">Nama Barang</label>
										<select name="barang">
												<option value="">Pilih Nama Barang</option>
												<?php
													foreach($peminjaman->getInventaris() as $row){
												?>
                                   					<option value="<?php  echo $row['id_inventaris'];?>"><?php echo $row['nama'] ?> - stok <?php echo $row['jumlah'] ?></option>
												<?php } ?>
										</select>
								</div>

								<div class="form-input">
										<label class="form-lb">Jumlah</label>
										<input type="text" name="jumlah" placeholder="Jumlah Barang" class="form-line">
								</div>

                            </div>

								<div class="form-btn" style="margin-left: 0%">
									<input type="submit" name="submit" class="btn btn-black" value="Simpan" style="width: 100%; margin-top: -8%;">
								</div>
							<!-- ======================================== form 1 =============================================== -->
							
							<!-- ======================================== form 2 =============================================== -->
                            <div class="form-pinjam">
							
								<div class="form-input">
										<label class="form-lb">Tanggal Pinjam</label>
										<input type="date" name="tanggal_pinjam" class="form-line" value="<?php echo date('Y-m-d');?>" readonly style="background-color: #f9f9f9;">
								</div>

								<div class="form-input">
										<label class="form-lb">Pegawai</label>
											<select name="pegawai">
												<option value="<?php echo $_SESSION['id_pegawai'];?>"><?php echo $_SESSION['nama_pegawai'];?></option>
										</select>
								</div>

                            </div>
								<!-- ======================================== form 2 =============================================== -->

						</form>
				</div>
		</div>
        <!-- ============================ TAMBAH DATA PEMINJAMAN ==================================== -->


        <!-- ============================ DATA PEMINJAMAN ==================================== -->
		<div class="section" style="margin-top: -3%;">
				<div class="text-table">
						<h4>Data Peminjaman</h4>
				</div>

				<hr class="line">

				<div class="table table-responsive">

						<table class="table-border" style="width: 100%;">
							<thead>
								<tr>
									<th>NO</th>
									<th>KODE INVENTARIS</th>
									<th>NAMA BARANG</th>
									<th>JUMLAH</th>
									<th>TANGGAL PINJAM</th>
									<th>STATUS PEMINJAMAN</th>
									<th>NAMA PEGAWAI</th>
								</tr>
							</thead>
							<?php
							$no = 1;

							$pem = $peminjaman->view(); 
							if($pem < 1) {                                                                                                                                                                                              
								echo "<td colspan='6'>Belum Ada Data</td>";
							}else if($pem > 1){

							foreach($pem as $row){ ?>
							<tbody>
								<tr>
									<td><?php echo $no++; ?></td>
									<td><?php echo $row['kode_inventaris']; ?></td>
									<td><?php echo $row['nama']; ?></td>
									<td><?php echo $row['jumlah']; ?></td>
									<td><?php echo $row['tanggal_pinjam']; ?></td>
									<td><?php echo $row['status_peminjaman']; ?></td>
									<td><?php echo $row['nama_pegawai']; ?></td>
								</tr>
							</tbody>							
							<?php } } ?>

						</table>
				</div>
		</div>
		<!-- ============================ DATA PEMINJAMAN ==================================== -->

	</div>
	<!-- ============ end body =============== -->

</body>
</html>