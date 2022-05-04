<x-admin.layout.app>
    @php
    $breadcrumbs = [
        ['name' => 'Element', 'link' => route("admin.element.index")],
        ['name' => $element->title],
        ['name' => "PDF Category", "link" => route('LaravelBlock2Pdf.index', $element->id)],
        ['name' => "Create"]
    ];
    @endphp
    <x-admin.atoms.breadcrumb :breadcrumbs="$breadcrumbs" />

    <form
        class="relative mt-7"
        method="POST"
        action="{{ route("LaravelBlock2Pdf.store", $element->id) }}"
        enctype="multipart/form-data"
    >
        @csrf
        
        <x-admin.atoms.required />

        <x-admin.atoms.row>
            <x-admin.atoms.label class="required mb-2">
                Image (656 x 887) (only accept jpg, png, webp)
            </x-admin.atoms.label>
            <input
                type="file"
                name="image"
                id="image"
                class="upload-image-copper"
                data-uic-display-width="328"
                data-uic-display-height="444"
                data-uic-target-width="656"
                data-uic-target-height="887"
                data-uic-title="Size: 656(w) x 887(h)"
            />
            @error("image")
                <x-admin.atoms.error>
                    {{ $message }}
                </x-admin.atoms.error>
            @enderror
        </x-admin.atoms.row>

        @foreach (config('translatable.locales') as $locale)
            <x-admin.atoms.row>
                <x-admin.atoms.label for="title_{{ $locale }}" class="required">
                    Title ({{ $locale }})
                </x-admin.atoms.label>
                <x-admin.atoms.text name="title[{{$locale}}]" id="title_{{$locale}}" />
            </x-admin.atoms.row>
            @error("title.*")
                <x-admin.atoms.error>
                    {{ $message }}
                </x-admin.atoms.error>
            @enderror
        @endforeach

        <hr class="my-10">

        <div class="text-right">
            <x-admin.atoms.link
                href="{{ route('LaravelBlock2Pdf.index', $element->id) }}"
            >
                Back
            </x-admin.atoms.link>
            <x-admin.atoms.button id="save">
                Save
            </x-admin.atoms.button>
        </div>
    </form>
    @once
        @push('css')
            <link rel="stylesheet" href="{{ asset('css/cropper.css') }}" />
            <link rel="stylesheet" href="{{ asset('css/uploadImageCopper.css') }}" />
            <link rel="stylesheet" href="{{ asset("css/select2.min.css") }}">
        @endpush
        @push('js')
            <script src="{{ asset('js/cropper.min.js') }}"></script>
            <script src="{{ asset('js/uploadImageCopper.js') }}"></script>
            <script src="{{ asset("js/jquery-3.6.0.min.js") }}"></script>
            <script src="{{ asset("js/select2.min.js") }}"></script>
            <script>
                $(".select2").select2();
            </script>
        @endpush
    @endonce
</x-admin.layout.app>
