@extends('admin.master_layout')
@section('title')
<title>{{__('admin.Invoice')}}</title>
@endsection
<style>
    @media print {
        .section-header,
        .order-status,
        #sidebar-wrapper,
        .print-area,
        .main-footer,
        .additional_info {
            display:none!important;
        }
    }
</style>
@section('admin-content')
      <!-- Main Content -->
      <div class="main-content">
        <section class="section">
        <div class="section-header d-flex justify-content-between align-items-center w-100">
            <div class="d-flex align-items-center">
              <h1 class="mr-3">{{ __('admin.Invoice') }}</h1>
              <a href="{{ url('/admin/all-order') }}" class="btn btn-sm btn-dark">
                <i class="fas fa-arrow-left"></i> Back to Orders
              </a>
            </div>
            <div class="section-header-breadcrumb">
              <div class="breadcrumb-item active">
                <a href="{{ route('admin.dashboard') }}">{{ __('admin.Dashboard') }}</a>
              </div>
              <div class="breadcrumb-item">{{ __('admin.Invoice') }}</div>
            </div>
          </div>

          <div class="section-body">
            <div class="invoice">
              <div class="invoice-print">
                <div class="row">
                  <div class="col-lg-12">
                  <div class="invoice-title">
                        <h2><img src="{{ asset($setting->logo) }}" alt="" width="120px"></h2>
                        <div class="invoice-number">Order #{{ $order->order_id }}</div>
                    </div>

                    @if ($order->guest)
                        <div class="alert alert-info mt-2">
                            <strong>Note:</strong> This order was placed by a guest.
                        </div>
                    @endif

                    <hr>
                    @php
                        $orderAddress = $order->orderAddress;
                    @endphp
                    <div class="row">
                      <div class="col-md-6">
                      <address>
    <strong>{{ __('admin.Customer Information') }}:</strong><br>
    {{ $order->user->name ?? $order->guest->name ?? 'No Name Provided' }}<br>
    
    @php
        $email = $order->user->email ?? $order->guest->email ?? null;
        $phone = $order->user->phone ?? $order->guest->phone ?? null;
    @endphp

    @if ($email)
        {{ $email }}<br>
    @endif
    @if ($phone)
        {{ $phone }}<br>
    @endif

    @if ($order->order_type === 'delivery' && $orderAddress)
        {{ $orderAddress->address ?? 'No Address Provided' }}<br>
    @else
        <em>{{ __('admin.Pickup Order – No delivery address') }}</em><br>
    @endif
</address>

                    </div>

                      <div class="col-md-6 text-md-right">
                        <address>
                            <strong>{{__('admin.Payment Information')}}:</strong><br>
                            {{__('admin.Method')}}: {{ $order->payment_method }}<br>
                            {{__('admin.Status')}} : @if ($order->payment_status == 1)
                                <span class="badge badge-success">{{__('admin.Success')}}</span>
                                @else
                                <span class="badge badge-danger">{{__('admin.Pending')}}</span>
                            @endif <br>
                            {{__('admin.Transaction')}}: {!! clean(nl2br($order->transection_id)) !!}
                          </address>
                      </div>
                    </div>
                    <div class="row">
                    <div class="col-md-6">
                        <address>
                            <strong>{{ __('admin.Order Information') }}:</strong><br>
                            {{ __('admin.Date') }}: {{ $order->created_at->format('d F, Y') }}<br>

                            <strong>Order Type:</strong> {{ ucfirst($order->order_type) }}<br>
                            <strong>Pre-Order:</strong> {{ $order->is_preorder ? 'Yes' : 'No' }}<br>

                            <strong>Scheduled {{ $order->order_type === 'delivery' ? 'Delivery' : 'Pickup' }} Time:</strong><br>
                            {{ \Carbon\Carbon::parse($order->schedule_time)->format('l, j F Y g:i A') }}<br>

                            @if ($order->order_type === 'pickup')
                                {{ __('admin.Shipping') }}: Pickup<br>
                            @elseif ($order->order_type === 'delivery' && $orderAddress)
                                {{ __('admin.Shipping') }}: {{ $orderAddress->address ?? 'No Address Provided' }}<br>
                            @else
                                {{ __('admin.Shipping') }}: No shipping address available<br>
                            @endif

                            {{ __('admin.Status') }}:
                            @if ($order->order_status == 1)
                                <span class="badge badge-warning">{{ __('admin.Pregress') }}</span>
                            @elseif ($order->order_status == 2)
                                <span class="badge badge-info">{{ __('admin.Delivered') }}</span>
                            @elseif ($order->order_status == 3)
                                <span class="badge badge-success">{{ __('admin.Completed') }}</span>
                            @elseif ($order->order_status == 4)
                                <span class="badge badge-secondary">{{ __('admin.Declined') }}</span>
                            @else
                                <span class="badge badge-danger">{{ __('admin.Pending') }}</span>
                            @endif
                        </address>

                    </div>


                    </div>
                  </div>
                </div>

                <div class="row mt-4">
                  <div class="col-md-12">
                    <div class="section-title">{{__('admin.Order Summary')}}</div>
                    <div class="table-responsive">
                      <table class="table table-striped table-hover table-md">
                        <tr>
                          <th width="5%">#</th>
                          <th width="25%">{{__('admin.Product')}}</th>
                          <th width="20%">{{__('admin.Optional')}}</th>

                          <th width="10%" class="text-center">{{__('admin.Unit Price')}}</th>
                          <th width="10%" class="text-center">{{__('admin.Quantity')}}</th>
                          <th width="10%" class="text-right">{{__('admin.Total')}}</th>
                        </tr>

                        @foreach ($order->orderProducts as $index => $orderProduct)

                            <tr>
                                <td>{{ ++$index }}</td>
                                <td>
                                    <a href="{{ route('admin.product.edit', $orderProduct->product_id) }}">{{ $orderProduct->product_name }}</a>
                                </td>

                                {{-- Size & Optional + Dynamic Addons (Protein, Soup, Wrap, Drink) --}}
                                <td>
                                    @if ($orderProduct->product_size)
                                        <div><strong>Size:</strong> {{ $orderProduct->product_size }}</div>
                                    @endif

                                    @php
                                        $optional_items = json_decode($orderProduct->optional_item);
                                    @endphp

                                    @if (!empty($optional_items))
                                        <div><strong>Optional:</strong></div>
                                        <ul style="margin-left: 15px;">
                                            @foreach ($optional_items as $optional_item)
                                                <li>{{ $optional_item->item }} (+{{ $currency_icon }}{{ $optional_item->price }})</li>
                                            @endforeach
                                        </ul>
                                    @endif

                                    @php
                                        $addonFields = [
                                            'protein_item' => 'Protein',
                                            'soup_item' => 'Soup',
                                            'wrap_item' => 'Wrap',
                                            'drink_item' => 'Drink',
                                        ];
                                    @endphp

                                    @foreach ($addonFields as $field => $label)
                                        @if (!empty($orderProduct->$field))
                                            @php $addons = json_decode($orderProduct->$field, true); @endphp
                                            @if (is_array($addons) && count($addons) > 0)
                                                <div><strong>{{ $label }}:</strong></div>
                                                <ul style="margin-left: 15px;">
                                                    @foreach ($addons as $addon)
                                                        <li>{{ $addon['item'] ?? 'Unnamed' }} (+{{ $currency_icon }}{{ $addon['price'] ?? '0.00' }})</li>
                                                    @endforeach
                                                </ul>
                                            @endif
                                        @endif
                                    @endforeach
                                </td>

                                <td class="text-center">{{ $setting->currency_icon }}{{ $orderProduct->unit_price }}</td>
                                <td class="text-center">{{ $orderProduct->qty }}</td>

                                @php
                                    $total = ($orderProduct->unit_price * $orderProduct->qty) + $orderProduct->optional_price;
                                @endphp
                                <td class="text-right">{{ $setting->currency_icon }}{{ $total }}</td>
                            </tr>

                            {{-- Food Instruction --}}
                            <tr>
                                <td></td>
                                <td colspan="5">
                                    <strong>Food Instruction:</strong><br>
                                    {{ $orderProduct->food_instruction ? e($orderProduct->food_instruction) : 'No food instruction provided.' }}
                                </td>
                            </tr>

                            @endforeach


                      </table>
                    </div>

                    <div class="row mt-3">
                      <div class="col-lg-6 order-status">
                        <div class="section-title">{{__('admin.Order Status')}}</div>

                        <form action="{{ route('admin.update-order-status',$order->id) }}" method="POST">
                          @csrf
                          @method("PUT")
                          <div class="form-group">
                              <label for="">{{__('admin.Payment')}}</label>
                            <select name="payment_status" id="" class="form-control">
                                <option {{ $order->payment_status == 0 ? 'selected' : '' }} value="0">{{__('admin.Pending')}}</option>
                                <option {{ $order->payment_status == 1 ? 'selected' : '' }} value="1">{{__('admin.Success')}}</option>
                            </select>
                          </div>

                          <div class="form-group">
                            <label for="">{{__('admin.Order')}}</label>
                            <select name="order_status" id="" class="form-control">
                              <option {{ $order->order_status == 0 ? 'selected' : '' }} value="0">{{__('admin.Pending')}}</option>
                              <option {{ $order->order_status == 1 ? 'selected' : '' }} value="1">{{__('admin.In Progress')}}</option>
                              <option {{ $order->order_status == 2 ? 'selected' : '' }}  value="2">{{__('admin.Delivered')}}</option>
                              <option {{ $order->order_status == 3 ? 'selected' : '' }} value="3">{{__('admin.Completed')}}</option>
                              <option {{ $order->order_status == 4 ? 'selected' : '' }} value="4">{{__('admin.Declined')}}</option>
                            </select>
                          </div>

                          <button class="btn btn-primary" type="submit">{{__('admin.Update Status')}}</button>
                        </form>
                      </div>

                      <div class="col-lg-6 text-right">

                        <div class="invoice-detail-item">
                          <div class="invoice-detail-name">{{__('admin.Subtotal')}} : {{ $setting->currency_icon }}{{ round($order->sub_total, 2) }}</div>
                        </div>
                        <div class="invoice-detail-item">
                          <div class="invoice-detail-name">{{__('admin.Discount')}}(-) : {{ $setting->currency_icon }}{{ round($order->coupon_price, 2) }}</div>
                        </div>
                        <div class="invoice-detail-item">
                          <div class="invoice-detail-name">{{__('admin.Delivery Charge')}} : {{ $setting->currency_icon }}{{ round($order->delivery_charge, 2) }}</div>
                        </div>
                        <div class="invoice-detail-item">
                          <div class="invoice-detail-name">{{__('admin.Tax (6%)')}} : {{ $setting->currency_icon }}{{ round($order->tax, 2) }}</div>
                        </div>
                        @if ($order->tip && $order->tip > 0)
                            <div class="invoice-detail-item">
                              <div class="invoice-detail-name">Tip : {{ $setting->currency_icon }}{{ number_format($order->tip, 2) }}</div>
                            </div>
                            @endif

                        <hr class="mt-2 mb-2">
                        <div class="invoice-detail-item">
                          <div class="invoice-detail-value invoice-detail-value-lg">{{__('admin.Grand Total')}} : {{ $setting->currency_icon }}{{ round($order->grand_total, 2) }}</div>
                        </div>
                      </div>

                    </div>
                  </div>
                </div>
              </div>

              <div class="text-md-right print-area">
                <hr>
                <button class="btn btn-success btn-icon icon-left print_btn"><i class="fas fa-print"></i> {{__('admin.Print')}}</button>
                <button class="btn btn-danger btn-icon icon-left" data-toggle="modal" data-target="#deleteModal" onclick="deleteData({{ $order->id }})"><i class="fas fa-times"></i> {{__('admin.Delete')}}</button>
              </div>
            </div>
          </div>

        </section>
      </div>
      <script>
        function deleteData(id){
            $("#deleteForm").attr("action",'{{ url("admin/delete-order/") }}'+"/"+id)
        }

        (function($) {
            "use strict";
            $(document).ready(function() {

                $(".print_btn").on("click", function(){
                    $(".custom_click").click();
                    window.print()
                })

            });
        })(jQuery);

    </script>




@endsection
