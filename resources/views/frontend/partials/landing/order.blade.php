@php
    // Get pricing and shipping data
    $productType = $landingPage->product_type;
    $product = $productType === 'course' ? $landingPage->course : $landingPage->book;

    if (!$product) {
        abort(404, ucfirst($productType) . ' not found for this landing page');
    }

    // Common assignments
    $offerPrice = $landingPage->pricing_offer_price ?? ($product->discounted_price ?? ($product->price ?? 0));
    $orderTitle = $landingPage->order_section_title ?? ($productType === 'course' ? 'Registration' : 'Order Now');
    $productTitle = $product->title ?? ucfirst($productType);

    // Product specific images
    if ($productType === 'course') {
        $productImage = $product->thumbnail
            ? asset('storage/' . $product->thumbnail)
            : asset('assets/images/course-placeholder.png');
    } else {
        $productImage = $product->cover_image
            ? asset('storage/' . $product->cover_image)
            : asset('assets/images/book-placeholder.png');
    }

    // Book specific assignments
    $shippingCharge = $productType === 'book' ? $landingPage->order_shipping_charge ?? 90 : 0;
    $shippingNote =
        $productType === 'book' ? $landingPage->order_shipping_note ?? 'সারা বাংলাদেশে হোম ডেলিভারি চার্জ' : '';
    $paymentNote =
        $landingPage->order_payment_note ??
        ($productType === 'book' ? 'Pay with cash upon delivery.' : 'Complete your registration.');

    // Form Action
    $formAction =
        $productType === 'course'
            ? route('landing-page.course.store', $landingPage->slug)
            : route('landing-page.order.store', $landingPage->slug);
@endphp

<section id="orderFormSection"style="background-color: #073050; padding-top: 15px">
    <div class="container-narrow">
        <div style="margin-top: 10px;">
            <form id="landingPageOrderForm" action="{{ $formAction }}" method="POST" enctype="multipart/form-data"
                style="display: flex; flex-direction: column; gap: 30px;">
                @csrf
                <input type="hidden" name="landing_page_id" value="{{ $landingPage->id }}">
                @if ($productType === 'book')
                    <input type="hidden" name="book_id" value="{{ $product->id }}">
                @endif

                <!-- Box 1: Billing & shipping address -->
                <div
                    style="background: white; padding: 30px; border-radius: 8px; border: 2px solid var(--accent-color); box-shadow: 0 2px 12px rgba(0, 0, 0, 0.06);">

                    @if ($orderTitle)
                        <div style="text-align: left; margin-bottom: 24px;">
                            <h2 class="bengali-text"
                                style="color: var(--primary-color); font-size: 1.8rem; font-weight: 700; margin: 0 0 10px; text-align: left;">
                                {{ $orderTitle }}
                            </h2>
                            {{-- <span
                                style="display: block; width: 30%; height: 2px; background: var(--accent-color); margin: 10px 0 0;"></span> --}}
                        </div>
                    @endif

                    <!-- Top Section: Billing Details -->
                    <div style="margin-bottom: 20px;">
                        <h3
                            style="font-size: 1.2rem; margin-bottom: 20px; padding-bottom: 10px; color: #333; text-align: left; position: relative;">
                            {{ $productType === 'course' ? 'Registration Details' : 'Billing details' }}
                            {{-- <span
                                style="display: block; width: 30%; height: 2px; background: var(--accent-color); margin: 10px 0 0;"></span> --}}
                        </h3>

                        <div style="margin-bottom: 15px;">
                            <label style="display: block; font-weight: 600; margin-bottom: 5px; color: #333;">আপনার নাম
                                লিখুন <span style="color: red;">*</span></label>
                            <input type="text" name="name" id="orderName" placeholder="আপনার নাম লিখুন *"
                                value="{{ old('name') }}" autocomplete="name"
                                style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 4px;"
                                required>
                            @error('name')
                                <span style="color: red; font-size: 0.85rem;">{{ $message }}</span>
                            @enderror
                        </div>

                        <div style="margin-bottom: 15px;">
                            <label style="display: block; font-weight: 600; margin-bottom: 5px; color: #333;">ইমেইল
                                ঠিকানা
                                <span style="color: red;">*</span></label>
                            <input type="email" name="email" id="orderEmail" placeholder="your@email.com *"
                                value="{{ old('email') }}" autocomplete="email"
                                style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 4px;"
                                required>
                            @error('email')
                                <span style="color: red; font-size: 0.85rem;">{{ $message }}</span>
                            @enderror
                        </div>

                        <div style="margin-bottom: 15px;">
                            <label style="display: block; font-weight: 600; margin-bottom: 5px; color: #333;">আপনার
                                মোবাইল
                                নাম্বার <span style="color: red;">*</span></label>
                            <input type="tel" name="phone" id="orderPhone" placeholder="আপনার মোবাইল নাম্বার *"
                                value="{{ old('phone') }}" autocomplete="tel"
                                style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 4px;"
                                required>
                            @error('phone')
                                <span style="color: red; font-size: 0.85rem;">{{ $message }}</span>
                            @enderror
                        </div>

                        <div style="margin-bottom: 15px;">
                            <label style="display: block; font-weight: 600; margin-bottom: 5px; color: #333;">আপনার
                                সম্পূর্ণ
                                ঠিকানা <span style="color: red;">*</span></label>
                            <textarea name="address" id="orderAddress" rows="3" placeholder="আপনার সম্পূর্ণ ঠিকানা *"
                                autocomplete="street-address"
                                style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 4px; resize: vertical;" required>{{ old('address') }}</textarea>
                            @error('address')
                                <span style="color: red; font-size: 0.85rem;">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <div>
                        <label style="display: block; font-weight: 600; margin-bottom: 5px; color: #333;">Country /
                            Region</label>
                        <div style="font-weight: 700; padding: 10px; background: #f9f9f9; border-radius: 4px;">
                            Bangladesh</div>
                    </div>

                </div>

                <!-- Box 2: Product, order summary & payment -->
                <div
                    style="background: white; padding: 30px; border-radius: 8px; border: 2px solid var(--accent-color); box-shadow: 0 2px 12px rgba(0, 0, 0, 0.06);">

                    <!-- Bottom Section: Your Products -->
                    <div>
                        <h3
                            style="font-size: 1.2rem; margin-bottom: 20px; padding-bottom: 10px; color: #333; text-align: left; position: relative;">
                            Your {{ $productType === 'course' ? 'Course' : 'Products' }}
                            {{-- <span
                                style="display: block; width: 30%; height: 2px; background: var(--accent-color); margin: 10px 0 0;"></span> --}}
                        </h3>
                        <div
                            style="display: flex; gap: 15px; margin-bottom: 20px; border-bottom: 1px solid #eee; padding-bottom: 20px;">
                            <div style="width: 60px; height: 60px; flex-shrink: 0;">
                                <img src="{{ $productImage }}" alt="{{ $productTitle }}"
                                    style="width: 100%; height: auto; border-radius: 4px; border: 1px solid #eee; object-fit: cover;">
                            </div>
                            <div style="flex-grow: 1;">
                                <div style="font-weight: 600; color: #333; font-size: 0.95rem; margin-bottom: 8px;">
                                    {{ $productTitle }}
                                </div>
                                <div
                                    style="display: flex; align-items: center; gap: 15px; margin-top: 8px; flex-wrap: wrap;">
                                    <!-- Qty Selector (Only for Books) -->
                                    @if ($productType === 'book')
                                        <div style="display: flex; align-items: center; gap: 8px;">
                                            <label
                                                style="font-size: 0.85rem; color: #666; font-weight: 500;">Quantity:</label>
                                            <div
                                                style="display: inline-flex; border: 1.5px solid #ddd; border-radius: 6px; overflow: hidden; background: white; box-shadow: 0 1px 3px rgba(0,0,0,0.05);">
                                                <button type="button" id="qtyDecrease"
                                                    style="border: none; background: #f8f9fa; padding: 6px 12px; cursor: pointer; font-size: 1.1rem; font-weight: 600; color: #555; transition: all 0.2s; user-select: none; min-width: 36px; display: flex; align-items: center; justify-content: center;"
                                                    onmouseover="this.style.background='#e9ecef'; this.style.color='#333';"
                                                    onmouseout="this.style.background='#f8f9fa'; this.style.color='#555';"
                                                    onclick="this.style.background='#dee2e6'; setTimeout(() => { this.style.background='#f8f9fa'; }, 150);">
                                                    −
                                                </button>
                                                <input type="number" name="quantity" id="orderQuantity" value="1"
                                                    min="1"
                                                    style="width: 50px; text-align: center; border: none; border-left: 1.5px solid #ddd; border-right: 1.5px solid #ddd; font-size: 0.95rem; font-weight: 600; color: #333; padding: 6px 4px; background: white; outline: none;"
                                                    readonly>
                                                <button type="button" id="qtyIncrease"
                                                    style="border: none; background: #f8f9fa; padding: 6px 12px; cursor: pointer; font-size: 1.1rem; font-weight: 600; color: #555; transition: all 0.2s; user-select: none; min-width: 36px; display: flex; align-items: center; justify-content: center;"
                                                    onmouseover="this.style.background='#e9ecef'; this.style.color='#333';"
                                                    onmouseout="this.style.background='#f8f9fa'; this.style.color='#555';"
                                                    onclick="this.style.background='#dee2e6'; setTimeout(() => { this.style.background='#f8f9fa'; }, 150);">
                                                    +
                                                </button>
                                            </div>
                                        </div>
                                    @else
                                        <!-- Hidden quantity for course logic -->
                                        <input type="hidden" name="quantity" id="orderQuantity" value="1">
                                    @endif

                                    <div style="font-weight: 700; color: #333; font-size: 1rem;" id="productPrice">
                                        Tk. {{ number_format($offerPrice, 0) }}</div>
                                </div>
                            </div>
                        </div>

                        <!-- Order Summary Table -->
                        <h3
                            style="font-size: 1.1rem; margin-bottom: 15px; padding-bottom: 10px; color: #333; border-top: 1px solid #eee; padding-top: 20px; margin-top: 20px;">
                            Your order</h3>

                        <div
                            style="display: flex; justify-content: space-between; margin-bottom: 10px; font-size: 0.9rem;">
                            <span style="font-weight: 600; color: #555;">Product</span>
                            <span style="font-weight: 600; color: #555;">Subtotal</span>
                        </div>

                        <div
                            style="display: flex; justify-content: space-between; margin-bottom: 10px; font-size: 0.9rem; border-bottom: 1px solid #eee; padding-bottom: 10px;">
                            <span style="color: #666;" id="productLineItem">{{ $productTitle }} × <span
                                    id="qtyDisplay">1</span></span>
                            <span style="font-weight: 600; font-size: 0.9rem; color: #333;" id="productSubtotal">Tk.
                                {{ number_format($offerPrice, 0) }}</span>
                        </div>

                        <div
                            style="display: flex; justify-content: space-between; margin-bottom: 10px; font-size: 0.9rem; border-bottom: 1px solid #eee; padding-bottom: 10px;">
                            <span style="font-weight: 600; font-size: 0.9rem; color: #555;">Subtotal</span>
                            <span style="font-weight: 600; font-size: 0.9rem; color: #333;" id="orderSubtotal">Tk.
                                {{ number_format($offerPrice, 0) }}</span>
                        </div>

                        @if ($productType === 'book')
                            <div
                                style="margin-bottom: 10px; font-size: 0.9rem; border-bottom: 1px solid #eee; padding-bottom: 10px;">
                                <div style="font-weight: 600; color: #555; margin-bottom: 5px;">Shipping</div>
                                <label style="display: flex; align-items: center; gap: 8px; cursor: pointer;">
                                    <input type="radio" name="shipping_method" value="home_delivery" checked
                                        style="accent-color: var(--accent-color);">
                                    <span>{{ $shippingNote }}: <b id="shippingChargeDisplay">Tk.
                                            {{ number_format($shippingCharge, 0) }}</b></span>
                                </label>
                            </div>
                        @endif

                        <div
                            style="display: flex; justify-content: space-between; margin-bottom: 20px; font-size: 1.1rem; border-bottom: 1px solid #eee; padding-bottom: 10px;">
                            <span style="font-weight: 700;  color: #333;">Total</span>
                            <span style="font-weight: 700;  color: #333;" id="orderTotal">Tk.
                                {{ number_format($offerPrice + $shippingCharge, 0) }}</span>
                        </div>

                        <!-- Payment Method -->
                        @if ($productType === 'book')
                            <div
                                style="margin-bottom: 20px; background: #fdfdfd; padding: 15px; border: 1px solid #eee; border-radius: 4px;">
                                <label
                                    style="display: flex; align-items: center; gap: 8px; font-weight: 600; color: #333; margin-bottom: 5px;">
                                    <input type="radio" name="payment_method" value="cod" checked
                                        style="accent-color: var(--accent-color);">
                                    Cash on delivery
                                </label>
                                <div
                                    style="margin-left: 24px; font-size: 0.9rem; color: #666; background: #eee; padding: 8px; border-radius: 3px;">
                                    {{ $paymentNote }}
                                </div>
                            </div>
                        @else
                            <!-- Course Payment Gateway Selection -->
                            <div style="margin-bottom: 20px;">
                                <label
                                    style="display: block; font-weight: 600; margin-bottom: 10px; color: #333;">Payment
                                    Method</label>

                                @if (isset($paymentGateways) && count($paymentGateways) > 0)
                                    <div style="display: flex; flex-direction: column; gap: 10px;">
                                        @foreach ($paymentGateways as $gateway)
                                            <div style="border: 1px solid #ddd; border-radius: 5px; padding: 10px;">
                                                <label
                                                    style="display: flex; align-items: center; gap: 10px; cursor: pointer;">
                                                    <input type="radio" name="payment_gateway_id"
                                                        value="{{ $gateway->id }}" required
                                                        style="accent-color: var(--accent-color);">
                                                    <span style="font-weight: 600;">{{ $gateway->name }}</span>
                                                    <span
                                                        style="font-size: 0.85rem; color: #666;">({{ $gateway->type }})</span>
                                                </label>
                                                <div class="payment-details" id="gateway-details-{{ $gateway->id }}"
                                                    style="display: none; margin-top: 10px; padding-left: 25px; font-size: 0.9rem; color: #555;">
                                                    <p style="margin: 0;"><strong>Account Number:</strong>
                                                        {{ $gateway->account_number }}</p>
                                                    @if ($gateway->instructions)
                                                        <p style="margin: 5px 0 0;">{{ $gateway->instructions }}</p>
                                                    @endif
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                @else
                                    <p style="color: red;">No payment methods available.</p>
                                @endif
                            </div>

                            <!-- Transaction ID Input -->
                            <div style="margin-bottom: 15px;">
                                <label
                                    style="display: block; font-weight: 600; margin-bottom: 5px; color: #333;">Transaction
                                    ID <span style="color: red;">*</span></label>
                                <input type="text" name="transaction_id" placeholder="Enter Transaction ID"
                                    value="{{ old('transaction_id') }}"
                                    style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 4px;"
                                    required>
                                @error('transaction_id')
                                    <span style="color: red; font-size: 0.85rem;">{{ $message }}</span>
                                @enderror
                            </div>

                            <!-- Payment Screenshot -->
                            <div style="margin-bottom: 15px;">
                                <label
                                    style="display: block; font-weight: 600; margin-bottom: 5px; color: #333;">Payment
                                    Screenshot
                                    (Optional)</label>
                                <input type="file" name="payment_screenshot" accept="image/*"
                                    style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 4px;">
                                @error('payment_screenshot')
                                    <span style="color: red; font-size: 0.85rem;">{{ $message }}</span>
                                @enderror
                            </div>

                            <script>
                                // Show/Hide gateway details
                                document.querySelectorAll('input[name="payment_gateway_id"]').forEach(radio => {
                                    radio.addEventListener('change', function() {
                                        // Hide all details
                                        document.querySelectorAll('.payment-details').forEach(el => el.style.display = 'none');
                                        // Show selected details
                                        const detailsId = 'gateway-details-' + this.value;
                                        const detailsEl = document.getElementById(detailsId);
                                        if (detailsEl) detailsEl.style.display = 'block';
                                    });
                                });
                            </script>
                        @endif

                        <div style="font-size: 0.85rem; color: #777; margin-bottom: 20px; line-height: 1.5;">
                            Your personal data will be used to process your order, support your experience throughout
                            this
                            website, and
                            for other purposes described in our privacy policy.
                        </div>

                        <button type="submit" id="submitOrderBtn"
                            style="width: 100%; background-color: #1A237E; color: white; border: none; padding: 15px; border-radius: 5px; font-size: 1.1rem; font-weight: 700; cursor: pointer; text-transform: uppercase; transition: background-color 0.3s; margin-top:20px">
                            {{ $productType === 'course' ? 'Enroll Now' : 'Place Order' }} <span id="submitTotal">Tk.
                                {{ number_format($offerPrice + $shippingCharge, 0) }}</span>
                        </button>

                    </div>

                </div>

            </form>
        </div>
    </div>

    <style>
        @media (max-width: 768px) {
            #orderFormSection .container-narrow>form>div[style*="background: white"] {
                padding: 20px !important;
            }
        }
    </style>

    <script>
        (function() {
            const offerPrice = {{ $offerPrice }};
            const shippingCharge = {{ $shippingCharge }};
            const qtyInput = document.getElementById('orderQuantity');
            const qtyDecrease = document.getElementById('qtyDecrease');
            const qtyIncrease = document.getElementById('qtyIncrease');
            const qtyDisplay = document.getElementById('qtyDisplay');
            const productSubtotal = document.getElementById('productSubtotal');
            const orderSubtotal = document.getElementById('orderSubtotal');
            const orderTotal = document.getElementById('orderTotal');
            const submitTotal = document.getElementById('submitTotal');
            const submitBtn = document.getElementById('submitOrderBtn');

            function updateTotals() {
                const quantity = parseInt(qtyInput.value) || 1;
                const subtotal = offerPrice * quantity;
                const total = subtotal + shippingCharge;

                if (qtyDisplay) qtyDisplay.textContent = quantity;
                productSubtotal.textContent = 'Tk. ' + subtotal.toLocaleString('en-US');
                orderSubtotal.textContent = 'Tk. ' + subtotal.toLocaleString('en-US');
                orderTotal.textContent = 'Tk. ' + total.toLocaleString('en-US');
                submitTotal.textContent = 'Tk. ' + total.toLocaleString('en-US');
            }

            if (qtyDecrease) {
                qtyDecrease.addEventListener('click', function() {
                    const current = parseInt(qtyInput.value) || 1;
                    if (current > 1) {
                        qtyInput.value = current - 1;
                        updateTotals();
                    }
                });
            }

            if (qtyIncrease) {
                qtyIncrease.addEventListener('click', function() {
                    const current = parseInt(qtyInput.value) || 1;
                    qtyInput.value = current + 1;
                    updateTotals();
                });
            }

            // Prevent form submission during processing
            document.getElementById('landingPageOrderForm').addEventListener('submit', function(e) {
                submitBtn.disabled = true;
                submitBtn.textContent = 'Processing...';
            });
        })();
    </script>
</section>
