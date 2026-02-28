@extends('admin.master_layout')
@section('title')
<title>{{ $product->name }}</title>
@endsection
@section('admin-content')
      <!-- Main Content -->
      <div class="main-content">
        <section class="section">
          <div class="section-header">
            <h1>{{ $product->name }}</h1>
          </div>
          <div class="section-body">
            <a href="{{ route('admin.product.index') }}" class="btn btn-primary"><i class="fas fa-backward"></i> {{__('admin.Go Back')}}</a>
            <!-- <div class="row mt-4">
                <div class="col">
                  <div class="card">
                      <div class="card-header">
                          <h1>{{__('admin.Product Size')}}</h1>
                      </div>
                        <div class="card-body">
                            <form action="{{ route('admin.store-product-variant', $product->id) }}" method="POST">
                                @csrf
                                <div id="size_box">
                                    @foreach ($size_variant as $index => $size)
                                        <div class="row size_box_hidden_area">

                                            <div class="col-4">
                                                <div class="form-group">
                                                    <label for="">{{__('admin.Size')}}</label>
                                                    <input type="text" name="sizes[]" class="form-control" value="{{ $size->size }}">
                                                </div>
                                            </div>

                                            <div class="col-4">
                                                <div class="form-group">
                                                    <label for="">{{__('admin.Price')}}</label>
                                                    <input type="text" name="prices[]" class="form-control" value="{{ $size->price }}">
                                                </div>
                                            </div>

                                            <div class="col-4">
                                                <button type="button" class="btn btn-danger plus_btn remove_size_box"> <i class="fa fa-trash" aria-hidden="true"></i> {{__('admin.Remove')}}</button>
                                            </div>

                                        </div>
                                    @endforeach
                                    <div class="row">

                                        <div class="col-4">
                                            <div class="form-group">
                                                <label for="">{{__('admin.Size')}}</label>
                                                <input type="text" name="sizes[]" class="form-control">
                                            </div>
                                        </div>

                                        <div class="col-4">
                                            <div class="form-group">
                                                <label for="">{{__('admin.Price')}}</label>
                                                <input type="text" name="prices[]" class="form-control">
                                            </div>
                                        </div>

                                        <div class="col-4">
                                            <button type="button" id="addNewSize" class="btn btn-success plus_btn"> <i class="fa fa-plus" aria-hidden="true"></i> {{__('admin.Add New')}}</button>
                                        </div>

                                    </div>
                                </div>

                                <button type="submit" class="btn btn-primary">{{__('admin.Save')}}</button>
                            </form>
                        </div>
                  </div>
                </div>
            </div> -->


            <div class="row mt-4">
                <div class="col">
                  <div class="card">
                      <div class="card-header">
                          <h1>{{__('admin.Optional Item')}}</h1>
                      </div>
                        <div class="card-body">
                            <form action="{{ route('admin.store-optional-item', $product->id) }}" method="POST">
                                @csrf
                                <div id="optional_box">
                                    @foreach ($optional_item as $index => $item)
                                        <div class="row optional_box_hidden_area">

                                            <div class="col-4">
                                                <div class="form-group">
                                                    <label for="">{{__('admin.Item Name')}}</label>
                                                    <input type="text" name="item_names[]" class="form-control" value="{{ $item->item }}">
                                                </div>
                                            </div>

                                            <div class="col-4">
                                                <div class="form-group">
                                                    <label for="">{{__('admin.Price')}}</label>
                                                    <input type="text" name="item_prices[]" class="form-control" value="{{ $item->price }}">
                                                </div>
                                            </div>

                                            <div class="col-4">
                                                <button type="button" class="btn btn-danger plus_btn remove_optional_box"> <i class="fa fa-trash" aria-hidden="true"></i> {{__('admin.Remove')}}</button>
                                            </div>

                                        </div>
                                    @endforeach
                                    <div class="row">

                                        <div class="col-4">
                                            <div class="form-group">
                                                <label for="">{{__('admin.Item Name')}}</label>
                                                <input type="text" name="item_names[]" class="form-control">
                                            </div>
                                        </div>

                                        <div class="col-4">
                                            <div class="form-group">
                                                <label for="">{{__('admin.Price')}}</label>
                                                <input type="text" name="item_prices[]" class="form-control">
                                            </div>
                                        </div>

                                        <div class="col-4">
                                            <button type="button" id="addNewOptionalItem" class="btn btn-success plus_btn"> <i class="fa fa-plus" aria-hidden="true"></i> {{__('admin.Add New')}}</button>
                                        </div>

                                    </div>
                                </div>

                                <button type="submit" class="btn btn-primary">{{__('admin.Save')}}</button>
                            </form>
                        </div>
                  </div>
                </div>
            </div>

            <!-- proteiins -->

                <div class="row mt-4">
                    <div class="col">
                        <div class="card">
                            <div class="card-header">
                                <h1>{{ __('admin.Proteins') }}</h1>
                            </div>
                            <div class="card-body">
                            <form action="{{ route('admin.store-optional-item', $product->id) }}" method="POST">
                                @csrf
                                <input type="hidden" name="type" value="protein"> <!-- 🔥 Add this line -->

                                <div id="protein_box">
                                    @foreach ($protein_item as $protein)
                                        <div class="row protein_box_hidden_area">
                                            <div class="col-4">
                                                <div class="form-group">
                                                    <label>{{ __('admin.Protein Type') }}</label>
                                                    <select name="item_names[]" class="form-control">
                                                        <option value="">-- Select --</option>
                                                      @php
                                                            $proteins = ['Beef', 'Goat', 'Fish', 'Chicken', 'Turkey', 'Acheke Fish', 'Tilapia', 'Atlantic Mackerel Fish'];
                                                        @endphp
                                                        @foreach ($proteins as $p)
                                                            <option value="{{ $p }}" {{ $protein->item == $p ? 'selected' : '' }}>{{ $p }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="col-4">
                                                <div class="form-group">
                                                    <label>{{ __('admin.Price') }}</label>
                                                    <input type="text" name="item_prices[]" class="form-control" value="{{ $protein->price }}">
                                                </div>
                                            </div>

                                            <div class="col-4">
                                                <button type="button" class="btn btn-danger plus_btn remove_protein_box" style="margin-top: 30px;">
                                                    <i class="fa fa-trash"></i> {{ __('admin.Remove') }}
                                                </button>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>



                                <!-- Add New Button after protein_box -->
                                <div class="mt-3">
                                    <button type="button" id="addNewProtein" class="btn btn-success">
                                        <i class="fa fa-plus"></i> {{ __('admin.Add New Protein') }}
                                    </button>
                                </div>

                                <button type="submit" class="btn btn-primary save-btn mt-3">
                                <span class="btn-text">{{ __('admin.Save') }}</span>
                                <span class="spinner-border spinner-border-sm d-none" role="status" aria-hidden="true"></span>
                                </button>
                            </form>

                            </div>
                        </div>
                    </div>
                </div>

                <!-- soup -->
                <div class="row mt-4">
                    <div class="col">
                        <div class="card">
                            <div class="card-header">
                                <h1>{{ __('admin.Soups') }}</h1>
                            </div>
                            <div class="card-body">
                                <form action="{{ route('admin.store-optional-item', $product->id) }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="type" value="soup">

                                    <div id="soup_box">
                                        @foreach ($soup_item as $soup)
                                            <div class="row soup_box_hidden_area">
                                                <div class="col-4">
                                                    <div class="form-group">
                                                        <label>{{ __('admin.Soup Type') }}</label>
                                                        <select name="item_names[]" class="form-control">
                                                            <option value="">-- Select Soup --</option>
                                                            @php
                                                                $soups = ['Egusi', 'Spinach / Collard green', 'OKro', 'Cassava leaves', 'Potato leaves', 'Native', 'Ndole Cameroon', 'Designner', 'Peanut butter', 'Assalted stew', 'Gbegriri / Ewedu'];
                                                            @endphp
                                                            @foreach ($soups as $s)
                                                                <option value="{{ $s }}" {{ $soup->item == $s ? 'selected' : '' }}>{{ $s }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-4">
                                                    <div class="form-group">
                                                        <label>{{ __('admin.Price') }}</label>
                                                        <input type="text" name="item_prices[]" class="form-control" value="{{ $soup->price }}">
                                                    </div>
                                                </div>
                                                <div class="col-4 d-flex align-items-end">
                                                    <button type="button" class="btn btn-danger plus_btn remove_soup_box">
                                                        <i class="fa fa-trash"></i> {{ __('admin.Remove') }}
                                                    </button>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>


                                    <!-- Add New Button after soup_box -->
                                    <div class="mt-3">
                                        <button type="button" id="addNewSoup" class="btn btn-success">
                                            <i class="fa fa-plus"></i> {{ __('admin.Add New Soup') }}
                                        </button>
                                    </div>

                                    <button type="submit" class="btn btn-primary save-btn mt-3">
                                        <span class="btn-text">{{ __('admin.Save') }}</span>
                                        <span class="spinner-border spinner-border-sm d-none" role="status" aria-hidden="true"></span>
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                 <!--  wrap swallow -->
                <div class="row mt-4">
                    <div class="col">
                        <div class="card">
                            <div class="card-header">
                                <h1>{{ __('admin.Wraps / Swallow Foods') }}</h1>
                            </div>
                            <div class="card-body">
                                <form action="{{ route('admin.store-optional-item', $product->id) }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="type" value="wrap">

                                    <div id="wrap_box">
                                        @foreach ($wrap_item as $wrap)
                                            <div class="row wrap_box_hidden_area">
                                                <div class="col-4">
                                                    <div class="form-group">
                                                        <label>{{ __('admin.Wrap / Swallow Type') }}</label>
                                                        <select name="item_names[]" class="form-control">
                                                            <option value="">-- Select Wrap / Swallow --</option>
                                                            @php
                                                                $wraps = ['Pounded Yam fufu', 'Plantain fufu amala', 'Cassava fufu lafun', 'Oats fufu amala', 'Millet seed fufu amala', 'Cassava gari eba'];
                                                            @endphp
                                                            @foreach ($wraps as $w)
                                                                <option value="{{ $w }}" {{ $wrap->item == $w ? 'selected' : '' }}>{{ $w }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-4">
                                                    <div class="form-group">
                                                        <label>{{ __('admin.Price') }}</label>
                                                        <input type="text" name="item_prices[]" class="form-control" value="{{ $wrap->price }}">
                                                    </div>
                                                </div>
                                                <div class="col-4 d-flex align-items-end">
                                                    <button type="button" class="btn btn-danger plus_btn remove_wrap_box">
                                                        <i class="fa fa-trash"></i> {{ __('admin.Remove') }}
                                                    </button>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>


                                    <!-- Add New Button after wrap_box -->
                                    <div class="mt-3">
                                        <button type="button" id="addNewWrap" class="btn btn-success">
                                            <i class="fa fa-plus"></i> {{ __('admin.Add New Wrap') }}
                                        </button>
                                    </div>

                                    <button type="submit" class="btn btn-primary save-btn mt-3">
                                        <span class="btn-text">{{ __('admin.Save') }}</span>
                                        <span class="spinner-border spinner-border-sm d-none" role="status" aria-hidden="true"></span>
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- drink -->
                <div class="row mt-4">
                    <div class="col">
                        <div class="card">
                            <div class="card-header">
                                <h1>{{ __('admin.Drinks') }}</h1>
                            </div>
                            <div class="card-body">
                                <form action="{{ route('admin.store-optional-item', $product->id) }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="type" value="drink">

                                    <div id="drink_box">
                                            @foreach ($drink_item as $drink)
                                                <div class="row drink_box_hidden_area">
                                                    <div class="col-4">
                                                        <div class="form-group">
                                                            <label>{{ __('admin.Drink') }}</label>
                                                            <select name="item_names[]" class="form-control">
                                                                <option value="">-- Select Drink --</option>
                                                                @php
                                                                    $drinks = ['Bottle Water', 'Cocacola', 'Fanta', 'Maltina', 'Soya Milk', 'Lacassera', 'Sobo', 'Vita milk'];
                                                                @endphp
                                                                @foreach ($drinks as $d)
                                                                    <option value="{{ $d }}" {{ $drink->item == $d ? 'selected' : '' }}>{{ $d }}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-4">
                                                        <div class="form-group">
                                                            <label>{{ __('admin.Price') }}</label>
                                                            <input type="text" name="item_prices[]" class="form-control" value="{{ $drink->price }}">
                                                        </div>
                                                    </div>
                                                    <div class="col-4 d-flex align-items-end">
                                                        <button type="button" class="btn btn-danger plus_btn remove_drink_box">
                                                            <i class="fa fa-trash"></i> {{ __('admin.Remove') }}
                                                        </button>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>


                                    <div class="mt-3">
                                        <button type="button" id="addNewDrink" class="btn btn-success">
                                            <i class="fa fa-plus"></i> {{ __('admin.Add New Drink') }}
                                        </button>
                                    </div>

                                    <button type="submit" class="btn btn-primary save-btn mt-3">
                                        <span class="btn-text">{{ __('admin.Save') }}</span>
                                        <span class="spinner-border spinner-border-sm d-none" role="status" aria-hidden="true"></span>
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>




          </div>

        </section>
      </div>

 




      <!-- <div id="hidden_size_box" class="d-none">
        <div class="row size_box_hidden_area">

            <div class="col-4">
                <div class="form-group">
                    <label for="">{{__('admin.Size')}}</label>
                    <input type="text" name="sizes[]" class="form-control">
                </div>
            </div>

            <div class="col-4">
                <div class="form-group">
                    <label for="">{{__('admin.Price')}}</label>
                    <input type="text" name="prices[]" class="form-control">
                </div>
            </div>

            <div class="col-4">
                <button type="button" class="btn btn-danger plus_btn remove_size_box"> <i class="fa fa-trash" aria-hidden="true"></i> {{__('admin.Remove')}}</button>
            </div>

        </div>
      </div> -->

      <!-- <div id="hidden_optional_box" class="d-none">
        <div class="row optional_box_hidden_area">

            <div class="col-4">
                <div class="form-group">
                    <label for="">{{__('admin.Item Name')}}</label>
                    <input type="text" name="item_names[]" class="form-control">
                </div>
            </div>

            <div class="col-4">
                <div class="form-group">
                    <label for="">{{__('admin.Price')}}</label>
                    <input type="text" name="item_prices[]" class="form-control">
                </div>
            </div>

            <div class="col-4">
                <button type="button" class="btn btn-danger plus_btn remove_optional_box"> <i class="fa fa-trash" aria-hidden="true"></i> {{__('admin.Remove')}}</button>
            </div>

        </div>
      </div> -->

      <!-- proteins -->
        <div id="hidden_protein_box" class="d-none">
            <div class="row protein_box_hidden_area">
                <div class="col-4">
                    <div class="form-group">
                        <label>{{ __('admin.Protein Type') }}</label>
                        <select name="item_names[]" class="form-control">
                            <option value="">-- Select --</option>
                             <option value="Atlantic Mackerel Fish">Atlantic Mackerel Fish</option>
                            <option value="Beef">Beef</option>
                            <option value="Goat">Goat</option>
                            <option value="Fish">Fish</option>
                            <option value="Chicken">Chicken</option>
                            <option value="Turkey">Turkey</option>
                            <option value="Acheke Fish">Acheke Fish</option>
                            <option value="Tilapia">Tilapia</option>
                        
                        </select>
                    </div>
                </div>

                <div class="col-4">
                    <div class="form-group">
                        <label>{{ __('admin.Price') }}</label>
                        <input type="text" name="item_prices[]" class="form-control" placeholder="Price">
                    </div>
                </div>

                <div class="col-4">
                    <button type="button" class="btn btn-danger plus_btn remove_protein_box" style="margin-top: 30px;">
                        <i class="fa fa-trash"></i> {{ __('admin.Remove') }}
                    </button>
                </div>
            </div>
        </div>

<!-- soups -->
<div id="hidden_soup_box" class="d-none">
    <div class="row soup_box_hidden_area">
        <div class="col-4">
            <div class="form-group">
                <label>{{ __('admin.Soup Type') }}</label>
                <select name="item_names[]" class="form-control">
                    <option value="">-- Select Soup --</option>
                    <option value="Egusi">Egusi</option>
                    <option value="Spinach / Collard green">Spinach / Collard green</option>
                    <option value="OKro">OKro</option>
                    <option value="Cassava leaves">Cassava leaves</option>
                    <option value="Potato leaves">Potato leaves</option>
                    <option value="Native">Native</option>
                    <option value="Ndole Cameroon">Ndole Cameroon</option>
                    <option value="Designner">Designner</option>
                    <option value="Peanut butter">Peanut butter</option>
                    <option value="Assalted stew">Assalted stew</option>
                    <option value="Gbegriri / Ewedu">Gbegriri / Ewedu</option>
                </select>
            </div>
        </div>
        <div class="col-4">
            <div class="form-group">
                <label>{{ __('admin.Price') }}</label>
                <input type="text" name="item_prices[]" class="form-control" placeholder="Price">
            </div>
        </div>
        <div class="col-4 d-flex align-items-end">
            <button type="button" class="btn btn-danger plus_btn remove_soup_box">
                <i class="fa fa-trash"></i> {{ __('admin.Remove') }}
            </button>
        </div>
    </div>
</div>

    <!-- wrap /swallow -->
    <div id="hidden_wrap_box" class="d-none">
        <div class="row wrap_box_hidden_area">
            <div class="col-4">
                <div class="form-group">
                    <label>{{ __('admin.Wrap / Swallow Type') }}</label>
                    <select name="item_names[]" class="form-control">
                        <option value="">-- Select Wrap / Swallow --</option>
                        <option value="Pounded Yam fufu">Pounded Yam fufu</option>
                        <option value="Plantain fufu amala">Plantain fufu amala</option>
                        <option value="Cassava fufu lafun">Cassava fufu lafun</option>
                        <option value="Oats fufu amala">Oats fufu amala</option>
                        <option value="Millet seed fufu amala">Millet seed fufu amala</option>
                        <option value="Cassava gari eba">Cassava gari eba</option>
                    </select>
                </div>
            </div>
            <div class="col-4">
                <div class="form-group">
                    <label>{{ __('admin.Price') }}</label>
                    <input type="text" name="item_prices[]" class="form-control" placeholder="Price">
                </div>
            </div>
            <div class="col-4 d-flex align-items-end">
                <button type="button" class="btn btn-danger plus_btn remove_wrap_box">
                    <i class="fa fa-trash"></i> {{ __('admin.Remove') }}
                </button>
            </div>
        </div>
    </div>
<!-- drink -->

<div id="hidden_drink_box" class="d-none">
    <div class="row drink_box_hidden_area">
        <div class="col-4">
            <div class="form-group">
                <label>{{ __('admin.Drink') }}</label>
                <select name="item_names[]" class="form-control">
                    <option value="">-- Select Drink --</option>
                    <option value="Bottle Water">Bottle Water</option>
                    <option value="Cocacola">Cocacola</option>
                    <option value="Fanta">Fanta</option>
                    <option value="Maltina">Maltina</option>
                    <option value="Soya Milk">Soya Milk</option>
                    <option value="Lacassera">Lacassera</option>
                    <option value="Sobo">Sobo</option>
                    <option value="Vita milk">Vita milk</option>
                </select>
            </div>
        </div>
        <div class="col-4">
            <div class="form-group">
                <label>{{ __('admin.Price') }}</label>
                <input type="text" name="item_prices[]" class="form-control" placeholder="Price">
            </div>
        </div>
        <div class="col-4 d-flex align-items-end">
            <button type="button" class="btn btn-danger plus_btn remove_drink_box">
                <i class="fa fa-trash"></i> {{ __('admin.Remove') }}
            </button>
        </div>
    </div>
</div>



<script>
(function($) {
    "use strict";
    $(document).ready(function () {

        // Product Size
        $("#addNewSize").on('click', function() {
            var html = $("#hidden_size_box").html();
            $("#size_box").append(html);
        });

        $(document).on('click', '.remove_size_box', function () {
            $(this).closest('.size_box_hidden_area').remove();
        });

        // Optional Item
        $("#addNewOptionalItem").on('click', function() {
            var html = $("#hidden_optional_box").html();
            $("#optional_box").append(html);
        });

        $(document).on('click', '.remove_optional_box', function () {
            $(this).closest('.optional_box_hidden_area').remove();
        });

        // Protein Variant
        $("#addNewProtein").on('click', function() {
            var html = $("#hidden_protein_box").html();
            $("#protein_box").append(html);
        });

        $(document).on('click', '.remove_protein_box', function () {
            $(this).closest('.protein_box_hidden_area').remove();
        });

        // Soup Variant
        $("#addNewSoup").on('click', function() {
            var html = $("#hidden_soup_box").html();
            $("#soup_box").append(html);
        });

        $(document).on('click', '.remove_soup_box', function () {
            $(this).closest('.soup_box_hidden_area').remove();
        });

        // Wrap / Swallow Foods Variant
        $("#addNewWrap").on('click', function() {
            var html = $("#hidden_wrap_box").html();
            $("#wrap_box").append(html);
        });

        $(document).on('click', '.remove_wrap_box', function () {
            $(this).closest('.wrap_box_hidden_area').remove();
        });

        // Drink Variant 🍹
        $("#addNewDrink").on('click', function() {
            var html = $("#hidden_drink_box").html();
            $("#drink_box").append(html);
        });

        $(document).on('click', '.remove_drink_box', function () {
            $(this).closest('.drink_box_hidden_area').remove();
        });

        // Spinner on Save button
        $("form").on('submit', function() {
            var btn = $(this).find('.save-btn');
            btn.prop('disabled', true);
            btn.find('.btn-text').addClass('d-none'); // Hide Save text
            btn.find('.spinner-border').removeClass('d-none'); // Show spinner
        });

    });
})(jQuery);
</script>



@endsection
