import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout";
import { Head, useForm } from "@inertiajs/react";
import { useState } from "react";
import Button from "@/Components/ui/Button";

export default function Index({ auth, contents }) {
    // Group contents by section is already done in backend: contents = { hero: [...], about: [...] }
    const sections = Object.keys(contents);
    const [activeSection, setActiveSection] = useState(sections[0] || "hero");

    return (
        <AuthenticatedLayout
            user={auth.user}
            header={
                <h2 className="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                    Frontend CMS
                </h2>
            }
        >
            <Head title="Frontend CMS" />

            <div className="py-12">
                <div className="max-w-7xl mx-auto sm:px-6 lg:px-8">
                    <div className="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                        <div className="p-6 text-gray-900 dark:text-gray-100">
                            
                            {/* Tabs */}
                            <div className="flex border-b border-gray-200 dark:border-gray-700 mb-6">
                                {sections.length > 0 ? (
                                    sections.map((section) => (
                                        <button
                                            key={section}
                                            onClick={() => setActiveSection(section)}
                                            className={`px-4 py-2 border-b-2 font-medium text-sm transition-colors ${
                                                activeSection === section
                                                    ? "border-primary-500 text-primary-600 dark:text-primary-400"
                                                    : "border-transparent text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-300"
                                            }`}
                                        >
                                            {section.charAt(0).toUpperCase() + section.slice(1)}
                                        </button>
                                    ))
                                ) : (
                                    <div className="px-4 py-2 text-gray-500">No content found. Please seed the database.</div>
                                )}
                            </div>

                            {/* Content List */}
                            {sections.length > 0 && contents[activeSection] && (
                                <div className="space-y-6">
                                    {contents[activeSection].map((item) => (
                                        <ContentEditor key={item.id} item={item} />
                                    ))}
                                </div>
                            )}
                        </div>
                    </div>
                </div>
            </div>
        </AuthenticatedLayout>
    );
}

function ContentEditor({ item }) {
    const { data, setData, post, processing, errors, recentlySuccessful } = useForm({
        section: item.section,
        key: item.key,
        value: item.type === 'image' ? null : item.value || "",
        _method: 'POST' // We use POST for file uploads essentially
    });
    
    // We actually mapped update to POST in routes, so that's fine.
    // Ideally we might want to split update into text vs image to use PUT etc, but POST is easiest for files.

    const handleSubmit = (e) => {
        e.preventDefault();
        post(route('admin.frontend-content.update'), {
            preserveScroll: true,
        });
    };

    return (
        <form onSubmit={handleSubmit} className="p-4 border border-gray-200 dark:border-gray-700 rounded-lg bg-gray-50 dark:bg-gray-900/50">
            <div className="flex flex-col md:flex-row gap-4">
                <div className="md:w-1/4">
                     <label className="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                        {item.key.replace(/_/g, ' ').replace(/\b\w/g, l => l.toUpperCase())}
                     </label>
                     <p className="text-xs text-gray-500">{item.key}</p>
                </div>
                
                <div className="flex-1 space-y-2">
                    {item.type === 'image' ? (
                        <div>
                           {item.value && (
                                <div className="mb-2">
                                    <img src={item.value} alt={item.key} className="h-32 object-cover rounded-lg border dark:border-gray-700" />
                                </div>
                           )}
                           <input 
                                type="file" 
                                onChange={e => setData('value', e.target.files[0])}
                                className="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-primary-50 file:text-primary-700 hover:file:bg-primary-100"
                           />
                        </div>
                    ) : item.type === 'textarea' ? (
                        <textarea
                            value={data.value}
                            onChange={e => setData('value', e.target.value)}
                            rows={4}
                            className="w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 shadow-sm focus:border-primary-500 focus:ring-primary-500"
                        />
                    ) : (
                        <input
                            type="text"
                            value={data.value}
                            onChange={e => setData('value', e.target.value)}
                            className="w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 shadow-sm focus:border-primary-500 focus:ring-primary-500"
                        />
                    )}
                    
                    {errors.value && <p className="text-sm text-red-600">{errors.value}</p>}
                </div>
                
                <div className="flex items-end">
                    <Button type="submit" disabled={processing} variant="primary">
                        {processing ? "Saving..." : "Save"}
                    </Button>
                </div>
            </div>
            {recentlySuccessful && (
                <p className="text-sm text-green-600 mt-2 text-right">Saved!</p>
            )}
        </form>
    );
}
