@extends('layouts.app') {{-- Ganti dengan layout admin milikmu --}}

@section('header')
    @include('layouts.header')
@endsection
@section('content')
    <div class="w-[27rem] md:w-full xl:w-full">
        <div class="flex justify-end items-center mb-4">
            <a href="{{ route('admin.information.create') }}"
                class="bg-emerald-600 text-white px-4 py-2 rounded hover:bg-emerald-700">
                <i class="fas fa-plus mr-2"></i>Tambah Informasi
            </a>
        </div>
        <div class="max-w-full overflow-x-auto bg-white rounded-lg shadow-md">
            <table class="table-auto w-full text-center text-sm text-gray-700">
                <thead class="bg-emerald-600">
                    <tr class="text-white">
                        <th class="px-4 py-2 border-b">Judul</th>
                        <th class="px-4 py-2 border-b">Kategori</th>
                        <th class="px-4 py-2 border-b">Tanggal</th>
                        <th class="px-4 py-2 border-b">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($informations as $info)
                        <tr class="hover:bg-gray-100">
                            <td class="px-4 py-2 border-b">{{ $info->title }}</td>
                            <td class="px-4 py-2 border-b">{{ $info->category }}</td>
                            <td class="px-4 py-2 border-b">{{ $info->created_at->format('d M Y') }}</td>
                            <td class="px-4 py-2 space-x-2">
                                <a href="{{ route('admin.information.edit', $info) }}"
                                    class="inline-block bg-green-700 hover:bg-green-600 text-white text-xs md:text-sm font-medium px-3 py-1 rounded-md shadow transition duration-200 text-center whitespace-nowrap">Edit</a>
                                <form action="{{ route('admin.information.destroy', $info) }}" method="POST"
                                    class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                        class="bg-red-700 hover:bg-red-600 text-white text-xs md:text-sm font-medium px-3 py-1 rounded-md shadow transition duration-200 text-center whitespace-nowrap"
                                        onclick="return confirmDelete(event, '{{ $info->title }}')">
                                        Hapus
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="py-4 text-gray-500">Data informasi tidak ditemukan</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection

{{-- @push('scripts') --}}
<script>
    function confirmDelete(event, title) {
        event.preventDefault();
        Swal.fire({
            title: 'Anda yakin?',
            text: `Anda yakin ingin menghapus informasi '${title}'?`,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya, hapus!'
        }).then((result) => {
            if (result.isConfirmed) {
                event.target.form.submit();
            }
        });
    }
</script>
{{-- @endpush --}}
