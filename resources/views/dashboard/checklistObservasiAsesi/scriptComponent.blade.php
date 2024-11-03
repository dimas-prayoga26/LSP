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
                                <button type="button" onclick="saveSignature()" class="btn btn-primary" data-dismiss="modal">Simpan</button>
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
            canvasAsesi.addEventListener('mousedown', (e) => {
                isDrawingAsesi = true;
                [lastXAsesi, lastYAsesi] = [e.offsetX, e.offsetY];
            });
            canvasAsesi.addEventListener('mousemove', draw);
            canvasAsesi.addEventListener('mouseup', () => isDrawingAsesi = false);
            canvasAsesi.addEventListener('mouseout', () => isDrawingAsesi = false);

            function draw(e) {
                if (!isDrawingAsesi) return;
                ctxAsesi.beginPath();
                ctxAsesi.moveTo(lastXAsesi, lastYAsesi);
                ctxAsesi.lineTo(e.offsetX, e.offsetY);
                ctxAsesi.stroke();
                [lastXAsesi, lastYAsesi] = [e.offsetX, e.offsetY];
            }

            function clearCanvasAsesi() {
                ctxAsesi.clearRect(0, 0, canvasAsesi.width, canvasAsesi.height);
            }

            function saveSignature() {
                const dataURL = canvasAsesi.toDataURL();
                let asesiUuId = @json($asesiId);
                $.ajax({
                    type: 'POST',
                    url: '{{ route('checklistObservasi.asesi-signature') }}',
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
                        clearCanvasAsesi();
                    },
                    error: function(xhr, status, error) {
                        snackBarAlert('Tanda tangan gagal', '#e7515a');
                        clearCanvasAsesi();
                    }
                });
            }
        </script>
    @endcan
    @can('asesor')
        {{-- MODAL TTD ASESOR --}}
        <div class="modal fade" id="create-ttd-asesor" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLongTitle">Tambah Tanda Tangan Asesor</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="modal-body text-center">
                            <canvas id="signatureCanvasAsesor" width="400" height="200" style="border: 1px solid black;"></canvas>
                            <div class="modal-footer bg-transparent d-flex justify-content-center">
                                <button onclick="clearCanvasAsesor()" id="clearCanvasAsesorButton" class="btn btn-outline-danger">Clear Canvas</button>
                                <button type="button" class="btn btn-primary" data-dismiss="modal">Simpan</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        {{-- TTD ASESOR SCRIPT --}}
        <script>
            var canvasAsesor = document.getElementById('signatureCanvasAsesor');
            var ctxAsesor = canvasAsesor.getContext('2d');
            var isDrawingAsesor = false;
            var lastXAsesor = 0;
            var lastYAsesor = 0;
            var inputSignatureAsesor = document.getElementById('signatureAsesor');

            canvasAsesor.addEventListener('mousedown', (e) => {
                isDrawingAsesor = true;
                [lastXAsesor, lastYAsesor] = [e.offsetX, e.offsetY];
            });

            canvasAsesor.addEventListener('mousemove', draw);
            canvasAsesor.addEventListener('mouseup', () => {
                isDrawingAsesor = false;
                updateSignatureInputAsesor();
            });

            canvasAsesor.addEventListener('mouseout', () => {
                isDrawingAsesor = false;
                updateSignatureInputAsesor();
            });

            function draw(e) {
                if (!isDrawingAsesor) return;
                ctxAsesor.beginPath();
                ctxAsesor.moveTo(lastXAsesor, lastYAsesor);
                ctxAsesor.lineTo(e.offsetX, e.offsetY);
                ctxAsesor.stroke();
                [lastXAsesor, lastYAsesor] = [e.offsetX, e.offsetY];
            }

            function updateSignatureInputAsesor() {
                inputSignatureAsesor.value = canvasAsesor.toDataURL();
            }

            function clearCanvasAsesor() {
                inputSignatureAsesor.value = "";
                ctxAsesor.clearRect(0, 0, canvasAsesor.width, canvasAsesor.height);
            }
        </script>
    @endcan
    {{-- GET DATA --}}
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            getData();
        });
        function getData() {
            let asesiUuId = @json($asesiId);
            @can('asesi')
                const buttonFormAsesi = document.getElementById('btn-form');
                buttonFormAsesi.style.display = 'none';
            @endcan
            @can('admin')
                const buttonFormAsesi = document.getElementById('btn-form');
                buttonFormAsesi.style.display = 'none';
            @endcan
            $.ajax({
                url: "{{ route('checklistObservasi.show-by-kelompokAsesor') }}",
                type: 'GET',
                data: {
                    kelompok_asesor: @json($kelompokAsesor['uuid']),
                    asesi_id: asesiUuId
                },
                success: function(response) {
                    const data = response.data;
                    const jawaban = JSON.parse(data.jawaban);
                    const umpanBalik = document.getElementById(`umpan_balik`);
                    const urlTtdAsesi = `{{ asset('storage/${data.ttd_asesi}') }}`;
                    const urlTtdAsesor = `{{ asset('storage/${data.ttd_asesor}') }}`;
                    let dateTtdAsesor = `<span>Tanggal: -</span>`;
                    let dateTtdAsesi = `<span>Tanggal: -</span>`;

                    @can('asesi')
                        if(data != null && data.ttd_asesi != null) {
                            const modalTtdAsesi = document.getElementById('modal-ttdAsesi');
                            modalTtdAsesi.style.display = 'none';
                            const spanElement = document.createElement('span');
                            spanElement.className = 'text-primary ml-2';
                            spanElement.id = 'date-ttdAsesi';
                            modalTtdAsesi.after(spanElement);
                        }
                        document.getElementById('clearCanvasAsesiButton').click();
                    @endcan
                    @can('asesor')
                        if(data != null && data.ttd_asesor != null) {
                            const modalTtdAsesor = document.getElementById('modal-ttdAsesor');
                            const buttonFormAsesi = document.getElementById('btn-form');
                            modalTtdAsesor.style.display = 'none';
                            buttonFormAsesi.style.display = 'none';
                            const spanElement = document.createElement('span');
                            spanElement.className = 'text-primary ml-2';
                            spanElement.id = 'date-ttdAsesor';
                            modalTtdAsesor.after(spanElement);
                        }
                        document.getElementById('clearCanvasAsesorButton').click();
                    @endcan

                    // TTD Asesi & Asesor
                    if(data.ttd_asesi) {
                        $('#available-ttdAsesi').html(`<img style="width: 130px; height: 60px;" src="${urlTtdAsesi}" style="width:70px; height:70px"/>`);
                        dateTtdAsesi = `<span>Tanggal: ${moment(data.tgl_ttd_asesi).format('DD MMMM Y')}</span>`;
                    }
                    if(data.ttd_asesor) {
                        $('#available-ttdAsesor').html(`<img style="width: 130px; height: 60px;" src="${urlTtdAsesor}" style="width:70px; height:70px"/>`);
                        dateTtdAsesor = `<span>Tanggal: ${moment(data.tgl_ttd_asesor).format('DD MMMM Y')}</span>`;
                    }

                    $('#date-ttdAsesor').html(dateTtdAsesor);
                    $('#date-ttdAsesi').html(dateTtdAsesi);

                    umpanBalik.value = data.umpan_balik;

                    jawaban.forEach(item => {
                        const benchmark = document.getElementById(`benchmark[${item.unit_kompetensi_id}][${item.elemen_id}]`);
                        item.observasi.forEach(obs => {
                            const radioButtons = document.querySelectorAll(`input[name="status_observasi[${item.unit_kompetensi_id}][${item.elemen_id}][${obs.kriteria_unjuk_kerja_id}]"]`);
                            const penilaianLanjut = document.getElementById(`penilaian_lanjut[${item.unit_kompetensi_id}][${item.elemen_id}][${obs.kriteria_unjuk_kerja_id}]`);

                            radioButtons.forEach(radio => {
                                if (radio.value === obs.status_observasi) {
                                    radio.checked = true;
                                }

                                if(obs.penilaian_lanjutan) {
                                    penilaianLanjut.value = obs.penilaian_lanjutan;
                                }
                            });
                        });

                        if(item.benchmark) {
                            benchmark.value = item.benchmark;
                        }
                    });
                },
                error: function(xhr, status, error) {
                    snackBarAlert('Data gagal dimuat', '#e7515a');
                }
            });
        }
    </script>
