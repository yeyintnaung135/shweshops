{{-- title --}}
<h3>လက်စွပ်</h3>
{{-- Filter --}}
<div class="d-flex pt-4 sop-filter form-group justify-content-between align-items-center">
    <div class="h-100" style="width: 10%">
        <i class="fas fa-filter fa-xl"></i>
    </div>
    <div class="" style="width: 29%">
        <select name="Sort" id="sort" class="h-100 form-control ">
            <option value="sortby">Sort by</option>
            <option value="latest">By Latest</option>
            <optgroup label="By Price">
            <option value="price_low_to_high">-low to high</option>
            <option value="price_high_to_low">-high to low</option>
        </select>
    </div>
    <div class="" style="width: 29%">
        <select name="category" id="category" class="h-100 form-control ">
            @foreach($catlist as $list)
            {{-- <option value="{{ $list }}">{{ $list }}</option> --}}
            <option value="လက်စွပ်">လက်စွပ်</option>
            <option value="ကလစ်">ကလစ်</option>
            <option value="နားကပ်">နားကပ်</option>
            <option value="ဘီး">ဘီး</option>
            <option value="နားဆွဲ">နားဆွဲ</option>
            <option value="ဆံထိုး">ဆံထိုး</option>
            <option value="ရင်ထိုး">ရင်ထိုး</option>
            <option value="ဘီးကုတ်">ဘီးကုတ်</option>
            <option value="လက်စွပ်">လက်စွပ်</option>
            <option value="ဆွဲကြိုး">ဆွဲကြိုး</option>
            <option value="လက်ကောက်">လက်ကောက်</option>
            <option value="ဘယက်">ဘယက်</option>
            <option value="ဟန်းချိန်">ဟန်းချိန်</option>
            <option value="လောကပ်သီး">လောကပ်သီး</option>
            <option value="ပီချူး">ပီချူး</option>
            <option value="ခြေကျင်း">ခြေကျင်း</option>
            @endforeach
        </select>
    </div>
    <div class="" style="width: 29%">
        <select name="price" id="price" class="h-100 form-control ">
            <option value="sortby">Price Range</option>
            <option value="0-1lakh">1သိန်း အောက်</option>
            <option value="1-2lakh">1သိန်း - 2သိန်း</option>
        </select>
    </div>
</div>

@push("css")
<style>
    .sop-filter select{
            border: none;
        }
    .sop-filter .form-control{
            line-height: 2rem;      
    }
    /*less than sm */
    @media (max-width: 576px) {  
        .sop-filter{
            width: 100%;
        }
        
    }
/* sm */
    @media (min-width: 576px) {  
        .sop-filter{
            width: 100%;
        }
    }
/* md */
    @media (min-width: 768px) { 
        .sop-filter{
            width: 75%;
        }
    }
/* lg */
    @media (min-width: 992px) {  
        .sop-filter{
            width: 75%;
        }
    }
/* xl */
    @media (min-width: 1200px) { 
        .sop-filter{
            width: 50%;
        }
    }
    
</style>
@endpush