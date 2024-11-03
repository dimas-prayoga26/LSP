<script>
    function handleListTestTulis(elemen) {
        const modalbs = elemen.getAttribute('data-modal');
        const dataRoute = elemen.getAttribute('data-route');
        const kriteriaUnjukKerjaName = elemen.getAttribute('data-kriteriaUnjukKerjaName');
        $.ajax({
            url: dataRoute,
            type: 'GET',
            success: function(response) {
                const data = response.data;
                $('#table-list-testTulis tbody').empty();
                $('#modal-title-testTulis').text('Daftar Ujian Tulis [' + kriteriaUnjukKerjaName + ']');
                $('#' + modalbs).modal('show');

                if(data.length > 0) {
                    $('#empty-dataTable').addClass('d-none');
                    data.forEach(function(item,index) {
                        var row = $('<tr>');
                        const plainText = $('<div>').html(item.pertanyaan).text();
                        row.append($('<td>').text(index+1));
                        row.append($('<td>').text(plainText));
                        $('#table-list-testTulis tbody').append(row);
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
