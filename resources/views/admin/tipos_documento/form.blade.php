{{-- resources/views/admin/tipos_documento/form.blade.php --}}
@csrf

<div class="mb-4">
    <label class="block text-gray-700 font-semibold">Nombre <span class="text-red-600">*</span></label>
    <input type="text" name="nombre" value="{{ old('nombre', $tipo->nombre ?? '') }}" required
        class="w-full border-gray-300 rounded px-3 py-2 mt-1">
    @error('nombre')
        <span class="text-red-500 text-sm">{{ $message }}</span>
    @enderror
</div>

<div class="mb-4">
    <label class="block text-gray-700 font-semibold">Descripción</label>
    <textarea name="descripcion" rows="3" class="w-full border-gray-300 rounded px-3 py-2 mt-1">{{ old('descripcion', $tipo->descripcion ?? '') }}</textarea>
    @error('descripcion')
        <span class="text-red-500 text-sm">{{ $message }}</span>
    @enderror
</div>

<div class="mb-4">
    <label class="flex items-center gap-2 text-gray-700 font-semibold">
        <input type="checkbox" name="obligatorio" value="1"
            {{ old('obligatorio', $tipo->obligatorio ?? true) ? 'checked' : '' }}>
        Obligatorio
    </label>
    @error('obligatorio')
        <span class="text-red-500 text-sm">{{ $message }}</span>
    @enderror
</div>

<div class="mb-4">
    <label class="block text-gray-700 font-semibold">Orden <span class="text-red-600">*</span></label>
    <input type="number" name="orden" value="{{ old('orden', $tipo->orden ?? 1) }}" required min="1"
        class="w-24 border-gray-300 rounded px-3 py-2 mt-1">
    @error('orden')
        <span class="text-red-500 text-sm">{{ $message }}</span>
    @enderror
</div>
