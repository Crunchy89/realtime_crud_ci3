<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>CRUD realtime</title>
	<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
	<link rel="stylesheet" href="<?= base_url('assets') ?>/plugins/fontawesome-free/css/all.min.css">
	<link rel="stylesheet" href="<?= base_url('assets') ?>/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
	<link rel="stylesheet" href="<?= base_url('assets') ?>/plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
	<link rel="stylesheet" href="<?= base_url('assets') ?>/plugins/datatables-buttons/css/buttons.bootstrap4.min.css">
	<link rel="stylesheet" href="<?= base_url('assets') ?>/dist/css/adminlte.min.css">
</head>
<script src="<?= base_url('assets') ?>/plugins/jquery/jquery.min.js"></script>

<body>

	<section class="content">
		<div class="container-fluid">
			<div class="row">
				<div class="col-12">

					<div class="card">
						<div class="card-header">
							<h3 class="card-title">Data Role</h3>
							<br>
							<br>
							<button class="btn btn-primary btn-sm tambah">Tambah Role</button>
						</div>
						<div class="card-body">
							<table id="example1" class="table table-bordered table-striped">
								<thead>
									<tr>
										<th>No</th>
										<th>Role</th>
										<th>Aksi</th>
									</tr>
								</thead>
								<tbody id="data">

								</tbody>
							</table>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>

	<!-- Modal -->
	<div class="modal fade" id="modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
		<div class="modal-dialog modal-dialog-centered" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="exampleModalLabel">Tambah</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<form id="form">
					<div class="modal-body">
						<div class="form-group">
							<label for="role">Role</label>
							<input type="text" class="form-control" name="role" id="role" placeholder="Masukkan Role">
						</div>
						<input type="hidden" name="aksi" id="aksi" value="tambah">
						<div id="add"></div>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
						<button type="submit" class="btn btn-primary" id="btn">Tambah</button>
					</div>
				</form>
			</div>
		</div>
	</div>

	<script src="<?= base_url('assets') ?>/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
	<script src="<?= base_url('assets') ?>/plugins/datatables/jquery.dataTables.min.js"></script>
	<script src="<?= base_url('assets') ?>/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
	<script src="<?= base_url('assets') ?>/plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
	<script src="<?= base_url('assets') ?>/plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
	<script src="<?= base_url('assets') ?>/plugins/datatables-buttons/js/dataTables.buttons.min.js"></script>
	<script src="<?= base_url('assets') ?>/plugins/datatables-buttons/js/buttons.bootstrap4.min.js"></script>
	<script src="<?= base_url('assets') ?>/plugins/jszip/jszip.min.js"></script>
	<script src="<?= base_url('assets') ?>/plugins/pdfmake/pdfmake.min.js"></script>
	<script src="<?= base_url('assets') ?>/plugins/pdfmake/vfs_fonts.js"></script>
	<script src="<?= base_url('assets') ?>/plugins/datatables-buttons/js/buttons.html5.min.js"></script>
	<script src="<?= base_url('assets') ?>/plugins/datatables-buttons/js/buttons.print.min.js"></script>
	<script src="<?= base_url('assets') ?>/plugins/datatables-buttons/js/buttons.colVis.min.js"></script>
	<script src="<?= base_url('assets') ?>/dist/js/adminlte.min.js"></script>
	<script src="<?= base_url('assets') ?>/dist/js/demo.js"></script>
	<!-- <script>
		$(function() {
			$("#example1").DataTable({
				"responsive": true,
				"lengthChange": false,
				"autoWidth": false,
				"buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
			}).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
		});
	</script> -->
	<script src="<?= base_url('node_modules/socket.io/node_modules/socket.io-client/socket.io.js'); ?>"></script>
	<script>
		$(document).ready(function() {
			const body = $('#modal').html();
			$('.tambah').click(() => {
				$('#modal').html(body);
				$('#modal').modal('show');
				submit()
			})
			$('#data').on('click', '.edit', function() {
				$('#modal').html(body);
				$('#modal').find('h5').html('Edit')
				$('#btn').html('Edit')
				$('#add').html(`
				<input type="hidden" name="id" id="id" value="${$(this).data('id')}">
				`)
				$('#role').val($(this).data('role'))
				$('#aksi').val('edit')
				$('#modal').modal('show');
				submit()
			})
			$('#data').on('click', '.hapus', function() {
				$('#modal').html(body);
				$('#modal').find('h5').html('Hapus')
				$('#btn').html('Hapus')
				$('.modal-body').html(`
				<input type="hidden" name="id" id="id" value="${$(this).data('id')}">
				<input type="hidden" name="aksi" id="aksi" value="hapus">
				<h3>Apakah Anda Yakin ?</h3>
				`)
				$('#modal').modal('show');
				submit()
			})

			function submit() {
				$("#modal").on('submit', '#form', function(e) {
					e.preventDefault()
					$.ajax({
						type: "POST",
						url: "<?= site_url('role/aksi'); ?>",
						data: new FormData(this),
						dataType: "json",
						processData: false,
						contentType: false,
						async: false,
						success: function(data) {
							console.log(data)
							if (data.status == true) {
								var socket = io.connect(`http://${window.location.hostname}:3000`);
								socket.emit('role', {
									status: data.status,
									pesan: data.pesan,
									data: data.data
								});
							}
							$('#modal').modal('hide')
						},
						error: function(xhr, status, error) {
							alert(error);
						},

					});

				});
			}

			$.ajax({
				url: `<?= site_url('role/getData') ?>`,
				method: 'get',
				dataType: 'json',
				success: result => {
					var socket = io.connect(`http://${window.location.hostname}:3000`);
					socket.emit('role', {
						status: result.status,
						pesan: result.pesan,
						data: result.data
					});
				}
			})
			var socket = io.connect(`http://${window.location.hostname}:3000`);
			socket.on('role', result => {
				if (result.status == true) {
					let roles = ''
					result.data.map((row, i) => {
						roles += `	<tr>
								<td>${++i}</td>
								<td>${row.role}</td>
								<td>
								<button data-role='${row.role}' data-id='${row.id_role}' class="btn btn-warning btn-sm edit"><i class="fas fa-edit"></i> Edit</button>
								<button data-id='${row.id_role}' class="btn btn-danger btn-sm hapus"><i class="fas fa-trash"></i> hapus</button>
								</td>
								</tr>`;
					})
					$("#data").html(roles);
				}
			});
		});
	</script>
</body>

</html>