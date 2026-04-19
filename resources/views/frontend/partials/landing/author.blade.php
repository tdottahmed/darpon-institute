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

<section class="section-sm" style="background-color: #133050; padding-top: 50px; padding-bottom: 50px;">
    <div class="container-narrow">

        <div class="author-card">

            <div class="author-top-section">
                <!-- Author Image Wrapper -->
                <div class="author-image-wrapper">
                    <img decoding="async" src="{{ $authorImage }}" alt="{{ $authorName }}">
                </div>

                <!-- Author Header -->
                <div class="author-header">
                    <h2 class="bengali-text author-name">
                        {!! $authorName !!}
                    </h2>
                    <h3 class="bengali-text author-title">
                        {!! $authorTitle !!}
                    </h3>
                </div>
            </div>

            <!-- Author Description -->
            <div class="bengali-text author-description js-author-desc-container">
                <div class="js-author-desc-short" style="display: none;"></div>
                <div class="js-author-desc-full" style="display: none;">
                    {!! $authorDescription !!}
                </div>
            </div>

            <div style="text-align: center; margin-top: 20px;">
                <x-cta-button :landingPage="$landingPage" />
            </div>

        </div>

    </div>

    <style>
        .author-card {
            background: #ffffff;
            padding: 40px;
            max-width: 900px;
            margin: 0 auto;
            border: 2px solid #f59e0b;
            border-radius: 12px;
            padding-bottom: 10px;
        }

        .author-top-section {
            display: flex;
            flex-direction: row;
            align-items: center;
            gap: 40px;
            margin-bottom: 30px;
        }

        .author-image-wrapper {
            flex: 0 0 250px;
            border-radius: 50%;
            overflow: hidden;
            width: 250px;
            height: 250px;
        }

        .author-image-wrapper img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            display: block;
        }

        .author-name {
            color: #000;
            margin: 0 0 10px;
            font-size: 2.5rem;
            font-weight: 800;
            line-height: 1.2;
        }

        .author-title {
            color: #000;
            margin: 0;
            font-size: 1.2rem;
            font-weight: 500;
            line-height: 1.4;
        }

        .author-description {
            color: #000;
            line-height: 1.6;
            font-size: 1.15rem;
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
            color: #000 !important;
        }

        @media (max-width: 900px) {
            .author-card {
                padding: 20px;
            }

            .author-top-section {
                flex-direction: column;
                text-align: center;
                gap: 20px;
            }

            .author-image-wrapper {
                flex: 0 0 180px;
                width: 180px;
                height: 180px;
                margin: 0 auto;
            }

            .author-name {
                font-size: 1.8rem;
                text-align: center !important;
            }

            .author-title {
                font-size: 1.1rem;
                text-align: center !important;
            }

            .author-description {
                font-size: 1.05rem;
                text-align: left !important;
            }
        }
    </style>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var containers = document.querySelectorAll('.js-author-desc-container');
            
            containers.forEach(function(container) {
                var fullDescContainer = container.querySelector('.js-author-desc-full');
                var shortDescContainer = container.querySelector('.js-author-desc-short');
                
                var textContent = fullDescContainer.textContent || fullDescContainer.innerText;
                var words = textContent.trim().split(/\s+/);
                
                if (words.length > 70) {
                    var shortText = words.slice(0, 70).join(' ');
                    shortDescContainer.textContent = shortText + ' ';
                    
                    var readMoreSpan = document.createElement('span');
                    readMoreSpan.textContent = 'Read more......';
                    readMoreSpan.style.fontWeight = 'bold';
                    readMoreSpan.style.cursor = 'pointer';
                    readMoreSpan.style.color = '#000';
                    readMoreSpan.onclick = function() {
                        shortDescContainer.style.display = 'none';
                        fullDescContainer.style.display = 'block';
                    };
                    
                    shortDescContainer.appendChild(readMoreSpan);
                    shortDescContainer.style.display = 'block';
                } else {
                    fullDescContainer.style.display = 'block';
                }
            });
        });
    </script>
</section>
