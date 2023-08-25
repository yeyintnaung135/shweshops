@extends('backend.super_admin.layout')
@section('title', 'MOE Admin Team | Site Setting')

@section('content')
    {{-- {{ print_r($sitesettings) }} --}}
    <div class="wrapper">
        <!-- Navbar -->
        @include('backend.super_admin.navbar')
        <!-- /.navbar -->
        <!-- Main Sidebar Container -->
        @include('backend.super_admin.sidebar')
        <div class="content-wrapper">
            <x-alert> </x-alert>
            <section class="content-header">
                <x-title>Site Settings</x-title>
            </section>
            <section class="content row container mx-auto">
                <ul class="list-group col-12 col-md-6 mx-1 mx-md-4">
                    @foreach ($sitesettings as $sitesetting)
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <div>{{ $sitesetting->name }} feature is <span id="toggleText{{ $sitesetting->id }}"></span>
                            </div>
                            <div class="custom-control custom-switch">
                                <input type="hidden" id="{{ $sitesetting->id }}">
                                <input type="checkbox" name="settings" class="custom-control-input"
                                    id="settingToggle{{ $sitesetting->id }}" name='machine_state'>
                                <label class="custom-control-label" id="statusText"
                                    for="settingToggle{{ $sitesetting->id }}"></label>
                            </div>
                        </li>
                    @endforeach
                </ul>
            </section>

        </div>
    </div>
@endsection

@push('scripts')
    <script>
        var sitesettings = {!! json_encode($sitesettings) !!};
        sitesettings.forEach(sitesetting => {
            if (sitesetting.action == "on") {
                $('#settingToggle' + sitesetting.id).prop('checked', true);
            } else {
                $('#settingToggle' + sitesetting.id).prop('checked', false);
            }
            document.getElementById('toggleText' + sitesetting.id).innerHTML = sitesetting.action;
            // if(sitesetting.id == 2) {
            //   $('#settingToggle'+sitesetting.id).prop('disabled', true);
            // }
        });

        var checkboxes = $('[name="settings"]');

        checkboxes.on('change', function() {
            var parentDiv = document.getElementById(this.id).parentNode;
            var divId = parentDiv.querySelector("input[type=hidden]").id;
            var action;
            if (this.checked) {
                action = "on";
            } else {
                action = "off";
            }
            $.ajax({
                method: "GET",
                url: " {{ route('backside.super_admin.superadmin.update_action') }}",
                cache: false,
                dataType: "json",
                data: {
                    id: divId,
                    action: action,
                },
                error: function(err) {
                    // console.log(err);
                },
                success: function(response) {
                    document.getElementById('toggleText' + divId).innerHTML = response.action;
                    // console.log(response);
                },
            });
        });
    </script>
@endpush
