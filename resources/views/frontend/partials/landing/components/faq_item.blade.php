<details class="faq-item">
    <summary class="faq-summary">
        <span class="bengali-text faq-question">{{ $question }}</span>
        <span class="faq-icon">
            <svg class="faq-icon-plus" width="16" height="16" viewBox="0 0 448 512" fill="var(--primary-color)">
                <path
                    d="M416 208H272V64c0-17.67-14.33-32-32-32h-32c-17.67 0-32 14.33-32 32v144H32c-17.67 0-32 14.33-32 32v32c0 17.67 14.33 32 32 32h144v144c0 17.67 14.33 32 32 32h32c17.67 0 32-14.33 32-32V304h144c17.67 0 32-14.33 32-32v-32c0-17.67-14.33-32-32-32z" />
            </svg>
            <svg class="faq-icon-minus" width="16" height="16" viewBox="0 0 448 512" fill="var(--accent-color)">
                <path
                    d="M416 208H32c-17.67 0-32 14.33-32 32v32c0 17.67 14.33 32 32 32h384c17.67 0 32-14.33 32-32v-32c0-17.67-14.33-32-32-32z" />
            </svg>
        </span>
    </summary>
    <div class="faq-answer">
        <p class="bengali-text">{!! nl2br(e($answer)) !!}</p>
    </div>
</details>
