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
            { "data": "subkategori" }
        ]
    });
});

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






