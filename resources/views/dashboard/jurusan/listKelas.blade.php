<script>
    function handleListKelas(elemen) {
        const modalbs = elemen.getAttribute('data-modal');
        const dataRoute = elemen.getAttribute('data-route');
        const jurusanName = elemen.getAttribute('data-jurusanName');
        $.ajax({
            url: dataRoute,
            type: 'GET',
            success: function(response) {
                const data = response.data;
                $('#table-list-kelas tbody').empty();
                $('#modal-title-kelas').text('Daftar Kelas [' + jurusanName + ']');
                $('#' + modalbs).modal('show');

                if(data.length > 0) {
                    $('#empty-dataTable').addClass('d-none');
                    data.forEach(function(item,index) {
                        var row = $('<tr>');
                        row.append($('<td>').text(index+1));
                        row.append($('<td>').text(item.nama_kelas));
                        row.append($('<td>').text(item.keterangan));
                        $('#table-list-kelas tbody').append(row);
                    });
                } else {
                    $('#empty-dataTable').removeClass('d-none').addClass('text-center');
                }
            },
            error: function(xhr, status, error) {
                snackBarAlert('Data gagal termuat', '#e7515a');
            }
        });
    }
</script>
