@extends('dashboard.layouts.main')

@section('content')
    <div class="row">
        <div class="col">
            @if (session()->has('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @elseif (session()->has('failed'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    {{ session('failed') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif
        </div>
    </div>

    <div class="row">
        <div class="col">
            <button class="btn btn-primary" type="button" data-bs-toggle="modal" data-bs-target="#tambahModal">
                <i class="fa-regular fa-plus me-2"></i>
                Tambah
            </button>
        </div>
    </div>

    <div class="row">
        <div class="col">
            <div class="card mt-3">
                <div class="card-body">
                    {{-- Table --}}
                    <table id="myTable" class="table responsive nowrap table-bordered table-striped align-middle"
                        style="width:100%">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Barang</th>
                                <th>Qty</th>
                                <th>Peminjam</th>
                                <th>Deskripsi</th>
                                <th>Status</th>
                                <th>Tanggal Pinjam</th>
                                <th>Tanggal Balik</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($peminjamans as $peminjaman)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $peminjaman->barangs->name }}</td>
                                    <td>{{ $peminjaman->qty }}</td>
                                    <td>{{ $peminjaman->users->name }}</td>
                                    <td>{{ $peminjaman->deskripsi }}</td>
                                    <td>
                                        @if ($peminjaman->isApprove == 1)
                                            <span class="badge bg-success">
                                                Diterima
                                            </span>
                                        @else
                                            <span class="badge bg-warning">
                                                Proses
                                            </span>
                                        @endif
                                    </td>
                                    <td>{{ $peminjaman->tgl_pinjam }}</td>
                                    <td>{{ $peminjaman->tgl_balik }}</td>
                                    <td>
                                        @if (auth()->user()->isAdmin == 0)
                                            <button data-bs-target="#modalCheck{{ $loop->iteration }}"
                                                class="btn btn-sm btn-success" data-bs-toggle="modal"
                                                @if ($peminjaman->barangs->isHabis === 1) disabled @endif>
                                                <i class="fa-regular fa-check fa-lg"></i>
                                            </button>
                                            <button data-bs-target="#modalApprove{{ $loop->iteration }}"
                                                class="btn btn-sm btn-info" data-bs-toggle="modal"
                                                @if ($peminjaman->isApprove === 1) disabled @endif>
                                                <i class="fa-regular fa-file fa-lg"></i>
                                            </button>
                                        @else
                                            <button data-bs-target="#modalCheck{{ $loop->iteration }}""
                                                class="btn btn-sm btn-success" data-bs-toggle="modal" 
                                                @if ($peminjaman->isApprove === 0 && $peminjaman->barangs->isHabis === 1) disabled @endif>
                                                <i class="fa-regular fa-check fa-lg"></i>
                                            </button>
                                        @endif

                                    </td>
                                </tr>

                                {{-- Modal Check Katgeori --}}
                                <div class="modal fade" id="modalCheck{{ $loop->iteration }}" tabindex="-1"
                                    aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="exampleModalLabel">Check Peminjaman</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                    aria-label="Close"></button>
                                            </div>
                                            <form action="{{ route('peminjaman.update', $peminjaman->id) }}"
                                                method="post">
                                                @method('put')
                                                @csrf
                                                <input type="hidden" name="id" value="{{ $peminjaman->id }}">
                                                <div class="modal-body">
                                                    <p class="fs-6">Apakah anda yakin akan mengembalikan Peminjaman
                                                        <b>{{ $peminjaman->barangs->name }}</b>?
                                                    </p>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary"
                                                        data-bs-dismiss="modal">Batal</button>
                                                    <button type="submit"
                                                        class="btn btn-outline-success">Kembalikan</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                                {{-- / Modal Hapus Kategori --}}

                                {{-- Modal Check Approve --}}
                                <div class="modal fade" id="modalApprove{{ $loop->iteration }}" tabindex="-1"
                                    aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="exampleModalLabel">Terima Peminjaman</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                    aria-label="Close"></button>
                                            </div>
                                            <form action="{{ route('peminjaman.approve', $peminjaman->id) }}"
                                                method="post">
                                                @method('put')
                                                @csrf
                                                <input type="hidden" name="id" value="{{ $peminjaman->id }}">
                                                <div class="modal-body">
                                                    <p class="fs-6">Apakah anda yakin akan Approve Peminjaman
                                                        <b>{{ $peminjaman->barangs->name }}</b>?
                                                    </p>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary"
                                                        data-bs-dismiss="modal">Batal</button>
                                                    <button type="submit" class="btn btn-outline-info">Terima</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                                {{-- / Modal Hapus Approve --}}
                            @endforeach

                            {{-- add Modal Tambah --}}
                            <div class="modal fade" id="tambahModal" tabindex="-1" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h1 class="modal-title fs-5">Add Peminjaman</h1>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                aria-label="Close"></button>
                                        </div>
                                        <form action="{{ route('peminjaman.store') }}" method="post">
                                            <div class="modal-body">
                                                @csrf

                                                <div class="mb-3">
                                                    <label for="barangId" class="form-label">Barang</label>
                                                    <select class="form-select" id="barangId" name="barangId" required>
                                                        @foreach ($barangs as $barang)
                                                            <option value="{{ $barang->id }}">
                                                                {{ $barang->name }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>

                                                <div class="mb-3">
                                                    <label for="qty" class="form-label">Qty</label>
                                                    <input type="text"
                                                        class="form-control @error('qty') is-invalid @enderror"
                                                        name="qty" id="qty" value="{{ old('qty') }}"
                                                        autofocus required>
                                                    @error('qty')
                                                        <div class="invalid-feedback">
                                                            {{ $message }}
                                                        </div>
                                                    @enderror
                                                </div>

                                                <div class="mb-3">
                                                    <label for="userId" class="form-label">User</label>
                                                    <select class="form-select" id="userId" name="userId" required>
                                                        @foreach ($users as $user)
                                                            <option value="{{ $user->id }}">
                                                                {{ $user->name }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>

                                                <div class="mb-3">
                                                    <label for="deskripsi" class="form-label">Deskripsi</label>
                                                    <input type="text"
                                                        class="form-control @error('deskripsi') is-invalid @enderror"
                                                        name="deskripsi" id="deskripsi" value="{{ old('deskripsi') }}"
                                                        autofocus required>
                                                    @error('deskripsi')
                                                        <div class="invalid-feedback">
                                                            {{ $message }}
                                                        </div>
                                                    @enderror
                                                </div>

                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary"
                                                    data-bs-dismiss="modal">Close</button>
                                                <button type="submit" class="btn btn-primary">Add</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            {{-- End Modal Tambah --}}
                        </tbody>
                    </table>
                    {{-- End Table --}}
                </div>
            </div>
        </div>
    </div>
@endsection
