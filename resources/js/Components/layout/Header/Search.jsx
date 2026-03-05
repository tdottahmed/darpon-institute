import { useState, useEffect, useRef } from "react";
import { Link } from "@inertiajs/react";
import { Search as SearchIcon, X, Loader2, ArrowLeft } from "lucide-react";
import { useDebounce } from "../../../Utils/useDebounce";
import { createPortal } from "react-dom";

export default function Search({ mobile = false, onClose }) {
    const [query, setQuery] = useState("");
    const [results, setResults] = useState([]);
    const [loading, setLoading] = useState(false);
    const [isOpen, setIsOpen] = useState(false);
    const [showMobileOverlay, setShowMobileOverlay] = useState(false);
    const [mounted, setMounted] = useState(false);
    const searchRef = useRef(null);
    const mobileInputRef = useRef(null);
    const debouncedQuery = useDebounce(query, 300);

    useEffect(() => {
        setMounted(true);
    }, []);

    const handleSearch = async (q) => {
        if (!q.trim()) {
            setResults([]);
            return;
        }

        setLoading(true);
        try {
            const response = await window.axios.get(route('search.api'), {
                params: { q }
            });
            setResults(response.data);
        } catch (error) {
            console.error("Search error:", error);
        } finally {
            setLoading(false);
        }
    };

    useEffect(() => {
        handleSearch(debouncedQuery);
    }, [debouncedQuery]);

    useEffect(() => {
        const handleClickOutside = (event) => {
            if (searchRef.current && !searchRef.current.contains(event.target)) {
                setIsOpen(false);
                if (mobile && onClose) onClose();
            }
        };

        if (isOpen) {
            document.addEventListener("mousedown", handleClickOutside);
        }
        return () => document.removeEventListener("mousedown", handleClickOutside);
    }, [isOpen]);

    const handleResultClick = () => {
        setIsOpen(false);
        setShowMobileOverlay(false);
        setQuery("");
        if (mobile && onClose) onClose();
    };

    const openMobileOverlay = () => {
        setShowMobileOverlay(true);
        // Delay focus slightly to ensure element is rendered
        setTimeout(() => mobileInputRef.current?.focus(), 100);
    };

    // Prevent body scroll when mobile overlay is open
    useEffect(() => {
        if (showMobileOverlay) {
            document.body.style.overflow = "hidden";
        } else {
            document.body.style.overflow = "auto";
        }
        return () => {
            document.body.style.overflow = "auto";
        };
    }, [showMobileOverlay]);

    // If passed 'mobile' as true, it's intended to be embedded in the mobile menu
    if (mobile) {
        return (
            <div className="w-full px-1 py-1" ref={searchRef}>
                <div className="relative">
                    <div className="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        {loading ? (
                            <Loader2 className="h-4 w-4 text-gray-400 animate-spin" />
                        ) : (
                            <SearchIcon className="h-4 w-4 text-gray-400" />
                        )}
                    </div>
                    <input
                        type="search"
                        className="block w-full pl-10 pr-3 py-2.5 border-none rounded-xl bg-gray-100 dark:bg-gray-800 text-sm placeholder-gray-500 focus:ring-0 transition-all duration-200"
                        placeholder="Search courses, books..."
                        value={query}
                        onChange={(e) => setQuery(e.target.value)}
                    />
                </div>

                {/* Mobile menu results: fixed overlay so they stay above header/banner */}
                {mounted && results.length > 0 && createPortal(
                    <div className="fixed inset-0 z-[200]">
                        <div
                            className="absolute inset-0 bg-black/20 dark:bg-black/40"
                            aria-hidden="true"
                            onClick={() => setResults([])}
                        />
                        <div className="absolute left-0 right-0 top-16 bottom-0 z-[201] bg-white dark:bg-gray-950 overflow-hidden flex flex-col">
                            <div className="flex items-center gap-2 px-3 py-2 border-b border-gray-100 dark:border-gray-800 bg-white dark:bg-gray-950 shrink-0">
                                <span className="text-xs font-bold text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                    {results.length} result{results.length !== 1 ? "s" : ""}
                                </span>
                            </div>
                            <div className="flex-1 overflow-y-auto overscroll-contain p-3 pb-[env(safe-area-inset-bottom)] custom-scrollbar">
                                <div className="space-y-2">
                                    {results.map((result) => (
                                        <Link
                                            key={`${result.type}-${result.id}`}
                                            href={result.url}
                                            onClick={handleResultClick}
                                            className="flex items-center gap-3 p-3 rounded-xl bg-gray-50 dark:bg-gray-800/80 hover:bg-gray-100 dark:hover:bg-gray-800 border border-transparent hover:border-gray-200 dark:hover:border-gray-700 transition-colors active:scale-[0.99]"
                                        >
                                            <div className="h-12 w-12 flex-shrink-0 rounded-lg overflow-hidden bg-gray-200 dark:bg-gray-700 shadow-sm">
                                                {result.image ? (
                                                    <img src={`/storage/${result.image}`} alt={result.title} className="h-full w-full object-cover" />
                                                ) : (
                                                    <div className="h-full w-full flex items-center justify-center text-gray-400 text-sm font-bold">
                                                        {result.type[0].toUpperCase()}
                                                    </div>
                                                )}
                                            </div>
                                            <div className="flex-1 min-w-0">
                                                <p className="text-sm font-semibold text-gray-900 dark:text-gray-100 truncate">
                                                    {result.title}
                                                </p>
                                                <div className="flex items-center gap-2 mt-1 flex-wrap">
                                                    <span className={`text-[10px] px-2 py-0.5 rounded-md font-bold uppercase tracking-wider ${result.type === "course"
                                                        ? "bg-blue-100 text-blue-700 dark:bg-blue-900/40 dark:text-blue-300"
                                                        : "bg-emerald-100 text-emerald-700 dark:bg-emerald-900/40 dark:text-emerald-300"
                                                        }`}>
                                                        {result.type}
                                                    </span>
                                                    <span className="text-sm font-bold text-primary-600 dark:text-primary-400">
                                                        ৳{result.discount_price || result.price}
                                                    </span>
                                                </div>
                                            </div>
                                        </Link>
                                    ))}
                                </div>
                            </div>
                        </div>
                    </div>,
                    document.body
                )}
            </div>
        );
    }

    return (
        <div className="relative flex items-center" ref={searchRef}>
            {/* Desktop Button - toggles input */}
            <div className="hidden lg:flex items-center transition-all duration-300">
                {!isOpen ? (
                    <button
                        onClick={() => setIsOpen(true)}
                        className="p-2 rounded-full hover:bg-gray-100 dark:hover:bg-gray-800 text-gray-600 dark:text-gray-400 transition-all duration-200 flex items-center justify-center active:scale-95"
                        aria-label="Search"
                    >
                        <SearchIcon className="h-5 w-5" />
                    </button>
                ) : (
                    <div className="flex items-center bg-gray-100/80 dark:bg-gray-800/80 backdrop-blur rounded-full px-4 py-1.5 min-w-[300px] border border-transparent focus-within:border-primary-500/30 focus-within:bg-white dark:focus-within:bg-gray-900 shadow-sm animate-in slide-in-from-right-4 fade-in duration-300">
                        <SearchIcon className="h-4 w-4 text-gray-400 mr-2" />
                        <input
                            type="search"
                            className="bg-transparent border-none focus:ring-0 p-0 text-sm w-full placeholder-gray-500 text-gray-900 dark:text-gray-100"
                            placeholder="Search courses, books..."
                            value={query}
                            onChange={(e) => setQuery(e.target.value)}
                            autoFocus
                        />
                        <button
                            onClick={() => {
                                setIsOpen(false);
                                setQuery("");
                                setResults([]);
                            }}
                            className="ml-2 p-1 rounded-full hover:bg-gray-200 dark:hover:bg-gray-700 text-gray-500"
                        >
                            <X className="h-4 w-4" />
                        </button>
                    </div>
                )}
            </div>

            {/* Mobile Button - opens dedicated overlay */}
            <button
                onClick={openMobileOverlay}
                className="lg:hidden p-2 rounded-full hover:bg-gray-100 dark:hover:bg-gray-800 text-gray-600 dark:text-gray-400 transition-all duration-200 active:scale-90"
                aria-label="Open Search"
            >
                <SearchIcon className="h-5 w-5" />
            </button>

            {/* Mobile Search Overlay */}
            {mounted && showMobileOverlay && createPortal(
                <div className="fixed inset-0 z-[150] bg-white dark:bg-gray-950 flex flex-col animate-in fade-in slide-in-from-bottom-5 duration-300">
                    <div className="flex items-center p-4 border-b border-gray-100 dark:border-gray-900 bg-white/80 dark:bg-gray-950/80 backdrop-blur-md sticky top-0">
                        <button
                            onClick={() => setShowMobileOverlay(false)}
                            className="p-2 -ml-2 rounded-full hover:bg-gray-100 dark:hover:bg-gray-800 text-gray-600 dark:text-gray-400"
                        >
                            <ArrowLeft className="h-6 w-6" />
                        </button>
                        <div className="flex-1 ml-2 relative">
                            <input
                                ref={mobileInputRef}
                                type="search"
                                className="w-full bg-transparent border-none focus:ring-0 p-0 text-lg placeholder-gray-400 text-gray-900 dark:text-gray-100"
                                placeholder="Search everything..."
                                value={query}
                                onChange={(e) => setQuery(e.target.value)}
                            />
                        </div>
                        {loading && <Loader2 className="h-5 w-5 text-primary-500 animate-spin ml-2" />}
                        {query && !loading && (
                            <button
                                onClick={() => setQuery("")}
                                className="p-1 rounded-full bg-gray-100 dark:bg-gray-800 text-gray-500"
                            >
                                <X className="h-4 w-4" />
                            </button>
                        )}
                    </div>

                    <div className="flex-1 overflow-y-auto bg-gray-50 dark:bg-gray-950 p-4">
                        {results.length > 0 ? (
                            <div className="space-y-4">
                                <h3 className="text-xs font-bold text-gray-400 uppercase tracking-widest px-1">Results</h3>
                                {results.map((result) => (
                                    <Link
                                        key={`${result.type}-${result.id}`}
                                        href={result.url}
                                        onClick={handleResultClick}
                                        className="flex items-start gap-4 p-4 rounded-2xl bg-white dark:bg-gray-900 shadow-sm border border-gray-100 dark:border-gray-800 active:scale-[0.98] transition-all"
                                    >
                                        <div className="h-16 w-16 flex-shrink-0 rounded-xl overflow-hidden bg-gray-100 dark:bg-gray-800 shadow-inner">
                                            {result.image ? (
                                                <img src={`/storage/${result.image}`} alt={result.title} className="h-full w-full object-cover" />
                                            ) : (
                                                <div className="h-full w-full flex items-center justify-center text-gray-300">
                                                    <SearchIcon className="h-6 w-6" />
                                                </div>
                                            )}
                                        </div>
                                        <div className="flex-1 min-w-0 py-0.5">
                                            <div className="flex justify-between items-start mb-1">
                                                <span className={`text-[10px] px-2 py-0.5 rounded-full font-black uppercase tracking-tighter ${result.type === 'course'
                                                    ? 'bg-blue-100 text-blue-700 dark:bg-blue-900/40 dark:text-blue-300'
                                                    : 'bg-emerald-100 text-emerald-700 dark:bg-emerald-900/40 dark:text-emerald-300'
                                                    }`}>
                                                    {result.type}
                                                </span>
                                                <span className="text-sm font-black text-primary-600">৳{result.discount_price || result.price}</span>
                                            </div>
                                            <p className="text-base font-bold text-gray-900 dark:text-gray-100 line-clamp-2 leading-tight">
                                                {result.title}
                                            </p>
                                        </div>
                                    </Link>
                                ))}
                            </div>
                        ) : query.trim() && !loading ? (
                            <div className="flex flex-col items-center justify-center py-20 text-center">
                                <SearchIcon className="h-16 w-16 text-gray-200 dark:text-gray-800 mb-4" />
                                <p className="text-gray-500 dark:text-gray-400 text-lg font-medium">No matches found</p>
                                <p className="text-sm text-gray-400 mt-2">Check your spelling or try different keywords</p>
                            </div>
                        ) : !query.trim() ? (
                            <div className="flex flex-col items-center justify-center py-20 text-center opacity-40">
                                <SearchIcon className="h-12 w-12 text-gray-300 dark:text-gray-700 mb-4" />
                                <p className="text-gray-400 dark:text-gray-600 font-medium">Type to start searching...</p>
                            </div>
                        ) : null}
                    </div>
                </div>,
                document.body
            )}

            {/* Desktop Dropdown Search Results */}
            {isOpen && query.trim() && (
                <div className="absolute right-0 top-full mt-3 w-[450px] bg-white/95 dark:bg-gray-900/95 backdrop-blur-xl border border-gray-200 dark:border-gray-800 rounded-3xl shadow-[0_20px_50px_rgba(0,0,0,0.15)] dark:shadow-[0_20px_50px_rgba(0,0,0,0.3)] overflow-hidden z-[60] animate-in fade-in zoom-in-95 duration-200 origin-top-right">
                    <div className="p-5">
                        <div className="flex items-center justify-between mb-4 px-1">
                            <h3 className="text-[10px] font-black text-gray-400 dark:text-gray-500 uppercase tracking-[0.2em]">
                                {loading ? "Searching Deeply..." : `Top Findings (${results.length})`}
                            </h3>
                        </div>

                        {results.length > 0 ? (
                            <div className="space-y-1.5">
                                {results.map((result) => (
                                    <Link
                                        key={`${result.type}-${result.id}`}
                                        href={result.url}
                                        onClick={handleResultClick}
                                        className="flex items-center gap-4 p-3.5 rounded-2xl hover:bg-gray-50 dark:hover:bg-gray-800/80 transition-all duration-300 group border border-transparent hover:border-gray-100 dark:hover:border-white/5 active:scale-[0.98]"
                                    >
                                        <div className="h-14 w-14 flex-shrink-0 rounded-xl overflow-hidden bg-gray-100 dark:bg-gray-800 shadow-sm border border-gray-200/50 dark:border-gray-800">
                                            {result.image ? (
                                                <img src={`/storage/${result.image}`} alt={result.title} className="h-full w-full object-cover group-hover:scale-110 transition-transform duration-500" />
                                            ) : (
                                                <div className="h-full w-full flex items-center justify-center">
                                                    <SearchIcon className="h-5 w-5 text-gray-400" />
                                                </div>
                                            )}
                                        </div>
                                        <div className="flex-1 min-w-0">
                                            <div className="flex justify-between items-start mb-1">
                                                <p className="text-sm font-bold text-gray-900 dark:text-gray-100 truncate pr-4 group-hover:text-primary-600 transition-colors">
                                                    {result.title}
                                                </p>
                                                <span className="text-sm font-black text-primary-600 shrink-0">
                                                    ৳{result.discount_price || result.price}
                                                </span>
                                            </div>
                                            <div className="flex items-center">
                                                <span className={`text-[9px] px-2 py-0.5 rounded-md font-black uppercase tracking-wider ${result.type === 'course'
                                                    ? 'bg-blue-100 text-blue-700 dark:bg-blue-900/40 dark:text-blue-300'
                                                    : 'bg-emerald-100 text-emerald-700 dark:bg-emerald-900/40 dark:text-emerald-300'
                                                    }`}>
                                                    {result.type}
                                                </span>
                                            </div>
                                        </div>
                                    </Link>
                                ))}
                            </div>
                        ) : !loading && query.trim() ? (
                            <div className="text-center py-12">
                                <div className="h-16 w-16 bg-gray-50 dark:bg-gray-800/50 rounded-full flex items-center justify-center mx-auto mb-4">
                                    <SearchIcon className="h-7 w-7 text-gray-300 dark:text-gray-700" />
                                </div>
                                <p className="text-gray-900 dark:text-gray-100 font-bold text-lg">Nothing found</p>
                                <p className="text-xs text-gray-500 dark:text-gray-400 mt-1 max-w-[200px] mx-auto italic">We couldn't find anything matching your search query.</p>
                            </div>
                        ) : loading ? (
                            <div className="flex flex-col items-center justify-center py-16">
                                <Loader2 className="h-10 w-10 text-primary-500 animate-spin" />
                                <p className="text-[10px] font-black text-gray-400 uppercase tracking-widest mt-4">Exploring codebase</p>
                            </div>
                        ) : null}
                    </div>

                    {results.length > 0 && (
                        <div className="bg-gray-50/80 dark:bg-gray-800/50 px-5 py-3 border-t border-gray-100 dark:border-gray-800/50 flex items-center justify-between">
                            <span className="text-[9px] text-gray-400 font-bold uppercase tracking-widest">
                                Quick Jump
                            </span>
                            <div className="flex items-center gap-1.5">
                                <kbd className="hidden sm:inline-flex h-5 items-center gap-1 rounded border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-900 px-1.5 font-sans text-[10px] font-medium text-gray-400">
                                    ESC
                                </kbd>
                            </div>
                        </div>
                    )}
                </div>
            )}
        </div>
    );
}
