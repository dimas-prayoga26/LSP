<script>
    function handleListKriteriaUnjukKerja(elemen) {
        const modalbs = elemen.getAttribute('data-modal');
        const dataRoute = elemen.getAttribute('data-route');
        const elemenName = elemen.getAttribute('data-elemenName');
        $.ajax({
            url: dataRoute,
            type: 'GET',
            success: function(response) {
                const data = response.data;
                $('#table-list-kriteriaUnjukKerja tbody').empty();
                $('#modal-title-kriteriaUnjukKerja').text('Daftar Kriteria Unjuk Kerja [' + elemenName + ']');
                $('#' + modalbs).modal('show');

                if(data.length > 0) {
                    $('#empty-dataTable').addClass('d-none');
                    data.forEach(function(item,index) {
                        var row = $('<tr>');
                        row.append($('<td>').text(index+1));
                        row.append($('<td>').text(item.nama_kriteria_kerja));
                        $('#table-list-kriteriaUnjukKerja tbody').append(row);
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
