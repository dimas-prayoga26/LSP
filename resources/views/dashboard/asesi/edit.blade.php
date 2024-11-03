<script>
    function handleEdit(elemen) {
        $('#asesi-modal-title').text('Edit Data Asesi');
        $('#btn-form').text('Update');
        const editRoute = elemen.getAttribute('data-route');
        const uuid = elemen.getAttribute('data-uuid');
        const updateRoute = '{{ route("asesi.update", [":uuid"]) }}';
        const form = $('.needs-validation');
        form.attr('action', updateRoute.replace(':uuid', uuid));
        form.attr('data-method','PUT');
        if ($('#_method').length === 0) {
            form.append('<input type="hidden" name="_method" id="_method" value="PUT">');
            form.append('<input type="hidden" name="asesi_uuid" value="'+uuid+'">');
        }
        $('#modal-asesi').modal('show');
        $.ajax({
            url: editRoute,
            type: 'GET',
            success: function(response) {
                const data = response.data;
                const urlPhoto = `{{ asset('storage/${data.user.photo}') }}`;
                const kelas = $('#kelas_id');

                $('#container-file-photo-show').removeClass('d-none');
                $('#editForm-container').removeClass('d-none');
                $('#editForm-status').removeClass('d-none');
                $('#editForm-status-assesmen').removeClass('d-none');

                $('#username').val(data.user.username);
                $('#status').val(data.user.status);
                $('#status_assesmen').val(data.status);
                $('#nim').val(data.nim);
                $('#name').val(data.user.name);
                $('#email').val(data.user.email);
                $('#phone').val(data.user.phone);
                $('#jenis_kelamin').val(data.user.jenis_kelamin);
                $('#address').val(data.user.address);

                if (kelas.find("option[value='" + data.kelas.nama_kelas + "']").length) {
                    kelas.val(data.kelas.nama_kelas).trigger('change');
                } else {
                    const newOption = new Option(data.kelas.nama_kelas, data.kelas.uuid, true, true);
                    kelas.append(newOption).trigger('change');
                }

                if(data.user.photo) {
                    $('#file-available-photo').html(`<img src="${urlPhoto}" class="rounded-circle" style="width:60px; height:60px"/>`);
                } else {
                    $('#file-available-photo').html('<small class="text-muted font-italic">Empty</small>');
                }
            },
            error: function(xhr, status, error) {
                snackBarAlert('Data gagal dimuat', '#e7515a');
            }
        });
    }
</script>
