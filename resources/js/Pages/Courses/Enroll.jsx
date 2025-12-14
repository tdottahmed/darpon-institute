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
            <div className="min-h-screen bg-gray-50 dark:bg-gray-900 font-sans text-gray-900 dark:text-gray-100">
                <Header />

                <main className="pt-24 pb-16">
                    <Container>
                        <div className="mx-auto max-w-4xl">
                            <div className="grid gap-8 lg:grid-cols-3">
                                {/* Left Column: Course Summary */}
                                <div className="lg:col-span-1">
                                    <h2 className="sr-only">Course Summary</h2>
                                    <div className="sticky top-24">
                                        <Card variant="elevated" className="overflow-hidden">
                                             <div className="aspect-video w-full bg-gray-200 dark:bg-gray-800 relative">
                                                {course.thumbnail ? (
                                                    <img 
                                                        src={course.thumbnail.startsWith('http') ? course.thumbnail : `/storage/${course.thumbnail}`} 
                                                        alt={course.title} 
                                                        className="h-full w-full object-cover"
                                                    />
                                                ) : (
                                                    <div className="flex h-full items-center justify-center text-gray-400">
                                                        <ApplicationLogo className="h-12 w-12 opacity-50" />
                                                    </div>
                                                )}
                                             </div>
                                            <div className="p-6">
                                                <h3 className="mb-2 text-lg font-bold text-gray-900 dark:text-white">
                                                    {course.title}
                                                </h3>
                                                <div className="mb-4 text-sm text-gray-600 dark:text-gray-400">
                                                    {course.short_description?.replace(/<[^>]*>/g, "").substring(0, 100)}...
                                                </div>
                                                <div className="border-t border-gray-100 dark:border-gray-700 pt-4">
                                                    <div className="flex justify-between text-sm font-medium">
                                                        <span className="text-gray-500 dark:text-gray-400">Duration</span>
                                                        <span>{course.duration || 'Self-paced'}</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </Card>
                                    </div>
                                </div>

                                {/* Right Column: Registration Form */}
                                <div className="lg:col-span-2">
                                    <Card variant="elevated" className="p-6 sm:p-8">
                                        <div className="mb-8">
                                            <h1 className="text-2xl font-bold text-gray-900 dark:text-white sm:text-3xl">
                                                Course Registration
                                            </h1>
                                            <p className="mt-2 text-gray-600 dark:text-gray-400">
                                                Fill in your details to enroll in this course. We'll get back to you shortly.
                                            </p>
                                        </div>

                                        <form onSubmit={submit} className="space-y-6">
                                            {/* Name */}
                                            <div>
                                                <InputLabel htmlFor="name" value="Full Name" />
                                                <TextInput
                                                    id="name"
                                                    type="text"
                                                    className="mt-1 block w-full"
                                                    value={data.name}
                                                    onChange={(e) => setData("name", e.target.value)}
                                                    required
                                                    autoFocus
                                                    placeholder="John Doe"
                                                />
                                                <InputError message={errors.name} className="mt-2" />
                                            </div>

                                            {/* Email */}
                                            <div>
                                                <InputLabel htmlFor="email" value="Email Address" />
                                                <TextInput
                                                    id="email"
                                                    type="email"
                                                    className="mt-1 block w-full"
                                                    value={data.email}
                                                    onChange={(e) => setData("email", e.target.value)}
                                                    required
                                                    placeholder="john@example.com"
                                                />
                                                <InputError message={errors.email} className="mt-2" />
                                            </div>

                                            {/* Phone */}
                                            <div>
                                                <InputLabel htmlFor="phone" value="Phone Number" />
                                                <TextInput
                                                    id="phone"
                                                    type="tel"
                                                    className="mt-1 block w-full"
                                                    value={data.phone}
                                                    onChange={(e) => setData("phone", e.target.value)}
                                                    required
                                                    placeholder="+880 1XXX XXXXXX"
                                                />
                                                <InputError message={errors.phone} className="mt-2" />
                                            </div>

                                            {/* Address */}
                                            <div>
                                                <InputLabel htmlFor="address" value="Address" />
                                                <textarea
                                                    id="address"
                                                    className="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 dark:focus:border-primary-600 dark:focus:ring-primary-600"
                                                    rows="3"
                                                    value={data.address}
                                                    onChange={(e) => setData("address", e.target.value)}
                                                    required
                                                    placeholder="Your full address"
                                                />
                                                <InputError message={errors.address} className="mt-2" />
                                            </div>

                                            <div className="pt-4">
                                                <Button
                                                    variant="primary"
                                                    size="lg"
                                                    className="w-full justify-center"
                                                    disabled={processing}
                                                >
                                                    {processing ? "Processing..." : "Complete Registration"}
                                                </Button>
                                            </div>
                                        </form>
                                    </Card>
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
