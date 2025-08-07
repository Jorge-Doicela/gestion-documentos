@csrf

{{-- Campo: Nombre --}}
<div class="mb-4">
    <label class="block text-gray-700 font-semibold">Nombre <span class="text-red-600">*</span></label>
    <input type="text" name="nombre" value="{{ old('nombre', $tipo->nombre ?? '') }}" required
        class="w-full border-gray-300 rounded px-3 py-2 mt-1">
    @error('nombre')
        <span class="text-red-500 text-sm">{{ $message }}</span>
    @enderror
</div>

{{-- Campo: Descripción --}}
<div class="mb-4">
    <label class="block text-gray-700 font-semibold">Descripción</label>
    <textarea name="descripcion" rows="3" class="w-full border-gray-300 rounded px-3 py-2 mt-1">{{ old('descripcion', $tipo->descripcion ?? '') }}</textarea>
    @error('descripcion')
        <span class="text-red-500 text-sm">{{ $message }}</span>
    @enderror
</div>

{{-- Campo: Obligatorio --}}
<div class="mb-4">
    <label class="flex items-center gap-2 text-gray-700 font-semibold">
        <input type="checkbox" name="obligatorio" value="1"
            {{ old('obligatorio', $tipo->obligatorio ?? false) ? 'checked' : '' }}>
        Obligatorio
    </label>
    @error('obligatorio')
        <span class="text-red-500 text-sm">{{ $message }}</span>
    @enderror
</div>

{{-- Campo: Orden con ayuda visual --}}
@php
    use App\Models\TipoDocumento;
    $ordenesUsadas = TipoDocumento::pluck('orden')->sort()->toArray();
@endphp
<div class="mb-4">
    <label class="block text-gray-700 font-semibold">Orden <span class="text-red-600">*</span></label>
    <input type="number" name="orden" value="{{ old('orden', $tipo->orden ?? 1) }}" required min="1"
        class="w-24 border-gray-300 rounded px-3 py-2 mt-1">
    <p class="text-sm text-gray-500 mt-1">Órdenes usadas: {{ implode(', ', $ordenesUsadas) }}</p>
    @error('orden')
        <span class="text-red-500 text-sm">{{ $message }}</span>
    @enderror
</div>

{{-- Campo: Archivo de ejemplo --}}
<div class="mb-4">
    <label class="block text-gray-700 font-semibold">Archivo de ejemplo (PDF, DOCX, etc.)</label>
    <input type="file" name="archivo_ejemplo" accept=".pdf,.doc,.docx"
        class="w-full border-gray-300 rounded px-3 py-2 mt-1">

    @if (isset($tipo) && $tipo->archivo_ejemplo)
        <p class="mt-2 text-sm">
            Archivo actual:
            <a href="{{ route('admin.tipos-documento.view', $tipo->id) }}" target="_blank"
                class="text-blue-600 underline">
                Ver archivo
            </a> |
            <a href="{{ route('admin.tipos-documento.download', $tipo->id) }}" class="text-blue-600 underline">
                Descargar
            </a>
        </p>
    @endif

    @error('archivo_ejemplo')
        <span class="text-red-500 text-sm">{{ $message }}</span>
    @enderror
</div>
