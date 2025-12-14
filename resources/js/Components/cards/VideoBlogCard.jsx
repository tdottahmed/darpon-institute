import { Link } from "@inertiajs/react";

export default function VideoBlogCard({ video }) {
    return (
        <div className="group relative overflow-hidden rounded-2xl bg-white shadow-sm transition-all duration-300 hover:-translate-y-1 hover:shadow-xl dark:bg-gray-800 border border-gray-100 dark:border-gray-700">
            {/* Thumbnail */}
            <div className="relative aspect-video overflow-hidden bg-gray-100 dark:bg-gray-900">
                {video.thumbnail ? (
                    <img
                        src={`/storage/${video.thumbnail}`}
                        alt={video.title}
                        className="h-full w-full object-cover transition-transform duration-500 group-hover:scale-110"
                    />
                ) : (
                    <div className="flex h-full w-full items-center justify-center bg-gray-200 dark:bg-gray-800 text-gray-400">
                        <svg className="h-12 w-12" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                           <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={1} d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z" />
                        </svg>
                    </div>
                )}
                
                {/* Play Overlay */}
                <div className="absolute inset-0 flex items-center justify-center bg-black/20 group-hover:bg-black/30 transition-colors">
                     <div className="flex h-12 w-12 items-center justify-center rounded-full bg-white/90 shadow-lg backdrop-blur-sm transition-transform duration-300 group-hover:scale-110 dark:bg-black/60">
                         <svg className="h-6 w-6 text-primary-600 dark:text-white ml-1" fill="currentColor" viewBox="0 0 24 24">
                             <path d="M8 5v14l11-7z" />
                         </svg>
                     </div>
                </div>

                {/* Badge/Tag (e.g. Video Type or first tag) */}
                <div className="absolute left-3 top-3">
                     <span className="inline-flex items-center rounded-md bg-black/60 px-2 py-1 text-xs font-medium text-white backdrop-blur-md">
                        {video.video_type === 'youtube' ? 'YouTube' : 'Video'}
                    </span>
                </div>
            </div>

            {/* Content */}
            <div className="p-5">
                <div className="mb-2 flex items-center text-xs text-gray-500 dark:text-gray-400">
                     <span>{new Date(video.created_at).toLocaleDateString()}</span>
                     {video.tags && video.tags.length > 0 && (
                         <>
                            <span className="mx-2">•</span>
                            <span className="uppercase text-primary-600 dark:text-primary-400 font-semibold">{video.tags[0]}</span>
                         </>
                     )}
                </div>

                <Link href={route("video_blogs.show", video.slug)} className="group-hover:text-primary-600 transition-colors">
                    <h3 className="mb-2 line-clamp-2 text-lg font-bold text-gray-900 dark:text-white">
                        {video.title}
                    </h3>
                </Link>

                <p className="line-clamp-2 text-sm text-gray-600 dark:text-gray-400">
                    {video.short_description}
                </p>
                
                <div className="mt-4">
                    <Link 
                        href={route("video_blogs.show", video.slug)}
                        className="text-sm font-semibold text-primary-600 hover:text-primary-700 dark:text-primary-400 dark:hover:text-primary-300 inline-flex items-center gap-1"
                    >
                        Watch Video
                        <svg className="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M17 8l4 4m0 0l-4 4m4-4H3" />
                        </svg>
                    </Link>
                </div>
            </div>
        </div>
    );
}
