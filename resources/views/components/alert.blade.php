<div>
@if(session()->has('message'))
        @push('scripts')
            <script>
            $(function () {
            const Toast = Swal.mixin({
            toast: true,
            position: 'top-center',
            confirmButtonText:'Close',
            timer: 5000,
            timerProgressBar: true,
            didOpen: (toast) => {
            toast.addEventListener('mouseenter', Swal.stopTimer)
            toast.addEventListener('mouseleave', Swal.resumeTimer)
            }
            })

            Toast.fire({
            customClass : {
            title: 'swal-yk-title'
            },
            icon: 'success',
            title: "{{ session()->get('message') }}",

            })
            });
            </script>
        @endpush

@endif
</div>
