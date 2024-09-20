@extends('layouts.app')

@section('title', 'Edit Video Modul')

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
                <h1>Edit Video Modul Budidaya</h1>
                <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item active"><a href="#">Dashboard</a></div>
                    <div class="breadcrumb-item"><a href="#">Edit</a></div>
                    <div class="breadcrumb-item"></div>Video
                </div>
            </div>

            <div class="section-body">
                <h2 class="section-title">Edit Video Budidaya</h2>
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <!-- Digunakan Untuk Melakukan Penginputan -->
                            <form action="{{ route('course_video.update', $classVideo->id) }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                @method('PUT')
                                <div class="card-header">
                                    <h4>Data Video</h4>
                                </div>
                                <div class="card-body">
                                    <div class="form-group row mb-4">
                                        <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3" for="nama">Nama Video</label>
                                        <div class="col-sm-12 col-md-7">
                                            <input id="nama" type="text" class="form-control @error('nama')
                                                is-invalid
                                            @enderror" name="nama" autofocus value="{{ old('nama', $classVideo->nama) }}">
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
                                            @enderror" name="path_video" autofocus value="{{ old('path_video', $classVideo->path_video) }}">
                                            @error('path_video')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="form-group row mb-4">
                                        <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3" for="thumbnail_video">Foto Thumbnail Video</label>
                                        <div class="col-sm-12 col-md-7">
                                            @if ($classVideo->thumbnail_video)
                                                <img src="{{ asset('storage/' . $classVideo->thumbnail_video) }}" class="img-thumbnail mb-2" alt="Gambar Thumbnail" style="max-height: 200px">
                                            @endif
                                            <div id="image-preview" class="image-preview">
                                                <label for="image-upload" id="image-label">Choose File</label>
                                                <input type="file" name="thumbnail_video" id="image-upload" class="form-control-file" value="{{ $classVideo->thumbnail_video }}"/>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group row mb-4">
                                        <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3"></label>
                                        <div class="col-sm-12 col-md-7">
                                            <button class="btn btn-primary">Update Video</button>
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
