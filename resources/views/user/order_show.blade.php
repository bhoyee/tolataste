<div class="wsus__track_order">
    <ul>
        {{-- Pending --}}
        <li class="{{ $order->order_status == 0 ? 'active' : '' }}">
            {{ __('user.order pending') }}
        </li>

        {{-- Accept --}}
        <li class="{{ $order->order_status == 1 ? 'active' : '' }}">
            {{ __('user.order accept') }}
        </li>

        {{-- Process --}}
        <li class="{{ $order->order_status == 2 ? 'active' : '' }}">
            {{ __('user.order process') }}
        </li>

        {{-- On the Way (only for Delivery orders) --}}
        @if($order->order_type == 'delivery')
            <li class="{{ $order->order_status == 3 ? 'active' : '' }}">
                {{ __('user.on the way') }}
            </li>
        @endif

        {{-- Completed --}}
        <li class="{{ ($order->order_status == 3 && $order->order_type == 'pickup') || $order->order_status == 4 ? 'active' : '' }}">
            {{ __('user.Completed') }}
        </li>

        {{-- Declined --}}
        @if($order->order_status == 5)
            <li class="active">
                {{ __('user.order declined') }}
            </li>
        @endif
    </ul>
</div>



@php
    $orderAddress = $order->orderAddress;
@endphp

@if($order->order_type == 'delivery' && $orderAddress)
    <p class="delivary_time">
        {{ __('user.estimated delivery time') }} : {{ $orderAddress->delivery_time ?? '45 - 60' }} {{ __('user.Minutes') }}
    </p>
@else
    <p class="delivary_time">
        {{ __('user.estimated delivery time') }} : Pickup Order
    </p>
@endif

<div class="wsus__invoice_header">
    <div class="header_address">
        <h4>{{ __('user.invoice to') }}</h4>

        @if($order->order_type == 'pickup')
            {{-- 🚗 Pickup Order: Show only user name and phone --}}
            @if($order->user)
                <p><b>Name:</b> {{ $order->user->name }}</p>
                <p><b>Phone:</b> {{ $order->user->phone ?? 'N/A' }}</p>
                <p><b>Phone:</b> {{ $order->user->email ?? 'N/A' }}</p>
            @endif
        @else
            {{-- 🚚 Delivery Order: Show full delivery address --}}
            @if($orderAddress)
                <p>{{ $orderAddress->address }}</p>
                <p>{{ $orderAddress->name }}
                    @if ($orderAddress->phone)
                        , {{ $orderAddress->phone }}
                    @endif
                </p>
                @if ($orderAddress->email)
                    <p>{{ $orderAddress->email }}</p>
                @endif
            @else
                <p>No address information available.</p>
            @endif
        @endif

    </div>

    <div class="header_address">
        <p><b>{{ __('user.Order ID') }}:</b> <span>#{{ $order->order_id }}</span></p>
        <p><b>{{ __('user.date') }}:</b> <span>{{ $order->created_at->format('d M, Y') }}</span></p>
        <p><b>{{ __('user.Payment') }}:</b> <span>{{ $order->payment_status == 1 ? 'Success' : 'Pending' }}</span></p>
    </div>
</div>


<div class="wsus__invoice_body">
    <div class="table-responsive">
        <table class="table table-striped">
            <tbody>
                <tr class="border_none">
                    <th class="sl_no">{{__('user.SL')}}</th>
                    <th class="package">{{__('user.item description')}}</th>
                    <th class="price">{{__('user.Unit Price')}}</th>
                    <th class="qnty">{{__('user.Quantity')}}</th>
                    <th class="total">{{__('user.Total')}}</th>
                </tr>
                @php
                    $products = $order->orderProducts;
                @endphp
                @foreach ($products as $index => $product)
                    <tr>
                        <td class="sl_no">{{ ++$index }}</td>
                        <td class="package">
                            <p>{{ $product->product_name }}</p>
                            <span class="size">{{ $product->product_size }}</span>
                            @php
                                $optional_items = json_decode($product->optional_item);
                            @endphp
                            @foreach ($optional_items as $optional_item)
                                <span class="coca_cola">{{ $optional_item->item }}(+{{ $currency_icon }}{{ $optional_item->price }})</span>
                            @endforeach

                            {{-- 🔥 Show Selected Proteins --}}
                            @php
                                $protein_items = json_decode($product->protein_item);
                            @endphp
                            @if (!empty($protein_items))
                                @foreach ($protein_items as $protein)
                                    <span class="coca_cola">{{ $protein->item }} (+{{ $currency_icon }}{{ $protein->price }})</span><br>
                                @endforeach
                            @endif
                        </td>
                        <td class="price">
                            <b>{{ $currency_icon }}{{ $product->unit_price }}</b>
                        </td>
                        <td class="qnty">
                            <b>{{ $product->qty }}</b>
                        </td>
                        <td class="total">
                            <b>{{ $currency_icon }}{{ ($product->qty * $product->unit_price) + $product->optional_price }}</b>
                        </td>
                    </tr>
                @endforeach

            </tbody>
            <tfoot>
                <tr>
                    <td class="package" colspan="3">
                        <b>{{__('user.sub total')}}</b>
                    </td>
                    <td class="qnty">
                        <b>{{ $order->product_qty }}</b>
                    </td>
                    <td class="total">
                        <b>{{ $currency_icon }}{{ $order->sub_total }}</b>
                    </td>
                </tr>
                <tr>
                    <td class="package coupon" colspan="3">
                        <b>(-) {{__('user.Discount coupon')}}</b>
                    </td>
                    <td class="qnty">
                        <b></b>
                    </td>
                    <td class="total coupon">
                        <b>{{ $currency_icon }}{{ $order->coupon_price }}</b>
                    </td>
                </tr>
                <tr>
                    <td class="package coast" colspan="3">
                        <b>(+) {{__('user.Delivery Charge')}}</b>
                    </td>
                    <td class="qnty">
                        <b></b>
                    </td>
                    <td class="total coast">
                        <b>{{ $currency_icon }}{{ $order->delivery_charge }}</b>
                    </td>
                </tr>
                <tr>
                    <td class="package" colspan="3">
                        <b>(+) {{ __('user.Tax (6%)') }}</b>
                    </td>
                    <td class="qnty">
                        <b></b>
                    </td>
                    <td class="total">
                    <b>{{ $currency_icon }}{{ number_format($order->tax, 2) }}</b>

                    </td>
                </tr>
                                @if ($order->tip && $order->tip > 0)
<tr>
    <td class="package" colspan="3">
        <b>(+) {{ __('user.Tip') }}</b>
    </td>
    <td class="qnty">
        <b></b>
    </td>
    <td class="total">
        <b>{{ $currency_icon }}{{ number_format($order->tip, 2) }}</b>
    </td>
</tr>
@endif


                <tr>
                    <td class="package" colspan="3">
                        <b>{{__('user.Grand Total')}}</b>
                    </td>
                    <td class="qnty">
                        <b></b>
                    </td>
                    <td class="total">
                        <b>{{ $currency_icon }}{{ $order->grand_total }}</b>
                    </td>
                </tr>
            </tfoot>
        </table>
    </div>
</div>
