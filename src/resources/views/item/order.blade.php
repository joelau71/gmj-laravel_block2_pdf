<x-admin.layout.app>
    @php
    $breadcrumbs = [
        ['name' => 'Element', 'link' => route("admin.element.index")],
        ['name' => $element->title],
        ['name' => "PDF Category", "link" => route('LaravelBlock2Pdf.index', $element->id)],
        ['name' => $category->title],
        ["name"=> "item", "link" => route('LaravelBlock2Pdf.item.index',['element_id' => $element_id, 'cat_id' => $cat_id])],
        ["name" => "Order"]
    ];
    @endphp
    <x-admin.atoms.breadcrumb :breadcrumbs="$breadcrumbs" />

    <div class="text-right mb-6">
        <x-admin.atoms.button form="myForm">
            Save
        </x-admin.atoms.button>
        <x-admin.atoms.link href="{{ url()->previous() }}">
            Back
        </x-admin.atoms.link>
    </div>

    <form
        id="myForm"
        method="POST"
        action="{{ route('LaravelBlock2Pdf.item.order2', ['element_id' => $element_id, 'cat_id' => $cat_id]) }}"
    >
        @csrf
        <div id="menu-list">
            @foreach ($collection as $item)
                <div class="py-3 px-6 bg-black text-white rounded-md w-full mt-4 cursor-move">
                    <img src="{{ $item->getFirstMedia("laravel_block2_pdf")->getUrl() }}" alt="" class="w-14">
                    <input type="hidden" name="id[]" value="{{ $item->id }}">
                </div>
            @endforeach
        </div>
    </form>

    @push("js")
        <script src="{{ asset("js/jquery-3.6.0.min.js") }}"></script>
        <script src="{{ asset("js/jquery-ui.min.js") }}"></script>
        <script>
            $(function() {
                $("#menu-list").sortable();
            });
        </script>
    @endpush
</x-admin.layout.app>