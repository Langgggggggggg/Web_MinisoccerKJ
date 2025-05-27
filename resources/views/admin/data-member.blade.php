@extends('layouts.app')

@section('header')
    @include('layouts.header')
@endsection

@section('content')
    <div class="w-[19rem] md:w-full xl:w-full">
        <div class="max-w-full overflow-x-auto bg-white rounded-lg shadow-md">
            <table class="table-auto w-full text-center text-sm text-gray-700">
                <thead class="bg-emerald-600">
                    <tr class="text-white">
                        <th class="px-4 py-2 border-b">No</th>
                        <th class="px-4 py-2 border-b">Nama</th>
                        <th class="px-4 py-2 border-b">Email</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($members as $index => $member)
                        <tr class="hover:bg-gray-100">
                            <td class="px-4 py-2 border-b">{{ $index + 1 }}</td>
                            <td class="px-4 py-2 border-b">{{ $member->user->name }}</td>
                            <td class="px-4 py-2 border-b">{{ $member->user->email }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="9" class="py-4 text-gray-500">Data member tidak ditemukan</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection
