<script>
    function handleDelete(element) {
        const dataRoute = element.getAttribute('data-route');
        swal({
            title: 'Apakah Kamu yakin?',
            text: "Data yang terhapus permanen tidak dapat di kembalikan lagi",
            type: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Hapus',
            cancelButtonText: 'Batal',
            padding: '2em'
            }).then(function(result) {
                if (result.value) {
                    deleteData(dataRoute);
                }
            });
    }

    function deleteData(route) {
        $.ajax({
            url: route,
            type: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            success: function(response) {
                swal(
                    'Terhapus!',
                    'Data terpilih berhasil dihapus permanen',
                    'success'
                    )
                getData();
            },
            error: function(xhr, status, error) {
                swal(
                'Gagal Terhapus!',
                'Data terpilih gagal terhapus',
                'error'
                )
            }
        });
    }
</script>
