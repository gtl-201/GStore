<div id="myAddModal" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <h2 class="modal-title">Thêm sản phẩm</h2>
            </div>
            <div class="modal-body">
                {{-- <p>Some text in the modal.</p> --}}
                <form action="" id="form-add" method="POST" role="form" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group">
                        <input required type="text" class="form-control" placeholder="Tên sản phẩm" name='name'
                            id="name">
                    </div>
                    <div class="form-group">
                        <input required type="text" class="form-control" placeholder="Mô tả" name="descrip"
                            id="descrip">
                    </div>
                    <div class="form-group row px-3">
                        <select class="form-select col" aria-label="" id='typename' name='typename'>
                            <option selected>Loại sản phẩm</option>
                            @forelse ($allType as $itemType)
                                <option value='{{ $itemType->id }}'>{{ $itemType->name }}</option>
                            @empty
                            @endforelse
                        </select>
                        <div class='px-1'></div>
                        <select class="form-select col" aria-label="" id='brand' name='brand'>
                            <option selected>Thương hiệu</option>
                            @forelse ($allBrand as $itemBrand)
                                <option value='{{ $itemBrand->id }}'>{{ $itemBrand->brand }}</option>
                            @empty
                            @endforelse
                        </select>
                    </div>
                    <div class="form-group row px-3">
                        <select class="form-select col" aria-label="" id='supplier' name='supplier'>
                            <option selected>Nhà cung cấp</option>
                            @forelse ($allSupplier as $itemSuplier)
                                <option value='{{ $itemSuplier->id }}'>{{ $itemSuplier->name }}</option>
                            @empty
                            @endforelse
                        </select>
                    </div>
                    <div id='multiAttribute'>
                        <div class="w-100 text-center mb-2">--------------------- Thuộc tính 1 ---------------------
                        </div>
                        <div class="form-group row px-3">
                            <select class="form-select col" aria-label="" id='color' name='color1'>
                                <option selected>Màu sắc</option>
                                @forelse ($allColor as $itemColor)
                                    <option value='{{ $itemColor->id }}'>{{ $itemColor->color }}</option>
                                @empty
                                @endforelse
                            </select>
                            <div class='px-3'></div>
                            <select class="form-select col" aria-label="" id='size' name='size1'>
                                <option selected>Kích cỡ</option>
                                @forelse ($allSize as $itemSize)
                                    <option value='{{ $itemSize->id }}'>{{ $itemSize->size }}</option>
                                @empty
                                @endforelse
                            </select>
                        </div>
                        <div class="form-group row mt--2">
                            <div class="form-group col">
                                <input required type="number" class="form-control" placeholder="Đơn giá (VNĐ)"
                                    name="price1" id="price">
                            </div>
                            <div class="form-group col">
                                <input required type="number" class="form-control" placeholder="Số lượng"
                                    name="quantity1" id="quantity">
                            </div>
                        </div>
                        <div class="flex justify-content-center align-items-center w-100">
                        </div>
                    </div>

                    <div class="btn btn-success btn-sm" style='margin-top:-40px; margin-bottom: 20px' onclick="addMoreAttribute()">Add more</div>

                    <div id='multiImg' name='multiImg'>
                        <div class="form-group row">
                            <div class='col'>
                                <label for="exampleFormControlFile1">Chọn ảnh kho thứ 1</label>
                                <input type="file" class="form-control-file" id="img1"
                                    name="img1">
                            </div>
                            {{-- onchange="openPicAdd(this)" --}}
                            {{-- <img src="" alt="" srcset="" id='imageDemoAdd' class='col'
                                style="width: auto;max-height: 100px"> --}}
                        </div>
                    </div>
                    <div class="btn btn-success btn-sm" style='margin-top:-10px; margin-bottom: 20px' onclick="addMoreImage()">Add more</div>
                    
                    <input type="hidden" id='CountImg' name='countImg' value="1">
                    <input type="hidden" value="1" id='Count' name='count'>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-dark" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-success">Submit</button>
                    </div>
                </form>
            </div>
        </div>

    </div>
</div>

<script>
    function addMoreAttribute() {
        const index = parseInt($('#Count').val()) + 1;
        const newAttribute =
                    `<div class="w-100 text-center mb-2">--------------------- Thuộc tính ${index} ---------------------</div>
                    <div class="form-group row px-3">
                        <select class="form-select col" aria-label="" id='color${index}' name='color${index}'>
                            <option selected>Màu sắc</option>
                            @forelse ($allColor as $itemColor)
                                <option value='{{ $itemColor->color }}'>{{ $itemColor->color }}</option>
                            @empty
                            @endforelse
                        </select>
                        <div class='px-3'></div>
                        <select class="form-select col" aria-label="" id='size${index}' name='size${index}'>
                            <option selected>Kích cỡ</option>
                            @forelse ($allSize as $itemSize)
                                <option value='{{ $itemSize->size }}'>{{ $itemSize->size }}</option>
                            @empty
                            @endforelse
                        </select>
                    </div>
                    <div class="form-group row mt--2">
                        <div class="form-group col">
                            <input required type="number" class="form-control" placeholder="Đơn giá (VNĐ)"
                                name="price${index}" id="price${index}">
                        </div>
                        <div class="form-group col">
                            <input required type="number" class="form-control" placeholder="Số lượng"
                                name="quantity${index}" id="quantity${index}">
                        </div>
                    </div>
                    <div class="flex justify-content-center align-items-center w-100">
                    </div>`;
        $( "#multiAttribute" ).append( newAttribute );
        $('#Count').val(index) ;
    }

    function addMoreImage() {
        const indexImg = parseInt($('#CountImg').val()) + 1;
        const newImage =
                    `<div class="form-group row">
                        <div class='col'>
                            <label for="exampleFormControlFile1">Chọn ảnh kho thứ ${indexImg}</label>
                            <input type="file" class="form-control-file" id="img${indexImg}"
                                name="img${indexImg}">
                        </div>
                        
                    </div>`;
        $( "#multiImg" ).append( newImage );
        $('#CountImg').val(indexImg) ;
    }
</script>
