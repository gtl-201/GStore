@extends('index')
@section('product')
    <header>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css"
            integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
        <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.1.4/toastr.min.css">

        <meta name="csrf-token" content="{{ csrf_token() }}">​

        <!-- Page plugins -->
        <!-- Argon CSS -->
        <link rel="stylesheet" href="{{ asset('css/argon.css') }}" type="text/css">
        <link rel="stylesheet" href="{{ asset('css/custom.css') }}" type="text/css">
    </header>
    <div class="header bg-primary pb-6">
        <div class="container-fluid">
            <div class="header-body">
                <div class="row align-items-center py-4">
                    <div class="col-lg-6 col-7">
                        <h6 class="h2 text-white d-inline-block mb-0">Màu sắc</h6>
                        <nav aria-label="breadcrumb" class="d-none d-md-inline-block ml-md-4">
                            <ol class="breadcrumb breadcrumb-links breadcrumb-dark">
                                <li class="breadcrumb-item"><a href="#"><i class="fas fa-home"></i></a></li>
                                <li class="breadcrumb-item"><a href="#">Sản phẩm</a></li>
                                {{-- <li class="breadcrumb-item active" aria-current="page">Thuộc tính</li> --}}
                                <li class="breadcrumb-item active" aria-current="page">Màu sắc</li>
                            </ol>
                        </nav>
                    </div>
                    <div class="col-lg-6 col-5 text-right">
                        <a href="#" class="btn btn-sm btn-neutral text-sm" onclick="ClickNew()">Thêm mới</a>
                        {{-- <a href="#" class="btn btn-sm btn-neutral">Filters</a> --}}
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Page content -->
    <div class="container-fluid mt--6">
        <div class="row">
            <div class="col">
                <div class="card" id='card_table'>
                    <!-- Card header -->
                    <div class="card-header border-0" id='header_table' onclick="tb_theme()">
                        <h3 class="mb-0" id='table_header_name'>Danh sách màu</h3>
                    </div>
                    <script>
                        function tb_theme() {
                            document.getElementById('card_table').classList.toggle('bg-default');
                            document.getElementById('card_table').classList.toggle('shadow');
                            document.getElementById('table_header_name').classList.toggle('text-white');
                            document.getElementById('table_Theme').classList.toggle('table-dark');
                            document.getElementById('thead_Theme').classList.toggle('thead-dark');
                            document.getElementById('header_table').classList.toggle('bg-transparent');
                            document.getElementById('panigation_table').classList.toggle('bg-default');
                            document.getElementById('panigation_table').classList.toggle('shadow');
                        }
                    </script>
                    <!-- Light table -->
                    <div class="table-responsive">
                        <table class="table align-items-center table-flush" id='table_Theme'>
                            <thead class="___class_+?23___" id='thead_Theme'>
                                <tr>
                                    <th scope="col" class="sort col-3" data-sort="name">Mã màu</th>
                                    <th scope="col" class="sort col-4" data-sort="budget">Tên màu</th>
                                    <th scope="col" class="col-1">Ngày cập nhật</th>
                                    <th scope="col" class="col-1"></th>
                                </tr>
                            </thead>
                            <tbody class="list" id='tbodyWarehouse'>
                                @forelse ($color as $item)
                                    <tr id='colorTr-{{ $item->id }}'>
                                        <th scope="row">
                                            <div class="media align-items-center">
                                                <div id='hexIndex-{{ $item->id }}' href="#"
                                                    class="avatar rounded-circle mr-3"
                                                    style="background-color: {{ $item->hex }}">
                                                </div>
                                                <div class="media-body">
                                                    <span class="name mb-0 text-sm" id="name-{{ $item->id }}">
                                                        {{ $item->hex }}
                                                    </span>
                                                </div>
                                            </div>
                                        </th>

                                        <td class="text-sm" id="color-{{ $item->id }}">
                                            {{ $item->color }}
                                        </td>

                                        <td class="text-sm" id="updated-{{ $item->id }}">
                                            {{ date('d-m-Y H:i:s', strtotime($item->updated_at)) }}
                                        </td>

                                        <td class="text-right">
                                            <div class="dropdown">
                                                <button ​type="button" data-toggle="modal"
                                                    onclick="editWh({{ $item->id }})"
                                                    class="btn btn-warning btn-edit">Edit</button>
                                                <button ​type="button" data-toggle="modal" class="btn btn-danger btn-delete"
                                                    onclick="deleteWh({{ $item->id }})">Delete</button>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                @endforelse
                            </tbody>

                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal -->
    @include('Admin.product.attribute.addColor')
    @include('Admin.product.attribute.updateColor')

    {{-- <script type="text/javascript" charset="utf-8">
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
    </script> --}}
    <script>
        var dtTable;
        $(document).ready(function() {
            dtTable = $('#table_Theme').DataTable({
                language: {
                    sProcessing: "Đang xử lý...",
                    sSearch: "Tìm:",
                    sLengthMenu: "Xem _MENU_ mục",
                    sZeroRecords: "Không tìm thấy dòng nào phù hợp",
                    sInfo: "Đang xem _START_ đến _END_ trong tổng số _TOTAL_ mục",
                    sInfoEmpty: "Đang xem 0 đến 0 trong tổng số 0 mục",
                    sInfoFiltered: "(được lọc từ _MAX_ mục)",
                    sInfoPostFix: "",
                    sUrl: "",
                    paginate: {
                        previous: "<i class='ni ni-bold-left'>",
                        next: "<i class='ni ni-bold-right'>"
                    },
                },
                "order": [
                    [2, "desc"]
                ],
                dom: 'Bfrtip',
                buttons: [
                    'copy', 'csv', 'excel', 'pdf', 'print'
                ],
            });
            dtTable.button(0).text('Sao chép');
            dtTable.button(1).text('Xuất file CSV');
            dtTable.button(2).text('Xuất file Excel');
            dtTable.button(3).text('Xuất file PDF');
            dtTable.button(4).text('In');
        });

        function rebuild() {
            dtTable = $('#table_Theme').DataTable({
                language: {
                    sProcessing: "Đang xử lý...",
                    sSearch: "Tìm:",
                    sLengthMenu: "Xem _MENU_ mục",
                    sZeroRecords: "Không tìm thấy dòng nào phù hợp",
                    sInfo: "Đang xem _START_ đến _END_ trong tổng số _TOTAL_ mục",
                    sInfoEmpty: "Đang xem 0 đến 0 trong tổng số 0 mục",
                    sInfoFiltered: "(được lọc từ _MAX_ mục)",
                    sInfoPostFix: "",
                    sUrl: "",
                    paginate: {
                        previous: "<i class='ni ni-bold-left'>",
                        next: "<i class='ni ni-bold-right'>"
                    },
                },
                "order": [
                    [2, "desc"]
                ],
                dom: 'Bfrtip',
                buttons: [
                    'copy', 'csv', 'excel', 'pdf', 'print'
                ],
            });
            dtTable.button(0).text('Sao chép');
            dtTable.button(1).text('Xuất file CSV');
            dtTable.button(2).text('Xuất file Excel');
            dtTable.button(3).text('Xuất file PDF');
            dtTable.button(4).text('In');
        }
    </script>
    <script type="text/javascript">
        function ClickNew() {
            $('#myAddModal').modal('toggle');
        }
        $('#form-add').submit(function(e) {
            e.preventDefault();
            var url = $(this).attr('data-url');
            let formSend = new FormData($('#form-add')[0]);
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                type: 'post',
                url: url,
                contentType: false,
                processData: false,
                data: formSend,
                success: function(response) {
                    $('#table_Theme').DataTable().destroy();
                    // $('#table_Theme').empty();

                    let item = response.data;
                    let th = `<tr id='colorTr-${ item.id }'>
                                <th scope="row">
                                    <div class="media align-items-center">
                                        <div id='hexIndex-${ item.id }' href="#" class="avatar rounded-circle mr-3" style="background-color: ${ item.hex }">
                                        </div>
                                        <div class="media-body">
                                            <span class="name mb-0 text-sm" id="name-${ item.id }">
                                                ${ item.hex }
                                            </span>
                                        </div>
                                    </div>
                                </th>`;
                    let td1 = `<td class="text-sm" id="color-${ item.id }">
                                ${ item.color }
                            </td>`

                    let td2 = ` <td class="text-sm" id="updated-${ item.id }">
                                    ${ new Date(item.updated_at).getDate() < 10 ? '0' + new Date(item.updated_at).getDate() : new Date(item.updated_at).getDate() }-${new Date(item.updated_at).getMonth() < 10 ? '0' + new Date(item.updated_at).getMonth() : new Date(item.updated_at).getMonth()}-${new Date(item.updated_at).getFullYear()} ${new Date(item.updated_at).getHours()}:${new Date(item.updated_at).getMinutes()}:${new Date(item.updated_at).getSeconds()}
                                 </td>`;

                    let td3 = `<td class="text-right">
                                    <div class="dropdown">
                                        <button ​type="button" data-toggle="modal"
                                            onclick="editWh(${ item.id })"
                                            class="btn btn-warning btn-edit">Edit</button>
                                        <button ​type="button" data-toggle="modal" class="btn btn-danger btn-delete"
                                            onclick="deleteWh(${ item.id })">Delete</button>
                                    </div>
                                </td>
                            </tr>`;

                    console.log(response.data);
                    toastr.options.positionClass = 'toast-bottom-left'
                    toastr.success(response.message, 'Thành công ✨🎉✨');
                    $('#myAddModal').modal('toggle');
                    $('#form-add')[0].reset();
                    $('tbody').prepend(th + td1 + td2 + td3);
                    rebuild();
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    toastr.options.positionClass = 'toast-bottom-left'
                    toastr.error('Thêm màu thất bại', 'Thất bại 👺👹👺')
                }
            })
        })

        function deleteWh(id) {
            if (confirm('Bạn có chắc muốn xóa ?')) {
                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    url: "color/" + id,
                    type: 'DELETE',
                    contentType: false,
                    processData: false,
                    success: function(res) {
                        $('#table_Theme').DataTable().destroy();
                        // $('#table_Theme').empty();
                        toastr.options.positionClass = 'toast-bottom-left'
                        toastr.success('Xoá kho thành công', 'Thành công ✨🎉✨')
                        $('#colorTr-' + res.id).remove();
                        rebuild();
                    },
                    error: function(res) {
                        toastr.options.positionClass = 'toast-bottom-left'
                        toastr.error('Xoá kho thất bại', 'Thất bại 👺👹👺')
                    }
                });
            }
        }

        function editWh(id) {
            $.get('color/' + id, function(e) {
                $('#id').val(id);
                $('#color-edit').val(e.color);
                $('#hex-edit').val(e.hex);
                $("#hexDemoUpdate").css("background-color", e.hex);
                $('#myUpdateModal').modal('toggle');
                setTimeout(() => {
                    e.status !== 1 ? $('#index2').click() : $('#index1').click();
                }, 150);
                console.log(e.avatar);
            });
        }

        $("#form-edit").submit(function(e) {
            e.preventDefault();

            let formData = new FormData($('#form-edit')[0]);
            console.log(formData);
            let color = $('#color-edit').val();
            let hex = $('#hex-edit').val();
            // let avatar = $('#avatar-edit').val();

            if (color !== '' && hex !== '') {
                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    url: "color/update",
                    type: 'POST',
                    data: formData,
                    contentType: false,
                    processData: false,
                    success: function(res) {
                        $('#table_Theme').DataTable().destroy();
                        // $('#table_Theme').empty();
                        let data = res.data;

                        $('#hexIndex-' + data.id).css("background-color", data.hex);
                        // document.getElementById('hexIndex-2').style.backgroundColor= e.hex;
                        $('#name-' + data.id).text(data.hex);
                        $('#color-' + data.id).text(data.color);
                        $('#updated-' + data.id).text(
                            `${ new Date(data.updated_at).getDate() < 10 ? '0' + new Date(data.updated_at).getDate() : new Date(data.updated_at).getDate() }-${new Date(data.updated_at).getMonth() < 10 ? '0' + new Date(data.updated_at).getMonth() : new Date(data.updated_at).getMonth()}-${new Date(data.updated_at).getFullYear()} ${new Date(data.updated_at).getHours()}:${new Date(data.updated_at).getMinutes()}:${new Date(data.updated_at).getSeconds()}`
                        );
                        $('#myUpdateModal').modal('hide');
                        $('#form-edit')[0].reset();
                        toastr.options.positionClass = 'toast-bottom-left'
                        toastr.success('Cập nhật màu thành công', 'Thành công ✨🎉✨');
                        rebuild();
                    },
                    error: function(res) {
                        toastr.options.positionClass = 'toast-bottom-left'
                        toastr.error('Cập nhật màu thất bại', 'Thất bại 👺👹👺')
                    }
                })
            }
        });
    </script>
    {{-- @php
        if(isset($err)){    
            echo("<div class='alert alert-primary' role='alert'>".$err."</div>");
        }
    @endphp --}}
    <script>
        function openHexAdd(obj) {
            $("#hexDemoAdd").css("background-color", obj.value);
        }

        function openHexUpdate(obj) {
            $("#hexDemoUpdate").css("background-color", obj.value);
        }
    </script>
@endsection
