<x-frontend.container>
    <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-5 gap-4 justify-items-center mt-4">
        @foreach ($collection as $item)
            <div class="group" style="max-width: 160px;">
                <div class="relative">
                    <img class="h-56 w-full" src="{{ $item->getFirstMedia("laravel_block2_pdf_category")->getUrl() }}" alt="" />
                    <div class="absolute top-0 left-0 w-full h-full bg-black bg-opacity-50 hidden group-hover:block">
            
                    </div>
                    <a class="absolute top-12 left-1/2 -translate-x-1/2 text-white hidden group-hover:block" href="pdf/{{ $item->id }}.pdf" target="_blank">
                        <svg class="w-6 h-6 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m15 13-3 3m0 0-3-3m3 3V8m0 13a9 9 0 1 1 0-18 9 9 0 0 1 0 18z"/></svg>
                        Download
                    </a>
            
                    <a class="absolute top-32 left-1/2 -translate-x-1/2 text-white hidden group-hover:block" href="{{ route('LaravelBlock2Pdf.preview.index', $item->id) }}"  target="_blank">
                        <svg class="w-6 h-6 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m21 21-6-6m2-5a7 7 0 1 1-14 0 7 7 0 0 1 14 0z"/></svg>
                        Preview
                    </a>
                </div>
                <div class="h-4 bg-slate-800 group-hover:bg-blue-800"></div>
                <div class="text-center text-sm mt-2">
                    {{ $item->getTranslation("title", $locale) }}
                </div>
            </div>
        @endforeach


    </div>
</x-frontend.container>