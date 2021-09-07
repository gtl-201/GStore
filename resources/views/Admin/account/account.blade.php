@extends('index')
@section('account')
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
                        <h6 class="h2 text-white d-inline-block mb-0">Quản lí tài khoản</h6>
                        <nav aria-label="breadcrumb" class="d-none d-md-inline-block ml-md-4">
                            <ol class="breadcrumb breadcrumb-links breadcrumb-dark">
                                <li class="breadcrumb-item"><a href="#"><i class="fas fa-home"></i></a></li>
                                <li class="breadcrumb-item"><a href="#">Quản lí tài khoản</a></li>
                                {{-- <li class="breadcrumb-item active" aria-current="page">Danh sách</li> --}}
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
                        <h3 class="mb-0" id='table_header_name'>Danh sách tài khoản</h3>
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
                                    <th scope="col" class="col">Tên</th>
                                    <th scope="col" class="col">Email</th>
                                    <th scope="col" class="col">User_Name</th>
                                    <th scope="col" class="col">Số điện thoại</th>
                                    <th scope="col" class="col">Địa chỉ</th>
                                    <th scope="col" class="col">Quyền</th>
                                    <th scope="col" class="col">Ngày cập nhật</th>
                                    <th scope="col" class="col"></th>
                                </tr>
                            </thead>
                            <tbody class="list" id='tbodyWarehouse'>
                                @forelse ($account as $item)
                                    <tr id="accountTr-{{$item->id}}">
                                        
                                        <th scope="row">
                                            <div class="media align-items-center">
                                                <a href="#" class="avatar rounded-circle mr-3">
                                                    <img alt="Image placeholder" id="avatar-{{$item->id}}" src="{{asset($item->avartar)}}">
                                                </a>
                                                <div class="media-body">
                                                    <span id="name-{{ $item->id }}" class="name mb-0 text-sm">{{ $item->name }}</span>
                                                </div>
                                            </div>
                                        </th>
                                        <td class="text-sm" id="email-{{ $item->id }}">
                                            {{ $item->email }}
                                        </td>

                                        <td class="text-sm" id="user_name-{{ $item->id }}">
                                            {{ $item->user_name }}
                                        </td>
                                        <td class="text-sm" id="phone-{{ $item->id }}">
                                            {{ $item->phone }}
                                        </td>
                                        <td class="text-sm" id="address-{{ $item->id }}">
                                            {{ $item->address }}
                                        </td>
                                        <td class="text-sm" id="roles-{{ $item->id }}">
                                            @php
                                               if ($item->roles == "1") {
                                                echo "SuperAdmin";
                                            }else {
                                                echo "Admin";
                                            }  
                                            @endphp
                                            
                                            
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
    @include('Admin.account.addAccount')
    @include('Admin.account.update')

    {{-- <script type="text/javascript" charset="utf-8">
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
    </script> --}}
    <script>
        $(document).ready(function() {
            $('#table_Theme').DataTable({
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
                    [5, "asc"]
                ]
            });
        });

        function rebuild() {
            $('#table_Theme').DataTable({
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
                    [5, "asc"]
                ]
            });
        }
    </script>
    <script type="text/javascript">
        function ClickNew() {
            $('#myAddModal').modal('toggle');
        }
        $('#form-add').submit(function(e) {
            e.preventDefault();
            if ($('#pass').val() == $('#repass').val()) {

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
                        console.log(response.data);
                        let {data} = response;
                        let tr = `<tr id="accountTr-${data.id}">
                                        
                                        <th scope="row">
                                            <div class="media align-items-center">
                                                <a href="#" class="avatar rounded-circle mr-3">
                                                    <img alt="Image placeholder" src="../../${data.avartar }">
                                                </a>
                                                <div class="media-body">
                                                    <span class="name mb-0 text-sm">${data.name }</span>
                                                </div>
                                            </div>
                                        </th>
                                        <td class="text-sm" id="color-${data.id }">
                                            ${data.email }
                                        </td>

                                        <td class="text-sm">
                                            ${data.user_name }
                                        </td>
                                        <td class="text-sm">
                                            ${data.phone }
                                        </td>
                                        <td class="text-sm">
                                            ${data.address }
                                        </td>
                                        <td class="text-sm">
                                            ${ new Date(data.updated_at).getDate() < 10 ? '0' + new Date(data.updated_at).getDate() : new Date(data.updated_at).getDate() }-${new Date(data.updated_at).getMonth() < 10 ? '0' + new Date(data.updated_at).getMonth() : new Date(data.updated_at).getMonth()}-${new Date(data.updated_at).getFullYear()} ${new Date(data.updated_at).getHours()}:${new Date(data.updated_at).getMinutes()}:${new Date(data.updated_at).getSeconds()}
                                            
                                        </td>
                                        <td class="text-right">
                                            <div class="dropdown">
                                                <button ​type="button" data-toggle="modal"
                                                    onclick="editWh(${data.id })"
                                                    class="btn btn-warning btn-edit">Edit</button>
                                                <button ​type="button" data-toggle="modal" class="btn btn-danger btn-delete"
                                                    onclick="deleteWh(${data.id })">Delete</button>
                                            </div>
                                        </td>
                                    </tr>`;


                        console.log(response.data);
                        toastr.options.positionClass = 'toast-bottom-left'
                        toastr.success(response.message, 'Thành công ✨🎉✨');
                        $('#myAddModal').modal('toggle');
                        $('#form-add')[0].reset();
                        $('tbody').prepend(tr);
                        rebuild();
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        toastr.options.positionClass = 'toast-bottom-left'
                        toastr.error('Thêm kho thất bại', 'Thất bại 👺👹👺')
                    }
                })
            } else {
                checkpass();
            }
        })

        function deleteWh(id) {
            if (confirm('Bạn có chắc muốn xóa ?')) {
                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    url: "account/" + id,
                    type: 'DELETE',
                    contentType: false,
                    processData: false,
                    success: function(res) {
                        $('#table_Theme').DataTable().destroy();
                        // $('#table_Theme').empty();
                        toastr.options.positionClass = 'toast-bottom-left'
                        toastr.success('Xoá kho thành công', 'Thành công ✨🎉✨')
                        $('#accountTr-' + res.id).remove();
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
            $.get('account/' + id, function(e) {
                $('#id-edit').val(id);
                $('#imageDemoUpdate').attr("src",e.avartar);
                $('#name-edit').val(e.name);
                $('#email-edit').val(e.email);
                $('#user_name-edit').val(e.user_name);
                $('#phone-edit').val(e.phone);
                $('#address-edit').val(e.address);
                $('#roles-edit').val(e.roles);
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
            let name = $('#name-edit').val();
            let email = $('#email-edit').val();
            let user_name = $('#user_name-edit').val();
            let phone = $('#phone-edit').val();
            let address = $('#address-edit').val();
            let roles = $('#roles-edit').val();

            // let avatar = $('#avatar-edit').val();
            

            if ($('#pass').val() == $('#repass').val() && name !== '' && email !== '' && user_name !== ''&& phone !== ''&& address !== ''&& roles !== '') {
                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    url: "account/update",
                    type: 'POST',
                    data: formData,
                    contentType: false,
                    processData: false,
                    success: function(res) {
                        $('#table_Theme').DataTable().destroy();
                        // $('#table_Theme').empty();
                        let data = res.data;

                        $('#name-' + data.id).css("background-color", data.name);
                        $('#avatar-' + data.id).attr("src", "../" + data.avartar);

                        $('#email-' + data.id).text(data.email);
                        $('#user_name-' + data.id).text(data.user_name);
                        $('#phone-' + data.id).text(data.phone);
                        $('#address-' + data.id).text(data.address);
                        $('#roles-' + data.id).text(data.roles);
                        $('#updated-' + data.id).text(
                            `${ new Date(data.updated_at).getDate() < 10 ? '0' + new Date(data.updated_at).getDate() : new Date(data.updated_at).getDate() }-${new Date(data.updated_at).getMonth() < 10 ? '0' + new Date(data.updated_at).getMonth() : new Date(data.updated_at).getMonth()}-${new Date(data.updated_at).getFullYear()} ${new Date(data.updated_at).getHours()}:${new Date(data.updated_at).getMinutes()}:${new Date(data.updated_at).getSeconds()}`
                        );
                        $('#myUpdateModal').modal('hide');
                        $('#form-edit')[0].reset();
                        toastr.options.positionClass = 'toast-bottom-left'
                        toastr.success('Cập nhật kho thành công', 'Thành công ✨🎉✨');
                        rebuild();
                    },
                    error: function(res) {
                        toastr.options.positionClass = 'toast-bottom-left'
                        toastr.error('Cập nhật kho thất bại', 'Thất bại 👺👹👺')
                    }
                })
            }else{
                checkpass();
            }
        });
    </script>
    {{-- @php
        if(isset($err)){    
            echo("<div class='alert alert-primary' role='alert'>".$err."</div>");
        }
    @endphp --}}
    <script>
        function openPicAdd(obj) {
            document.getElementById('imageDemoAdd').src = URL.createObjectURL(obj.files[0]);
        }

        function openPicUpdate(obj) {
            document.getElementById('imageDemoUpdate').src = URL.createObjectURL(obj.files[0]);
        }
        var pass = '';
        var repass = '';
        // function savepass(obj){
        //    var pass = obj.value;
        //    if(pass == repass){
        //        return true;
        //    }else{
        //        return false;
        //    }

        // } 

        function checkpass() {

            if ($('#pass').val() == $('#repass').val()) {
                document.getElementById('repass').style.borderColor = '#43fa38';
                document.getElementById('pass').style.borderColor = '#43fa38';

                return true;
            } else {
                document.getElementById('repass').style.borderColor = '#fc403e';
                document.getElementById('pass').style.borderColor = '#fc403e';
                return false;
            }

        }
    </script>
@endsection
