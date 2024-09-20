@extends('layouts.app')

@section('title', 'Kategori Modul Budidaya')

@push('style')
    <!-- CSS Libraries -->
    <link rel="stylesheet"
        href="{{ asset('library/selectric/public/selectric.css') }}">
@endpush

@section('main')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Kategori Modul Budidaya</h1>
                <div class="section-header-button">
                    <a href="{{ route('category_class.create') }}" class="btn btn-primary">Tambah</a>
                </div>
                <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item active"><a href="#">Dashboard</a></div>
                    <div class="breadcrumb-item"><a href="#">Kategori Modul Budidaya</a></div>
                    <div class="breadcrumb-item">All Modul Budidaya</div>
                </div>
            </div>
            <div class="section-body">
                <div class="row">
                    <div class="col-12">
                        @include('layouts.alert')
                    </div>
                </div>
                <h2 class="section-title">Kategori Modul Budidaya</h2>
                <p class="section-lead">
                    You can manage all modul budidaya, such as editing, deleting and more.
                </p>
                <div class="row mt-4">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h4>All Modul Budidaya</h4>
                            </div>
                            <div class="card-body">
                                <div class="clearfix mb-3"></div>
                                <div class="table-responsive">
                                    <table class="table-striped table">
                                        <tr>
                                            <th>Thumbnail</th>
                                            <th>Nama</th>
                                            <th>Deskripsi</th>
                                            <th>Jumlah Video</th>
                                            <th>Created At</th>
                                            <th>Action</th>
                                        </tr>
                                        @forelse ($categoryClass as $data)
                                        <tr>
                                            <td>
                                                <img src="{{ Storage::url($data->thumbnail_category) }}" alt="{{ $data->name }}'s Thumbnail Category" width="100" height="100">
                                            </td>
                                            <td> {{ $data->name }} </td>
                                            <td> {{ Str::limit($data->about, 100) }} </td>
                                            <td>{{ $data->videos->count() }}</td>
                                            <td> {{ $data->created_at }} </td>
                                            <td>
                                                <div class="d-flex justify-content-center">
                                                    <a href="{{ route('category_class.edit', $data) }}" class="btn btn-sm btn-info btn-icon">
                                                        <i class="fas fa-edit"></i>
                                                        Update
                                                    </a>
                                                    <form action="{{ route('category_class.destroy', $data) }}" method="POST" class="ml-2">
                                                        @csrf
                                                        @method('DELETE')
                                                        <input type="hidden" name="_method" value="DELETE">
                                                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                                        <button type="submit" class="btn btn-sm btn-danger btn-icon confirm-delete">
                                                            <i class="fas fa-times"></i>
                                                            Delete
                                                        </button>
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>
                                        @empty
                                        <p>
                                            Tidak Ada Kategori Terbaru
                                        </p>
                                        @endforelse
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection

@push('scripts')
    <!-- JS Libraies -->
    <script src="{{ asset('library/selectric/public/jquery.selectric.min.js') }}"></script>

    <!-- Page Specific JS File -->
    <script src="{{ asset('js/page/features-posts.js') }}"></script>
@endpush

