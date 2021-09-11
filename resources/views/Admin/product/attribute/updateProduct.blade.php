<div id="myUpdateModal" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <h2 class="modal-title">Sửa sản phẩm</h2>
            </div>
            <div class="modal-body">
                {{-- <p>Some text in the modal.</p> --}}
                <form action="" id="form-edit" method="POST" role="form">
                    @csrf
                    <div class="form-group">
                        {{-- <label for="email">Tên Kho:</label> --}}
                        <input required type="text" class="form-control" placeholder="Mã loại sản phẩm" name='id_type' id="id_type-edit">
                        <input required type="hidden" class="form-control" placeholder="Tên màu" name='id' id="id">
                    </div>
                    <div class="form-group">
                        {{-- <label for="email">Tên Kho:</label> --}}
                        <input required type="text" class="form-control" placeholder="Tên sản phẩm" name='name' id="name-edit">
                        
                    </div><div class="form-group">
                        {{-- <label for="email">Tên Kho:</label> --}}
                        
                        <textarea class="form-control" placeholder="Mô tả" name='descrip' id="descrip-edit" rows="3"></textarea>

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