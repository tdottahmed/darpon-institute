import { Head, useForm } from "@inertiajs/react";
import Header from "@/Components/layout/Header";
import Footer from "@/Components/layout/Footer";
import Container from "@/Components/ui/Container";
import Button from "@/Components/ui/Button";
import Card from "@/Components/ui/Card";
import TextInput from "@/Components/TextInput";
import InputLabel from "@/Components/InputLabel";
import InputError from "@/Components/InputError";
import ApplicationLogo from "@/Components/ApplicationLogo";

export default function Enroll({ course }) {
    const { data, setData, post, processing, errors } = useForm({
        name: "",
        email: "",
        phone: "",
        address: "",
    });

    const submit = (e) => {
        e.preventDefault();
        post(route("courses.enroll.store", course.slug));
    };

    return (
        <>
            <Head title={`Enroll in ${course.title}`} />
            <div className="min-h-screen bg-white dark:bg-gray-900 font-sans text-gray-900 dark:text-gray-100 flex flex-col">
                <Header />

                <main className="flex-grow pt-24 pb-16 relative">
                     {/* Background Decorative Elements */}
                     <div className="absolute top-0 left-0 w-full h-96 bg-gradient-to-br from-primary-50 to-secondary-50 dark:from-gray-900 dark:to-gray-800 -z-10"></div>
                     <div className="absolute -top-10 right-0 w-96 h-96 bg-primary-200/20 rounded-full blur-3xl dark:bg-primary-900/10 -z-10"></div>

                    <Container>
                        <div className="text-center max-w-2xl mx-auto mb-12">
                            <h1 className="text-3xl md:text-5xl font-extrabold text-gray-900 dark:text-white mb-4 tracking-tight">
                                Secure Your Spot
                            </h1>
                            <p className="text-lg text-gray-600 dark:text-gray-300">
                                You are enrolling in <span className="text-primary-600 dark:text-primary-400 font-semibold">{course.title}</span>. Complete the form below to get started.
                            </p>
                        </div>

                        <div className="grid gap-12 lg:grid-cols-5 max-w-6xl mx-auto">
                             {/* Left Column: Form (Focus Order) */}
                             <div className="lg:col-span-3 order-2 lg:order-1">
                                <Card variant="elevated" className="p-8 sm:p-10 border-t-4 border-primary-500 shadow-2xl">
                                    <form onSubmit={submit} className="space-y-8">
                                        <div className="grid gap-8 sm:grid-cols-2">
                                            <div>
                                                <InputLabel htmlFor="name" value="Full Name" className="text-base" />
                                                <TextInput
                                                    id="name"
                                                    type="text"
                                                    className="mt-2 block w-full py-3 px-4 bg-gray-50 dark:bg-gray-800 border-gray-200 dark:border-gray-700"
                                                    value={data.name}
                                                    onChange={(e) => setData("name", e.target.value)}
                                                    required
                                                    autoFocus
                                                    placeholder="e.g. Tanbir Ahmed"
                                                />
                                                <InputError message={errors.name} className="mt-2" />
                                            </div>

                                            <div>
                                                <InputLabel htmlFor="phone" value="Phone Number" className="text-base" />
                                                <TextInput
                                                    id="phone"
                                                    type="tel"
                                                    className="mt-2 block w-full py-3 px-4 bg-gray-50 dark:bg-gray-800 border-gray-200 dark:border-gray-700"
                                                    value={data.phone}
                                                    onChange={(e) => setData("phone", e.target.value)}
                                                    required
                                                    placeholder="+880 1XXX XXXXXX"
                                                />
                                                <InputError message={errors.phone} className="mt-2" />
                                            </div>
                                        </div>

                                        <div>
                                            <InputLabel htmlFor="email" value="Email Address" className="text-base" />
                                            <TextInput
                                                id="email"
                                                type="email"
                                                className="mt-2 block w-full py-3 px-4 bg-gray-50 dark:bg-gray-800 border-gray-200 dark:border-gray-700"
                                                value={data.email}
                                                onChange={(e) => setData("email", e.target.value)}
                                                required
                                                placeholder="you@email.com"
                                            />
                                            <InputError message={errors.email} className="mt-2" />
                                        </div>

                                        <div>
                                            <InputLabel htmlFor="address" value="Full Address" className="text-base" />
                                            <textarea
                                                id="address"
                                                className="mt-2 block w-full rounded-lg border-gray-200 bg-gray-50 shadow-sm focus:border-primary-500 focus:ring-primary-500 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-300 dark:focus:border-primary-600 dark:focus:ring-primary-600 py-3 px-4"
                                                rows="3"
                                                value={data.address}
                                                onChange={(e) => setData("address", e.target.value)}
                                                required
                                                placeholder="Street, Area, City"
                                            />
                                            <InputError message={errors.address} className="mt-2" />
                                        </div>

                                        <div className="pt-6">
                                            <Button
                                                variant="primary"
                                                size="xl"
                                                className="w-full justify-center text-lg font-bold py-4 shadow-xl shadow-primary-500/30 hover:shadow-primary-500/50 hover:-translate-y-1 transition-all duration-300"
                                                disabled={processing}
                                            >
                                                {processing ? (
                                                    <span className="flex items-center gap-2">
                                                        <svg className="animate-spin h-5 w-5 text-white" fill="none" viewBox="0 0 24 24">
                                                            <circle className="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" strokeWidth="4"></circle>
                                                            <path className="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                                        </svg>
                                                        Processing...
                                                    </span>
                                                ) : "Complete Registration"}
                                            </Button>
                                            <p className="mt-4 text-center text-sm text-gray-500 dark:text-gray-400">
                                                By clicking "Complete Registration", you agree to our Terms of Service.
                                            </p>
                                        </div>
                                    </form>
                                </Card>
                             </div>

                             {/* Right Column: Benefits / Course Highlight (Visual) */}
                             <div className="lg:col-span-2 order-1 lg:order-2 space-y-8">
                                <div className="bg-white dark:bg-gray-800 rounded-2xl p-6 shadow-lg border border-gray-100 dark:border-gray-700">
                                     <div className="aspect-video w-full rounded-xl overflow-hidden mb-6 relative group">
                                         {course.thumbnail ? (
                                                <img 
                                                    src={course.thumbnail.startsWith('http') ? course.thumbnail : `/storage/${course.thumbnail}`} 
                                                    alt={course.title} 
                                                    className="h-full w-full object-cover transition-transform duration-700 group-hover:scale-105"
                                                />
                                            ) : (
                                                <div className="flex h-full items-center justify-center bg-gray-100 dark:bg-gray-700">
                                                    <ApplicationLogo className="h-16 w-16 opacity-30" />
                                                </div>
                                            )}
                                         <div className="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent"></div>
                                         <div className="absolute bottom-4 left-4 text-white">
                                             <p className="text-sm font-medium opacity-90">Course</p>
                                             <h3 className="text-xl font-bold">{course.title}</h3>
                                         </div>
                                     </div>

                                     <h4 className="font-bold text-gray-900 dark:text-white mb-4">What you'll get:</h4>
                                     <ul className="space-y-4">
                                         {[
                                             'Unlimited access to all course materials',
                                             'Expert instruction and support',
                                             'Certificate of completion',
                                             'Community access'
                                         ].map((item, i) => (
                                             <li key={i} className="flex items-start gap-3 text-gray-600 dark:text-gray-300">
                                                 <div className="mt-1 h-5 w-5 rounded-full bg-green-100 dark:bg-green-900/30 flex items-center justify-center flex-shrink-0 text-green-600 dark:text-green-400">
                                                     <svg className="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={3} d="M5 13l4 4L19 7" />
                                                    </svg>
                                                 </div>
                                                 <span className="text-sm">{item}</span>
                                             </li>
                                         ))}
                                     </ul>
                                </div>
                                
                                {/* Testimonial Snippet (Optional - adds trust) */}
                                <div className="bg-primary-50 dark:bg-primary-900/10 rounded-xl p-6 border border-primary-100 dark:border-primary-800/20">
                                    <div className="flex gap-1 text-yellow-500 mb-3">
                                        {[1,2,3,4,5].map(i => <span key={i}>★</span>)}
                                    </div>
                                    <p className="text-sm text-gray-700 dark:text-gray-300 italic mb-4">
                                        "This course changed the way I learn. Highly recommended for anyone looking to improve quickly."
                                    </p>
                                    <div className="flex items-center gap-3">
                                        <div className="h-8 w-8 rounded-full bg-primary-200 flex items-center justify-center text-xs font-bold text-primary-700">SJ</div>
                                        <div>
                                            <p className="text-xs font-bold text-gray-900 dark:text-white">Sarah Johnson</p>
                                            <p className="text-[10px] text-gray-500 uppercase tracking-wide">Student</p>
                                        </div>
                                    </div>
                                </div>
                             </div>
                        </div>
                    </Container>
                </main>
                <Footer />
            </div>
        </>
    );
}
