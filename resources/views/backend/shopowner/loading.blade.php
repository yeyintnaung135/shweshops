@push('css')
<style>
    .loader-container{
        height : 100vh;
        width: 100%;
        /* background-color: rgb(0,0,0);
        background-color: rgba(181, 177, 177, 0.62); 
        backdrop-filter: blur(6px); */
        background: transparent;
        position:fixed;
        cursor: wait;
        z-index: 2000;
        display: flex;
        justify-content: center;
        align-items: center;
    }
</style>
@endpush
<div id="loader" class="loader-container">
    <div class="loader">Loading...</div>
</div>