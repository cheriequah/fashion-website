<div class="col-lg-3 col-md-12">
    <div class="border-bottom mb-4 pb-4">
        <!-- Category -->
        <h5 class="font-weight-semi-bold mb-4">Category</h5>
        <form>
            <div class="list-group">
                @foreach ($categories as $category)
                    <a href="{{ url('/'.$category->slug) }}" class="list-group-item"><strong>&gt;&nbsp;{{ $category->name }}</strong></a>
                    @foreach ($category->subcategories as $subcategory)
                        <a href="{{ url('/'.$subcategory->slug) }}" class="list-group-item">&nbsp;&nbsp;&nbsp;&nbsp;{{ $subcategory->name }}</a>
                    @endforeach
                @endforeach
                
              </div>
        </form>
    </div>

    {{--<!-- Style -->
    <div class="border-bottom mb-4 pb-4">
        <h5 class="font-weight-semi-bold mb-4">Pattern</h5>
        <form>
            @foreach ($patternArray as $patternsA)
                <div class="custom-control custom-checkbox d-flex align-items-center justify-content-between mb-3">
                    <input type="checkbox" class="pattern" name="patternsA[]" id="{{ $patternsA }}" value="{{ $patternsA }}">
                    <label class="custom-control-label" for="price-all">{{ $patternsA }}</label>
                    <span class="badge border font-weight-normal">1000</span>
                </div>
            @endforeach 
        </form>
    </div>--}}

    <!-- Style -->
    <div class="border-bottom mb-4 pb-4">
        <h5 class="font-weight-semi-bold mb-4">Pattern</h5>
            @foreach ($patterns as $pattern)
                <div class="custom-control custom-checkbox d-flex align-items-center justify-content-between mb-3">
                    <input type="checkbox" class="pattern" id="{{ $pattern['id'] }}" name="{{ $pattern['name'] }}" value="{{ $pattern['id'] }}">
                    <label class="custom-control-label" for="price-all">{{ $pattern['name'] }}</label>
                    <span class="badge border font-weight-normal">{{ 1000 }}</span>
                </div>
            @endforeach 
    </div>

    <!-- Price -->
    <div class="border-bottom mb-4 pb-4">
        <h5 class="font-weight-semi-bold mb-4">Occasion</h5>
        <form>
            @foreach ($occasions as $occasion)
                <div class="custom-control custom-checkbox d-flex align-items-center justify-content-between mb-3">
                    <input type="checkbox" class="occasion" id="{{ $occasion->id }}" name="{{ $occasion->type }}" value="{{ $occasion->id }}">
                    <label class="custom-control-label" for="price-1">{{ $occasion->type }}</label>
                    <span class="badge border font-weight-normal">150</span>
                </div>
            @endforeach
            
        </form>
    </div>
    
    <!-- Color -->
    <div class="border-bottom mb-4 pb-4">
        <h5 class="font-weight-semi-bold mb-4">Color</h5>
        <form>
            @foreach ($colors as $color)
                <div class="custom-control custom-checkbox d-flex align-items-center justify-content-between mb-3">
                    <input type="checkbox" class="color" id="{{ $color->id }}" name="{{ $color->type }}" value="{{ $color->id }}">
                    <label class="custom-control-label" for="color-1">{{ $color->type }}</label>
                    <span class="badge border font-weight-normal">150</span>
                </div>
            @endforeach
        </form>
    </div>
    <!-- Color End -->

    <!-- Sleeve -->
    <div class="border-bottom mb-4 pb-4">
        <h5 class="font-weight-semi-bold mb-4">Sleeve</h5>
        <form>
            @foreach ($sleeves as $sleeve)
                <div class="custom-control custom-checkbox d-flex align-items-center justify-content-between mb-3">
                    <input type="checkbox" class="sleeve" id="{{ $sleeve->id }}" name="{{ $sleeve->type }}" value="{{ $sleeve->id }}">
                    <label class="custom-control-label" for="color-1">{{ $sleeve->type }}</label>
                    <span class="badge border font-weight-normal">150</span>
                </div>
            @endforeach
        </form>
    </div>
    <!-- Sleeve End -->

    <!-- Material -->
    <div class="border-bottom mb-4 pb-4">
        <h5 class="font-weight-semi-bold mb-4">Material</h5>
        <form>
            @foreach ($materials as $material)
                <div class="custom-control custom-checkbox d-flex align-items-center justify-content-between mb-3">
                    <input type="checkbox" class="material" id="{{ $material->id }}" name="{{ $material->type }}" value="{{ $material->id }}">
                    <label class="custom-control-label" for="color-1">{{ $material->type }}</label>
                    <span class="badge border font-weight-normal">150</span>
                </div>
            @endforeach
        </form>
    </div>
    <!-- Material End -->

    <!-- Size Start -->
    <div class="mb-5">
        <h5 class="font-weight-semi-bold mb-4">Size</h5>
        <form>
            <div class="custom-control custom-checkbox d-flex align-items-center justify-content-between mb-3">
                <input type="checkbox" class=" id="size-1">
                <label class="custom-control-label" for="size-1">XS</label>
                <span class="badge border font-weight-normal">150</span>
            </div>
            <div class="custom-control custom-checkbox d-flex align-items-center justify-content-between mb-3">
                <input type="checkbox" class=" id="size-2">
                <label class="custom-control-label" for="size-2">S</label>
                <span class="badge border font-weight-normal">295</span>
            </div>
            <div class="custom-control custom-checkbox d-flex align-items-center justify-content-between mb-3">
                <input type="checkbox" class=" id="size-3">
                <label class="custom-control-label" for="size-3">M</label>
                <span class="badge border font-weight-normal">246</span>
            </div>
            <div class="custom-control custom-checkbox d-flex align-items-center justify-content-between mb-3">
                <input type="checkbox" class=" id="size-4">
                <label class="custom-control-label" for="size-4">L</label>
                <span class="badge border font-weight-normal">145</span>
            </div>
            <div class="custom-control custom-checkbox d-flex align-items-center justify-content-between">
                <input type="checkbox" class=" id="size-5">
                <label class="custom-control-label" for="size-5">XL</label>
                <span class="badge border font-weight-normal">168</span>
            </div>
        </form>
    </div>
    <!-- Size End -->
</div>