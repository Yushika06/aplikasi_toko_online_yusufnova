@extends('layouts.app')

@section('title', 'Detail Produk')

@section('content')
<!DOCTYPE html>
<html>
<head>
    <title>Detail Produk</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.1.3/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>
<body>
    <div class="container mt-5">
        <div class="card">
            <div class="card-header">
                <h1>{{ $produk->name }}</h1>
            </div>
            <div class="card-body">
                <img src="{{ asset('images/' . $produk->img) }}" class="img-fluid mb-3" alt="{{ $produk->name }}">
                <h3 class="card-text btn btn-warning">Harga: Rp {{ number_format($produk->price, 2, ',', '.') }}</h3>
                <br>
                <p><strong>Deskripsi:</strong> {{ $produk->description }}</p>

                <!-- Form Pembelian -->
                <h4>Form Pembelian</h4>
                <form action="{{ route('produk.beli', $produk->id) }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label for="quantity" class="form-label">Jumlah:</label>
                        <input type="number" name="quantity" id="quantity" class="form-control" min="1" required>
                    </div>
                    <div style="display:flex;flex-direction:row;justify-content:space-between;">
                        <button type="submit" class="btn btn-primary">Beli Sekarang</button>
                    </div>
                </form>

                <a href="{{ route('home.index') }}" class="btn btn-secondary mt-3">Kembali ke Daftar Produk</a>
                <br>
                @if(auth()->check())
                    <p><strong>Total Pembelian Anda:</strong> {{ auth()->user()->purchases }}</p>
                @endif
            </div>
        </div>

        <!-- Bagian Ulasan -->
        <div class="card mt-4">
            <div class="card-header">
                <h4>Ulasan</h4>
            </div>
            <div class="card-body">
                @foreach ($produk->reviews as $review)
                    <div class="card mt-3">
                        <div class="card-body">
                            <h5 class="card-title"><i class="fa-solid fa-user fa-xs"></i> {{ $review->user->username }}</h5>
                            <p class="card-text">{{ $review->review }}</p>
                            <p class="card-text"><strong>Rating:</strong> {{ $review->rating }}/5</p>
                        </div>
                    </div>
                @endforeach
                @if(auth()->check())
                    <form action="{{ route('reviews.store', $produk->id) }}" method="POST" class="mt-4">
                        @csrf
                        <div class="mb-3">
                            <label for="review" class="form-label">Tulis Ulasan</label>
                            <textarea name="review" id="review" class="form-control" rows="3" required></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="rating" class="form-label">Rating</label>
                            <select name="rating" id="rating" class="form-control" required>
                                <option value="5">5</option>
                                <option value="4">4</option>
                                <option value="3">3</option>
                                <option value="2">2</option>
                                <option value="1">1</option>
                            </select>
                        </div>
                        <button type="submit" class="btn btn-primary">Submit Review</button>
                    </form>
                @else
                    <p><a href="{{ route('login') }}">Login</a> untuk menulis ulasan.</p>
                @endif
            </div>
        </div>
    </div>
</body>
</html>
@endsection
