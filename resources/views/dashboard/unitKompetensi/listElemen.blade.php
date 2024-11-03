<script>
    function handleListElemen(elemen) {
        const modalbs = elemen.getAttribute('data-modal');
        const dataRoute = elemen.getAttribute('data-route');
        const unitKompetensiName = elemen.getAttribute('data-unitKompetensiName');
        $.ajax({
            url: dataRoute,
            type: 'GET',
            success: function(response) {
                const data = response.data;
                $('#table-list-elemen tbody').empty();
                $('#modal-title-elemen').text('Daftar Elemen [' + unitKompetensiName + ']');
                $('#' + modalbs).modal('show');

                if(data.length > 0) {
                    $('#empty-dataTable').addClass('d-none');
                    data.forEach(function(item, index) {
                        var row = $('<tr>');
                        row.append($('<td>').text(index+1));
                        row.append($('<td>').text(item.nama_elemen));
                        $('#table-list-elemen tbody').append(row);
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
