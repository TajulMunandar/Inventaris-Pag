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
                                <th>Name</th>
                                <th>Username</th>
                                <th>Role</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($users as $user)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $user->name }}</td>
                                    <td>{{ $user->username }}</td>
                                    <td>
                                        @if ($user->isAdmin == 0)
                                            Admin
                                        @else
                                            Karyawan
                                        @endif
                                    </td>
                                    <td>
                                        <button class="btn btn-sm btn-dark" data-bs-toggle="modal"
                                            data-bs-target="#pswdModal{{ $loop->iteration }}">
                                            <i class="fa-regular fa-lock"></i>
                                        </button>
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

                                <!-- Modal reset Pswd User -->
                                <div class="modal fade" id="pswdModal{{ $loop->iteration }}" tabindex="-1"
                                    aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h1 class="modal-title fs-5">Edit Password User</h1>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                    aria-label="Close">
                                                </button>
                                            </div>
                                            <form action="/dashboard/user/reset-password" method="post">
                                                @csrf
                                                <div class="modal-body">
                                                    <input type="hidden" name="id" value="{{ $user->id }}">
                                                    <div class="mb-3">
                                                        <label for="password" class="form-label">Password</label>
                                                        <div id="pwd1" class="input-group">
                                                            <input type="passwrod"
                                                                class="form-control @error('password') is-invalid @enderror"
                                                                name="password" id="password" autofocus required>
                                                            <span class="input-group-text cursor-pointer">
                                                                <i class="fa-regular fa-eye-slash" id="togglePassword"></i>
                                                            </span>
                                                            @error('password')
                                                                <div class="invalid-feedback">
                                                                    {{ $message }}
                                                                </div>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label for="password2" class="form-label">Konfirmasi Password</label>
                                                        <div id="pwd2" class="input-group">
                                                            <input type="passwrod"
                                                                class="form-control @error('password2') is-invalid @enderror"
                                                                name="password2" id="password2" autofocus required>
                                                            <span class="input-group-text cursor-pointer">
                                                                <i class="fa-regular fa-eye-slash" id="togglePassword2"></i>
                                                            </span>
                                                            @error('password2')
                                                                <div class="invalid-feedback">
                                                                    {{ $message }}
                                                                </div>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary"
                                                        data-bs-dismiss="modal">Close</button>
                                                    <button type="submit" class="btn btn-dark">Edit</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                                {{-- End reset User --}}

                                <!-- Modal Edit User -->
                                <div class="modal fade" id="editModal{{ $loop->iteration }}" tabindex="-1"
                                    aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h1 class="modal-title fs-5">Edit User</h1>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                    aria-label="Close">
                                                </button>
                                            </div>
                                            <form action="{{ route('user.update', $user->id) }}" method="post">
                                                @method('put')
                                                @csrf
                                                <div class="modal-body">
                                                    <div class="mb-3">
                                                        <label for="name" class="form-label">Name</label>
                                                        <input type="text"
                                                            class="form-control @error('name') is-invalid @enderror"
                                                            name="name" id="name"
                                                            value="{{ old('name', $user->name) }}" autofocus required>
                                                        @error('name')
                                                            <div class="invalid-feedback">
                                                                {{ $message }}
                                                            </div>
                                                        @enderror
                                                    </div>
                                                    <div class="mb-3">
                                                        <label for="username" class="form-label">Username</label>
                                                        <input type="text"
                                                            class="form-control @error('username') is-invalid @enderror"
                                                            name="username" id="username"
                                                            value="{{ old('username', $user->username) }}" autofocus
                                                            required>
                                                        @error('username')
                                                            <div class="invalid-feedback">
                                                                {{ $message }}
                                                            </div>
                                                        @enderror
                                                    </div>
                                                    <div class="mb-3">
                                                        <label for="isAdmin" class="form-label">Role</label>
                                                        <select class="form-select" name="isAdmin" id="isAdmin">
                                                            <option value="{{ old('isAdmin', $user->isAdmin) }}" disabled selected>
                                                                @if ($user->isAdmin == 0)
                                                                    Admin
                                                                @else
                                                                    Karyawan
                                                                @endif
                                                            </option>
                                                            <option value="0">Admin</option>
                                                            <option value="1">Karyawan</option>
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
                                {{-- End Edit Hapus --}}

                                {{-- Modal Hapus User --}}
                                <div class="modal fade" id="modalHapus{{ $loop->iteration }}" tabindex="-1"
                                    aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="exampleModalLabel">Hapus User</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                    aria-label="Close"></button>
                                            </div>
                                            <form action="{{ route('user.destroy', $user->id) }}" method="post">
                                                @method('delete')
                                                @csrf
                                                <div class="modal-body">
                                                    <p class="fs-6">Apakah anda yakin akan menghapus User
                                                        <b>{{ $user->name }}</b>?
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
                                {{-- / Modal Hapus User --}}
                            @endforeach

                            {{-- add Modal Tambah --}}
                            <div class="modal fade" id="tambahModal" tabindex="-1" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h1 class="modal-title fs-5">Add User</h1>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                aria-label="Close"></button>
                                        </div>
                                        <form action="{{ route('user.store') }}" method="post">
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
                                                    <label for="username" class="form-label">Username</label>
                                                    <input type="text"
                                                        class="form-control @error('username') is-invalid @enderror"
                                                        name="username" id="username" value="{{ old('username') }}"
                                                        autofocus required>
                                                    @error('username')
                                                        <div class="invalid-feedback">
                                                            {{ $message }}
                                                        </div>
                                                    @enderror
                                                </div>
                                                <div class="mb-3">
                                                    <label for="password" class="form-label">Password</label>
                                                    <input type="password"
                                                        class="form-control @error('password') is-invalid @enderror"
                                                        name="password" id="password" value="{{ old('password') }}"
                                                        autofocus required>
                                                    @error('password')
                                                        <div class="invalid-feedback">
                                                            {{ $message }}
                                                        </div>
                                                    @enderror
                                                </div>
                                                <div class="mb-3">
                                                    <label for="isAdmin" class="form-label">Role</label>
                                                    <select class="form-select" name="isAdmin" id="isAdmin">
                                                        <option value="0" selected>Admin</option>
                                                        <option value="1">Karyawan</option>
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

    <script>
        const input1 = document.querySelector("#pwd1 input");
        const eye1 = document.querySelector("#pwd1 .fa-eye-slash");

        eye1.addEventListener("click", () => {
          if (input1.type === "password") {
            input1.type = "text";

            eye1.classList.remove("fa-eye-slash");
            eye1.classList.add("fa-eye");
          } else {
            input1.type = "password";

            eye1.classList.remove("fa-eye");
            eye1.classList.add("fa-eye-slash");
          }
        });

        const input2 = document.querySelector("#pwd2 input");
        const eye2 = document.querySelector("#pwd2 .fa-eye-slash");

        eye2.addEventListener("click", () => {
          if (input2.type === "password") {
            input2.type = "text";

            eye2.classList.remove("fa-eye-slash");
            eye2.classList.add("fa-eye");
          } else {
            input2.type = "password";

            eye2.classList.remove("fa-eye");
            eye2.classList.add("fa-eye-slash");
          }
        });
      </script>
@endsection
