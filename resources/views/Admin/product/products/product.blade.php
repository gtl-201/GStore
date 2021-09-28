@extends('index')
@section('product')
    <header>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css"
            integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
        <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.1.4/toastr.min.css">

        <meta name="csrf-token" content="{{ csrf_token() }}">​

        <!-- Page plugins -->
        <!-- Argon CSS -->
        <link rel="stylesheet" href="../css/argon.css" type="text/css">
        <link rel="stylesheet" href="../css/custom.css" type="text/css">

    </header>
    <div class="header bg-primary pb-6">
        <div class="container-fluid">
            <div class="header-body">
                <div class="row align-items-center py-4">
                    <div class="col-lg-6 col-7">
                        <h6 class="h2 text-white d-inline-block mb-0">Kho Hàng {{Session::get('warehouseChoosedId')}}</h6>
                        <nav aria-label="breadcrumb" class="d-none d-md-inline-block ml-md-4">
                            <ol class="breadcrumb breadcrumb-links breadcrumb-dark">
                                <li class="breadcrumb-item"><a href="#"><i class="fas fa-home"></i></a></li>
                                <li class="breadcrumb-item"><a href="#">Kho hàng</a></li>
                                <li class="breadcrumb-item active" aria-current="page">Danh sách</li>
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
                        <h3 class="mb-0" id='table_header_name'>Danh sách sản phẩm trong kho {{Session::get('warehouseChoosedId')}} </h3>
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
                                    <th scope="col" class="col-1">#</th>
                                    <th scope="col" class="sort col-3" data-sort="name">Tên</th>
                                    <th scope="col" class="sort col-4" data-sort="budget">Mô tả</th>
                                    <th scope="col" class="sort col-1" data-sort="status">Loại hàng</th>
                                    <th scope="col" class="col-1">Ảnh sản phẩm</th>
                                    <th scope="col" class="col-1">Giá</th>
                                    <th scope="col" class="col-1">Số lượng còn</th>
                                    <th scope="col" class="col-1">Màu sắc</th>
                                    <th scope="col" class="col-1">Thương hiệu</th>
                                    <th scope="col" class="col-1">Size</th>
                                    {{-- <th scope="col" class="col-1">Trong kho</th> --}}
                                    <th scope="col" class="col-1">Ngày cập nhật</th>
                                </tr>
                            </thead>
                            <tbody class="list" id='tbodyWarehouse'>
                                @if (count($product) > 0)
                                    @if (count($product[0]->product_detail) > 0)
                                        @forelse ($product as $item)
                                            <tr id='productTr-{{ $item->id }}'>
                                                <td class="text-right">
                                                <div class="dropdown">
                                                    <div class="dropdown">
                                                        <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                            Hành động
                                                        </button>
                                                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                                            <button  class="dropdown-item" ​type="button" data-toggle="modal"
                                                            onclick="transfer({{ $item->product_detail[0]->id }})"
                                                            class="btn btn-warning btn-edit">chuyển kho
                                                            </button>
                                                            
                                                            <button  class="dropdown-item" ​type="button" data-toggle="modal"
                                                                onclick="issue({{ $item->product_detail[0]->id }})"
                                                                class="btn btn-warning btn-edit">xuất kho
                                                            </button>
                                                        </div>
                                                    </div> 
                                                </div>
                                                </td>
                                                <th scope="row" class="col-1">
                                                    <div class="media align-items-center">
                                                        <div class="media-body">
                                                            <span class="name mb-0 text-sm" id="name-{{ $item->id }}">
                                                                {{ $item->name }}
                                                            </span>
                                                        </div>
                                                    </div>
                                                </th>

                                                <td class="text-sm col-1" id="descript-{{ $item->id }}">
                                                    {{ $item->descrip }}
                                                </td>

                                                <td class="text-sm col-1" id="typename-{{ $item->id }}">
                                                    {{ $item->typename }}
                                                </td>

                                                <td>
                                                    <div class="avatar-group">
                                                        @forelse ($item->image  as $itemImg)
                                                            <img class="avatar avatar-sm rounded-circle"
                                                                alt="Image placeholder" id='img-{{ $itemImg->id }}'
                                                                src='../{{ $itemImg->image }}'>
                                                        @empty
                                                        @endforelse
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="avatar-group">
                                                        @forelse ($item->product_detail  as $itemProductDetail)
                                                            <a class="text-sm"
                                                                id="price-{{ $itemProductDetail->id }}">
                                                                {{ $itemProductDetail->price }} | 
                                                            </a>
                                                        @empty
                                                        @endforelse
                                                    </div>
                                                </td>

                                                <td>
                                                    <div class="avatar-group">
                                                        @forelse ($item->product_detail  as $itemProductDetail)
                                                            <a class="text-sm"
                                                                id="quantity-{{ $itemProductDetail->id }}">
                                                                {{ $itemProductDetail->quantity }} | 
                                                            </a>
                                                        @empty
                                                        @endforelse
                                                    </div>
                                                </td>

                                                <td>
                                                    @forelse ($item->product_detail  as $itemProductDetail)
                                                        @forelse ($itemProductDetail->color  as $itemProductcolor)
                                                            <a class="text-sm"
                                                                id="color-{{ $itemProductcolor->id }}">
                                                                {{ $itemProductcolor->color }} | 
                                                            </a>
                                                        @empty
                                                        @endforelse
                                                    @empty
                                                    @endforelse
                                                </td>

                                                <td>
                                                    @forelse ($item->product_detail  as $itemProductDetail)
                                                        @forelse ($itemProductDetail->brand  as $itemProductbrand)
                                                            <a class="text-sm"
                                                                id="brand-{{ $itemProductbrand->id }}">
                                                                {{ $itemProductbrand->brand }} | 
                                                            </a>
                                                        @empty
                                                        @endforelse
                                                    @empty
                                                    @endforelse
                                                </td>

                                                <td>
                                                    @forelse ($item->product_detail  as $itemProductDetail)
                                                        @forelse ($itemProductDetail->size  as $itemProductsize)
                                                            <a class="text-sm"
                                                                id="size-{{ $itemProductsize->id }}">
                                                                {{ $itemProductsize->size }} | 
                                                            </a>
                                                        @empty
                                                        @endforelse
                                                    @empty
                                                    @endforelse
                                                </td>

                                                <td class="text-sm" id="updated-{{ $item->id }}">
                                                    {{ date('d-m-Y H:i:s', strtotime($item->updated_at)) }}
                                                </td>
                                            </tr>
                                        @empty
                                        @endforelse
                                    @else

                                    @endif
                                @endif
                            </tbody>

                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal -->
    @include('Admin.product.products.addProduct')
    @include('Admin.warehouse.updateWarehouse')
    @include('Admin.warehouse.addWarehouse_transfer')
    @include('Admin.warehouse.addIssue')

    <script>
        let tableheight = $('#card_table').width() - 5;
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
                scrollY: "100%",
                scrollX: tableheight,
                "order": [
                    [10, "desc"]
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
                scrollY: "100%",
                scrollX: tableheight,

                "order": [
                    [10, "desc"]
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
            var url = $(this).attr('data-url');
            let formSend = new FormData($('#form-add')[0]);
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                type: 'post',
                url: url,
                enctype: 'multipart/form-data',
                contentType: false,
                processData: false,
                data: formSend,
                success: function(response) {
                    $('#table_Theme').DataTable().destroy();
                    // $('#table_Theme').empty();
                    let item = response.data[0];
                    let th = `<tr id='productTr-${item.id }'>`;
                    th += `<td class="text-right">
                            <div class="dropdown">`;

                        th+=`<div class="dropdown">
                                    <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        Hành động
                                    </button>
                                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                        <button  class="dropdown-item" ​type="button" data-toggle="modal"
                                        onclick="transfer(${item.product_detail[0].id })"
                                        class="btn btn-warning btn-edit">chuyển kho
                                        </button>
                                        
                                        <button  class="dropdown-item" ​type="button" data-toggle="modal"
                                            onclick="issue(${item.product_detail[0].id })"
                                            class="btn btn-warning btn-edit">xuất kho
                                        </button>
                                    </div>
                                </div>`;

                    th+=`</div>
                        </td>`;
                    let td1 = `<th scope="row" class="col-1">
                                <div class="media align-items-center">
                                    <div class="media-body">
                                        <span class="name mb-0 text-sm" id="name-${item.id }">
                                            ${item.name }
                                        </span>
                                    </div>
                                </div>
                            </th>`;
                    let td2 = `<td class="text-sm col-1" id="descript-${item.id }">
                                ${item.descrip }
                            </td>

                            <td class="text-sm col-1" id="typename-${item.id }">
                                ${item.typename }
                            </td>`;
                    let td3 = `<td>
                                <div class="avatar-group">`;

                    item.image.map(element => {
                        td3 += `<img class="avatar avatar-sm rounded-circle" alt="Image placeholder"
                                            id='img-${element.id }' src='../${element.image }'>`;
                    });
                    td3 += `</div>
                            </td>`;

                    let td4 = `<td>
                                <div class="avatar-group">`;
                    item.product_detail.map(element => {
                        td4 += `<a class="text-sm"
                                            id="price-${element.id}">
                                            ${element.price} | 
                                        </a>`
                    });
                    td4 += `</div>
                            </td>`;

                    let td5 = `<td>
                            <div class="avatar-group">`;
                    item.product_detail.map(element => {
                        td5 += `<a class="text-sm"
                                            id="quantity-${element.id }">
                                            ${element.quantity } | 
                                        </a>`
                    });
                    td5 += `</div>
                        </td>`;

                    let td6 = `<td>`;
                    item.product_detail.map(element1 => {
                        element1.color.map(element2 => {
                            td6 += `<a class="text-sm" id="color-${element2.id }">
                                            ${element2.color } | 
                                        </a>`
                        });
                    });
                    td6 += `</td>`;

                    let td7 = `<td>`;
                    item.product_detail.map(element1 => {
                        element1.brand.map(element2 => {
                            td7 += `<a class="text-sm" id="brand-${element2.id }">
                                            ${element2.brand } | 
                                        </a>`
                        });
                    });
                    td7 += `</td>`;
                    let td8 = `<td>`;
                    item.product_detail.map(element1 => {
                        element1.size.map(element2 => {
                            td8 += `<a class="text-sm" id="size-${element2.id }">
                                            ${element2.size } | 
                                        </a>`;
                        });
                    });
                    td8 += `</td>`;
                    // let td9 = `<td>`;
                    // item.product_detail.map(element1 => {
                    //     element1.warehouse.map(element2 => {
                    //         td9 += `<a class="text-sm col-1"
                    //                         id="warehouse-${element1.warehouse[0].id }">
                    //                         ${element2.name } | 
                    //                     </a>`
                    //     });
                    // });
                    // td9 += `</td>`;
                    let td10 = `<td class="text-sm" id="updated-${item.id }">
                                    ${ new Date(item.updated_at).getDate() < 10 ? '0' + new Date(item.updated_at).getDate() : new Date(item.updated_at).getDate() }-${new Date(item.updated_at).getMonth() < 10 ? '0' + new Date(item.updated_at).getMonth() : new Date(item.updated_at).getMonth()}-${new Date(item.updated_at).getFullYear()} ${new Date(item.updated_at).getHours()}:${new Date(item.updated_at).getMinutes()}:${new Date(item.updated_at).getSeconds()}
                                </td>
                            </tr>`;

                    console.log(response.data);
                    toastr.options.positionClass = 'toast-bottom-left';
                    toastr.success(response.message, 'Thành công ✨🎉✨');
                    $('#myAddModal').modal('toggle');
                    $('#form-add')[0].reset();
                    $('tbody').prepend(th + td1 + td2 + td3 + td4 + td5 + td6 + td7 + td8 + td10);
                    rebuild();
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    toastr.options.positionClass = 'toast-bottom-left'
                    toastr.error('Thêm kho thất bại', 'Thất bại 👺👹👺')
                }
            })
        })

        
        function transfer(id) {
            $.get('product/product_detail/' + id, function(e) {
                $('#id_product_detail').val(e[0].id);
                $('#myAddModalTransfer').modal('toggle');
                
            });
        }
        function issue(id) {
            $.get('product/product_detail/' + id, function(e) {
                $('#id_product_detail_issue').val(e[0].id);
                $('#myAddModalIssue').modal('toggle');
                
            });
        }
        $("#form-add-transfer").submit(function(e) {
            e.preventDefault();

            let formData = new FormData($('#form-add-transfer')[0]);
            console.log(formData);
            let id = $('#id_product_detail').val();
            let id_warehouse = $('#id_warehouse').val();
            let quantity_transfer = $('#quantity_transfer').val();
            let date_transfer = $('#date_transfer').val();

            if (id !== '' && id_warehouse !== '' && quantity_transfer !== '' && date_transfer !== '') {
                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    url: "product/transfer",
                    type: 'POST',
                    data: formData,
                    contentType: false,
                    processData: false,
                    success: function(res) {
                        $('#table_Theme').DataTable().destroy();
                        let data = res.data;
                        $.get('product/product_detail/' + id, function(result) {
                        $('#quantity-' + data.id_product_detail).text(result[0].quantity);});
                        toastr.options.positionClass = 'toast-bottom-left'
                        toastr.success('Cập nhật kho thành công', 'Thành công ✨🎉✨');
                        $('#myAddModalTransfer').modal('hide');
                        $('#form-add-transfer')[0].reset();
                        
                        rebuild();
                    },
                    error: function(res) {
                        toastr.options.positionClass = 'toast-bottom-left'
                        toastr.error('Cập nhật kho thất bại', 'Thất bại 👺👹👺')
                    }
                })
            }
        });
        $("#form-add-issue").submit(function(e) {
            e.preventDefault();

            let formData = new FormData($('#form-add-issue')[0]);
            console.log(formData);
            let id = $('#id_product_detail_issue').val();
            let quantity_transfer = $('#quantity_issue').val();
            let date_issue = $('#date_issue').val();

            if (id !== '' && quantity_issue !== '' && date_issue !== '') {
                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    url: "product/issue",
                    type: 'POST',
                    data: formData,
                    contentType: false,
                    processData: false,
                    success: function(res) {
                        $('#table_Theme').DataTable().destroy();
                        // $('#table_Theme').empty();
                        let data = res.data;
                        $.get('product/product_detail/' + id, function(result) {
                        $('#quantity-' + data.id_product_detail).text(result[0].quantity);});
                        toastr.options.positionClass = 'toast-bottom-left'
                        toastr.success('Cập nhật kho thành công', 'Thành công ✨🎉✨');
                        $('#myAddModalIssue').modal('hide');
                        $('#form-add-issue')[0].reset();
                        
                        rebuild();
                    },
                    error: function(res) {
                        toastr.options.positionClass = 'toast-bottom-left'
                        toastr.error('Cập nhật kho thất bại', 'Thất bại 👺👹👺')
                    }
                })
            }
        });
        
    </script>
    
    @php
        echo  '<script> var chooseWarehouseID = '.Session::get('warehouseChoosedId').'</script>';
    @endphp 
    <script>
        function checkTransfer() {
           
            $.get('product/product_detail/' + $('#id_product_detail').val(), function(res) {
                // $('#id_warehouse_old').val(e.id_warehouse);
                
                let e = res[0];
                var flag = 0;
                var checkId = 0;
                var checkQuantity = 0;
                let idWarehouse = $('#id_warehouse').val();
                res[1].map(warehouseId => flag += (warehouseId.id == idWarehouse) ? 1 : 0 );
                console.log(parseInt($('#quantity_transfer').val()));
                // console.log($('#id_warehouse').val(), res[1]);
                if(flag > 0){
                    document.getElementById('id_warehouse').style.borderColor = '#43fa38';
                    document.getElementById('error2').innerText = '';

                    if($('#id_warehouse').val() == chooseWarehouseID){
                        document.getElementById('id_warehouse').style.borderColor = '#fc403e';
                        document.getElementById('error2').innerText = 'Bạn đang không ở kho ' + e.id_warehouse;
                        checkId = 0;
                    }else if($('#id_warehouse').val() == e.id_warehouse ){
                        document.getElementById('id_warehouse').style.borderColor = '#fc403e';
                        document.getElementById('error2').innerText = 'Bị trùng kho hiện tại!';
                        checkId = 0;
                    }
                    else{
                        document.getElementById('id_warehouse').style.borderColor = '#43fa38';
                        document.getElementById('error2').innerText = '';
                        checkId = 1;
                    }
                    
                    
                }else{
                    document.getElementById('id_warehouse').style.borderColor = '#fc403e';
                    document.getElementById('error2').innerText = 'Kho không tồn tại!';
                    checkId = 0;
                }
                
                if(parseInt($('#quantity_transfer').val()) >  e.quantity){
                        document.getElementById('quantity_transfer').style.borderColor = '#fc403e';
                        document.getElementById('error').innerText = 'Vượt quá số lượng  ' + e.quantity + ' ở trong kho!';
                        checkQuantity = 0;
                    }else{
                        document.getElementById('quantity_transfer').style.borderColor = '#43fa38';
                        document.getElementById('error').innerText = '';
                        checkQuantity = 1;
                    }

                    if(checkQuantity + checkId == 0){
                        return false;
                    }else{
                        return true;
                    }
            });  
        }
        function checkIssue() {
            
            $.get('product/product_detail/' + $('#id_product_detail_issue').val(), function(res) {
                let e = res[0];
                var checkId = 0;
                var checkQuantity = 0;

                    if(e.id_warehouse != chooseWarehouseID){
                        document.getElementById('id_product_detail_issue').style.borderColor = '#fc403e';
                        document.getElementById('error_issue').innerText = 'Sản phẩm đang ở [kho] ' + e.id_warehouse + ' không ở kho hiện tại [kho] ' + chooseWarehouseID;
                        checkId = 0;
                    }
                    else{
                        document.getElementById('id_product_detail_issue').style.borderColor = '#43fa38';
                        document.getElementById('error_issue').innerText = '';
                        checkId = 1;
                    }
    
                if(parseInt($('#quantity_issue').val()) >  e.quantity){
                        document.getElementById('quantity_issue').style.borderColor = '#fc403e';
                        document.getElementById('error2_issue').innerText = 'Vượt quá số lượng  ' + e.quantity + ' ở trong kho!';
                        checkQuantity = 0;
                    }else{
                        document.getElementById('quantity_issue').style.borderColor = '#43fa38';
                        document.getElementById('error2_issue').innerText = '';
                        checkQuantity = 1;
                    }

                    if(checkQuantity + checkId == 0){
                        return false;
                    }else{
                        return true;
                    }
            });  
        }
    </script>
@endsection
