@php
    // Get FAQ data from landing page
    $faqSectionTitle = $landingPage->faq_section_title ?? 'Frequently Asked Questions';
    $faqList = [];
    
    if ($landingPage->faq_list) {
        $faqList = is_array($landingPage->faq_list)
            ? $landingPage->faq_list
            : json_decode($landingPage->faq_list, true) ?? [];
    }
    
    // Only show section if there are FAQs
    if (empty($faqList)) {
        return;
    }
@endphp

<section class="section-sm faq-section">
    <div class="container-narrow">
        <div class="faq-header">
            <h2 class="bengali-text faq-title">
                {{ $faqSectionTitle }}
            </h2>
            <span class="faq-divider"></span>
        </div>

        <div class="faq-container">
            <!-- FAQ Accordion -->
            <div class="faq-accordion">
                @foreach ($faqList as $faq)
                    @if (!empty($faq['question']) && !empty($faq['answer']))
                        @include('frontend.partials.landing.components.faq_item', [
                            'question' => $faq['question'],
                            'answer' => $faq['answer']
                        ])
                    @endif
                @endforeach
            </div>
        </div>
    </div>

    <style>
        .faq-section {
            background-color: #073050;
        }

        .faq-header {
            text-align: center;
            margin-bottom: 40px;
        }

        .faq-title {
            color: white;
            font-size: 1.8rem;
            font-weight: 700;
            margin-bottom: 20px;
        }

        .faq-divider {
            display: block;
            width: 30%;
            height: 2px;
            background: var(--accent-color);
            margin: 10px auto 0;
        }

        .faq-container {
            background-color: #ffffff;
            padding: 20px;
            border-radius: 8px;
            border: 2px solid var(--accent-color);
        }

        .faq-accordion {
            display: flex;
            flex-direction: column;
            gap: 15px;
        }

        .faq-item {
            margin-bottom: 15px;
            background: white;
            border-radius: 8px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.05);
            overflow: hidden;
        }

        .faq-summary {
            padding: 20px;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: space-between;
            list-style: none;
            font-weight: 600;
            color: var(--dark-text);
        }

        .faq-question {
            font-size: 1.1rem;
        }

        .faq-icon {
            display: flex;
            align-items: center;
        }

        .faq-icon-minus {
            display: none;
        }

        .faq-item[open] .faq-icon-plus {
            display: none;
        }

        .faq-item[open] .faq-icon-minus {
            display: block !important;
        }

        .faq-item summary::-webkit-details-marker {
            display: none;
            /* Hide default arrow in Chrome */
        }

        .faq-answer {
            padding: 0 20px 20px;
            color: #555;
            line-height: 1.6;
        }

        @media (max-width: 768px) {
            .faq-title {
                font-size: 1.5rem;
            }

            .faq-container {
                padding: 15px;
            }

            .faq-summary {
                padding: 15px;
            }

            .faq-question {
                font-size: 1rem;
            }
        }
    </style>
</section>
