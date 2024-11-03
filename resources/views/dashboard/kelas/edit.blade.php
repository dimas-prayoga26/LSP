<script>
    function handleEdit(elemen) {
        $('#kelas-modal-title').text('Edit Data Kelas');
        $('#btn-form').text('Update');
        const editRoute = elemen.getAttribute('data-route');
        const uuid = elemen.getAttribute('data-uuid');
        const updateRoute = '{{ route("kelas.update", [":uuid"]) }}';
        const form = $('.needs-validation');
        form.attr('action', updateRoute.replace(':uuid', uuid));
        form.attr('data-method','PUT');

        if ($('#_method').length === 0) {
            form.append('<input type="hidden" name="_method" id="_method" value="PUT">');
        }
        $('#modal-kelas').modal('show');
        $.ajax({
            url: editRoute,
            type: 'GET',
            success: function(response) {
                const data = response.data;
                const jurusanSelect = $('#jurusan_id');

                $('#nama_kelas').val(data.nama_kelas);
                $('#keterangan').val(data.keterangan);
                if (jurusanSelect.find("option[value='" + data.jurusan.nama_jurusan + "']").length) {
                    jurusanSelect.val(data.jurusan.nama_jurusan).trigger('change');
                } else {
                    const newOption = new Option(data.jurusan.nama_jurusan, data.jurusan.uuid, true, true);
                    jurusanSelect.append(newOption).trigger('change');
                }
            },
            error: function(xhr, status, error) {
                snackBarAlert('Data gagal dimuat', '#e7515a');
            }
        });
    }
</script>
