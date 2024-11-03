<script>
    function handleEdit(elemen) {
        $('#asesor-modal-title').text('Edit Data Asesor');
        $('#btn-form').text('Update');
        const editRoute = elemen.getAttribute('data-route');
        const uuid = elemen.getAttribute('data-uuid');
        const updateRoute = '{{ route("asesor.update", [":uuid"]) }}';
        const form = $('.needs-validation');
        form.attr('action', updateRoute.replace(':uuid', uuid));
        form.attr('data-method','PUT');
        if ($('#_method').length === 0) {
            form.append('<input type="hidden" name="_method" id="_method" value="PUT">');
            form.append('<input type="hidden" name="asesor_uuid" value="'+uuid+'">');
        }
        $('#modal-asesor').modal('show');
        $.ajax({
            url: editRoute,
            type: 'GET',
            success: function(response) {
                const data = response.data;
                const urlPhoto = `{{ asset('storage/${data.user.photo}') }}`;
                const urlSuratTugas = `{{ asset('storage/${data.surat_tugas}') }}`;

                $('#container-file-photo-show').removeClass('d-none');
                $('#container-file-suratTugas-show').removeClass('d-none');
                $('#editForm-container').removeClass('d-none');
                $('#editForm-status').removeClass('d-none');

                $('#username').val(data.user.username);
                $('#status').val(data.user.status);
                $('#nip').val(data.nip);
                $('#name').val(data.user.name);
                $('#email').val(data.user.email);
                $('#phone').val(data.user.phone);
                $('#jenis_kelamin').val(data.user.jenis_kelamin);
                $('#address').val(data.user.address);
                if(data.user.photo) {
                    $('#file-available-photo').html(`<img src="${urlPhoto}" class="rounded-circle" style="width:60px; height:60px"/>`);
                } else {
                    $('#file-available-photo').html('<small class="text-muted font-italic">Empty</small>');
                }
                if(data.surat_tugas) {
                    $('#file-available-suratTugas').html(`<a href="${urlSuratTugas}" download="Surat Tugas ${data.user.name}.pdf" class="text-primary">Download berkas</a>`);
                } else {
                    $('#file-available-suratTugas').html('<small class="text-muted font-italic">Empty</small>');
                }
            },
            error: function(xhr, status, error) {
                snackBarAlert('Data gagal dimuat', '#e7515a');
            }
        });
    }
</script>
