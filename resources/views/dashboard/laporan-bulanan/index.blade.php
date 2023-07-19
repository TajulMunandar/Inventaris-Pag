@extends('dashboard.layouts.main')

@section('content')
    <div class="row">
        <div class="col">
            @if (session()->has('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif
        </div>
    </div>

    <div class="row">
        <div class="col">
            <div class="card mt-3">
                <ul class="nav nav-tabs">
                    <li class="nav-item">
                        <a class="nav-link " aria-current="page" href="{{ route('laporan-utama.index') }}" >Laporan</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" aria-current="page" href="{{ route('laporan-mingguan.index') }}">Mingguan</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="{{ route('laporan-bulanan.index') }}">Bulanan</a>
                    </li>
                </ul>
                <div class="card-body">
                    {{-- Table --}}
                    <table id="myTable" class="table responsive nowrap table-bordered table-striped align-middle"
                        style="width:100%">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Barang</th>
                                <th>Peminjam</th>
                                <th>Qty</th>
                                <th>Status</th>
                                <th>Deskripsi</th>
                                <th>Tanggal Pinjam</th>
                                <th>Tanggal Balik</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($peminjamans as $peminjaman)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $peminjaman->barangs->name }}</td>
                                    <td>{{ $peminjaman->users->name }}</td>
                                    <td>{{ $peminjaman->qty }}</td>
                                    <td>

                                        @if ($peminjaman->status == 0)
                                            <span class="badge bg-success">
                                                Selesai
                                            </span>
                                        @else
                                            <span class="badge bg-warning">
                                                Dipinjam
                                            </span>
                                        @endif

                                    </td>
                                    <td>{{ $peminjaman->deskripsi }}</td>
                                    <td>{{ $peminjaman->tgl_pinjam }}</td>
                                    <td>{{ $peminjaman->tgl_balik }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    {{-- End Table --}}
                </div>
            </div>
        </div>
    </div>
@endsection
