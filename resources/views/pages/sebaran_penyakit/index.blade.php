@extends('layouts.app')

@section('title', 'Sebaran Penyakit Anggur')

@push('style')
    <!-- CSS Libraries -->
    <link rel="stylesheet"
        href="{{ asset('library/selectric/public/selectric.css') }}">
@endpush

@section('main')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Sebaran Hama Dan Penyakit</h1>
                <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item active"><a href="#">Dashboard</a></div>
                    <div class="breadcrumb-item"><a href="#">Sebaran OPT</a></div>
                    <div class="breadcrumb-item">All Sebaran OPT</div>
                </div>
            </div>
            <div class="section-body">
                <div class="row">
                    <div class="col-12">
                        @include('layouts.alert')
                    </div>
                </div>
                <h2 class="section-title">Sebaran Hama Dan Penyakit</h2>
                <p class="section-lead">
                    You can manage all opt anggur, such as editing, deleting and more.
                </p>
                <div class="row mt-4">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h4>All Sebaran OPT</h4>
                            </div>
                            <div class="card-body">
                                <div class="float-right">
                                    <form method="GET" action="{{ route('sebaran_penyakit.index') }}">
                                        <div class="input-group">
                                            <input type="text" class="form-control" placeholder="Search" name="nama">
                                            <div class="input-group-append">
                                                <button class="btn btn-primary"><i class="fas fa-search"></i></button>
                                            </div>
                                        </div>
                                    </form>
                                </div>

                                <div class="clearfix mb-3"></div>

                                <div class="table-responsive">
                                    <table class="table-striped table">
                                        <tr>
                                            <th>Gambar</th>
                                            <th>Nama</th>
                                            <th>Gejala</th>
                                            <th>Solusi</th>
                                            <th>Created At</th>
                                            <th>Action</th>
                                        </tr>
                                        @foreach ($sebaranPenyakit as $data)
                                        <tr>
                                            <td>
                                                <img src="{{ Storage::url($data->gambar) }}" alt="{{ $data->nama }}'s Hama Photo" width="100" height="100">
                                            </td>
                                            <td> {{ $data->nama }} </td>
                                            <td> {{ Str::limit($data->gejala, 100) }} </td>
                                            <td> {{ Str::limit($data->solusi, 100) }} </td>
                                            <td> {{ $data->created_at }} </td>
                                            <td>
                                                <div class="d-flex justify-content-center">
                                                    <form action="{{ route('sebaran_penyakit.destroy', $data->id) }}" method="POST" class="ml-2">
                                                        <input type="hidden" name="_method" value="DELETE">
                                                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                                        <button class="btn btn-sm btn-danger btn-icon confirm-delete">
                                                            <i class="fas fa-times"></i>
                                                            Delete
                                                        </button>
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </table>
                                </div>
                                <div class="float-right">
                                    {{ $sebaranPenyakit->withQueryString()->links() }}
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

