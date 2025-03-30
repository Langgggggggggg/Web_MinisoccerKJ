@extends('layouts.app')

@section('header')
    @include('layouts.header')
@endsection

@section('content')
    <div class="w-[20rem] md:w-full lg:w-full xl:w-full">
        {{-- <div class="flex justify-end items-center mb-2">
            <a href="#" class="bg-emerald-600 text-white px-4 py-2 rounded hover:bg-emerald-700">
                + Tambah User
            </a>
        </div> --}}

        <div class="max-w-full overflow-x-auto bg-white rounded-lg shadow-md">
            <table class="table-auto w-full text-center text-sm text-gray-700">
                <thead class="bg-emerald-600 text-white">
                    <tr>
                        <th class="px-4 py-2 border-b">No</th>
                        <th class="px-4 py-2 border-b">Nama</th>
                        <th class="px-4 py-2 border-b">Username</th>
                        <th class="px-4 py-2 border-b">Email</th>
                        {{-- <th class="px-4 py-2 border-b">Aksi</th> --}}
                    </tr>
                </thead>
                <tbody>
                    @foreach ($users as $index => $user)
                        <tr class="hover:bg-gray-100">
                            <td class="px-4 py-2 border-b">{{ $index + 1 }}</td>
                            <td class="px-4 py-2 border-b">{{ $user->name }}</td>
                            <td class="px-4 py-2 border-b">{{ $user->username }}</td>
                            <td class="px-4 py-2 border-b">{{ $user->email }}</td>
                            {{-- <td class="px-4 py-2 border-b">
                                <a href="#" class="bg-blue-500 text-white px-3 py-1 rounded hover:bg-blue-600">Edit</a>
                                <a href="#" class="bg-red-500 text-white px-3 py-1 rounded hover:bg-red-600">Hapus</a>
                            </td> --}}
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="d-flex justify-content-center mt-3">
            {{ $users->links() }}
        </div>
    </div>
     <!-- Sweet Alert CDN -->
     <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

     @if (session('success'))
         <script>
             Swal.fire({
                 icon: 'success',
                 title: 'Berhasil!',
                 text: "{{ session('success') }}"
             });
         </script>
     @endif
 
     @if (session('error'))
         <script>
             Swal.fire({
                 icon: 'error',
                 title: 'Gagal!',
                 text: "{{ session('error') }}"
             });
         </script>
     @endif
@endsection
