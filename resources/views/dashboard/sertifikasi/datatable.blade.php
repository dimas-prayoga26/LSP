<script>
    function getData() {
        const table = $('#table-sertifikasi');
        
        const dataRoute = table.data('route');
        console.log(dataRoute);

        $.ajax({
            url: dataRoute,
            type: 'GET',
            dataType: 'json',
            success: function(response) {
                const data = response.data;
                const deleteRoute = '{{ route("sertifikasi.destroy", [":uuid"]) }}';
                const uploadRoute = '{{ route("sertifikasi.upload", [":uuid"]) }}'; // route untuk upload sertifikat
                console.log(data);
                
                table.DataTable({
                    "dom": "<'dt--top-section'<'row'<'col-12 col-sm-6 d-flex justify-content-sm-start justify-content-center'l><'col-12 col-sm-6 d-flex justify-content-sm-end justify-content-center mt-sm-0 mt-3'f>>>" +
                        "<'table-responsive'tr>" +
                        "<'dt--bottom-section d-sm-flex justify-content-sm-between text-center'<'dt--pages-count  mb-sm-0 mb-3'i><'dt--pagination'p>>",
                    "oLanguage": {
                        "oPaginate": {
                            "sPrevious": '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-arrow-left"><line x1="19" y1="12" x2="5" y2="12"></line><polyline points="12 19 5 12 12 5"></polyline></svg>',
                            "sNext": '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-arrow-right"><line x1="5" y1="12" x2="19" y2="12"></line><polyline points="12 5 19 12 12 19"></polyline></svg>'
                        },
                        "sInfo": "Showing page _PAGE_ of _PAGES_",
                        "sSearch": '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-search"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>',
                        "sSearchPlaceholder": "Search...",
                        "sLengthMenu": "Results :  _MENU_",
                    },
                    "stripeClasses": [],
                    "lengthMenu": [5, 10, 20, 50],
                    "pageLength": 5,
                    "destroy": true,
                    "data": data,
                    "columns": [
                        {
                            data: 'uuid',
                            render: function(data) {
                                const deleteRouteRendered = deleteRoute.replace(':uuid', data);
                                // const editRouteRendered = editRoute.replace(':uuid', data);

                                return `
                                    <div class="">
                                        <a class="dropdown-toggle" href="javascript:void(0);" role="button" id="dropdownMenuLink10" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" title="More menu">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-more-horizontal"><circle cx="12" cy="12" r="1"></circle><circle cx="19" cy="12" r="1"></circle><circle cx="5" cy="12" r="1"></circle></svg>
                                        </a>
                                        <div class="dropdown-menu left" aria-labelledby="dropdownMenuLink10" style="will-change: transform; position: absolute; transform: translate3d(-141px, 19px, 0px); top: 0px; left: 0px;" x-placement="bottom-end">
                                            <a class="dropdown-item" href="javascript:void(0);" onclick="handleDelete(this)" data-route="${deleteRouteRendered}" title="Delete Asesor">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x-square"><rect x="3" y="3" width="18" height="18" rx="2" ry="2"></rect><line x1="9" y1="9" x2="15" y2="15"></line><line x1="15" y1="9" x2="9" y2="15"></line></svg>
                                                Delete Asesor
                                            </a>
                                        </div>
                                    </div>`;
                            }
                        },
                        {
                            data: 'asesi.user',
                            render: function(data) {
                                return data ? data.name : 'N/A';
                            }
                        },
                        {
                            data: 'asesi',
                            render: function(data) {
                                if (data && data.is_qualification) {
                                    return `<span class="badge badge-success">Kompeten</span>`;
                                } else {
                                    return `<span class="badge badge-danger">Belum Kompeten</span>`;
                                }
                            }
                        },
                        {
                            data: 'uuid',
                            render: function(data) {
                                const uploadRouteRendered = '{{ route("sertifikasi.upload", ":uuid") }}'.replace(':uuid', data);
                                return `<button class="btn btn-primary" onclick="submitCertificate('${uploadRouteRendered}')">Upload Sertifikat</button>`;
                            }
                        }
                    ]
                });
            },
            error: function(xhr, status, error) {
                snackBarAlert('Data gagal termuat', '#e7515a');
            }
        });

    }

    function submitCertificate(url) {
    $.ajax({
        url: url,
        type: 'POST',  // Pastikan menggunakan POST
        success: function(response) {
            snackBarAlert(response.message, '#1abc9c');
            getData();  // Panggil fungsi untuk memperbarui data
            clearCanvasAsesi();  // Bersihkan canvas tanda tangan
        },
        error: function(xhr, status, error) {
            // Tampilkan pesan error spesifik dari response
            let errorMessage = '';

            // Jika ada response JSON, ambil pesan kesalahannya
            if (xhr.responseJSON && xhr.responseJSON.message) {
                errorMessage = xhr.responseJSON.message;
            } else {
                // Jika tidak, tampilkan pesan status dan error yang diambil dari server
                errorMessage = `Error ${xhr.status}: ${status} - ${error}`;
            }

            // Gunakan snackBarAlert atau alert untuk menampilkan error
            snackBarAlert('Certificated error generate: ' + errorMessage, '#e7515a');
            clearCanvasAsesi();  // Bersihkan canvas tanda tangan
        }
    });
}

</script>
