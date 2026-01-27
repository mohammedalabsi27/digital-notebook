@extends('layouts.master')

@section('title', 'إدارة المحل')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0 text-dark fw-bold">إدارة المحل</h1>
    </div>

    <div class="card card-rounded card-shadow">
        <div class="card-body">
            <form action="{{ route('shop.update', $shop) }}" method="POST">
                @csrf
                @method('PATCH')
                
                <div class="row g-3">
                    <div class="col-md-6">
                        <label for="name" class="form-label">اسم المحل</label>
                        <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name', $shop->name) }}" required>
                        @error('name')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    
                    <div class="col-12 mt-4">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save me-2"></i>حفظ التغييرات
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection