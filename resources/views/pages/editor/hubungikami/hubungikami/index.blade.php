@extends('layouts.editor')
@section('title')
    Hubungi Kami - Pesan Masuk
@endsection

@section('content')
<div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Pesan Masuk - Hubungi Kami</h1>
        
        <form action="" id="form_cari" method="post">
            @csrf
            <div class="input-group">
                <input type="text" class="form-control" placeholder="Cari pesan atau ID" name="cari" id="cari">
                <div class="input-group-append">
                    <button class="d-none d-sm-inline-block btn btn-sm btn-info shadow-sm" type="button" id="btn-cari">Cari</button>
                </div>
            </div>
        </form>
    </div>

    <!-- Stats Cards -->
    <div class="row mb-4">
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Total Pesan</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800" id="totalMessages">0</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-envelope fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-warning shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">Belum Dibaca</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800" id="unreadMessages">0</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-envelope-open fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Sudah Dibaca</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800" id="readMessages">0</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-envelope-open-text fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-info shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Hari Ini</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800" id="todayMessages">0</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-calendar-day fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Data Pesan Masuk</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="ThubungiKami" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>Nama Lengkap</th>
                            <th>Email</th>
                            <th>No. Telepon</th>
                            <th>Pesan</th>
                            <th>Status</th>
                            <th>Tanggal</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Detail Modal -->
<div class="modal fade" id="detailModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Detail Pesan</h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label><strong>Nama Lengkap:</strong></label>
                            <p id="detail_full_name" class="form-control-plaintext"></p>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label><strong>Email:</strong></label>
                            <p id="detail_email" class="form-control-plaintext"></p>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label><strong>No. Telepon:</strong></label>
                            <p id="detail_phone" class="form-control-plaintext"></p>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label><strong>Tanggal:</strong></label>
                            <p id="detail_created_at" class="form-control-plaintext"></p>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label><strong>Pesan:</strong></label>
                    <div id="detail_message" class="form-control" style="min-height: 100px; white-space: pre-wrap;"></div>
                </div>
                <div class="form-group">
                    <label><strong>Status:</strong></label>
                    <p id="detail_status" class="form-control-plaintext"></p>
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-secondary" type="button" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
@endsection

@section('script')
<script>
    $('document').ready(function(e){
        // Load stats on page load
        loadStats();
        
        var ThubungiKami = $('#ThubungiKami').DataTable({
            "responsive": true,
            'searching': false,
            "processing": true,
            "serverSide": true,
            "pagingType": "full_numbers",
            "paging": true,
            "ajax": {
                "url": "{{ route('editor.hubungi-kami.data') }}",
                "data": function(parm){
                    parm.search = $('#cari').val();
                },
            },
            "columns": [
                {"data": "full_name_display", "orderable": false},
                {"data": "email_display", "orderable": false},
                {"data": "phone_display", "orderable": false},
                {"data": "message_display", "orderable": false},
                {"data": "status_display", "orderable": false},
                {"data": "created_at_display", "orderable": false},
                {"data": "action", "orderable": false}
            ]
        });
        
        function redraw(){
            ThubungiKami.draw();
            loadStats(); // Reload stats after any action
        }
        
        function loadStats() {
            $.ajax({
                url: "{{ route('editor.hubungi-kami.stats') }}",
                type: "GET",
                dataType: "JSON",
                success: function(data) {
                    if(data.success == 1) {
                        $('#totalMessages').text(data.data.total);
                        $('#unreadMessages').text(data.data.unread);
                        $('#readMessages').text(data.data.read);
                        $('#todayMessages').text(data.data.today);
                    }
                }
            });
        }
        
        $("#btn-cari").click(function(){
            ThubungiKami.draw();
        });
        
        // Detail button
        $("#ThubungiKami tbody").on('click', '.btnDetail', function(){
            let data = ThubungiKami.row($(this).parents('tr')).data();
            let idData = $(this).data('id');
            
            $.ajax({
                url: "{{ route('editor.hubungi-kami.detail') }}",
                type: "GET",
                data: {
                    "_token": "{{ csrf_token() }}",
                    'id': idData
                },
                dataType: "JSON",
                cache: false,
                beforeSend: function(){
                    $('.loading-clock').css('display','flex');
                },
                success: function(data) {
                    if(data.success == 1){
                        $('#detail_full_name').text(data.data.full_name);
                        $('#detail_email').text(data.data.email);
                        $('#detail_phone').text(data.data.phone);
                        $('#detail_message').text(data.data.message);
                        $('#detail_created_at').text(data.data.created_at);
                        $('#detail_status').html(data.data.is_read ? 
                            '<span class="badge badge-success">Sudah Dibaca</span>' : 
                            '<span class="badge badge-warning">Belum Dibaca</span>'
                        );
                        
                        $("#detailModal").modal("show");
                    } else {
                        toastr_error(data.messages);
                    }
                },
                complete: function(){
                    $('.loading-clock').css('display','none');
                }
            });
        });
        
        // Toggle read status
        $("#ThubungiKami tbody").on('click', '.btnRead', function(){
            let idData = $(this).data('id');
            
            $.ajax({
                url: "{{ route('editor.hubungi-kami.toggle-read') }}",
                type: "POST",
                data: {
                    "_token": "{{ csrf_token() }}",
                    'id': idData
                },
                dataType: "JSON",
                cache: false,
                beforeSend: function(){
                    $('.loading-clock').css('display','flex');
                },
                success: function(data) {
                    if(data.success == 1){
                        toastr_success(data.messages);
                        redraw();
                    } else {
                        toastr_error(data.messages);
                    }
                },
                complete: function(){
                    $('.loading-clock').css('display','none');
                }
            });
        });
        
        // Delete button
        $("#ThubungiKami tbody").on('click', '.btnDelete', function(){
            let idData = $(this).data('id');
            
            Swal.fire({
                title: "Are you sure?",
                text: "You won't be able to revert this!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Yes, delete it!"
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: "{{ route('editor.hubungi-kami.delete') }}",
                        type: "DELETE",
                        data: {
                            "_token": "{{ csrf_token() }}",
                            'id': idData
                        },
                        dataType: "JSON",
                        cache: false,
                        beforeSend: function(){
                            $('.loading-clock').css('display','flex');
                        },
                        success: function(data) {
                            if(data.success == 1){
                                toastr_success(data.messages);
                                redraw();
                            } else {
                                toastr_error(data.messages);
                            }
                        },
                        complete: function(){
                            $('.loading-clock').css('display','none');
                        }
                    }); 
                }
            });
        });
        
        function toastr_success(msg){
            const Toast = Swal.mixin({
                toast: true,
                position: "top-end",
                showConfirmButton: false,
                timer: 3000,
                timerProgressBar: true,
                didOpen: (toast) => {
                    toast.onmouseenter = Swal.stopTimer;
                    toast.onmouseleave = Swal.resumeTimer;
                }
            });
            Toast.fire({
                icon: "success",
                title: msg
            });
        }
        
        function toastr_error(msg){
            const Toast = Swal.mixin({
                toast: true,
                position: "top-end",
                showConfirmButton: false,
                timer: 3000,
                timerProgressBar: true,
                didOpen: (toast) => {
                    toast.onmouseenter = Swal.stopTimer;
                    toast.onmouseleave = Swal.resumeTimer;
                }
            });
            Toast.fire({
                icon: "error",
                title: msg
            });
        }
    });
</script>
@endsection