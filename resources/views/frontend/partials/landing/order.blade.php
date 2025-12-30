<section id="orderFormSection" class="section" style="background-color: #f9f9f9;">
  <div class="container-narrow">

    <form id="orderForm" style="display: grid; grid-template-columns: 1fr 1fr; gap: 30px; align-items: start;">
       @csrf

       <!-- Left Column: Billing Details -->
       <div style="background: white; padding: 20px; border-radius: 5px; box-shadow: 0 2px 5px rgba(0,0,0,0.05);">
          <h3 style="font-size: 1.2rem; margin-bottom: 20px; border-bottom: 1px solid #eee; padding-bottom: 10px; color: #333;">Billing details</h3>
          
          <div style="margin-bottom: 15px;">
             <label style="display: block; font-weight: 600; margin-bottom: 5px; color: #333;">আপনার নাম লিখুন <span style="color: red;">*</span></label>
             <input type="text" name="name" placeholder="আপনার নাম লিখুন *" style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 4px;" required>
          </div>

          <div style="margin-bottom: 15px;">
             <label style="display: block; font-weight: 600; margin-bottom: 5px; color: #333;">আপনার মোবাইল নাম্বার <span style="color: red;">*</span></label>
             <input type="tel" name="phone" placeholder="আপনার মোবাইল নাম্বার *" style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 4px;" required>
          </div>

          <div style="margin-bottom: 15px;">
             <label style="display: block; font-weight: 600; margin-bottom: 5px; color: #333;">আপনার সম্পূর্ণ ঠিকানা <span style="color: red;">*</span></label>
             <input type="text" name="address" placeholder="আপনার সম্পূর্ণ ঠিকানা *" style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 4px;" required>
          </div>

          <div style="margin-bottom: 15px;">
             <label style="display: block; font-weight: 600; margin-bottom: 5px; color: #333;">Country / Region <span style="color: #777; font-weight: 400;">(optional)</span></label>
             <div style="font-weight: 700;">Bangladesh</div>
          </div>
       </div>

       <!-- Right Column: Order Review -->
       <div style="background: white; padding: 20px; border-radius: 5px; box-shadow: 0 2px 5px rgba(0,0,0,0.05);">
          
          <!-- Product item -->
          <h3 style="font-size: 1.1rem; margin-bottom: 15px; border-bottom: 1px solid #eee; padding-bottom: 10px; color: #333;">Your Products</h3>
          <div style="display: flex; gap: 15px; margin-bottom: 20px; border-bottom: 1px solid #eee; padding-bottom: 20px;">
             <div style="width: 60px; height: 60px; flex-shrink: 0;">
                <img src="https://book.darponbd.com/wp-content/uploads/2025/11/2-removebg-preview-300x300.png" alt="Book Cover" style="width: 100%; height: auto; border-radius: 4px; border: 1px solid #eee;">
             </div>
             <div style="flex-grow: 1;">
                <div style="font-weight: 600; color: #333; font-size: 0.95rem;">Spoken English In Real Life</div>
                <div style="display: flex; align-items: center; gap: 10px; margin-top: 5px;">
                   <!-- Qty Selector -->
                   <div style="display: inline-flex; border: 1px solid #ddd; border-radius: 4px;">
                      <button type="button" style="border: none; background: #f9f9f9; padding: 2px 8px; cursor: pointer;">-</button>
                      <input type="text" value="1" style="width: 30px; text-align: center; border: none; border-left: 1px solid #ddd; border-right: 1px solid #ddd; font-size: 0.9rem;" readonly>
                      <button type="button" style="border: none; background: #f9f9f9; padding: 2px 8px; cursor: pointer;">+</button>
                   </div>
                   <div style="font-weight: 700; color: #333;">750৳</div>
                </div>
             </div>
          </div>

          <!-- Order Summary Table -->
          <h3 style="font-size: 1.1rem; margin-bottom: 15px; border-bottom: 1px solid #eee; padding-bottom: 10px; color: #333;">Your order</h3>
          
          <div style="display: flex; justify-content: space-between; margin-bottom: 10px; font-size: 0.95rem;">
             <span style="font-weight: 600; color: #555;">Product</span>
             <span style="font-weight: 600; color: #555;">Subtotal</span>
          </div>
          
           <div style="display: flex; justify-content: space-between; margin-bottom: 10px; font-size: 0.95rem; border-bottom: 1px solid #eee; padding-bottom: 10px;">
             <span style="color: #666;">Spoken English In Real Life × 1</span>
             <span style="font-weight: 600; color: #333;">750৳</span>
          </div>

           <div style="display: flex; justify-content: space-between; margin-bottom: 10px; font-size: 0.95rem; border-bottom: 1px solid #eee; padding-bottom: 10px;">
             <span style="font-weight: 600; color: #555;">Subtotal</span>
             <span style="font-weight: 600; color: #333;">750৳</span>
          </div>

          <div style="margin-bottom: 10px; font-size: 0.95rem; border-bottom: 1px solid #eee; padding-bottom: 10px;">
             <div style="font-weight: 600; color: #555; margin-bottom: 5px;">Shipping</div>
             <label style="display: flex; align-items: center; gap: 8px; cursor: pointer;">
                <input type="radio" name="shipping_method" checked style="accent-color: var(--accent-color);">
                <span>সারা বাংলাদেশে হোম ডেলিভারি চার্জ মাত্র: <b>90৳</b></span>
             </label>
          </div>

          <div style="display: flex; justify-content: space-between; margin-bottom: 20px; font-size: 1.1rem; border-bottom: 1px solid #eee; padding-bottom: 10px;">
             <span style="font-weight: 700; color: #333;">Total</span>
             <span style="font-weight: 700; color: #333;">840৳</span>
          </div>
          
          <!-- Payment Method -->
           <div style="margin-bottom: 20px; background: #fdfdfd; padding: 15px; border: 1px solid #eee; border-radius: 4px;">
              <label style="display: flex; align-items: center; gap: 8px; font-weight: 600; color: #333; margin-bottom: 5px;">
                 <input type="radio" name="payment_method" checked style="accent-color: var(--accent-color);">
                 Cash on delivery
              </label>
              <div style="margin-left: 24px; font-size: 0.9rem; color: #666; background: #eee; padding: 8px; border-radius: 3px;">
                 Pay with cash upon delivery.
              </div>
           </div>
           
           <div style="font-size: 0.85rem; color: #777; margin-bottom: 20px; line-height: 1.5;">
              Your personal data will be used to process your order, support your experience throughout this website, and for other purposes described in our privacy policy.
           </div>

          <button type="submit" style="width: 100%; background-color: var(--accent-color); color: white; border: none; padding: 15px; border-radius: 5px; font-size: 1.1rem; font-weight: 700; cursor: pointer; text-transform: uppercase;">
             Place Order 840৳
          </button>

       </div>

    </form>
  </div>
  
  <style>
    @media (max-width: 768px) {
       #orderForm {
          grid-template-columns: 1fr !important;
       }
    }
  </style>
</section>
