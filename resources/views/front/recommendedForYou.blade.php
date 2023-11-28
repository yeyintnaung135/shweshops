{{-- <x-wrappercomponent div-id="preminumwrap" toshow-id="preminum"></x-wrappercomponent> --}}

{{-- shop slide --}}
<div id="preminum" class="col-12 d-none show_dev">
    <div id="primary2" class="sop-font">

        <div
            class="mt-4 elementor-element elementor-element-3205fef1 elementor-widget elementor-widget-heading px-4 px-md-5 d-flex justify-content-end">
            <div class="elementor-widget-container d-flex justify-content-between">
                <h3 class="elementor-heading-title elementor-size-default" style="font-family: sans-serif !important">
                    သင့်အတွက်စိန်ရွှေရတနာများ
                </h3>
            </div>

            <div>
                <a class="btn see-more-button" href="{{ url('seeallforyou') }}"
                    style="white-space: nowrap; border-radius: 7px">See All <i class="fas fa-angle-right"></i></a>
            </div>
        </div>
        <rec-for-you></rec-for-you>
    </div>

</div>
{{-- preminum seller slide --}}

