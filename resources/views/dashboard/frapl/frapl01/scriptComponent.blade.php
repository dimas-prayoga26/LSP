    @can('asesi')
        {{-- MODAL TTD ASESI --}}
        <div class="modal fade" id="create-ttd-asesi" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLongTitle">Tambah Tanda Tangan Asesi</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="modal-body text-center">
                            <canvas id="signatureCanvasAsesi" width="400" height="200" style="border: 1px solid black;"></canvas>
                            <div class="modal-footer bg-transparent d-flex justify-content-center">
                                <button onclick="clearCanvasAsesi()" id="clearCanvasAsesiButton" class="btn btn-outline-danger">Clear Canvas</button>
                                <button type="button" class="btn btn-primary" data-dismiss="modal">Simpan</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        {{-- TTD ASESI SCRIPT --}}
        <script>
            var canvasAsesi = document.getElementById('signatureCanvasAsesi');
            var ctxAsesi = canvasAsesi.getContext('2d');
            var isDrawingAsesi = false;
            var lastXAsesi = 0;
            var lastYAsesi = 0;
            var inputSignatureAsesi = document.getElementById('signatureAsesi');
            canvasAsesi.addEventListener('mousedown', (e) => {
                isDrawingAsesi = true;
                [lastXAsesi, lastYAsesi] = [e.offsetX, e.offsetY];
            });
            canvasAsesi.addEventListener('mousemove', draw);
            canvasAsesi.addEventListener('mouseup', () => {
                isDrawingAsesi = false;
                updateSignatureInputAsesi();
            });
            canvasAsesi.addEventListener('mouseout', () => {
                isDrawingAsesi = false;
                updateSignatureInputAsesi();
            });
            function draw(e) {
                if (!isDrawingAsesi) return;
                ctxAsesi.beginPath();
                ctxAsesi.moveTo(lastXAsesi, lastYAsesi);
                ctxAsesi.lineTo(e.offsetX, e.offsetY);
                ctxAsesi.stroke();
                [lastXAsesi, lastYAsesi] = [e.offsetX, e.offsetY];
            }
            function updateSignatureInputAsesi() {
                inputSignatureAsesi.value = canvasAsesi.toDataURL();
            }
            function clearCanvasAsesi() {
                inputSignatureAsesi.value = "";
                ctxAsesi.clearRect(0, 0, canvasAsesi.width, canvasAsesi.height);
            }
        </script>
    @endcan
    @can('admin')
        {{-- MODAL TTD Admin LSP --}}
        <div class="modal fade" id="create-ttd-adminLSP" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLongTitle">Tambah Tanda Tangan Admin LSP</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="modal-body text-center">
                            <canvas id="signatureCanvasAdminLSP" width="400" height="200" style="border: 1px solid black;"></canvas>
                            <div class="modal-footer bg-transparent d-flex justify-content-center">
                                <button onclick="clearCanvasAdminLSP()" id="clearCanvasAdminLSPButton" class="btn btn-outline-danger">Clear Canvas</button>
                                <button type="button" onclick="saveSignature()" class="btn btn-primary" data-dismiss="modal">Simpan</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        {{-- TTD ADMIN LSP SCRIPT --}}
        <script>
            var canvasAdminLSP = document.getElementById('signatureCanvasAdminLSP');
            var ctxAdminLSP = canvasAdminLSP.getContext('2d');
            var isDrawingAdminLSP = false;
            var lastXAdminLSP = 0;
            var lastYAdminLSP = 0;

            canvasAdminLSP.addEventListener('mousedown', (e) => {
                isDrawingAdminLSP = true;
                [lastXAdminLSP, lastYAdminLSP] = [e.offsetX, e.offsetY];
            });

            canvasAdminLSP.addEventListener('mousemove', draw);
            canvasAdminLSP.addEventListener('mouseup', () => isDrawingAdminLSP = false);
            canvasAdminLSP.addEventListener('mouseout', () => isDrawingAdminLSP = false);

            function draw(e) {
                if (!isDrawingAdminLSP) return;
                ctxAdminLSP.beginPath();
                ctxAdminLSP.moveTo(lastXAdminLSP, lastYAdminLSP);
                ctxAdminLSP.lineTo(e.offsetX, e.offsetY);
                ctxAdminLSP.stroke();
                [lastXAdminLSP, lastYAdminLSP] = [e.offsetX, e.offsetY];
            }

            function clearCanvasAdminLSP() {
                ctxAdminLSP.clearRect(0, 0, canvasAdminLSP.width, canvasAdminLSP.height);
            }

            function saveSignature() {
                const dataURL = canvasAdminLSP.toDataURL();
                let asesiUuId = @json($asesiId);
                $.ajax({
                    type: 'POST',
                    url: '{{ route('frapl01.admin-signature') }}',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    data: {
                        signature: dataURL,
                        kelompok_asesor: @json($kelompokAsesor['uuid']),
                        asesi_id: asesiUuId
                    },
                    success: function(response) {
                        snackBarAlert(response.message, '#1abc9c');
                        getData();
                        clearCanvasAdminLSP();
                    },
                    error: function(xhr, status, error) {
                        snackBarAlert('Tanda tangan gagal', '#e7515a');
                        clearCanvasAdminLSP();
                    }
                });
            }
        </script>
    @endcan
    {{-- GET DATA --}}
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            getData();
            const fileInputs = document.querySelectorAll('input[type="file"][name^="berkasFilePemohon"]');
            fileInputs.forEach(function(fileInput) {
                fileInput.addEventListener('change', function() {
                    const index = fileInput.name.match(/\[(\d+)\]/)[1];
                    const statusSpan = document.getElementById(`uploadStatus_${index}`);
                    if (fileInput.files.length > 0) {
                        statusSpan.textContent = ' (Berhasil Upload)';
                        statusSpan.classList.remove('text-danger');
                        statusSpan.classList.add('text-success');
                    } else {
                        statusSpan.textContent = ' (Belum Upload)';
                        statusSpan.classList.remove('text-success');
                        statusSpan.classList.add('text-danger');
                    }
                });
            });
        });
        function getData() {
            let asesiUuId = @json($asesiId);
            @can('admin')
                const buttonFormAsesi = document.getElementById('btn-form');
                buttonFormAsesi.style.display = 'none';
            @endcan
            $.ajax({
                url: "{{ route('frapl01.show-by-kelompokAsesor') }}",
                type: 'GET',
                data: {
                    kelompok_asesor: @json($kelompokAsesor['uuid']),
                    asesi_id: asesiUuId
                },
                success: function(response) {
                    // Variabel
                    const data = response.data;
                    const tujuanAssesmen = data.tujuan_assesmen;
                    const jenisKelamin = data.asesi.user.jenis_kelamin;
                    const berkasData = JSON.parse(data.berkas_pemohon_asesi);
                    const urlTtdAsesi = `{{ asset('storage/${data.ttd_asesi}') }}`;
                    const urlTtdAdminLSP = `{{ asset('storage/${data.ttd_admin_lsp}') }}`;
                    let dateTtdAdminLSP = `<span>Tanggal: -</span>`;
                    let dateTtdAsesi = `<span>Tanggal: -</span>`;
                    @can('asesor')
                        document.getElementById('btn-form').style.display = 'none';
                    @endcan
                    @can('asesi')
                        if(data != null) {
                            const modalTtdAsesi = document.getElementById('modal-ttdAsesi');
                            const buttonFormAsesi = document.getElementById('btn-form');
                            modalTtdAsesi.style.display = 'none';
                            buttonFormAsesi.style.display = 'none';
                            const spanElement = document.createElement('span');
                            spanElement.className = 'text-primary ml-2';
                            spanElement.id = 'date-ttdAsesi';
                            modalTtdAsesi.after(spanElement);
                        }
                        document.getElementById('clearCanvasAsesiButton').click();
                    @endcan
                    @can('admin')
                        if(data != null && data.ttd_admin_lsp != null) {
                            const modalTtdAdminLSP = document.getElementById('modal-ttdAdminLSP');
                            modalTtdAdminLSP.style.display = 'none';
                            const spanElement = document.createElement('span');
                            spanElement.className = 'text-primary ml-2';
                            spanElement.id = 'date-ttdAdminLSP';
                            modalTtdAdminLSP.after(spanElement);
                        }
                        document.getElementById('clearCanvasAdminLSPButton').click();
                    @endcan

                    // TTD Asesi & Admin LSP
                    if(data.ttd_asesi) {
                        $('#available-ttdAsesi').html(`<img style="width: 130px; height: 60px;" src="${urlTtdAsesi}" style="width:70px; height:70px"/>`);
                        dateTtdAsesi = `<span>Tanggal: ${moment(data.tgl_ttd_asesi).format('DD MMMM Y')}</span>`;
                    }
                    if(data.ttd_admin_lsp) {
                        $('#available-ttdAdminLSP').html(`<img style="width: 130px; height: 60px;" src="${urlTtdAdminLSP}" style="width:70px; height:70px"/>`);
                        dateTtdAdminLSP = `<span>Tanggal: ${moment(data.tgl_ttd_admin_lsp).format('DD MMMM Y')}</span>`;
                    }
                    $('#date-ttdAdminLSP').html(dateTtdAdminLSP);
                    $('#date-ttdAsesi').html(dateTtdAsesi);
                    // Tujuan Assesmen
                    if(tujuanAssesmen === "Sertifikasi") {
                        document.getElementById('ckSertifikasi').checked = true;
                    }
                    if(tujuanAssesmen === "Sertifikasi Ulang") {
                        document.getElementById('ckSertifikasiUlang').checked = true;
                    }
                    if(tujuanAssesmen === "Pengakuan Kompetensi Terkini (PKT)") {
                        document.getElementById('ckPKT').checked = true;
                    }
                    if(tujuanAssesmen === "Rekognisi Pembelajaran Lampau") {
                        document.getElementById('ckRPL').checked = true;
                    }
                    if(tujuanAssesmen === "Lainnya") {
                        document.getElementById('ckLainnya').checked = true;
                    }
                    // Berkas Permohonan
                    berkasData.forEach((item, index) => {
                        // Update radio buttons
                        const radioButtons = document.querySelectorAll(`input[name="statusBerkasPemohon[${index}]"]`);
                        radioButtons.forEach(radio => {
                            if (radio.value === item.keterangan) {
                                radio.checked = true;
                            }
                        });

                        // Update file link and status
                        const fileLink = document.getElementById(`fileLink_${index}`);
                        fileLink.href = `/storage/${item.berkas}`;
                        fileLink.textContent = "Tampilkan file";
                        fileLink.classList.remove('d-none');

                        const uploadStatus = document.getElementById(`uploadStatus_${index}`);
                        if (item.berkas) {
                            uploadStatus.textContent = "(Berhasil Upload)";
                            uploadStatus.classList.remove('text-danger');
                            uploadStatus.classList.add('text-success');
                        }
                    });
                    // Input Lainnya
                    $('#name').val(data.asesi.user.name);
                    $('#email').val(data.asesi.user.email);
                    $('#address').val(data.asesi.user.address);
                    $('#phone').val(data.asesi.user.phone);
                    if(jenisKelamin === "Laki-laki") {
                        document.getElementById('jklakilaki').checked = true;
                    }
                    if(jenisKelamin === "Perempuan") {
                        document.getElementById('jkperempuan').checked = true;
                    }
                    $('#no_ktp').val(data.no_ktp);
                    $('#tempat_lahir').val(data.tempat_lahir);
                    $('#tgl_lahir').val(data.tgl_lahir);
                    $('#kebangsaan').val(data.kebangsaan);
                    $('#kode_pos').val(data.kode_pos);
                    $('#tlp_rumah').val(data.tlp_rumah);
                    $('#tlp_kantor').val(data.tlp_kantor);
                    $('#pendidikan').val(data.pendidikan);
                    $('#nama_institusi').val(data.nama_institusi);
                    $('#jabatan').val(data.jabatan);
                    $('#no_tlp_institusi').val(data.no_tlp_institusi);
                    $('#kode_pos_institusi').val(data.kode_pos_institusi);
                    $('#email_institusi').val(data.email_institusi);
                    $('#fax').val(data.fax);
                    $('#alamat_kantor').val(data.alamat_kantor);
                    $('#catatan').val(data.catatan);
                },
                error: function(xhr, status, error) {
                    snackBarAlert('Data gagal dimuat', '#e7515a');
                }
            });
        }
    </script>
