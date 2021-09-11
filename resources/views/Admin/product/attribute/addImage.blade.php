<div id="myAddModal" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <h2 class="modal-title">Thêm ảnh sản phẩm</h2>
            </div>
            <div class="modal-body">
                {{-- <p>Some text in the modal.</p> --}}
                <form action="" id="form-add" method="POST" role="form" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group">
                        {{-- <label for="email">Tên Kho:</label> --}}
                        <input required type="text" class="form-control" placeholder="Mã sản phẩm" name='id_product' id="id_product">
                    </div>
                    <div class="form-group">
                        <label for="exampleFormControlFile1">Chọn ảnh sản phẩm</label>
                        <input type="file" class="form-control-file" id="image"
                            onchange="openPicAdd(this)" name="image">
                    </div>
                    <div class="d-flex justify-content-center align-items-center">
                        <img src="" alt="" srcset="" id='imageDemoAdd' style="width: 150px; height:auto">
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