@extends('layouts.app')

@section('title', 'Video Modul Budidaya')

@push('style')
    <!-- CSS Libraries -->
    <link rel="stylesheet"
        href="{{ asset('library/selectric/public/selectric.css') }}">
@endpush

@section('main')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Video Modul Budidaya</h1>
                <div class="section-header-button">
                    <a href="{{ route('course_video.create') }}" class="btn btn-primary">Tambah</a>
                </div>
                <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item active"><a href="#">Dashboard</a></div>
                    <div class="breadcrumb-item"><a href="#">Video Modul Budidaya</a></div>
                    <div class="breadcrumb-item">All Video Budidaya</div>
                </div>
            </div>
            <div class="section-body">
                <div class="row">
                    <div class="col-12">
                        @include('layouts.alert')
                    </div>
                </div>
                <h2 class="section-title">Video Modul Budidaya</h2>
                <p class="section-lead">
                    You can manage all video budidaya, such as editing, deleting and more.
                </p>
                <div class="row mt-4">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h4>All Video Budidaya</h4>
                            </div>
                            <div class="card-body">
                                <div class="clearfix mb-3"></div>
                                <div class="table-responsive">
                                    <table class="table-striped table">
                                        <tr>
                                            <th>Thumbnail</th>
                                            <th>Nama</th>
                                            <th>Video Modul</th>
                                            <th>Kategori Kelas</th>
                                            <th>Created At</th>
                                            <th>Action</th>
                                        </tr>
                                        @forelse ($classVideo as $data)
                                        <tr>
                                            <td>
                                                <img src="{{ Storage::url($data->thumbnail_video) }}" alt="{{ $data->name }}'s Thumbnail Video" width="100" height="100">
                                            </td>
                                            <td> {{ $data->nama }} </td>
                                            <td>
                                                @if ($data->path_video)
                                                    <iframe width="200" height="150"
                                                        src="https://www.youtube.com/embed/{{$data->path_video}}"
                                                        frameborder="0" allowfullscreen>
                                                    </iframe>
                                                @else
                                                    No video available
                                                @endif
                                            </td>
                                            <td> {{ $data->category_classes_id }} </td>
                                            <td> {{ $data->created_at }} </td>
                                            <td>
                                                <div class="d-flex justify-content-center">

                                                    {{-- <a href="{{ route('course_video.update', $data) }}" class="btn btn-sm btn-info btn-icon">
                                                        <i class="fas fa-edit"></i>
                                                        Update
                                                    </a> --}}

                                                    <form action="{{ route('course_video.destroy', $data) }}" method="POST" class="ml-2">
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
                                            Tidak Ada Video Terbaru
                                        </p>
                                        @endforelse
                                    </table>
                                </div>
                                <div class="float-right">
                                    {{ $classVideo->withQueryString()->links() }}
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

