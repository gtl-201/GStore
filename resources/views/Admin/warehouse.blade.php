@extends('index')
@section('product')
    <div class="header bg-primary pb-6">
        <div class="container-fluid">
            <div class="header-body">
                <div class="row align-items-center py-4">
                    <div class="col-lg-6 col-7">
                        <h6 class="h2 text-white d-inline-block mb-0">Kho Hàng</h6>
                        <nav aria-label="breadcrumb" class="d-none d-md-inline-block ml-md-4">
                            <ol class="breadcrumb breadcrumb-links breadcrumb-dark">
                                <li class="breadcrumb-item"><a href="#"><i class="fas fa-home"></i></a></li>
                                <li class="breadcrumb-item"><a href="#">Kho hàng</a></li>
                                <li class="breadcrumb-item active" aria-current="page">Danh sách</li>
                            </ol>
                        </nav>
                    </div>
                    <div class="col-lg-6 col-5 text-right">
                        <a href="#" class="btn btn-sm btn-neutral">New</a>
                        <a href="#" class="btn btn-sm btn-neutral">Filters</a>
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
                        <h3 class="mb-0" id='table_header_name'>Danh sách kho hàng</h3>
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
                            <thead class="" id='thead_Theme'>
                                <tr>
                                    <th scope="col" class="sort" data-sort="name">Tên</th>
                                    <th scope="col" class="sort" data-sort="budget">Địa chỉ</th>
                                    <th scope="col" class="sort" data-sort="status">Trạng thái</th>
                                    {{-- <th scope="col">Users</th>
                                    <th scope="col" class="sort" data-sort="completion">Completion</th>
                                    <th scope="col"></th> --}}
                                </tr>
                            </thead>
                            <tbody class="list">
                                @forelse ($warehouseList as $item)
                                    <tr>
                                        <th scope="row">
                                            <div class="media align-items-center">
                                                <a href="#" class="avatar rounded-circle mr-3">
                                                    <img alt="Image placeholder" src="@php
                                                        echo('../../'.$item -> avatar)
                                                    @endphp">
                                                </a>
                                                <div class="media-body">
                                                    <span class="name mb-0 text-sm">
                                                        @php
                                                            echo $item->name;
                                                        @endphp
                                                    </span>
                                                </div>
                                            </div>
                                        </th>
                                        <td class="text-sm">
                                            @php
                                                echo $item->address;
                                            @endphp
                                        </td>
                                        <td>
                                            <span class="badge badge-dot mr-4">
                                                <i class="
                                                    @php
                                                        echo $item->status == 1 ? 'bg-success' : 'bg-danger';
                                                    @endphp
                                                    "></i>
                                                <span class="status">
                                                    @php
                                                        echo $item->status == 1 ? 'Hoạt động' : 'Đã khoá';
                                                    @endphp
                                                </span>
                                            </span>
                                        </td>
                                    </tr>
                                @empty
                                    <h3>Không có dữ liệu</h3>
                                @endforelse


                            </tbody>
                        </table>
                    </div>
                    <!-- Card footer -->
                    <div class="card-footer py-4" id='panigation_table'>
                        <nav aria-label="...">
                            <ul class="pagination justify-content-end mb-0">
                                <li class="page-item disabled">
                                    <a class="page-link" href="#" tabindex="-1">
                                        <i class="fas fa-angle-left"></i>
                                        <span class="sr-only">Previous</span>
                                    </a>
                                </li>
                                <li class="page-item active">
                                    <a class="page-link" href="#">1</a>
                                </li>
                                <li class="page-item">
                                    <a class="page-link" href="#">2 <span class="sr-only">(current)</span></a>
                                </li>
                                <li class="page-item"><a class="page-link" href="#">3</a></li>
                                <li class="page-item">
                                    <a class="page-link" href="#">
                                        <i class="fas fa-angle-right"></i>
                                        <span class="sr-only">Next</span>
                                    </a>
                                </li>
                            </ul>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
