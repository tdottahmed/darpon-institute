@php
    // Default author information
    $defaultAuthorBadge = 'About The Author';
    $defaultAuthorName = 'মো: শফিকুল ইসলাম';
    $defaultAuthorTitle = 'প্রতিষ্ঠাতা ও পরিচালক, দর্পণ ইংলিশ টিচিং জোন';
    $defaultAuthorDescription =
        '<p><strong>মো: শফিকুল ইসলাম</strong> একজন অভিজ্ঞ ও গবেষণাশীল ইংরেজি শিক্ষক, যার শিক্ষকতার বয়স <strong style="color: #ff9800;">২৫ বছরেরও বেশি</strong>। তিনি আধুনিক পদ্ধতিতে Spoken English, Written English, Phonetics ও Academic English শেখানোর ক্ষেত্রে সুনাম অর্জন করেছেন।</p><p>ইংরেজি ভাষার ওপর ১৬ বছর ধরে গবেষণা করছেন এবং এখন পর্যন্ত ৩০টিরও বেশি বই রচনা করেছেন। <em>\'Spoken English In Real Life\'</em> তার প্রথম প্রকাশিত বই। তাঁর বইগুলো সহজবোধ্য উপস্থাপনা, বাস্তব উদাহরণ ও শিক্ষার্থী-বান্ধব স্টাইলে সমৃদ্ধ, যা ইংরেজি শেখাকে আরও সহজ ও কার্যকর করে তোলে। ইংরেজি শিক্ষাকে সবার জন্য সহজ ও আনন্দময় করাই তাঁর মূল লক্ষ্য।</p>';
    $defaultAuthorImage = 'https://book.darponbd.com/wp-content/uploads/2025/11/Book-Writer-removebg-preview.png';

    // Get values from landing page or use defaults
    $authorBadge = $landingPage->author_badge ?? $defaultAuthorBadge;
    $authorName = $landingPage->author_name ?? $defaultAuthorName;
    $authorTitle = $landingPage->author_title ?? $defaultAuthorTitle;
    $authorDescription = $landingPage->author_description ?? $defaultAuthorDescription;
    $authorImage = $landingPage->author_image ? Storage::url($landingPage->author_image) : $defaultAuthorImage;
@endphp

<section class="section-sm" style="background-color: #073050;">
    <div class="container-narrow">

        <div
            style="background: #ffffff; border-radius: 15px; padding: 40px; box-shadow: 0 10px 30px rgba(0,0,0,0.05); display: flex; flex-direction: row; gap: 40px; align-items: center; justify-content: center; position: relative; overflow: hidden; border: 2px solid var(--accent-color);">

            <!-- Decorative Background Text -->
            <div
                style="position: absolute; top: -20px; right: -20px; font-size: 150px; font-weight: 900; color: rgba(13, 71, 161, 0.03); z-index: 0; pointer-events: none; font-family: 'Times New Roman', serif;">
                AUTHOR
            </div>

            <!-- Author Image Wrapper -->
            <div style="flex: 0 0 350px; position: relative; z-index: 1;">
                <div style="position: relative; border-radius: 50%; overflow: visible;">
                    <img decoding="async" src="{{ $authorImage }}" alt="{{ $authorName }}"
                        style="width: 100%; height: auto; display: block; filter: drop-shadow(0px 10px 15px rgba(0,0,0,0.2)); transform: scale(1.05);">
                </div>
            </div>

            <!-- Author Content -->
            <div class="author-content">

                <div class="author-badge">
                    <span class="author-badge-text">
                        {{ $authorBadge }}
                    </span>
                </div>

                <h2 class="bengali-text author-name">
                    {!! $authorName !!}
                </h2>

                <h3 class="bengali-text author-title">
                    {!! $authorTitle !!}
                </h3>

                <div class="bengali-text author-description">
                    {!! $authorDescription !!}
                </div>

            </div>

        </div>

        <div style="text-align: center; margin-top: 20px;">
            <x-cta-button :landingPage="$landingPage" />
        </div>

    </div>

    <style>
        .author-content {
            flex: 1;
            z-index: 1;
            text-align: left;
        }

        .author-badge {
            margin-bottom: 20px;
        }

        .author-badge-text {
            background-color: #e3f2fd;
            color: #0d47a1;
            padding: 5px 15px;
            border-radius: 20px;
            font-size: 0.9rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .author-name {
            color: #0d47a1;
            margin: 0 0 5px;
            font-size: 2.2rem;
            font-weight: 700;
            line-height: 1.2;
        }

        .author-title {
            color: #555;
            margin: 0 0 25px;
            font-size: 1.1rem;
            font-weight: 600;
            border-left: 4px solid #ff9800;
            padding-left: 15px;
        }

        .author-description {
            color: #444;
            line-height: 1.8;
            font-size: 1.05rem;
            text-align: left;
        }

        .author-description p,
        .author-description div,
        .author-description span,
        .author-description em,
        .author-description strong {
            text-align: left !important;
            margin-left: 0 !important;
            margin-right: 0 !important;
        }

        @media (max-width: 900px) {

            .author-name {
                font-size: 1.5rem;
            }

            .author-description {
                font-size: 0.9rem;
            }

            div[style*="flex-direction: row"] {
                flex-direction: column !important;
                text-align: center !important;
                padding: 30px 20px !important;
            }

            div[style*="flex: 0 0 350px"] {
                flex: 0 0 auto !important;
                width: 80% !important;
                margin: 0 auto 20px !important;
            }

            .author-title {
                border-left: none !important;
                border-bottom: 3px solid #ff9800 !important;
                padding-left: 0 !important;
                padding-bottom: 10px !important;
                display: inline-block !important;
            }

            .author-content {
                text-align: center !important;
                /* Force center on mobile for container */
            }

            .author-description {
                text-align: left !important;
                font-size: 1rem !important;
                text-align-last: left !important;
            }

            div[style*="position: absolute; top: -20px"] {
                display: none;
                /* Hide decorative text on mobile */
            }
        }
    </style>
</section>
