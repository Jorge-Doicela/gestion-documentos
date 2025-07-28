@extends('layouts.app')

@section('content')
    <div class="container mx-auto p-4">
        <h1 class="text-2xl font-bold mb-4">Normativas Documentales</h1>

        <table class="min-w-full border border-gray-300">
            <thead>
                <tr class="bg-gray-200">
                    <th class="border px-4 py-2">Tipo de Documento</th>
                    <th class="border px-4 py-2">Contenido</th>
                </tr>
            </thead>
            <tbody>
                @forelse($normativas as $normativa)
                    <tr>
                        <td class="border px-4 py-2">{{ $normativa->tipoDocumento->nombre }}</td>
                        <td class="border px-4 py-2 whitespace-pre-line">{!! nl2br(e($normativa->contenido)) !!}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="2" class="border px-4 py-2 text-center">No hay normativas disponibles.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        <div class="mt-4">
            {{ $normativas->links() }}
        </div>
    </div>
@endsection
