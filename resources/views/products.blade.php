@extends('shop')
   
@section('content')
    
<div class="row">
    @foreach($product as $products)
        <div class="col-md-3 col-6 mb-4">
            <div class="card">
                <img src="{{ $products->image }}" alt="{{ $products->name }}" class="card-img-top">
                <div class="card-body">
                    <h4 class="card-title">{{ $products->name }}</h4>
                    
                    <p class="card-text"><strong>Price: </strong> ${{ $products->price }}</p>
                    <p class="btn-holder"><a href="{{ route('addproduct.to.cart', $products->id) }}" class="btn btn-outline-danger">Add to cart</a> </p>
                </div>
            </div>
        </div>
    @endforeach
</div>
<!-- <div class="card">
  <div class="card-header">Add Product</div>
  <div class="card-body">
    <form action="{{ url('shopping-cart') }}" method="post">
      {!! csrf_field() !!}
      <input type="text" name="name" id="name" class="form-control" placeholder="Name"></br>
      <input type="price" name="price" id="price" class="form-control" placeholder="Price"></br>
      
      <label for="file">Product Image:</label>
      <input type="file" name="file" id="file" class="form-control">
      <input type="submit" value="Save" class="btn btn-success"></br>
    </form>
  </div>
</div> -->
    
@endsection