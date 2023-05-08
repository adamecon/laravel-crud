<!DOCTYPE html>
<html lang="en">

<head>
    @include('admin.css')

    <style type="text/css">
    .div_center {
        text-align: center;
        padding-top: 40px;

    }

    .font_size {
        font-size: 40px;
        padding-bottom: 40px;
    }

    .text_color {
        color: black;
        padding-bottom: 20px;

    }

    label {
        display: inline-block;
        width: 200px;
    }

    .div_design {
        padding-bottom: 15px;
    }
    </style>
</head>

<body>
    <div class="container-scroller">
        @include('admin.sidebar');

        <!-- partial -->
        @include('admin.navbar');
        <!-- partial -->

        <div class="main-panel">
            <div class="content-wrapper">

                @if(session() -> has('message'))
                <div class="alert alert-success">

                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">X</button>
                    {{session() -> get('message')}}
                </div>

                @endif

                <div class="div_center">
                    <h1 class="font_size">Add Products</h1>

                    <form action="{{url('/add_product')}}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <div class="div_design">
                            <label>Product Name</label>
                            <input class="text_color" type="text" name="title" placeholder="Product Title">
                        </div>

                        <div class="div_design">

                            <label>Product Description</label>
                            <input class="text_color" type="text" name="description" placeholder="Product Description">
                        </div>

                        <div class="div_design">

                            <label>Price</label>
                            <input class="text_color" type="number" name="price" placeholder="Product Pricing">
                        </div>

                        <div class="div_design">

                            <label>Quantity</label>
                            <input class="text_color" type="number" name="quantity" min="0"
                                placeholder="Product Quantity">
                        </div>

                        <div class="div_design">
                            <label>Discount</label>
                            <input class="text_color" type="number" name="discount" placeholder="Discount Price">
                        </div>

                        <div class="div_design">
                            <label>Category</label>
                            <select class="text_color" name="category">
                                <option value="" selected="">Add a Category</option>

                                @foreach($category as $category)
                                <option value="{{$category->category_name}}">{{$category->category_name}}</option>

                                @endforeach
                            </select>
                        </div>

                        <div class="div_design">
                            <label>Product Image</label>
                            <input type="file" name="image">
                        </div>

                        <div class="div_design">
                            <input type="submit" value="LIST PRODUCT" class="btn btn-primary">
                        </div>

                    </form>




                </div>
            </div>
        </div>

        <!-- plugins:js -->
        @include('admin.script')
</body>

</html>