<script>
    function handleListUnitKompetensi(elemen) {
        const modalbs = elemen.getAttribute('data-modal');
        const dataRoute = elemen.getAttribute('data-route');
        const skemaName = elemen.getAttribute('data-skemaName');
        $.ajax({
            url: dataRoute,
            type: 'GET',
            success: function(response) {
                const data = response.data;
                $('#table-list-unitKompetensi tbody').empty();
                $('#modal-title-unitKompetensi').text('Daftar Unit Kompetensi [' + skemaName + ']');
                $('#' + modalbs).modal('show');

                if(data.length > 0) {
                    $('#empty-dataTable').addClass('d-none');
                    data.forEach(function(item,index) {
                        var row = $('<tr>');
                        row.append($('<td>').text(index+1));
                        row.append($('<td>').text(item.kode_unit));
                        row.append($('<td>').text(item.judul_unit));
                        row.append($('<td>').text(item.jenis_standar));
                        $('#table-list-unitKompetensi tbody').append(row);
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
