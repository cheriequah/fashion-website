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
                <div class="custom-control custom-checkbox d-flex mb-3">
                    <input type="checkbox" class="pattern" id="{{ $pattern['id'] }}" name="{{ $pattern['name'] }}" value="{{ $pattern['id'] }}">
                    <label class="custom-control-label px-4" for="price-all">{{ $pattern['name'] }}</label>
                </div>
            @endforeach 
    </div>

    <!-- Price -->
    <div class="border-bottom mb-4 pb-4">
        <h5 class="font-weight-semi-bold mb-4">Occasion</h5>
        <form>
            @foreach ($occasions as $occasion)
                <div class="custom-control custom-checkbox d-flex mb-3">
                    <input type="checkbox" class="occasion" id="{{ $occasion->id }}" name="{{ $occasion->type }}" value="{{ $occasion->id }}">
                    <label class="custom-control-label px-4" for="price-1">{{ $occasion->type }}</label>
                </div>
            @endforeach
            
        </form>
    </div>
    
    <!-- Color -->
    <div class="border-bottom mb-4 pb-4">
        <h5 class="font-weight-semi-bold mb-4">Color</h5>
        <form>
            @foreach ($colors as $color)
                <div class="custom-control custom-checkbox d-flex mb-3">
                    <input type="checkbox" class="color" id="{{ $color->id }}" name="{{ $color->type }}" value="{{ $color->id }}">
                    <label class="custom-control-label px-4" for="color-1">{{ $color->type }}</label>
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
                <div class="custom-control custom-checkbox d-flex mb-3">
                    <input type="checkbox" class="sleeve" id="{{ $sleeve->id }}" name="{{ $sleeve->type }}" value="{{ $sleeve->id }}">
                    <label class="custom-control-label px-4" for="color-1">{{ $sleeve->type }}</label>
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
                <div class="custom-control custom-checkbox d-flex mb-3">
                    <input type="checkbox" class="material" id="{{ $material->id }}" name="{{ $material->type }}" value="{{ $material->id }}">
                    <label class="custom-control-label px-4" for="color-1">{{ $material->type }}</label>
                </div>
            @endforeach
        </form>
    </div>
    <!-- Material End -->

</div>