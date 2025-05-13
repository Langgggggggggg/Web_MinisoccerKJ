@extends('layouts.app')

@section('header')
    @include('layouts.header')
@endsection

@section('content')
    <div class="w-[20rem] md:w-full lg:w-full xl:w-full">
        <div class="max-w-full overflow-x-auto bg-white rounded-lg shadow-md">
            <table class="table-auto w-full text-center text-sm text-gray-700">
                <thead class="bg-emerald-600 text-white">
                    <tr>
                        <th class="px-4 py-2 border-b">No</th>
                        <th class="px-4 py-2 border-b">Nama</th>
                        <th class="px-4 py-2 border-b">Email</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($members as $index => $member)
                        <tr class="hover:bg-gray-100">
                            <td class="px-4 py-2 border-b">{{ $index + 1 }}</td>
                            <td class="px-4 py-2 border-b">{{ $member->user->name }}</td>
                            <td class="px-4 py-2 border-b">{{ $member->user->email }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        {{-- <div class="d-flex justify-content-center mt-3">
            {{ $members->links() }}
        </div> --}}
    </div>
@endsection

