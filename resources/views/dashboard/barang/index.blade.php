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
                <div class="alert alert-warning alert-dismissible fade show" role="alert">
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
            <button class="btn btn-dark" type="button" data-bs-toggle="modal" data-bs-target="#tambahStockModal">
                <i class="fa-regular fa-plus me-2"></i>
                Tambah Stock
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
                                <th>Name</th>
                                <th>Serial Number</th>
                                <th>Qty</th>
                                <th>Deskripsi</th>
                                <th>Kategori</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($barangs as $barang)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $barang->name }}</td>
                                    <td>{{ $barang->serialNumber }}</td>
                                    <td>{{ $barang->qty }}</td>
                                    <td>{{ $barang->deskripsi }}</td>
                                    <td>{{ $barang->kategoris->name }}</td>
                                    <td>
                                        <button class="btn btn-sm btn-warning" data-bs-toggle="modal"
                                            data-bs-target="#editModal{{ $loop->iteration }}">
                                            <i class="fa-regular fa-pen-to-square"></i>
                                        </button>
                                        <button data-bs-target="#modalHapus{{ $loop->iteration }}"
                                            class="btn btn-sm btn-danger" data-bs-toggle="modal">
                                            <i class="fa-regular fa-trash-can fa-lg"></i>
                                        </button>
                                    </td>
                                </tr>

                                <!-- Modal Edit -->
                                <div class="modal fade" id="editModal{{ $loop->iteration }}" tabindex="-1"
                                    aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h1 class="modal-title fs-5">Edit Kategori</h1>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                    aria-label="Close">
                                                </button>
                                            </div>
                                            <form action="{{ route('barang.update', $barang->id) }}" method="post">
                                                @method('put')
                                                @csrf
                                                <div class="modal-body">
                                                    <div class="mb-3">
                                                        <input type="hidden" name="id" value="{{ $barang->id }}">
                                                        <label for="name" class="form-label">Name</label>
                                                        <input type="text"
                                                            class="form-control @error('name') is-invalid @enderror"
                                                            name="name" id="name"
                                                            value="{{ old('name', $barang->name) }}" autofocus required>
                                                        @error('name')
                                                            <div class="invalid-feedback">
                                                                {{ $message }}
                                                            </div>
                                                        @enderror
                                                    </div>
                                                    <div class="mb-3">
                                                        <label for="serialNumber" class="form-label">Serial Number</label>
                                                        <input type="text"
                                                            class="form-control @error('serialNumber') is-invalid @enderror"
                                                            name="serialNumber" id="serialNumber"
                                                            value="{{ old('serialNumber', $barang->serialNumber) }}"
                                                            autofocus required>
                                                        @error('serialNumber')
                                                            <div class="invalid-feedback">
                                                                {{ $message }}
                                                            </div>
                                                        @enderror
                                                    </div>
                                                    <div class="mb-3">
                                                        <label for="qty" class="form-label">Qty</label>
                                                        <input type="text"
                                                            class="form-control @error('qty') is-invalid @enderror"
                                                            name="qty" id="qty"
                                                            value="{{ old('qty', $barang->qty) }}" autofocus required>
                                                        @error('qty')
                                                            <div class="invalid-feedback">
                                                                {{ $message }}
                                                            </div>
                                                        @enderror
                                                    </div>
                                                    <div class="mb-3">
                                                        <label for="deskripsi" class="form-label">Deskripsi</label>
                                                        <input type="text"
                                                            class="form-control @error('deskripsi') is-invalid @enderror"
                                                            name="deskripsi" id="deskripsi"
                                                            value="{{ old('deskripsi', $barang->deskripsi) }}" autofocus
                                                            required>
                                                        @error('deskripsi')
                                                            <div class="invalid-feedback">
                                                                {{ $message }}
                                                            </div>
                                                        @enderror
                                                    </div>
                                                    <div class="mb-3">
                                                        <label for="kategoriId" class="form-label">Kategori</label>
                                                        <select class="form-select" id="kategoriId" name="kategoriId"
                                                            required>
                                                            @foreach ($kategoris as $kategori)
                                                                @if (old('kategoriId', $kategori->kategoriId) == $kategori->id)
                                                                    <option value="{{ old('kategoriId', $kategori->id) }}">
                                                                        {{ $kategori->name }}</option>
                                                                @else
                                                                    <option value="{{ $kategori->id }}">
                                                                        {{ $kategori->name }}</option>
                                                                @endif
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary"
                                                        data-bs-dismiss="modal">Close</button>
                                                    <button type="submit" class="btn btn-warning">Edit</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                                {{-- End Edit  --}}

                                {{-- Modal Hapus --}}
                                <div class="modal fade" id="modalHapus{{ $loop->iteration }}" tabindex="-1"
                                    aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="exampleModalLabel">Hapus Barang</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                    aria-label="Close"></button>
                                            </div>
                                            <form action="{{ route('barang.destroy', $barang->id) }}" method="post">
                                                @method('delete')
                                                @csrf
                                                <div class="modal-body">
                                                    <p class="fs-6">Apakah anda yakin akan menghapus Kategori
                                                        <b>{{ $barang->name }}</b>?
                                                    </p>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary"
                                                        data-bs-dismiss="modal">Batal</button>
                                                    <button type="submit" class="btn btn-outline-danger">Hapus</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                                {{-- / Modal Hapus --}}
                            @endforeach

                            {{-- add Modal Tambah --}}
                            <div class="modal fade" id="tambahModal" tabindex="-1" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h1 class="modal-title fs-5">Add Barang</h1>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                aria-label="Close"></button>
                                        </div>
                                        <form action="{{ route('barang.store') }}" method="post">
                                            <div class="modal-body">
                                                @csrf
                                                <div class="mb-3">
                                                    <label for="name" class="form-label">Name</label>
                                                    <input type="text"
                                                        class="form-control @error('name') is-invalid @enderror"
                                                        name="name" id="name" value="{{ old('name') }}"
                                                        autofocus required>
                                                    @error('name')
                                                        <div class="invalid-feedback">
                                                            {{ $message }}
                                                        </div>
                                                    @enderror
                                                </div>
                                                <div class="mb-3">
                                                    <label for="serialNumber" class="form-label">Serial Number</label>
                                                    <input type="text"
                                                        class="form-control @error('serialNumber') is-invalid @enderror"
                                                        name="serialNumber" id="serialNumber"
                                                        value="{{ old('serialNumber') }}" autofocus required>
                                                    @error('serialNumber')
                                                        <div class="invalid-feedback">
                                                            {{ $message }}
                                                        </div>
                                                    @enderror
                                                </div>
                                                <div class="mb-3">
                                                    <label for="qty" class="form-label">Qty</label>
                                                    <input type="number"
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
                                                <div class="mb-3">
                                                    <label for="kategoriId" class="form-label">Kategori</label>
                                                    <select class="form-select" name="kategoriId" id="kategoriId">
                                                        <option disabled selected>Pilih Kategori</option>
                                                        @foreach ($kategoris as $kategori)
                                                            <option value="{{ $kategori->id }}">{{ $kategori->name }}
                                                            </option>
                                                        @endforeach
                                                    </select>
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

                            {{-- add Modal Tambah --}}
                            <div class="modal fade" id="tambahStockModal" tabindex="-1" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h1 class="modal-title fs-5">Add Stock Barang</h1>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                aria-label="Close"></button>
                                        </div>
                                        <form action="{{ route('barang.stock') }}" method="post">
                                            <div class="modal-body">
                                                @csrf
                                                <div class="mb-3">
                                                    <label for="qty" class="form-label">Qty</label>
                                                    <input type="number"
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
                                                    <label for="barangId" class="form-label">Barang</label>
                                                    <select class="form-select" name="barangId" id="barangId">
                                                        <option disabled selected>Pilih Barang</option>
                                                        @foreach ($barangs as $barang)
                                                            <option value="{{ $barang->id }}">{{ $barang->name }}
                                                            </option>
                                                        @endforeach
                                                    </select>
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
