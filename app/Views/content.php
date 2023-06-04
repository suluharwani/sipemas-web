<!-- create.php -->
<form id="createContentForm" enctype="multipart/form-data">
    <div>
        <label for="title">title</label>
        <input type="text" name="title" id="title" required>
    </div>
    <div>
        <label for="content">content</label>
        <textarea name="content" id="content" required></textarea>
    </div>
    <div>
        <label for="image">Image</label>
        <!-- <input type="file" name="image" id="image" > -->
    </div>
    <button type="submit">Create</button>
</form>
<script src="https://code.jquery.com/jquery-3.7.0.min.js" integrity="sha256-2Pmvv0kuTBOenSvLm6bvfBSSHrUJ+3A7x6P5Ebd07/g=" crossorigin="anonymous"></script>

<script type="text/javascript">
// JavaScript code
$(document).ready(function() {
    // Menangkap event submit form
    $('#createContentForm').submit(function(e) {
        e.preventDefault(); // Mencegah pengiriman form secara normal

        // Mengambil data form
        var formData = new FormData(this);

        // Mengirim data form ke server dengan AJAX
        $.ajax({
            url: '/content/create', // Ubah sesuai dengan URL yang benar
            type: 'POST',
            data: formData,
            dataType: 'json',
            contentType: false,
            processData: false,
            success: function(response) {
                // Tanggapan sukses dari server
                if (response.success) {
                    alert('Content created successfully');
                    // Lakukan aksi lain yang diperlukan setelah pembuatan konten berhasil
                } else {
                    alert('Failed to create content');
                }
            },
            error: function() {
                // Kesalahan dalam permintaan AJAX
                alert('An error occurred while creating content');
            }
        });
    });
});

</script>