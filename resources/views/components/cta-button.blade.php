@props(['landingPage', 'class' => '', 'style' => ''])

@php
    $buttonText = $landingPage->cta_button_text ?? 'অর্ডার করুন';
    $defaultStyle = 'display: inline-flex; align-items: center; justify-content: center; gap: 16px; background-color: rgb(26, 35, 126); color: white; border: none; padding: 8px 8px 8px 24px; border-radius: 50px; font-size: 1.1rem; font-weight: 600; cursor: pointer; transition: transform 0.2s;';
    $combinedStyle = $style ? $defaultStyle . ' ' . $style : $defaultStyle;
@endphp

<button onclick="document.getElementById('orderFormSection').scrollIntoView({behavior: 'smooth'})"
        style="{{ $combinedStyle }}"
        class="{{ $class }}"
        onmouseover="this.style.transform='scale(1.05)'" 
        onmouseout="this.style.transform='scale(1)'">
    <span>{{ $buttonText }}</span>
    <div style="display: flex; align-items: center; justify-content: center; width: 36px; height: 36px; border-radius: 50%; background-color: rgba(0, 0, 0, 0.15); flex-shrink: 0;">
        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M5 12H19M19 12L12 5M19 12L12 19" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
        </svg>
    </div>
</button>
