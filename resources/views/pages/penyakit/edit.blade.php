@extends('layouts.app')

@section('title', 'Edit OPT')

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
                    <a href="{{ route('penyakit.index') }}"
                        class="btn btn-icon"><i class="fas fa-arrow-left"></i></a>
                </div>
                <h1>Edit OPT</h1>
                <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item active"><a href="#">Dashboard</a></div>
                    <div class="breadcrumb-item"><a href="#">Edit</a></div>
                    <div class="breadcrumb-item"></div>Opt
                </div>
            </div>

            <div class="section-body">
                <h2 class="section-title">Edit OPT</h2>
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <!-- Digunakan Untuk Melakukan Penginputan -->
                            <form action="{{ route('penyakit.update', $penyakitAnggur->id) }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                @method('PUT')
                                <div class="card-header">
                                    <h4>Input OPT</h4>
                                </div>
                                <div class="card-body">
                                    <div class="form-group row mb-4">
                                        <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3" for="nama">Nama OPT</label>
                                        <div class="col-sm-12 col-md-7">
                                            <input id="nama" type="text" class="form-control @error('nama')
                                                is-invalid
                                            @enderror" name="nama" autofocus value="{{ $penyakitAnggur->nama }}">
                                            @error('nama')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="form-group row mb-4">
                                        <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3" for="gejala">Gejala OPT</label>
                                        <div class="col-sm-12 col-md-7">
                                            <textarea name="gejala" id="gejala" data-height="150"
                                                class="form-control @error('gejala')
                                                    is-invalid
                                                @enderror" placeholder="Tuliskan Gejala Yang Dialami">{{ $penyakitAnggur->gejala }}</textarea>
                                            @error('gejala')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="form-group row mb-4">
                                        <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3" for="solusi">Solusi OPT</label>
                                        <div class="col-sm-12 col-md-7">
                                            <textarea name="solusi" id="solusi" data-height="150"
                                                class="form-control @error('solusi')
                                                    is-invalid
                                                @enderror" placeholder="Tuliskan Cara Pencegahannya">{{ $penyakitAnggur->solusi }}</textarea>
                                            @error('solusi')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="form-group row mb-4">
                                        <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3" for="penyebab">Penyebab OPT</label>
                                        <div class="col-sm-12 col-md-7">
                                            <textarea name="penyebab" id="penyebab" data-height="150"
                                                class="form-control @error('penyebab')
                                                    is-invalid
                                                @enderror" placeholder="Tuliskan Penyebabnya">{{ $penyakitAnggur->penyebab }}</textarea>
                                            @error('penyebab')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="form-group row mb-4">
                                        <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3" for="gambar">Foto OPT</label>
                                        <div class="col-sm-12 col-md-7">
                                            @if ($penyakitAnggur->gambar)
                                                <img src="{{ asset('storage/' . $penyakitAnggur->gambar) }}" class="img-thumbnail mb-2" alt="Gambar Penyakit" style="max-height: 200px">
                                            @endif
                                            <div id="image-preview" class="image-preview">
                                                <label for="image-upload" id="image-label">Choose File</label>
                                                <input type="file" name="gambar" id="image-upload" class="form-control-file" value="{{ $penyakitAnggur->gambar }}"/>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group row mb-4">
                                        <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3"></label>
                                        <div class="col-sm-12 col-md-7">
                                            <button class="btn btn-primary">Update Penyakit</button>
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
