<div id="myAddModal" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <h2 class="modal-title">Thêm sản phẩm</h2>
            </div>
            <div class="modal-body">
                {{-- <p>Some text in the modal.</p> --}}
                <form action="" id="form-add" method="POST" role="form">
                    @csrf
                    <div class="form-group">
                        {{-- <label for="email">Tên Kho:</label> --}}
                        <input required type="text" class="form-control" placeholder="Mã sản phẩm" name='product'
                            id="product">
                    </div>
                    <div class="row ml-0 mr-0 d-flex justify-content-lg-between" style="width: 100%">
                        <div class="form-group" style="width: 45%">
                            {{-- <label for="email">Tên Kho:</label> --}}
                            <input required type="text" class="form-control"  placeholder="Kích cỡ" name='size'
                                id="size">
                        </div>
                        <div class="form-group" style="width: 45%">
                            {{-- <label for="pwd">Địa chỉ:</label> --}}
                            <input required type="text" class="form-control"  placeholder="Mã màu (hex)" name="hex"
                                id="hex" onchange="openHexAdd(this)">
                            {{-- <input required type="color" class="form-control" placeholder="Tên màu" name='color' id="color"> --}}
                        </div>
                    </div>
                    <div src="" alt="" srcset="" id='hexDemoAdd' class="text-center text-lg-center border rounded p-5"
                        style="">Hex Color Demo</div>
                    <div class="row ml-0 mr-0 d-flex justify-content-lg-between" style="margin-top: 25px;width: 100%">
                        <div class="form-group" style="width: 45%">
                            {{-- <label for="email">Tên Kho:</label> --}}
                            <input required type="text" class="form-control" placeholder="Thương hiệu" name='brand'
                                id="brand">
                        </div>
                        <div class="form-group" style="width: 45%">
                            {{-- <label for="email">Tên Kho:</label> --}}
                            <input required type="text" class="form-control" placeholder="Kho" name='warehouse'
                                id="warehouse">
                        </div>
                    </div>
                    <div class="row ml-0 mr-0 d-flex justify-content-lg-between" style="width: 100%">
                        <div class="form-group" style="width: 45%">
                            {{-- <label for="email">Tên Kho:</label> --}}
                            <input required type="text" class="form-control" placeholder="Số lượng" name='quantity'
                                id="quantity">
                        </div>
                        <div class="form-group" style="width: 45%">
                            {{-- <label for="pwd">Địa chỉ:</label> --}}
                            <input required type="text" class="form-control" placeholder="Giá" name="price"
                                id="price" onchange="openHexAdd(this)">
                            {{-- <input required type="color" class="form-control" placeholder="Tên màu" name='color' id="color"> --}}
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-dark" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-success">Submit</button>
                    </div>
                </form>
            </div>

        </div>

    </div>
</div>
