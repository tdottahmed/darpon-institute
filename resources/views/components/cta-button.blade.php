@props(['landingPage', 'class' => '', 'style' => ''])

@php
    $buttonText = $landingPage->cta_button_text ?? 'অর্ডার করুন';
    $defaultStyle = 'background-color: rgb(26, 35, 126); color: white; border: none; padding: 12px 30px; border-radius: 5px; font-size: 1rem; font-weight: 600; cursor: pointer; transition: transform 0.2s;';
    $combinedStyle = $style ? $defaultStyle . ' ' . $style : $defaultStyle;
@endphp

<button onclick="document.getElementById('orderFormSection').scrollIntoView({behavior: 'smooth'})"
        style="{{ $combinedStyle }}"
        class="{{ $class }}"
        onmouseover="this.style.transform='scale(1.05)'" 
        onmouseout="this.style.transform='scale(1)'">
    {{ $buttonText }}
</button>
