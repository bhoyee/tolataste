@extends('layout')
@section('title')
    <title>{{__('user.Dashboard')}}</title>
@endsection
@section('meta')
    <meta name="description" content="Dashboard">
@endsection

@section('public-content')
<!-- DataTables CSS -->
<link href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css" rel="stylesheet">




    <!--=============================
        BREADCRUMB START
    ==============================-->
    <section class="wsus__breadcrumb" style="background: url({{ asset($breadcrumb) }});">
        <div class="wsus__breadcrumb_overlay">
            <div class="container">
                <div class="wsus__breadcrumb_text">
                    <h1>{{__('user.Dashboard')}}</h1>
                    <ul>
                        <li><a href="{{ route('home') }}">{{__('user.Home')}}</a></li>
                        <li><a href="{{ route('dashboard') }}">{{__('user.Dashboard')}}</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </section>
    <!--=============================
        BREADCRUMB END
    ==============================-->


        <!--=========================
        DASHBOARD START
    ==========================-->
    <section class="wsus__dashboard mt_120 xs_mt_90 mb_100 xs_mb_70">
        <div class="container">
            <div class="wsus__dashboard_area">
                <div class="row">
                    <div class="col-xl-3 col-lg-4 wow fadeInUp" data-wow-duration="1s">
                        <div class="wsus__dashboard_menu">
                            <div class="dasboard_header">
                                <div class="dasboard_header_img">

                                    @if ($personal_info->image)

                                    <img id="preview-user-avatar" src="{{ asset($personal_info->image) }}" alt="user" class="img-fluid w-100">
                                    @else
                                    <img id="preview-user-avatar" src="{{ asset($default_user_avatar) }}" alt="user" class="img-fluid w-100">
                                    @endif

                                    <label for="upload"><i class="far fa-camera"></i></label>
                                    <form id="upload_user_avatar_form" enctype="multipart/form-data" method="POST">
                                        @csrf
                                        <input type="file" name="image" id="upload" hidden onchange="previewThumnailImage(event)">
                                    </form>
                                </div>
                                <h2>{{ html_decode($personal_info->name) }}</h2>
                            </div>
                            <div class="nav flex-column nav-pills" id="v-pills-tab" role="tablist"
                                aria-orientation="vertical">
                                <button class="nav-link active" id="v-pills-home-tab" data-bs-toggle="pill"
                                    data-bs-target="#v-pills-home" type="button" role="tab" aria-controls="v-pills-home"
                                    aria-selected="true"><span><i class="fas fa-user"></i></span> {{__('user.Personal Info')}}</button>

                                <!--<button class="nav-link" id="v-pills-address-tab" data-bs-toggle="pill"-->
                                <!--    data-bs-target="#v-pills-address" type="button" role="tab"-->
                                <!--    aria-controls="v-pills-address" aria-selected="true"><span><i-->
                                <!--            class="fas fa-user"></i></span>{{__('user.Address')}}</button>-->

                                <button class="nav-link" id="v-pills-profile-tab" data-bs-toggle="pill"
                                    data-bs-target="#v-pills-profile" type="button" role="tab"
                                    aria-controls="v-pills-profile" aria-selected="false"><span><i
                                            class="fas fa-bags-shopping"></i></span> {{__('user.Order')}}</button>

                                <button class="nav-link" id="v-pills-messages-tab2" data-bs-toggle="pill"
                                    data-bs-target="#v-pills-messages2" type="button" role="tab"
                                    aria-controls="v-pills-messages2" aria-selected="false"><span><i
                                            class="far fa-heart"></i></span> {{__('user.wishlist')}}</button>

                                <button class="nav-link" id="v-pills-messages-tab" data-bs-toggle="pill"
                                    data-bs-target="#v-pills-messages" type="button" role="tab"
                                    aria-controls="v-pills-messages" aria-selected="false"><span><i
                                            class="fas fa-star"></i></span> {{__('user.Reviews')}}</button>

                                <button class="nav-link" id="v-pills-settings-tab" data-bs-toggle="pill"
                                    data-bs-target="#v-pills-settings" type="button" role="tab"
                                    aria-controls="v-pills-settings" aria-selected="false"><span><i
                                            class="fas fa-user-lock"></i></span> {{__('user.Change Password')}} </button>

                                <button class="nav-link" id="v-pills-reservation-tab" data-bs-toggle="pill"
                                    data-bs-target="#v-pills-reservation" type="button" role="tab"
                                    aria-controls="v-pills-reservation" aria-selected="false"><span><i
                                            class="fas fa-user-lock"></i></span> {{__('user.Reservations')}} </button>

                                <a onclick="return confirm('Are you sure ?')" href="{{ route('delete-account') }}" class="nav-link"><span> <i class="fas fa-trash"></i>
                                    </span> {{__('user.Delete Account')}}</a>

                                    <button id="logout_btn" class="nav-link" type="button"><span> <i class="fas fa-sign-out-alt"></i>
                                    </span> {{__('user.Logout')}}</button>


                            </div>
                        </div>
                    </div>
                    <div class="col-xl-9 col-lg-8 wow fadeInUp" data-wow-duration="1s">
                        <div class="wsus__dashboard_content">
                            <div class="tab-content" id="v-pills-tabContent">

                                <div class="tab-pane fade show active" id="v-pills-home" role="tabpanel"
                                    aria-labelledby="v-pills-home-tab">
                                    <div class="wsus_dashboard_body">
                                        <h3>{{__('user.Welcome to your Profile')}}</h3>

                                        <div class="wsus__dsahboard_overview">
                                            <div class="row">
                                                <div class="col-xl-4 col-sm-6 col-md-4">
                                                    <div class="wsus__dsahboard_overview_item">
                                                        <span class="icon"><i class="far fa-shopping-basket"></i></span>
                                                        <h4>{{__('user.Total order')}} <span>({{ $total_order }})</span></h4>
                                                    </div>
                                                </div>
                                                <div class="col-xl-4 col-sm-6 col-md-4">
                                                    <div class="wsus__dsahboard_overview_item green">
                                                        <span class="icon"><i class="far fa-shopping-basket"></i></span>
                                                        <h4>{{__('user.Completed')}} <span>({{ $complete_order }})</span></h4>
                                                    </div>
                                                </div>
                                                <div class="col-xl-4 col-sm-6 col-md-4">
                                                    <div class="wsus__dsahboard_overview_item red">
                                                        <span class="icon"><i class="far fa-shopping-basket"></i></span>
                                                        <h4>{{__('user.Cancel')}} <span>({{ $declined_order }})</span></h4>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="wsus_dash_personal_info">
                                            <h4>{{__('user.Personal Information')}}
                                                <a class="dash_info_btn">
                                                    <span class="edit">{{__('user.edit')}}</span>
                                                    <span class="cancel">{{__('user.cancel')}}</span>
                                                </a>
                                            </h4>

                                            <div class="personal_info_text">
                                                <p><span>{{__('user.Name')}}:</span> {{ html_decode($personal_info->name) }}</p>
                                                <p><span>{{__('user.Email')}}:</span> {{ html_decode($personal_info->email) }}</p>
                                                <p><span>{{__('user.Phone')}}:</span> {{ html_decode($personal_info->phone) }}</p>
                                                <p><span>{{__('user.Address')}}:</span>{{ html_decode($personal_info->address) }} </p>
                                            </div>

                                            <div class="wsus_dash_personal_info_edit comment_input p-0">
                                                <form id="personal_info_form">
                                                    @csrf
                                                    <div class="row">
                                                        <div class="col-12">
                                                            <div class="wsus__comment_imput_single">
                                                                <label>{{__('user.Name')}}</label>
                                                                <input type="text" name="name" value="{{ html_decode($personal_info->name) }}" >
                                                            </div>
                                                        </div>
                                                        <div class="col-xl-6 col-lg-6">
                                                            <div class="wsus__comment_imput_single">
                                                                <label>{{__('user.Email')}}</label>
                                                                <input type="email" name="email" value="{{ html_decode($personal_info->email) }}" readonly>
                                                            </div>
                                                        </div>
                                                        <div class="col-xl-6 col-lg-6">
                                                            <div class="wsus__comment_imput_single">
                                                                <label>{{__('user.Phone')}}</label>
                                                                <input type="text" placeholder="{{__('user.Phone')}}" name="phone" value="{{ html_decode($personal_info->phone) }}">
                                                            </div>
                                                        </div>
                                                        <div class="col-xl-12">
                                                            <div class="wsus__comment_imput_single">
                                                                <label>{{__('user.Address')}}</label>

                                                                <input type="text" placeholder="{{__('user.Address')}}" name="address" value="{{ html_decode($personal_info->address) }}">

                                                            </div>
                                                            <button type="submit" class="common_btn">{{__('user.submit')}}</button>
                                                        </div>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="tab-pane fade" id="v-pills-address" role="tabpanel"
                                    aria-labelledby="v-pills-address-tab">
                                    <div class="wsus_dashboard_body address_body">
                                        <h3>{{__('user.address')}} <a class="dash_add_new_address"><i class="far fa-plus"></i> {{__('user.add new')}}
                                            </a>
                                        </h3>
                                        <div class="wsus_dashboard_address">
                                            <div class="wsus_dashboard_existing_address">
                                                <div class="row" id="address_all_list">

                                                    @foreach ($addresses as $address)
                                                        <div class="col-md-6">
                                                            <div class="wsus__checkout_single_address ">
                                                                <div class="form-check address-list-{{ $address->id }}">
                                                                    <label class="form-check-label">
                                                                        @if ($address->type == 'home')
                                                                        <span class="icon"><i class="fas fa-home"></i>{{__('user.Home')}}</span>
                                                                        @else
                                                                        <span class="icon"><i class="far fa-car-building"></i>{{__('user.Office')}}</span>
                                                                        @endif
                                                                        <span class="address">{{__('user.Name')}} : {{ $address->first_name.' '. $address->last_name }}</span>

                                                                        <span class="address">{{__('user.Phone')}} : {{ $address->phone }}</span>

                                                                        <span class="address">{{__('user.Delivery area')}} : {{ $address->deliveryArea->area_name }}</span>

                                                                        <span class="address">{{__('user.Address')}} : {{ $address->address }}</span>
                                                                    </label>
                                                                </div>
                                                                <ul>
                                                                    <li><a  data-existing-address="{{ $address }}" class="dash_edit_btn edit_data_attribute-{{ $address->id }}"><i
                                                                                class="far fa-edit"></i></a></li>
                                                                    <li><a onclick="delete_address({{ $address->id }})" class="dash_del_icon"><i
                                                                                class="fas fa-trash-alt"></i></a>
                                                                    </li>

                                                                    <form id="delete_address_{{ $address->id }}" action="{{ route('address.destroy', $address->id) }}" method="POST">
                                                                    @csrf
                                                                    @method('DELETE')
                                                                    </form>
                                                                </ul>
                                                            </div>
                                                        </div>
                                                    @endforeach
                                                </div>
                                            </div>
                                            <div class="wsus_dashboard_new_address ">
                                                <form id="add_new_address_form" method="POST">
                                                    @csrf
                                                    <div class="row">
                                                        <div class="col-12">
                                                            <h4>{{__('user.add new address')}}</h4>
                                                        </div>

                                                        <div class="col-12">
                                                            <div class="wsus__check_single_form">
                                                                <select name="delivery_area_id" class="select2">
                                                                    <option value="">{{__('user.Select Delivery Area')}}</option>
                                                                    @foreach ($delivery_areas as $delivery_area)
                                                                        <option value="{{ $delivery_area->id }}">{{ $delivery_area->area_name }}</option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                        </div>

                                                        <div class="col-md-6 col-lg-12 col-xl-6">
                                                            <div class="wsus__check_single_form">
                                                                <input type="text" placeholder="{{__('user.First Name')}}*" name="first_name">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6 col-lg-12 col-xl-6">
                                                            <div class="wsus__check_single_form">
                                                                <input type="text" placeholder="{{__('user.Last Name')}} *" name="last_name">
                                                            </div>
                                                        </div>

                                                        <div class="col-md-6 col-lg-12 col-xl-6">
                                                            <div class="wsus__check_single_form">
                                                                <input type="text" placeholder="{{__('user.Phone')}}" name="phone">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6 col-lg-12 col-xl-6">
                                                            <div class="wsus__check_single_form">
                                                                <input type="email" placeholder="{{__('user.Email')}}" name="email">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-12 col-lg-12 col-xl-12">
                                                            <div class="wsus__check_single_form">
                                                                <textarea name="address" cols="3" rows="4"
                                                                    placeholder="{{__('user.Address')}} *"></textarea>
                                                            </div>
                                                        </div>
                                                        <div class="col-12">
                                                            <div class="wsus__check_single_form check_area">
                                                                <div class="form-check">
                                                                    <input value="home" class="form-check-input" type="radio"
                                                                        name="address_type" id="flexRadioDefault1">
                                                                    <label class="form-check-label"
                                                                        for="flexRadioDefault1">
                                                                        {{__('user.home')}}
                                                                    </label>
                                                                </div>
                                                                <div class="form-check">
                                                                    <input value="office" class="form-check-input" type="radio"
                                                                        name="address_type" id="flexRadioDefault2">
                                                                    <label class="form-check-label"
                                                                        for="flexRadioDefault2">
                                                                        {{__('user.office')}}
                                                                    </label>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-12">
                                                            <button type="button"
                                                                class="common_btn cancel_new_address">{{__('user.cancel')}}</button>
                                                            <button type="submit" class="common_btn">{{__('user.Save Address')}}</button>
                                                        </div>
                                                    </div>
                                                </form>
                                            </div>
                                            <div class="wsus_dashboard_edit_address ">
                                                <form id="edit_address_form" method="POST">
                                                    @method('PUT')
                                                    @csrf
                                                    <div class="row">
                                                        <div class="col-12">
                                                            <h4>{{__('user.Edit address')}}</h4>
                                                        </div>

                                                        <div class="col-12">
                                                            <div class="wsus__check_single_form">
                                                                <select name="delivery_area_id" class="select2 edit_delivery_area_id">

                                                                    @foreach ($delivery_areas as $delivery_area)
                                                                        <option value="{{ $delivery_area->id }}">{{ $delivery_area->area_name }}</option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                        </div>

                                                        <input type="hidden" name="edit_id" class="edit_id">
                                                        <div class="col-md-6 col-lg-12 col-xl-6">
                                                            <div class="wsus__check_single_form">
                                                                <input class="edit_first_name" type="text" placeholder="{{__('user.First Name')}}*" name="first_name">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6 col-lg-12 col-xl-6">
                                                            <div class="wsus__check_single_form">
                                                                <input class="edit_last_name" type="text" placeholder="{{__('user.Last Name')}} *" name="last_name">
                                                            </div>
                                                        </div>

                                                        <div class="col-md-6 col-lg-12 col-xl-6">
                                                            <div class="wsus__check_single_form">
                                                                <input class="edit_phone" type="text" placeholder="{{__('user.Phone')}}" name="phone">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6 col-lg-12 col-xl-6">
                                                            <div class="wsus__check_single_form">
                                                                <input class="edit_email" type="email" placeholder="{{__('user.Email')}}" name="email">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-12 col-lg-12 col-xl-12">
                                                            <div class="wsus__check_single_form">
                                                                <textarea class="edit_address" name="address" cols="3" rows="4"
                                                                    placeholder="{{__('user.Address')}} *"></textarea>
                                                            </div>
                                                        </div>
                                                        <div class="col-12">
                                                            <div class="wsus__check_single_form check_area">
                                                                <div class="form-check">
                                                                    <input value="home" class="form-check-input edit_address_type home_type" type="radio"
                                                                        name="address_type" id="flexRadioDefault3">
                                                                    <label class="form-check-label"
                                                                        for="flexRadioDefault3">
                                                                        {{__('user.home')}}
                                                                    </label>
                                                                </div>
                                                                <div class="form-check">
                                                                    <input value="office" class="form-check-input edit_address_type office_type" type="radio"
                                                                        name="address_type" id="flexRadioDefault4">
                                                                    <label class="form-check-label"
                                                                        for="flexRadioDefault4">
                                                                        {{__('user.office')}}
                                                                    </label>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-12">
                                                            <button type="button"
                                                                class="common_btn cancel_edit_address">{{__('user.cancel')}}</button>
                                                            <button type="submit" class="common_btn">{{__('user.Save Address')}}</button>
                                                        </div>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="tab-pane fade" id="v-pills-profile" role="tabpanel"
                                    aria-labelledby="v-pills-profile-tab">
                                    <div class="wsus_dashboard_body">
                                        <h3>{{__('user.order list')}}</h3>
                                        <div class="wsus_dashboard_order">
                                        <div class="table-responsive">
    <table class="table" id="orderTable">
        <thead>
            <tr class="t_header">
                <th>{{ __('user.Order') }}</th>
                <th>{{ __('user.Date') }}</th>
                <th>{{ __('user.Status') }}</th>
                <th>{{ __('user.Amount') }}</th>
                <th>{{ __('user.Action') }}</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($orders as $index => $order)
                <tr>
                    <td>#{{ $order->order_id }}</td>
                    <td data-order="{{ $order->created_at->timestamp }}">{{ $order->created_at->format('d M Y') }}</td>
                    <td>
                        @if ($order->order_status == 1)
                            <span class="complete">{{ __('user.Processing') }}</span>
                        @elseif ($order->order_status == 2)
                            <span class="complete">{{ __('user.On the way') }}</span>
                        @elseif ($order->order_status == 3)
                            <span class="complete">{{ __('user.Completed') }}</span>
                        @elseif ($order->order_status == 4)
                            <span class="cancel">{{ __('user.Declined') }}</span>
                        @else
                            <span class="cancel">{{ __('user.Pending') }}</span>
                        @endif
                    </td>
                    <td>{{ $currency_icon }}{{ number_format($order->grand_total, 2) }}</td>
                    <td>
                        <a class="view_invoice" data-order-id="{{ $order->id }}">{{ __('user.View Details') }}</a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>

                                        </div>
                                        <div class="wsus__invoice">
                                            <a class="go_back"><i class="fas fa-long-arrow-alt-left"></i> {{__('user.go back')}}</a>
                                            <div id="load_order_details">

                                            </div>

                                        </div>
                                    </div>
                                </div>

                                <div class="tab-pane fade " id="v-pills-messages2" role="tabpanel"
                                    aria-labelledby="v-pills-messages-tab2">
                                    <div class="wsus_dashboard_body">
                                        <h3>{{__('user.wishlist')}}</h3>
                                        <div class="wsus__dashoard_wishlist">
                                            <div class="row">
                                                @foreach ($products as $product)
                                                <div class="col-xl-4 col-sm-6 col-lg-6">
                                                    <div class="wsus__menu_item">
                                                        <div class="wsus__menu_item_img">
                                                            <img src="{{ asset($product->thumb_image) }}" alt="menu" class="img-fluid w-100">
                                                            <a class="category" href="{{ route('products', ['category'=> $product->category->slug]) }}">{{ $product->category->name }}</a>
                                                        </div>
                                                        <div class="wsus__menu_item_text">
                                                            <p class="rating">

                                                                @php
                                                                    if ($product->total_review > 0) {
                                                                        $average = $product->average_rating;

                                                                        $int_average = intval($average);

                                                                        $next_value = $int_average + 1;
                                                                        $review_point = $int_average;
                                                                        $half_review=false;
                                                                        if($int_average < $average && $average < $next_value){
                                                                            $review_point= $int_average + 0.5;
                                                                            $half_review=true;
                                                                        }
                                                                    }
                                                                @endphp

                                                                @if ($product->total_review > 0)
                                                                    @for ($i = 1; $i <=5; $i++)
                                                                        @if ($i <= $review_point)
                                                                            <i class="fas fa-star"></i>
                                                                        @elseif ($i> $review_point )
                                                                            @if ($half_review==true)
                                                                                <i class="fas fa-star-half-alt"></i>
                                                                                @php
                                                                                    $half_review=false
                                                                                @endphp
                                                                            @else
                                                                            <i class="far fa-star"></i>
                                                                            @endif
                                                                        @endif
                                                                    @endfor
                                                                @else
                                                                    <i class="far fa-star"></i>
                                                                    <i class="far fa-star"></i>
                                                                    <i class="far fa-star"></i>
                                                                    <i class="far fa-star"></i>
                                                                    <i class="far fa-star"></i>
                                                                @endif

                                                                <span>{{ $product->total_review }}</span>
                                                            </p>
                                                            <a class="title" href="{{ route('show-product', $product->slug) }}">{{ $product->name }}</a>
                                                            @if ($product->is_offer)
                                                                <h5 class="price">{{ $currency_icon }}{{ $product->offer_price }} <del>{{ $currency_icon }}{{ $product->price  }}</del> </h5>
                                                            @else
                                                                <h5 class="price">{{ $currency_icon }}{{ $product->price }}</h5>
                                                            @endif

                                                            <ul class="d-flex flex-wrap justify-content-center">
                                                                <li><a href="javascript:;" onclick="load_product_model({{ $product->id }})"><i
                                                                            class="fas fa-shopping-basket"></i></a></li>

                                                                    <form id="remove_wishlist_{{ $product->id }}" action="{{ route('remove-to-wishlist', $product->id) }}" method="POST">
                                                                        @csrf
                                                                        @method('DELETE')
                                                                    </form>

                                                                    <li><a href="javascript:;" onclick="remove_wishlist({{ $product->id }})"><i class="fal fa-heart"></i></a></li>

                                                                <li><a href="{{ route('show-product', $product->slug) }}"><i class="far fa-eye"></i></a></li>
                                                            </ul>
                                                        </div>
                                                    </div>
                                                </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="tab-pane fade" id="v-pills-messages" role="tabpanel"
                                    aria-labelledby="v-pills-messages-tab">
                                    <div class="wsus_dashboard_body dashboard_review">
                                        <h3>{{__('user.reviews')}}</h3>
                                        <div class="wsus__review_area">
                                            <div class="wsus__comment pt-0 mt_20">
                                                @foreach ($reviews as $review)
                                                <div class="wsus__single_comment m-0 border-0">
                                                    <img src="{{ asset($review->product->thumb_image) }}" alt="review" class="img-fluid">
                                                    <div class="wsus__single_comm_text">
                                                        <h3><a href="{{ route('show-product', $review->product->slug) }}">{{ $review->product->name }}</a> <span>{{ $review->created_at->format('d M Y') }} </span>
                                                        </h3>
                                                        <span class="rating">
                                                            @for ($i = 1; $i <=5; $i++)
                                                                @if ($i <= $review->rating)
                                                                    <i class="fas fa-star"></i>
                                                                @else
                                                                    <i class="fal fa-star"></i>
                                                                @endif
                                                            @endfor
                                                        </span>
                                                        <p>{{ $review->review }}</p>
                                                        @if ($review->status == 1)
                                                        <span class="status active">{{__('user.active')}}</span>
                                                        @else
                                                        <span class="status inactive">{{__('user.inactive')}}</span>
                                                        @endif

                                                    </div>
                                                </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="tab-pane fade" id="v-pills-settings" role="tabpanel"
                                    aria-labelledby="v-pills-settings-tab">
                                    <div class="wsus_dashboard_body wsus__change_password">
                                        <div class="wsus__review_input">
                                            <h3>{{__('user.change password')}}</h3>
                                            <div class="comment_input pt-0">
                                                <form id="change_password_form">
                                                    @csrf
                                                    <div class="row">
                                                        <div class="col-xl-6">
                                                            <div class="wsus__comment_imput_single">
                                                                <label>{{__('user.Current Password')}}</label>
                                                                <input type="password" placeholder="{{__('user.Current Password')}}" name="current_password">
                                                            </div>
                                                        </div>
                                                        <div class="col-xl-6">
                                                            <div class="wsus__comment_imput_single">
                                                                <label>{{__('user.New Password')}}</label>
                                                                <input type="password" placeholder="{{__('user.New Password')}}" name="password">
                                                            </div>
                                                        </div>
                                                        <div class="col-xl-12">
                                                            <div class="wsus__comment_imput_single">
                                                                <label>{{__('user.Confirm Password')}}</label>
                                                                <input type="password" name="password_confirmation" placeholder="{{__('user.Confirm Password')}}">
                                                            </div>
                                                            <button type="submit"
                                                                class="common_btn mt_20">{{__('user.submit')}}</button>
                                                        </div>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="tab-pane fade" id="v-pills-reservation" role="tabpanel"
                                    aria-labelledby="v-pills-reservation-tab">
                                    <div class="wsus_dashboard_body">
                                        <h3>{{__('user.Reservations')}}</h3>
                                        <div class="wsus_dashboard_order reservation_list">
                                            <div class="table-responsive">
                                                <table class="table">
                                                    <tbody>
                                                        <tr class="t_header">
                                                            <th class="sn">{{__('user.SN')}}</th>
                                                            <th class="time">{{__('user.Date & Time')}}</th>
                                                            <th class="person">{{__('user.Person')}}</th>
                                                            <th class="status">{{__('user.Status')}}</th>
                                                        </tr>
                                                        @foreach ($reservations as $index => $reservation)
                                                            <tr>
                                                                <td class="sn">
                                                                    <h5>#{{ ++$index }}</h5>
                                                                </td>
                                                                <td class="time">
                                                                    <p>{{ date('d M, Y', strtotime($reservation->reserve_date)) }}</p>
                                                                    <br>
                                                                    <p>{{ $reservation->reserve_time }}</p>

                                                                </td>
                                                                <td class="person">
                                                                    {{ $reservation->person_qty }}
                                                                </td>
                                                                <td class="status">
                                                                    @if ($reservation->reserve_status == 1)
                                                                    <span class="complete">{{__('user.Approved')}} </span>
                                                                    @elseif ($reservation->reserve_status == 3)
                                                                    <span class="complete">{{__('user.Completed')}} </span>
                                                                    @elseif ($reservation->reserve_status == 4)
                                                                    <span class="cancel">{{__('user.Declined')}} </span>
                                                                    @else
                                                                    <span class="cancel">{{__('user.Pending')}}</span>
                                                                    @endif
                                                                </td>

                                                            </tr>
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>

                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
<!-- DataTables JS -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.5.0/js/dataTables.responsive.min.js"></script>

<script>
$(document).ready(function() {
    $('#orderTable').DataTable({
        "pageLength": 10,
        "lengthChange": false,
        "ordering": true,
        "searching": true,
        "info": true,
        "autoWidth": false,
        "responsive": true,
        "order": [[1, 'desc']] // 🛠️ order by Date column (index 1), Descending (newest first)
    });
});
</script>



    <script>
        (function($) {
            "use strict";
            $(document).ready(function () {

                $("#personal_info_form").on("submit", function(e){
                    e.preventDefault();

                    var isDemo = "{{ env('APP_MODE') }}"
                    if(isDemo == 0){
                        toastr.error('This Is Demo Version. You Can Not Change Anything');
                        return;
                    }

                    $.ajax({
                        type: 'POST',
                        data: $('#personal_info_form').serialize(),
                        url: "{{ route('update-profile') }}",
                        success: function (response) {
                            toastr.success(response.message)
                            let personal_info = `
                                <p><span>{{__('user.Name')}}:</span> ${ response.user.name }</p>
                                <p><span>{{__('user.Email')}}:</span> ${ response.user.email }</p>
                                <p><span>{{__('user.Phone')}}:</span> ${ response.user.phone }</p>
                                <p><span>{{__('user.Address')}}:</span>${ response.user.address } </p>`;
                            $(".personal_info_text").html(personal_info);

                        },
                        error: function(response) {
                            if(response.status == 422){
                                if(response.responseJSON.errors.name)toastr.error(response.responseJSON.errors.name[0])
                                if(response.responseJSON.errors.phone)toastr.error(response.responseJSON.errors.phone[0])
                                if(response.responseJSON.errors.address)toastr.error(response.responseJSON.errors.address[0])
                            }

                            if(response.status == 500){
                                toastr.error("{{__('user.Server error occured')}}")
                            }


                        }
                    });

                })

                $("#change_password_form").on("submit", function(e){
                    e.preventDefault();

                    var isDemo = "{{ env('APP_MODE') }}"
                    if(isDemo == 0){
                        toastr.error('This Is Demo Version. You Can Not Change Anything');
                        return;
                    }

                    $.ajax({
                        type: 'POST',
                        data: $('#change_password_form').serialize(),
                        url: "{{ route('update-password') }}",
                        success: function (response) {
                            toastr.success(response.message)
                            $("#change_password_form").trigger("reset");
                        },
                        error: function(response) {
                            if(response.status == 422){
                                if(response.responseJSON.errors.current_password)toastr.error(response.responseJSON.errors.current_password[0])
                                if(response.responseJSON.errors.password)toastr.error(response.responseJSON.errors.password[0])
                            }

                            if(response.status == 500){
                                toastr.error("{{__('user.Server error occured')}}")
                            }

                            if(response.status == 403){
                                toastr.error(response.responseJSON.message);
                            }

                        }
                    });
                })

                $("#logout_btn").on("click", function(){
                    window.location.href = "{{ route('user-logout') }}";
                })

                $("#delete_account_btn").on("click", function(){
                    window.location.href = "{{ route('delete-account') }}";
                })




                $("#upload_user_avatar_form").on("submit", function(e){
                    e.preventDefault();

                    var isDemo = "{{ env('APP_MODE') }}"
                    if(isDemo == 0){
                        toastr.error('This Is Demo Version. You Can Not Change Anything');
                        return;
                    }

                    $.ajax({
                        type: 'POST',
                        data:new FormData(this),
                        dataType:'JSON',
                        contentType: false,
                        cache: false,
                        processData: false,
                        url: "{{ route('upload-user-avatar') }}",
                        success: function (response) {
                            toastr.success(response.message)
                        },
                        error: function(response) {

                        }
                    });
                })

                $("#add_new_address_form").on("submit", function(e){
                    e.preventDefault();

                    var isDemo = "{{ env('APP_MODE') }}"
                    if(isDemo == 0){
                        toastr.error('This Is Demo Version. You Can Not Change Anything');
                        return;
                    }

                    $.ajax({
                        type: 'POST',
                        data: $('#add_new_address_form').serialize(),
                        url: "{{ route('address.store') }}",
                        success: function (response) {
                            toastr.success(response.message)
                            $("#add_new_address_form").trigger("reset");
                            location.reload();
                        },
                        error: function(response) {
                            if(response.status == 422){
                                if(response.responseJSON.errors.first_name)toastr.error(response.responseJSON.errors.first_name[0])
                                if(response.responseJSON.errors.last_name)toastr.error(response.responseJSON.errors.last_name[0])
                                if(response.responseJSON.errors.address)toastr.error(response.responseJSON.errors.address[0])
                                if(response.responseJSON.errors.address_type)toastr.error(response.responseJSON.errors.address_type[0])
                                if(response.responseJSON.errors.delivery_area_id)toastr.error(response.responseJSON.errors.delivery_area_id[0])

                            }

                            if(response.status == 500){
                                toastr.error("{{__('user.Server error occured')}}")
                            }

                            if(response.status == 403){
                                toastr.error(response.responseJSON.message);
                            }

                        }
                    });
                })

                $(".dash_edit_btn").on("click", function(){
                    let existing_address = $(this).data('existing-address');

                    $(".edit_id").val(existing_address.id)
                    $(".edit_first_name").val(existing_address.first_name)
                    $(".edit_last_name").val(existing_address.last_name)
                    $(".edit_phone").val(existing_address.phone)
                    $(".edit_email").val(existing_address.email)
                    $(".edit_address").val(existing_address.address)
                    $(".edit_delivery_area_id").val(existing_address.delivery_area_id).trigger('change')

                    if(existing_address.type == 'home'){
                        $('.home_type').attr('checked', 'checked');
                    }else{
                        $('.office_type').attr('checked', 'checked');
                    }
                })

                $("#edit_address_form").on("submit", function(e){
                    e.preventDefault();

                    var isDemo = "{{ env('APP_MODE') }}"
                    if(isDemo == 0){
                        toastr.error('This Is Demo Version. You Can Not Change Anything');
                        return;
                    }

                    let edit_id = $(".edit_id").val();
                    let url = "{{ route('address.update', [':id']) }}";
                    url = url.replace(':id', edit_id);

                    $.ajax({
                        type: 'PUT',
                        data: $('#edit_address_form').serialize(),
                        url:url,
                        success: function (response) {
                            toastr.success(response.message)
                            let address = response.address

                            let type = '';
                            if(response.address.type == 'home'){
                                type = '<span class="icon"><i class="fas fa-home"></i>{{__('user.Home')}}</span>';
                            }else{
                                type = '<span class="icon"><i class="far fa-car-building"></i>{{__('user.Office')}}</span>';
                            }
                            let html_response = `
                            <label class="form-check-label">
                                    ${type}
                                    <span class="address">{{__('user.Name')}} : ${ address.first_name} ${ address.last_name}</span>
                                    <span class="address">{{__('user.Phone')}} : ${ address.phone}</span>
                                    <span class="address">{{__('user.Address')}} : ${ address.address}</span>
                                </label>
                            `
                            $('.address-list-' + edit_id).html(html_response);
                            $('.edit_data_attribute-' + edit_id).attr("data-existing-address", address);
                            window.location.reload();
                        },
                        error: function(response) {
                            if(response.status == 422){
                                if(response.responseJSON.errors.first_name)toastr.error(response.responseJSON.errors.first_name[0])
                                if(response.responseJSON.errors.last_name)toastr.error(response.responseJSON.errors.last_name[0])
                                if(response.responseJSON.errors.address)toastr.error(response.responseJSON.errors.address[0])
                                if(response.responseJSON.errors.address_type)toastr.error(response.responseJSON.errors.address_type[0])
                                if(response.responseJSON.errors.delivery_area_id)toastr.error(response.responseJSON.errors.delivery_area_id[0])
                            }

                            if(response.status == 500){
                                toastr.error("{{__('user.Server error occured')}}")
                            }

                            if(response.status == 403){
                                toastr.error(response.responseJSON.message);
                            }

                        }
                    });
                })

                $(".view_invoice").on("click", function(){
                    let order_id = $(this).data('order-id');
                    $("#load_order_details").html('')
                    $.ajax({
                        type: 'get',
                        url: "{{ url('/single-order') }}" + "/" + order_id,
                        success: function (response) {
                            $("#load_order_details").html(response)
                        },
                        error: function(response) {
                            toastr.error("{{__('user.Server error occured')}}")
                        }
                    });
                })


            });
        })(jQuery);


        function previewThumnailImage(event) {
            var reader = new FileReader();
            reader.onload = function(){
                var output = document.getElementById('preview-user-avatar');
                output.src = reader.result;
            }

            reader.readAsDataURL(event.target.files[0]);
            $("#upload_user_avatar_form").submit();
        };


        function delete_address(id){
            Swal.fire({
                title: "{{__('user.Are you realy want to delete this item ?')}}",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: "{{__('user.Yes, Delete It')}}",
                cancelButtonText: "{{__('user.Cancel')}}",
            }).then((result) => {
                if (result.isConfirmed) {

                    var isDemo = "{{ env('APP_MODE') }}"
                    if(isDemo == 0){
                        toastr.error('This Is Demo Version. You Can Not Change Anything');
                        return;
                    }

                    $("#delete_address_"+id).submit();
                }

            })
        }

        function remove_wishlist(id){

            Swal.fire({
                title: "{{__('user.Are you realy want to remove wishlist item ?')}}",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: "{{__('user.Yes, Remove It')}}",
                cancelButtonText: "{{__('user.Cancel')}}",
            }).then((result) => {
                if (result.isConfirmed) {

                    var isDemo = "{{ env('APP_MODE') }}"
                    if(isDemo == 0){
                        toastr.error('This Is Demo Version. You Can Not Change Anything');
                        return;
                    }

                    $("#remove_wishlist_"+id).submit();
                }

            })
        }



    </script>
@endsection
