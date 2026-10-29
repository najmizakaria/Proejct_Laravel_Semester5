@props(['name'])
@error($name)
    <p id="{{ $name }}-error" class="field-error" role="alert">{{ $message }}</p>
@enderror
