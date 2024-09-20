@extends('layouts.app')

@section('title', 'Video Modul')

@push('style')
    <!-- CSS Libraries -->
    <link rel="stylesheet"
        href="{{ asset('library/summernote/dist/summernote-bs4.css') }}">
    <link rel="stylesheet"
        href="{{ asset('library/selectric/public/selectric.css') }}">
    <link rel="stylesheet"
        href="{{ asset('library/bootstrap-tagsinput/dist/bootstrap-tagsinput.css') }}">
@endpush

@section('main')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <div class="section-header-back">
                    <a href="{{ route('course_video.index') }}"
                        class="btn btn-icon"><i class="fas fa-arrow-left"></i></a>
                </div>
                <h1>Tambah Video Modul Budidaya</h1>
                <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item active"><a href="#">Dashboard</a></div>
                    <div class="breadcrumb-item"><a href="#">Tambah</a></div>
                    <div class="breadcrumb-item"></div>Video Modul
                </div>
            </div>
            <div class="section-body">
                <h2 class="section-title">Tambah Video Modul</h2>
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <!-- Digunakan Untuk Melakukan Penginputan -->
                            <form action="{{ route('course_video.store') }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <div class="card-header">
                                    <h4>Tambah Video</h4>
                                </div>
                                <div class="card-body">
                                    <div class="form-group row mb-4">
                                        <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3" for="thumbnail_video">Foto Thumbnail Video</label>
                                        <div class="col-sm-12 col-md-7">
                                            <div id="image-preview" class="image-preview">
                                                <label for="image-upload" id="image-label">Choose File</label>
                                                <input type="file" name="thumbnail_video" id="image-upload" class="form-control-file"/>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group row mb-4">
                                        <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3" for="nama">Nama Video</label>
                                        <div class="col-sm-12 col-md-7">
                                            <input id="nama" type="text" class="form-control @error('nama')
                                                is-invalid
                                            @enderror" name="nama" autofocus>
                                            @error('nama')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="form-group row mb-4">
                                        <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3" for="path_video">Path Video</label>
                                        <div class="col-sm-12 col-md-7">
                                            <input id="path_video" type="text" class="form-control @error('path_video')
                                                is-invalid
                                            @enderror" name="path_video" autofocus>
                                            @error('path_video')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="form-group row mb-4">
                                        <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3" for="category_classes_id">Kategori Modul</label>
                                        <div class="col-sm-12 col-md-7">
                                            <select name="category_classes_id" id="category_classes_id" class="form-control selectric @error('category_classes_id') is-invalid @enderror">
                                                <option>Pilih Kategori Modul</option>
                                                @foreach ($categoryClass as $data)
                                                    <option value="{{ $data->id }}">{{ $data->name }}</option>
                                                @endforeach
                                                    {{-- <option value="" disabled>Tidak ada kategori</option>
                                                @endforelse --}}
                                            </select>
                                            @error('category_classes_id')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="form-group row mb-4">
                                        <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3"></label>
                                        <div class="col-sm-12 col-md-7">
                                            <button class="btn btn-primary">Tambah Video</button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection

@push('scripts')
    <!-- JS Libraies -->
    <script src="{{ asset('library/summernote/dist/summernote-bs4.js') }}"></script>
    <script src="{{ asset('library/bootstrap-tagsinput/dist/bootstrap-tagsinput.min.js') }}"></script>
    <script src="{{ asset('library/selectric/public/jquery.selectric.min.js') }}"></script>
    <script src="{{ asset('library/upload-preview/upload-preview.js') }}"></script>

    <!-- Page Specific JS File -->
    <script src="{{ asset('js/page/features-post-create.js') }}"></script>
@endpush
