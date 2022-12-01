<div class="mb-3">
    <label
        for="{{ $id }}"
        class="form-label text-capitalize">
        {{ $title }}
    </label>
    <input
        type="{{ $type }}"
        name="{{ $name }}"
        class="form-control @error($name) is-invalid @enderror"
        id="{{ $id }}"
        @if ($required) required @endif
        @if ($min) min="{{ $min }}" @endif
        @if ($max) max="{{ $max }}" @endif
        @if ($maxchar) maxlength="{{ $maxchar }}" @endif
        @if ($value || old($name))
            @if (old($name))
                value="{{ old($name) }}"
            @elseif ($value)
                value="{{ $value }}"
            @endif
        @endif>

    @error($name)
        <span class="invalid-feedback" role="alert">
            <strong>{{ $message }}</strong>
        </span>
    @enderror

    <small>{{ $info }}</small>
  </div>