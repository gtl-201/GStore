<div id="myUpdateModal" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <h2 class="modal-title">Chi tiết nhập kho cuả sản phẩm</h2>
            </div>
            <div class="w-100 text-center px-2">
                <hr class="p-0 m-0" />
            </div>
            <div class="modal-body py-2">
                @forelse ($receipt as $item)
                    <div class="row w-100 pb-1">
                        {{-- <input type="text" id='id'> --}}
                        {{-- <div class="col-5 font-weight-600" id='id'>Mã sản phẩm:</div> --}}
                        <div class="col-5 font-weight-600">Mã sản phẩm:</div>
                        <div class="col-7">{{ $item->id_product_detail }}</div>
                    </div>
                    <div class="row w-100 pb-1">
                        <div class="col-5 font-weight-600">Tên Kho:</div>
                        <div class="col-7">{{ $item->warehouseName }}</div>
                    </div>
                    
                    @foreach ($item->receiptDetail as $key => $itemDetail)
                        <div class="w-100 text-center px-5 py-2">
                            <hr class="p-0 m-0" />
                        </div>
                        {{-- {{dd($item->admin[$key])}} --}}
                        <div class="row w-100 pb-1">
                            <div class="col-5 font-weight-600">Tên admin:</div>
                            <div class="col-7">{{ $item->admin[$key]->name }}</div>
                        </div>
                        <div class="row w-100 pb-1">
                            <div class="col-5 font-weight-600">Nhà cung cấp:</div>
                            <div class="col-7">{{ $itemDetail->name }}</div>
                        </div>
                         <div class="row w-100 pb-1">
                            <div class="col-5 font-weight-600">Số lượng:</div>
                            <div class="col-7">{{ $itemDetail->quantity }}</div>
                        </div>
                        <div class="row w-100 pb-1">
                            <div class="col-5 font-weight-600">Ngày nhập:</div>
                            <div class="col-7">{{ $itemDetail->created_at }}</div>
                        </div>
                    @endforeach
                @empty
                @endforelse
            </div>
        </div>

    </div>
</div>
