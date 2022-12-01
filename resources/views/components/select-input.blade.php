<div class="form-group mb-4">
    <label for="{{ $id }}" class="text-capitalize">{{ $title }}</label>
    <select
        id="{{ $id }}"
        class="form-select h-100 @error($name) is-invalid @enderror"
        name="{{ $name }}"
        data-control="select2"
        data-placeholder="Select an option"
        data-allow-clear="true">

        {{ $slot }}
    </select>

    @if ($info)
        <small>{{ $info }}</small>
    @endif

    @error($name)
        <span class="invalid-feedback d-block">
            {{ $message }}
        </span>
    @enderror
</div>