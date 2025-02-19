@extends('main')
@section('title', '| Product Create')

@section('content')

<div class="row">
    <form action="{{ route('product.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
      
        <!-- Nama Produk -->
        <div class="mb-3">
          <label for="name" class="form-label">Nama Produk</label>
          <input type="text" class="form-control border-secondary"  id="name" name="name" required>
        </div>
      
        <!-- Harga -->
        <div class="mb-3">
          <label for="price" class="form-label">Harga</label>
          <input type="number" class="form-control border-secondary"  id="price" name="price" required>
        </div>
      
        <!-- Stok -->
        <div class="mb-3">
          <label for="stock" class="form-label">Stock</label>
          <input type="number" class="form-control border-secondary"  id="stock" name="stock" required>
        </div>
      
        <!-- Gambar Produk -->
        <div class="mb-3">
          <label for="image" class="form-label">Gambar Produk</label>
          <input type="file" class="form-control border-secondary"  id="image" name="image" accept="image/*" required>
        </div>
      
        <!-- Tombol Submit -->
        <button type="submit" class="btn btn-primary">Simpan</button>
      </form>      
</div>

@endsection
