@php
  // Get pricing and shipping data
  $book = $landingPage->book;
  if (!$book) {
      abort(404, 'Book not found for this landing page');
  }
  $offerPrice = $landingPage->pricing_offer_price ?? ($book->discounted_price ?? ($book->price ?? 0));
  $shippingCharge = $landingPage->order_shipping_charge ?? 90;
  $shippingNote = $landingPage->order_shipping_note ?? 'সারা বাংলাদেশে হোম ডেলিভারি চার্জ';
  $paymentNote = $landingPage->order_payment_note ?? 'Pay with cash upon delivery.';
  $orderTitle = $landingPage->order_section_title ?? 'Order Now';
  $bookTitle = $book->title ?? 'Book';
  $bookImage = $book->cover_image
      ? asset('storage/' . $book->cover_image)
      : asset('assets/images/placeholder-book.png');
@endphp

<section id="orderFormSection" class="section" style="background-color: #f9f9f9;">
  <div class="container-narrow">
    @if ($orderTitle)
      <h2 class="bengali-text"
          style="text-align: center; font-size: 2rem; font-weight: 700; margin-bottom: 30px; color: var(--primary-color);">
        {{ $orderTitle }}
      </h2>
    @endif

    <form id="landingPageOrderForm" action="{{ route('landing-page.order.store', $landingPage->slug) }}" method="POST"
          style="display: grid; grid-template-columns: 1fr 1fr; gap: 30px; align-items: start;">
      @csrf
      <input type="hidden" name="landing_page_id" value="{{ $landingPage->id }}">
      <input type="hidden" name="book_id" value="{{ $book->id }}">

      <!-- Left Column: Billing Details -->
      <div style="background: white; padding: 20px; border-radius: 5px; box-shadow: 0 2px 5px rgba(0,0,0,0.05);">
        <h3
            style="font-size: 1.2rem; margin-bottom: 20px; border-bottom: 1px solid #eee; padding-bottom: 10px; color: #333;">
          Billing details</h3>

        <div style="margin-bottom: 15px;">
          <label style="display: block; font-weight: 600; margin-bottom: 5px; color: #333;">আপনার নাম লিখুন <span
                  style="color: red;">*</span></label>
          <input type="text" name="name" id="orderName" placeholder="আপনার নাম লিখুন *"
                 value="{{ old('name') }}"
                 style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 4px;" required>
          @error('name')
            <span style="color: red; font-size: 0.85rem;">{{ $message }}</span>
          @enderror
        </div>

        <div style="margin-bottom: 15px;">
          <label style="display: block; font-weight: 600; margin-bottom: 5px; color: #333;">ইমেইল ঠিকানা <span
                  style="color: red;">*</span></label>
          <input type="email" name="email" id="orderEmail" placeholder="your@email.com *"
                 value="{{ old('email') }}"
                 style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 4px;" required>
          @error('email')
            <span style="color: red; font-size: 0.85rem;">{{ $message }}</span>
          @enderror
        </div>

        <div style="margin-bottom: 15px;">
          <label style="display: block; font-weight: 600; margin-bottom: 5px; color: #333;">আপনার মোবাইল নাম্বার <span
                  style="color: red;">*</span></label>
          <input type="tel" name="phone" id="orderPhone" placeholder="আপনার মোবাইল নাম্বার *"
                 value="{{ old('phone') }}"
                 style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 4px;" required>
          @error('phone')
            <span style="color: red; font-size: 0.85rem;">{{ $message }}</span>
          @enderror
        </div>

        <div style="margin-bottom: 15px;">
          <label style="display: block; font-weight: 600; margin-bottom: 5px; color: #333;">আপনার সম্পূর্ণ ঠিকানা <span
                  style="color: red;">*</span></label>
          <textarea name="address" id="orderAddress" rows="3" placeholder="আপনার সম্পূর্ণ ঠিকানা *"
                    style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 4px; resize: vertical;" required>{{ old('address') }}</textarea>
          @error('address')
            <span style="color: red; font-size: 0.85rem;">{{ $message }}</span>
          @enderror
        </div>

        <div style="margin-bottom: 15px;">
          <label style="display: block; font-weight: 600; margin-bottom: 5px; color: #333;">Country / Region</label>
          <div style="font-weight: 700; padding: 10px; background: #f9f9f9; border-radius: 4px;">Bangladesh</div>
        </div>
      </div>

      <!-- Right Column: Order Review -->
      <div style="background: white; padding: 20px; border-radius: 5px; box-shadow: 0 2px 5px rgba(0,0,0,0.05);">

        <!-- Product item -->
        <h3
            style="font-size: 1.1rem; margin-bottom: 15px; border-bottom: 1px solid #eee; padding-bottom: 10px; color: #333;">
          Your Products</h3>
        <div
             style="display: flex; gap: 15px; margin-bottom: 20px; border-bottom: 1px solid #eee; padding-bottom: 20px;">
          <div style="width: 60px; height: 60px; flex-shrink: 0;">
            <img src="{{ $bookImage }}" alt="{{ $bookTitle }}"
                 style="width: 100%; height: auto; border-radius: 4px; border: 1px solid #eee; object-fit: cover;">
          </div>
          <div style="flex-grow: 1;">
            <div style="font-weight: 600; color: #333; font-size: 0.95rem;">{{ $bookTitle }}</div>
            <div style="display: flex; align-items: center; gap: 10px; margin-top: 5px;">
              <!-- Qty Selector -->
              <div style="display: inline-flex; border: 1px solid #ddd; border-radius: 4px;">
                <button type="button" id="qtyDecrease"
                        style="border: none; background: #f9f9f9; padding: 2px 8px; cursor: pointer; font-size: 1rem;">-</button>
                <input type="number" name="quantity" id="orderQuantity" value="1" min="1"
                       style="width: 40px; text-align: center; border: none; border-left: 1px solid #ddd; border-right: 1px solid #ddd; font-size: 0.9rem;"
                       readonly>
                <button type="button" id="qtyIncrease"
                        style="border: none; background: #f9f9f9; padding: 2px 8px; cursor: pointer; font-size: 1rem;">+</button>
              </div>
              <div style="font-weight: 700; color: #333;" id="productPrice">{{ number_format($offerPrice, 0) }}৳</div>
            </div>
          </div>
        </div>

        <!-- Order Summary Table -->
        <h3
            style="font-size: 1.1rem; margin-bottom: 15px; border-bottom: 1px solid #eee; padding-bottom: 10px; color: #333;">
          Your order</h3>

        <div style="display: flex; justify-content: space-between; margin-bottom: 10px; font-size: 0.95rem;">
          <span style="font-weight: 600; color: #555;">Product</span>
          <span style="font-weight: 600; color: #555;">Subtotal</span>
        </div>

        <div
             style="display: flex; justify-content: space-between; margin-bottom: 10px; font-size: 0.95rem; border-bottom: 1px solid #eee; padding-bottom: 10px;">
          <span style="color: #666;" id="productLineItem">{{ $bookTitle }} × <span id="qtyDisplay">1</span></span>
          <span style="font-weight: 600; color: #333;" id="productSubtotal">{{ number_format($offerPrice, 0) }}৳</span>
        </div>

        <div
             style="display: flex; justify-content: space-between; margin-bottom: 10px; font-size: 0.95rem; border-bottom: 1px solid #eee; padding-bottom: 10px;">
          <span style="font-weight: 600; color: #555;">Subtotal</span>
          <span style="font-weight: 600; color: #333;" id="orderSubtotal">{{ number_format($offerPrice, 0) }}৳</span>
        </div>

        <div style="margin-bottom: 10px; font-size: 0.95rem; border-bottom: 1px solid #eee; padding-bottom: 10px;">
          <div style="font-weight: 600; color: #555; margin-bottom: 5px;">Shipping</div>
          <label style="display: flex; align-items: center; gap: 8px; cursor: pointer;">
            <input type="radio" name="shipping_method" value="home_delivery" checked
                   style="accent-color: var(--accent-color);">
            <span>{{ $shippingNote }}: <b
                 id="shippingChargeDisplay">{{ number_format($shippingCharge, 0) }}৳</b></span>
          </label>
        </div>

        <div
             style="display: flex; justify-content: space-between; margin-bottom: 20px; font-size: 1.1rem; border-bottom: 1px solid #eee; padding-bottom: 10px;">
          <span style="font-weight: 700; color: #333;">Total</span>
          <span style="font-weight: 700; color: #333;"
                id="orderTotal">{{ number_format($offerPrice + $shippingCharge, 0) }}৳</span>
        </div>

        <!-- Payment Method -->
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

        <div style="font-size: 0.85rem; color: #777; margin-bottom: 20px; line-height: 1.5;">
          Your personal data will be used to process your order, support your experience throughout this website, and
          for other purposes described in our privacy policy.
        </div>

        <button type="submit" id="submitOrderBtn"
                style="width: 100%; background-color: var(--accent-color); color: white; border: none; padding: 15px; border-radius: 5px; font-size: 1.1rem; font-weight: 700; cursor: pointer; text-transform: uppercase; transition: background-color 0.3s;">
          Place Order <span id="submitTotal">{{ number_format($offerPrice + $shippingCharge, 0) }}</span>৳
        </button>

      </div>

    </form>
  </div>

  <style>
    @media (max-width: 768px) {
      #landingPageOrderForm {
        grid-template-columns: 1fr !important;
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

        qtyDisplay.textContent = quantity;
        productSubtotal.textContent = subtotal.toLocaleString('en-US') + '৳';
        orderSubtotal.textContent = subtotal.toLocaleString('en-US') + '৳';
        orderTotal.textContent = total.toLocaleString('en-US') + '৳';
        submitTotal.textContent = total.toLocaleString('en-US');
      }

      qtyDecrease.addEventListener('click', function() {
        const current = parseInt(qtyInput.value) || 1;
        if (current > 1) {
          qtyInput.value = current - 1;
          updateTotals();
        }
      });

      qtyIncrease.addEventListener('click', function() {
        const current = parseInt(qtyInput.value) || 1;
        qtyInput.value = current + 1;
        updateTotals();
      });

      // Prevent form submission during processing
      document.getElementById('landingPageOrderForm').addEventListener('submit', function(e) {
        submitBtn.disabled = true;
        submitBtn.textContent = 'Processing...';
      });
    })();
  </script>
</section>
