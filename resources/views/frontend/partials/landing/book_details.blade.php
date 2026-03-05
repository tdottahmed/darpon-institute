@php
    // Get dynamic data from landing page
    $title = $landingPage->book_details_title ?? '';
    $description = $landingPage->book_details_description ?? '';
    $specialtiesTitle =
        $landingPage->book_details_specialties_title ?? ($landingPage->product_type === 'book' ? '' : '');
    $specialtiesDescription = $landingPage->book_details_specialties_description ?? '';
    $studentsLoveTitle = $landingPage->book_details_students_love_title ?? '';
    $studentsLoveDescription = $landingPage->book_details_students_love_description ?? '';
    $extraordinaryTitle = $landingPage->book_details_extraordinary_title ?? '';
    $extraordinaryDescription = $landingPage->book_details_extraordinary_description ?? '';

    // Default static content if empty
    $defaultDescription = '';
@endphp

<section class="book-details-section section-sm" style="background-color: #073050;">
    <div class="container-narrow">

        <!-- Main Heading -->
        @if (!empty($title))
            <div style="text-align: center; margin-bottom: 20px;">
                <h2 class="bengali-text"
                    style="color: white; font-size: 1.8rem; font-weight: 700; margin-bottom: 10px;">
                    {{ $title }}
                </h2>
                <span
                    style="display: block; width: 30%; height: 2px; background: var(--accent-color); margin: 10px auto 0;"></span>
            </div>
        @endif

        <!-- Description Block -->
        @php
            // Check if description has actual content (not just empty HTML tags)
            $hasContent = !empty($description) && trim(strip_tags($description)) !== '';
        @endphp
        @if ($hasContent)
            <div class="description-block"
                style="background-color: white; padding: 30px; border-radius: 10px; box-shadow: 0 4px 15px rgba(0,0,0,0.05); margin-bottom: 20px; text-align: left; border: 2px solid var(--accent-color);">
                <p class="bengali-text description-text"
                    style="color: #444; font-size: 1.2rem; line-height: 1.8; font-weight: 500;">
                    {!! $description !!}
                </p>
            </div>
        @endif

        {{-- Check if specialties description has actual content (not just empty HTML tags) --}}
        @php
            $hasSpecialtiesContent =
                !empty($specialtiesDescription) && trim(strip_tags($specialtiesDescription)) !== '';
        @endphp
        <!-- Specialties Description -->
        @if ($hasSpecialtiesContent)
            <div>
                @if (!empty($specialtiesTitle))
                    <h2 class="bengali-text"
                        style="color: white; margin: 0 0 20px; font-size: 1.8rem; text-align: center; font-weight: 700;  width: 100%; position: relative;">
                        {{ $specialtiesTitle }}
                        <span
                            style="display: block; width: 30%; height: 2px; background: var(--accent-color); margin: 10px auto 0;"></span>
                    </h2>
                @endif

                <div
                    style="background: white; padding: 25px; border-radius: 8px; border: 2px solid var(--accent-color);">
                    <p class="bengali-text description-text"
                        style="color: var(--dark-text); line-height: 1.8; font-size: 1.05rem;">
                        {!! $specialtiesDescription !!}
                    </p>
                </div>
            </div>
        @endif

        @if ($hasSpecialtiesContent)
            <div style="text-align: center; margin-top: 20px;">
                <x-cta-button :landingPage="$landingPage" />
            </div>
        @endif

        @if ($landingPage->product_type === 'book')
            <!-- Full Width Sections: Extraordinary & Students Love -->
            <div style="margin-top: 20px;">

                <!-- Section 1: What makes it extraordinary -->
                @php
                    // Check if extraordinary description has actual content (not just empty HTML tags)
                    $hasExtraordinaryContent =
                        !empty($extraordinaryDescription) && trim(strip_tags($extraordinaryDescription)) !== '';
                @endphp
                @if ($hasExtraordinaryContent)
                    <div style="margin-bottom: 20px;">
                        @if (!empty($extraordinaryTitle))
                            <h2 class="bengali-text"
                                style="color: white; margin: 0 0 20px; font-size: 1.8rem; font-weight: 700; text-align: center; width: 100%; position: relative;">
                                {{ $extraordinaryTitle }}
                                <span
                                    style="display: block; width: 30%; height: 2px; background: var(--accent-color); margin: 10px auto 0;"></span>
                            </h2>
                        @endif
                        <div
                            style="background: white; padding: 25px; border-radius: 8px; border: 2px solid var(--accent-color);">
                            <p class="bengali-text description-text"
                                style="color: var(--dark-text); line-height: 1.8; ">
                                {!! $extraordinaryDescription !!}
                            </p>
                        </div>

                        <div style="text-align: center; margin-top: 20px;">
                            <x-cta-button :landingPage="$landingPage" style="padding: 10px 25px; font-size: 0.9rem;" />
                        </div>

                    </div>
                @endif

                <!-- Section 2: Why Students Love -->
                @php
                    // Check if students love description has actual content (not just empty HTML tags)
                    $hasStudentsLoveContent =
                        !empty($studentsLoveDescription) && trim(strip_tags($studentsLoveDescription)) !== '';
                @endphp
                @if ($hasStudentsLoveContent)
                    <div>
                        @if (!empty($studentsLoveTitle))
                            <h2 class="bengali-text"
                                style="color: white; margin: 0 0 20px; font-size: 1.8rem; font-weight: 700; text-align: center; width: 100%; padding-bottom: 10px; position: relative;">
                                {{ $studentsLoveTitle }}
                                <span
                                    style="display: block; width: 30%; height: 2px; background: var(--accent-color); margin: 10px auto 0;"></span>
                            </h2>
                        @endif
                        <div
                            style="background: white; padding: 25px; border-radius: 8px; border: 2px solid var(--accent-color);">
                            <div class="bengali-text" style="color: #444; font-size: 1.05rem; line-height: 1.8;">
                                {!! $studentsLoveDescription !!}
                            </div>
                        </div>
                        <div style="text-align: center; margin-top: 20px;">
                            <x-cta-button :landingPage="$landingPage" style="padding: 10px 25px; font-size: 0.9rem;" />
                        </div>
                    </div>
                @endif
            </div>
        @endif
    </div>
    </div>

    <style>
        @media (max-width: 768px) {
            .book-details-section h2 {
                font-size: 1.5rem !important;
            }

            .description-block {
                padding: 20px !important;
            }

            .description-text {
                font-size: 1rem !important;
                text-align: left !important;
            }
        }
    </style>
</section>
