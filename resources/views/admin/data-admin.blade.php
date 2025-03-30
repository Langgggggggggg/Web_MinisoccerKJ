@extends('layouts.app')

@section('header')
    @include('layouts.header')
@endsection

@section('content')
    <div class="w-[20rem] md:w-full lg:w-full xl:w-full">
        <div class="flex justify-end items-center mb-2">
            <a href="{{ route('admin.create') }}" class="bg-emerald-600 text-white px-4 py-2 rounded hover:bg-emerald-700">
                <i class="fas fa-user-plus mr-2"></i>Tambah Admin
            </a>
        </div>

        <div class="max-w-full overflow-x-auto bg-white rounded-lg shadow-md">
            <table class="table-auto w-full text-center text-sm text-gray-700">
                <thead class="bg-emerald-600 text-white">
                    <tr>
                        <th class="px-4 py-2 border-b">No</th>
                        <th class="px-4 py-2 border-b">Nama</th>
                        <th class="px-4 py-2 border-b">Username</th>
                        <th class="px-4 py-2 border-b">Email</th>
                        <th class="px-4 py-2 border-b">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($admins as $index => $admin)
                        <tr class="hover:bg-gray-100">
                            <td class="px-4 py-2 border-b">{{ $index + 1 }}</td>
                            <td class="px-4 py-2 border-b">{{ $admin->name }}</td>
                            <td class="px-4 py-2 border-b">{{ $admin->username }}</td>
                            <td class="px-4 py-2 border-b">{{ $admin->email }}</td>
                            <td class="px-4 py-2 border-b">
                                @if (auth()->user()->id === $admin->id)
                                    <a href="{{ route('admin.edit', $admin->id) }}" class="bg-blue-500 text-white px-3 py-1 rounded hover:bg-blue-600">
                                        Edit
                                    </a>
                                @endif
                            </td>
                            
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="d-flex justify-content-center mt-3">
            {{ $admins->links() }}
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
