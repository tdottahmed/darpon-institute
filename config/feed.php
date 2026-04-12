<?php

return [
    'feeds' => [
        'main' => [
            /*
             * Here you can specify which class and method will return
             * the items that should appear in the feed. For example:
             * [App\Model::class, 'getAllFeedItems']
             *
             * You can also pass an argument to that method. Note that their key must be the name of the parameter:
             * [App\Model::class, 'getAllFeedItems', 'parameterName' => 'argument']
             */
            'items' => [\App\Services\FeedService::class, 'getAllFeedItems'],

            /*
             * The feed will be available on this url.
             */
            'url' => '/feed',

            'title' => config('app.name') . ' - Video Blogs Feed',
            'description' => 'Latest video blogs and content updates from ' . config('app.name'),
            'language' => 'en-US',

            /*
             * The image to display for the feed. For Atom feeds, this is displayed as
             * a banner/logo; for RSS and JSON feeds, it's displayed as an icon.
             * An empty value omits the image attribute from the feed.
             */
            'image' => '',

            /*
             * The format of the feed. Acceptable values are 'rss', 'atom', or 'json'.
             */
            'format' => 'rss',

            /*
             * The view that will render the feed.
             */
            'view' => 'feed::rss',

            /*
             * The mime type to be used in the <link> tag. Set to an empty string to automatically
             * determine the correct value.
             */
            'type' => '',

            /*
             * The content type for the feed response. Set to an empty string to automatically
             * determine the correct value.
             */
            'contentType' => '',
        ],

        'courses' => [
            'items' => [\App\Models\Course::class, 'getFeedItems'],
            'url' => '/feed/courses',
            'title' => config('app.name') . ' - Courses Feed',
            'description' => 'Latest courses from ' . config('app.name'),
            'language' => 'en-US',
            'format' => 'rss',
            'view' => 'feed::rss',
        ],

        'books' => [
            'items' => [\App\Models\Book::class, 'getFeedItems'],
            'url' => '/feed/books',
            'title' => config('app.name') . ' - Books Feed',
            'description' => 'Latest books from ' . config('app.name'),
            'language' => 'en-US',
            'format' => 'rss',
            'view' => 'feed::rss',
        ],
    ],
];
