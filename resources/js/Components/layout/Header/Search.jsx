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
    const [mounted, setMounted] = useState(false);
    const inputRef = useRef(null);
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
        const handleKeyDown = (e) => {
            if ((e.metaKey || e.ctrlKey) && e.key === 'k') {
                e.preventDefault();
                setIsOpen(true);
            }
            if (e.key === 'Escape') {
                setIsOpen(false);
            }
        };
        document.addEventListener('keydown', handleKeyDown);
        return () => document.removeEventListener('keydown', handleKeyDown);
    }, []);

    // Prevent body scroll when modal is open
    useEffect(() => {
        if (isOpen) {
            document.body.style.overflow = "hidden";
            setTimeout(() => inputRef.current?.focus(), 100);
        } else {
            document.body.style.overflow = "auto";
        }
        return () => {
            document.body.style.overflow = "auto";
        };
    }, [isOpen]);

    const handleResultClick = () => {
        setIsOpen(false);
        setQuery("");
        if (onClose) onClose();
    };

    const renderResults = () => {
        if (results.length > 0) {
            return (
                <div className="space-y-1.5">
                    {results.map((result) => (
                        <Link
                            key={`${result.type}-${result.id}`}
                            href={result.url}
                            onClick={handleResultClick}
                            className="flex items-center gap-4 p-3 rounded-2xl hover:bg-gray-100 dark:hover:bg-gray-800/80 transition-all duration-300 group border border-transparent hover:border-gray-200 dark:hover:border-white/5 active:scale-[0.98]"
                        >
                            <div className="h-14 w-14 flex-shrink-0 rounded-xl overflow-hidden bg-white dark:bg-gray-800 shadow-sm border border-gray-200/50 dark:border-gray-800 relative">
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
            );
        }

        if (loading) {
            return (
                <div className="flex flex-col items-center justify-center py-16">
                    <Loader2 className="h-10 w-10 text-primary-500 animate-spin" />
                    <p className="text-[10px] font-black text-gray-400 uppercase tracking-widest mt-4">Searching Codebase...</p>
                </div>
            );
        }

        if (query.trim() && !loading) {
            return (
                <div className="flex flex-col items-center justify-center py-20 text-center">
                    <SearchIcon className="h-16 w-16 text-gray-200 dark:text-gray-800 mb-4" />
                    <p className="text-gray-500 dark:text-gray-400 text-lg font-medium">No matches found</p>
                    <p className="text-sm text-gray-400 mt-2">Check your spelling or try different keywords</p>
                </div>
            );
        }

        if (!query.trim()) {
            return (
                <div className="flex flex-col items-center justify-center py-20 text-center opacity-40">
                    <SearchIcon className="h-12 w-12 text-gray-300 dark:text-gray-700 mb-4" />
                    <p className="text-gray-400 dark:text-gray-600 font-medium">Type to start searching...</p>
                </div>
            );
        }

        return null;
    };

    const Modal = () => mounted && isOpen && createPortal(
        <div className="fixed inset-0 z-[200] flex flex-col lg:items-center lg:justify-start lg:pt-[10vh] px-0 lg:px-4">
            {/* Backdrop */}
            <div 
                className="fixed inset-0 bg-white/90 lg:bg-gray-900/50 dark:bg-gray-950/90 lg:dark:bg-black/70 backdrop-blur-sm transition-opacity" 
                aria-hidden="true"
                onClick={() => setIsOpen(false)}
            />
            
            {/* Modal Content */}
            <div 
                role="dialog" 
                aria-modal="true"
                className="relative flex flex-col w-full h-full lg:h-auto lg:max-h-[80vh] lg:max-w-2xl bg-white dark:bg-gray-950 lg:dark:bg-gray-900 lg:rounded-2xl shadow-2xl overflow-hidden animate-in fade-in slide-in-from-bottom-4 lg:slide-in-from-bottom-0 lg:zoom-in-95 duration-200"
            >
                {/* Header/Input Area */}
                <div className="flex items-center px-4 py-4 lg:p-4 border-b border-gray-100 dark:border-gray-800 shrink-0 bg-white dark:bg-gray-950 lg:dark:bg-gray-900">
                    <SearchIcon className="hidden lg:block h-5 w-5 text-gray-400 ml-2" />
                    <ArrowLeft 
                        className="lg:hidden h-6 w-6 text-gray-500 mr-3 cursor-pointer" 
                        onClick={() => setIsOpen(false)}
                    />
                    
                    <input 
                        ref={inputRef}
                        type="search"
                        className="flex-1 bg-transparent border-none focus:ring-0 p-0 lg:px-4 text-lg lg:text-base placeholder-gray-400 text-gray-900 dark:text-gray-100"
                        placeholder="Search courses, books..."
                        value={query}
                        onChange={(e) => setQuery(e.target.value)}
                    />
                    
                    {loading && <Loader2 className="h-5 w-5 text-primary-500 animate-spin mr-3" />}
                    
                    <button
                        onClick={() => setIsOpen(false)}
                        className="hidden lg:flex p-1.5 rounded-md text-gray-400 hover:text-gray-600 hover:bg-gray-100 dark:hover:bg-gray-800 transition-colors"
                        title="Close (Esc)"
                    >
                        <kbd className="hidden sm:inline-flex h-5 items-center gap-1 rounded bg-gray-100 dark:bg-gray-800 border border-gray-200 dark:border-gray-700 px-1.5 font-sans text-[10px] font-medium text-gray-500 shadow-sm">ESC</kbd>
                    </button>
                    {query && !loading && (
                        <button onClick={() => setQuery("")} className="lg:hidden p-1.5 rounded-full text-gray-400 bg-gray-100 dark:bg-gray-800">
                            <X className="h-4 w-4" />
                        </button>
                    )}
                </div>

                {/* Results Area */}
                <div className="flex-1 overflow-y-auto outline-none custom-scrollbar p-2 lg:p-4 bg-gray-50/50 lg:bg-transparent dark:bg-gray-950/50 lg:dark:bg-transparent">
                    {results.length > 0 && (
                        <h3 className="text-[10px] font-black text-gray-400 dark:text-gray-500 uppercase tracking-[0.2em] mb-3 px-2">
                            Top Findings ({results.length})
                        </h3>
                    )}
                    {renderResults()}
                </div>

                {/* Footer instructions (desktop only) */}
                {results.length > 0 && (
                    <div className="hidden lg:flex bg-gray-50/80 dark:bg-gray-800/50 px-5 py-3 border-t border-gray-100 dark:border-gray-800/50 items-center justify-between shrink-0">
                        <span className="text-[9px] text-gray-400 font-bold uppercase tracking-widest">
                            Quick Jump
                        </span>
                        <div className="flex items-center gap-1.5">
                            <kbd className="inline-flex h-5 items-center gap-1 rounded border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-900 px-1.5 font-sans text-[10px] font-medium text-gray-400">
                                ESC
                            </kbd>
                        </div>
                    </div>
                )}
            </div>
        </div>,
        document.body
    );

    if (mobile) {
        return (
            <>
                <div className="w-full px-1 py-1">
                    <button 
                        onClick={() => setIsOpen(true)}
                        className="w-full flex items-center relative group"
                    >
                        <div className="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <SearchIcon className="h-4 w-4 text-gray-400 group-hover:text-primary-500 transition-colors" />
                        </div>
                        <div className="block w-full pl-10 pr-3 py-2.5 border-none rounded-xl bg-gray-100 dark:bg-gray-800 text-sm transition-all duration-200 text-left text-gray-500">
                            Search...
                        </div>
                    </button>
                </div>
                <Modal />
            </>
        );
    }

    return (
        <div className="relative flex items-center">
            {/* Desktop Button - opens modal */}
            <button
                onClick={() => setIsOpen(true)}
                className="hidden lg:flex items-center justify-between gap-2 p-2 rounded-full lg:w-44 lg:px-4 lg:py-2 bg-transparent lg:bg-gray-100 dark:lg:bg-gray-800 hover:bg-gray-100 lg:hover:bg-gray-200 dark:hover:bg-gray-800 dark:lg:hover:bg-gray-700 text-gray-600 dark:text-gray-400 transition-all duration-200 active:scale-95 group"
                aria-label="Search"
            >
                <div className="flex items-center gap-2 overflow-hidden">
                    <SearchIcon className="h-5 w-5 lg:h-4 lg:w-4 flex-shrink-0 group-hover:text-primary-500 transition-colors" />
                    <span className="hidden lg:inline-block text-sm text-gray-500 dark:text-gray-400 truncate">Search...</span>
                </div>
                <kbd className="hidden lg:inline-flex flex-shrink-0 h-5 items-center gap-1 rounded border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-900 px-1.5 font-sans text-[10px] font-medium text-gray-400 shadow-sm">
                    <span className="text-[10px]">⌘</span>K
                </kbd>
            </button>

            {/* Mobile Button - opens modal */}
            <button
                onClick={() => setIsOpen(true)}
                className="lg:hidden p-2 rounded-full hover:bg-gray-100 dark:hover:bg-gray-800 text-gray-600 dark:text-gray-400 transition-all duration-200 active:scale-90"
                aria-label="Open Search"
            >
                <SearchIcon className="h-5 w-5" />
            </button>

            <Modal />
        </div>
    );
}
