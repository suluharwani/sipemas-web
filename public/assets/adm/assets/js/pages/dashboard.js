var loc = window.location;
var base_url = loc.protocol + "//" + loc.hostname + (loc.port? ":"+loc.port : "") + "/";
// $(document).ready(function() {
//     // Inisialisasi DataTables
//     $('#laporanTable').DataTable({
//         ajax: {
//             url: base_url + 'LaporanController/getLaporanData',
//             type: 'POST',
//             dataSrc: '',
//         },
//         columns: [
//             { data: 'uid' },
//             { data: 'tanggal' },
//             { data: 'kategori' },
//             { data: 'rating' },
//             // tambahkan kolom lain sesuai kebutuhan
//         ],
//     });
// });
$(document).ready(function() {
	 let tableDibaca;
	 let tableDibalas;
  
  // Membuka modal saat tombol diklik
  $('.sudahDibaca').click(function() {
    $('#modalDibaca').modal('show');
    
    // Membuat tabel DataTables saat modal dibuka
    if (!tableDibaca) {
      tableDibaca = $('#laporanTableDibaca').DataTable({
        "processing": true,
        "serverSide": true,
        "ajax": {
          "url": 'LaporanController/getLaporanDataDibaca', 
          "type": 'POST'
        },
        "columns": [
          { "data": "uid" },
			{ "data": "nama" },
			{ "data": "kategori" },
			{ "data": "subkategori" },
			{ "data": "uid",
				"render": function(data, type, row, meta) {
					return '<button class="btn btn-secondary" onclick="viewLaporan(\'' + data + '\')">View</button> <button class="btn btn-primary" onclick="balasLaporan(\'' + data + '\')">Balas</button> <button class="btn btn-warning" onclick="rejectLaporan(\'' + data + '\')">Tandai Belum Dibaca</button>';
				}
		   	}
        ]
      });
    } else {
      // Memperbarui data tabel saat modal dibuka jika tabel sudah ada
      tableDibaca.ajax.reload();
    }
  });
$('.sudahDibalas').click(function() {
    $('#modalDibalas').modal('show');
    
    // Membuat tabel DataTables saat modal dibuka
    if (!tableDibalas) {
      tableDibalas = $('#laporanTableDibalas').DataTable({
        "processing": true,
        "serverSide": true,
        "ajax": {
          "url": 'LaporanController/getLaporanDataDibalas', 
          "type": 'POST'
        },
        "columns": [
          { "data": "uid" },
			{ "data": "nama" },
			{ "data": "kategori" },
			{ "data": "subkategori" },
			{ "data": "uid",
				"render": function(data, type, row, meta) {
					return '<button class="btn btn-secondary" onclick="viewLaporanBalasan(\'' + data + '\')">View</button> <button class="btn btn-danger" onclick="HapusBalasLaporan(\'' + data + '\')">Hapus Balasan</button> ';
				}
		   	}
        ]
      });
    } else {
      // Memperbarui data tabel saat modal dibuka jika tabel sudah ada
      tableDibalas.ajax.reload();
    }
  });


	$('#laporanTable').DataTable({
		"processing": true,
		"serverSide": true,
		"ajax": {
			"url": "LaporanController/getLaporanData",
			"type": "POST"
		},
		"columns": [
			{ "data": "uid" },
			{ "data": "nama" },
			{ "data": "kategori" },
			{ "data": "subkategori" },
			{ "data": "uid",
			"render": function(data, type, row, meta) {
				return '<button class="btn btn-secondary" onclick="viewLaporan(\'' + data + '\')">View</button> <button class="btn btn-primary" onclick="balasLaporan(\'' + data + '\')">Balas</button> <button class="btn btn-success" onclick="acceptLaporan(\'' + data + '\')">Tandai Sudah Dibaca</button>';
			}
		}
		]
	});
});

// $('.sudahDibaca').on('click',function(){
// $('#modalDibaca').modal('show')
// })
// $('.sudahDibalas').on('click',function(){
// $('#modalDibalas').modal('show')


// })
function rejectLaporan(uid){
	Swal.fire({
		title: 'Apakah anda yakin?',
		text: "Laporan akan ditandai belum dibaca!",
		icon: 'warning',
		showCancelButton: true,
		confirmButtonColor: '#3085d6',
		cancelButtonColor: '#d33',
		confirmButtonText: 'Konfirmasi!'
	}).then((result) => {
		$.ajax({
      type : "POST",
      url  : base_url+'LaporanController/TandaiBelumDibaca',
      async : false,
      // dataType : "JSON",
      data : {uid:uid},
      success: function(data){
        $('#laporanTableDibaca').DataTable().ajax.reload();
        $('#laporanTable').DataTable().ajax.reload();
        if (result.isConfirmed) {
			Swal.fire(
				'Berhasil!',
				'Laporan berhasil ditandai sebagai "Sudah dibaca"',
				'success'
				)
		}
      },
      error: function(xhr){
        let d = JSON.parse(xhr.responseText);
        Swal.fire({
          icon: 'error',
          title: 'Oops...',
          text: `${d.message}`,
          footer: '<a href="">Why do I have this issue?</a>'
        })
      }
    });
		
	})
}
function acceptLaporan(uid){
	Swal.fire({
		title: 'Apakah anda yakin?',
		text: "Laporan akan ditandai telah dibaca!",
		icon: 'warning',
		showCancelButton: true,
		confirmButtonColor: '#3085d6',
		cancelButtonColor: '#d33',
		confirmButtonText: 'Konfirmasi!'
	}).then((result) => {
		$.ajax({
      type : "POST",
      url  : base_url+'LaporanController/TandaiDibaca',
      async : false,
      // dataType : "JSON",
      data : {uid:uid},
      success: function(data){
        $('#laporanTable').DataTable().ajax.reload();
        if (result.isConfirmed) {
			Swal.fire(
				'Berhasil!',
				'Laporan berhasil ditandai sebagai "Sudah dibaca"',
				'success'
				)
		}
      },
      error: function(xhr){
        let d = JSON.parse(xhr.responseText);
        Swal.fire({
          icon: 'error',
          title: 'Oops...',
          text: `${d.message}`,
          footer: '<a href="">Why do I have this issue?</a>'
        })
      }
    });
		
	})
}
function HapusBalasLaporan(uid){
	Swal.fire({
		title: 'Apakah anda yakin?',
		text: "Balasan Laporan akan dihapus dan ditandai telah dibaca!",
		icon: 'warning',
		showCancelButton: true,
		confirmButtonColor: '#3085d6',
		cancelButtonColor: '#d33',
		confirmButtonText: 'Konfirmasi!'
	}).then((result) => {
		$.ajax({
      type : "POST",
      url  : base_url+'LaporanController/HapusBalasLaporan',
      async : false,
      // dataType : "JSON",
      data : {uid:uid},
      success: function(data){
        $('#laporanTableDibalas').DataTable().ajax.reload();
        if (result.isConfirmed) {
			Swal.fire(
				'Berhasil!',
				'Balasan laporan berhasil dihapus dan ditandai sebagai "Sudah dibaca"',
				'success'
				)
		}
      },
      error: function(xhr){
        let d = JSON.parse(xhr.responseText);
        Swal.fire({
          icon: 'error',
          title: 'Oops...',
          text: `${d.message}`,
          footer: '<a href="">Why do I have this issue?</a>'
        })
      }
    });
		
	})
}
function viewLaporan(uid) {
        // Perform AJAX request to fetch laporan data from controller
	$.ajax({
		url: 'LaporanController/getLaporanById',
		type: 'POST',
		data: { uid: uid },
		success: function(response) {
                // Process the response data

			let lap= JSON.parse(response);
			if (lap['status'] == "0") {
				status = "Belum dibaca"
			}else if (lap['status'] == "1") {
				status = "Sudah dibaca"
			}else if (lap['status'] == "2") {
				status = "Sudah ditanggapi"
			}else{
				status = "Tidak Ada"

			}
			Swal.fire({
				title: `${lap['kategori']} <br> ${lap['subkategori']}`,
				icon: 'info',
				customClass: 'swal-wide',
				html:
				`<div class="table-responsive text-start" >`+
				  `<table class="table">`+
				    `<tbody>`+
				      `<tr>`+
				        `<td style="width: 30%;">Nama</td>`+
				        `<td style="width: 70%;">${lap['nama']}</td>`+
				      `</tr>`+
				      `<tr>`+
				        `<td>Jenis Kelamin</td>`+
				        `<td>${lap['jenis_kelamin']}</td>`+
				      `</tr>`+
				      `<tr>`+
				        `<td>Pengaduan</td>`+
				        `<td>${lap['pengaduan']}</td>`+
				      `</tr>`+
				      `<tr>`+
				        `<td>Status</td>`+
				        `<td>${status}</td>`+
				      `</tr>`+
				      `<tr>`+
				        `<td>Tanggal</td>`+
				        `<td>${tanggalIndo(lap['tanggal'])}</td>`+
				      `</tr>`+
				    `</tbody>`+
				  `</table>`+
				`</div>`,
				showCloseButton: true,
				showCancelButton: false,
				focusConfirm: false,

			})
                // Handle the laporan data as needed (e.g., display it in a modal)
		},
		error: function(xhr, status, error) {
			console.log(error);
		}
	});
}
function viewLaporanBalasan(uid){
	$.ajax({
		url: 'LaporanController/getBalasanLaporanById',
		type: 'POST',
		data: { uid: uid },
		success: function(response) {
                // Process the response data

			let lap= JSON.parse(response);
			if (lap['status'] == "0") {
				status = "Belum dibaca"
			}else if (lap['status'] == "1") {
				status = "Sudah dibaca"
			}else if (lap['status'] == "2") {
				status = "Sudah ditanggapi"
			}else{
				status = "Tidak Ada"

			}
			Swal.fire({
				title: `${lap['kategori']} <br> ${lap['subkategori']}`,
				icon: 'info',
				customClass: 'swal-wide',
				html:
				`<div class="table-responsive text-start" >`+
				  `<table class="table">`+
				    `<tbody>`+
				      `<tr>`+
				        `<td style="width: 30%;">Nama</td>`+
				        `<td style="width: 70%;">${lap['nama']}</td>`+
				      `</tr>`+
				      `<tr>`+
				        `<td>Jenis Kelamin</td>`+
				        `<td>${lap['jenis_kelamin']}</td>`+
				      `</tr>`+
				      `<tr>`+
				        `<td>Pengaduan</td>`+
				        `<td>${lap['pengaduan']}</td>`+
				      `</tr>`+
				      `<tr>`+
				        `<td>Balasan</td>`+
				        `<td>${lap['balasan']}</td>`+
				      `</tr>`+
				      `<tr>`+
				        `<td>Status</td>`+
				        `<td>${status}</td>`+
				      `</tr>`+
				      `<tr>`+
				        `<td>Tanggal</td>`+
				        `<td>${tanggalIndo(lap['tanggal'])}</td>`+
				      `</tr>`+
				    `</tbody>`+
				  `</table>`+
				`</div>`,
				showCloseButton: true,
				showCancelButton: false,
				focusConfirm: false,

			})
                // Handle the laporan data as needed (e.g., display it in a modal)
		},
		error: function(xhr, status, error) {
			console.log(error);
		}
	});
}

function balasLaporan(uid) {
  // let id = $(this).attr('id');

  Swal.fire({
    title: `Balas Laporan `,
    html: `<input type="text" id="balasan" class="swal2-input" placeholder="Isi jawaban laporan">`,
    confirmButtonText: 'Confirm',
    focusConfirm: false,
    preConfirm: () => {
      const balasan = Swal.getPopup().querySelector('#balasan').value
      if (!balasan) {
        Swal.showValidationMessage('Silakan lengkapi data')
      }
      return {balasan: balasan }
    }
  }).then((result) => {
    $.ajax({
      type : "POST",
      url  : base_url+'LaporanController/KirimBalasan',
      async : false,
      // dataType : "JSON",
      data : {uid:uid,balasan:result.value.balasan},
      success: function(data){
        $('#laporanTable').DataTable().ajax.reload();
        Swal.fire({
          position: 'center',
          icon: 'success',
          title: `balasan berhasil dikirim`,
          showConfirmButton: false,
          timer: 1500
        })
      },
      error: function(xhr){
        let d = JSON.parse(xhr.responseText);
        Swal.fire({
          icon: 'error',
          title: 'Oops...',
          text: `${d.message}`,
          footer: '<a href="">Why do I have this issue?</a>'
        })
      }
    });

  })
}

dataUser();
function dataUser(){
	$.ajax({
		type : "POST",
		url  : base_url+"UserController/index",
		async : true,
    // data:{id:id,status:status},
		success: function(data){

			$('#userCount').html(data['data'].length)
		},
		error: function(xhr){
			let d = JSON.parse(xhr.responseText);
			Swal.fire({
				icon: 'error',
				title: 'Oops...',
				text: `${d.message}`,
				footer: '<a href="">Why do I have this issue?</a>'
			})
		}
	});
}
dataAdmin();
function dataAdmin(){
	$.ajax({
		type : "POST",
		url  : base_url+"AdminController/index",
		async : true,
    // data:{id:id,status:status},
		success: function(data){

			$('#adminCount').html(data['data'].length)
		},
		error: function(xhr){
			let d = JSON.parse(xhr.responseText);
			Swal.fire({
				icon: 'error',
				title: 'Oops...',
				text: `${d.message}`,
				footer: '<a href="">Why do I have this issue?</a>'
			})
		}
	});
}
dataLaporan();
function dataLaporan(){
	$.ajax({
		type : "POST",
		url  : base_url+"LaporanController/index",
		async : true,
    // data:{id:id,status:status},
		success: function(data){

			$('#laporanCount').html(data['data'].length)
		},
		error: function(xhr){
			let d = JSON.parse(xhr.responseText);
			Swal.fire({
				icon: 'error',
				title: 'Oops...',
				text: `${d.message}`,
				footer: '<a href="">Why do I have this issue?</a>'
			})
		}
	});
}
dataContent();
function dataContent(){
	$.ajax({
		type : "POST",
		url  : base_url+"ContentController/index",
		async : true,
    // data:{id:id,status:status},
		success: function(data){

			$('#contentCount').html(data['data'].length)
		},
		error: function(xhr){
			let d = JSON.parse(xhr.responseText);
			Swal.fire({
				icon: 'error',
				title: 'Oops...',
				text: `${d.message}`,
				footer: '<a href="">Why do I have this issue?</a>'
			})
		}
	});
}

// dataLaporanPerBulan();
function dataLaporanPerBulan() {
	return new Promise(function(resolve, reject) {
		$.ajax({
			type: "POST",
			url: base_url + "LaporanController/countchart",
			async: true,
			success: function(data) {
				resolve(data);
			},
			error: function(xhr) {
				let d = JSON.parse(xhr.responseText);
				Swal.fire({
					icon: 'error',
					title: 'Oops...',
					text: `${d.message}`,
					footer: '<a href="">Why do I have this issue?</a>'
				});
				reject(new Error(d.message));
			}
		});
	});
}
function dataLaporanRating() {
	return new Promise(function(resolve, reject) {
		$.ajax({
			type: "POST",
			url: base_url + "LaporanController/countrating",
			async: true,
			success: function(data) {
				resolve(data);
			},
			error: function(xhr) {
				let d = JSON.parse(xhr.responseText);
				Swal.fire({
					icon: 'error',
					title: 'Oops...',
					text: `${d.message}`,
					footer: '<a href="">Why do I have this issue?</a>'
				});
				reject(new Error(d.message));
			}
		});
	});
}

// Mendapatkan data dan mengatur chart options saat data tersedia
dataLaporanPerBulan()
.then(function(data) {
  	// console.log(data[0])
	var DataPerBulanLaporan = {
		annotations: {
			position: 'back'
		},
		dataLabels: {
			enabled: false
		},
		chart: {
			type: 'bar',
			height: 300
		},
		fill: {
			opacity: 1
		},
		plotOptions: {},
		series: [{
			name: 'Laporan diterima',
			data: data[0]
		}],
		colors: '#435ebe',
		xaxis: {
			categories: ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"],
		},
	};

    // Menggunakan chart options yang telah disetel
    // Di sini Anda dapat memanggil fungsi untuk membuat chart dengan menggunakan DataPerBulanLaporan
	var chartBulanan = new ApexCharts(document.querySelector("#chart-profile-visit"), DataPerBulanLaporan);



	chartBulanan.render();
    // Contoh penggunaan DataPerBulanLaporan di luar fungsi
    // console.log(DataPerBulanLaporan);
})
.catch(function(error) {
	console.error("Terjadi kesalahan:", error);
});



dataLaporanRating()
.then(function(data) {

	let optionsRating  = {
		series: data[0],
		labels: ['Sangat Tidak Berkualitas', 'Tidak Berkualitas', 'Cukup Berkualitas', 'Berkualitas', 'Sangat Berkualitas'],
		colors: ['#A7220B','#EDED2F','#64ED2F','#64EDCC','#416AFA'],
		chart: {
			type: 'donut',
			width: '100%',
			height:'350px'
		},
		legend: {
			position: 'bottom'
		},
		plotOptions: {
			pie: {
				donut: {
					size: '30%'
				}
			}
		}
	}

	var chartRating = new ApexCharts(document.getElementById('chart-visitors-profile'), optionsRating)



	chartRating.render();

})
.catch(function(error) {
	console.error("Terjadi kesalahan:", error);
});


function tanggalIndo(timestamp) {
    var date = new Date(parseInt(timestamp));
  var options = { year: 'numeric', month: 'long', day: 'numeric' };
  var formattedDate = date.toLocaleDateString('id-ID', options);
  return formattedDate;
}




