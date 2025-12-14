import { Head, useForm, usePage } from "@inertiajs/react";
import Header from "@/Components/layout/Header";
import Footer from "@/Components/layout/Footer";
import Container from "@/Components/ui/Container";
import Button from "@/Components/ui/Button";
import Card from "@/Components/ui/Card";
import TextInput from "@/Components/TextInput";
import InputLabel from "@/Components/InputLabel";
import InputError from "@/Components/InputError";
import { useState, useEffect } from "react";

export default function Checkout({ book }) {
    const { data, setData, post, processing, errors } = useForm({
        name: "",
        email: "",
        phone: "",
        address: "",
        quantity: 1,
        shipping_method: "inside_dhaka",
        note: "",
    });

    const [shippingCost, setShippingCost] = useState(60);
    
    // Calculate price (handling discount if exists)
    const price = book.discount > 0 
        ? book.price - (book.price * (book.discount / 100)) 
        : book.price;

    const [total, setTotal] = useState(price + shippingCost);

    useEffect(() => {
        const cost = data.shipping_method === 'inside_dhaka' ? 60 : 120;
        setShippingCost(cost);
        setTotal((price * data.quantity) + cost);
    }, [data.shipping_method, data.quantity, price]);

    const submit = (e) => {
        e.preventDefault();
        post(route("books.checkout.store", book.slug));
    };

    return (
        <>
            <Head title={`Checkout - ${book.title}`} />
            <div className="min-h-screen bg-gray-50 dark:bg-gray-900 font-sans text-gray-900 dark:text-gray-100">
                <Header />

                <main className="pt-24 pb-16">
                    <Container>
                        <form onSubmit={submit} className="grid gap-8 lg:grid-cols-3">
                            {/* Left Column: Shipping & Details */}
                            <div className="lg:col-span-2 space-y-6">
                                <Card variant="elevated" className="p-6 sm:p-8">
                                    <h2 className="text-xl font-bold text-gray-900 dark:text-white mb-6">
                                        Shipping Information
                                    </h2>

                                    <div className="space-y-6">
                                        {/* Name & Phone */}
                                        <div className="grid gap-6 sm:grid-cols-2">
                                            <div>
                                                <InputLabel htmlFor="name" value="Full Name" />
                                                <TextInput
                                                    id="name"
                                                    type="text"
                                                    className="mt-1 block w-full"
                                                    value={data.name}
                                                    onChange={(e) => setData("name", e.target.value)}
                                                    required
                                                />
                                                <InputError message={errors.name} className="mt-2" />
                                            </div>
                                            <div>
                                                <InputLabel htmlFor="phone" value="Phone Number" />
                                                <TextInput
                                                    id="phone"
                                                    type="tel"
                                                    className="mt-1 block w-full"
                                                    value={data.phone}
                                                    onChange={(e) => setData("phone", e.target.value)}
                                                    required
                                                />
                                                <InputError message={errors.phone} className="mt-2" />
                                            </div>
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
                                            />
                                            <InputError message={errors.email} className="mt-2" />
                                        </div>

                                        {/* Address */}
                                        <div>
                                            <InputLabel htmlFor="address" value="Delivery Address" />
                                            <textarea
                                                id="address"
                                                className="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 dark:focus:border-primary-600 dark:focus:ring-primary-600"
                                                rows="3"
                                                value={data.address}
                                                onChange={(e) => setData("address", e.target.value)}
                                                required
                                                placeholder="House, Road, Area, City"
                                            />
                                            <InputError message={errors.address} className="mt-2" />
                                        </div>

                                        {/* Shipping Method */}
                                        <div>
                                            <InputLabel value="Shipping Area" className="mb-2" />
                                            <div className="grid gap-4 sm:grid-cols-2">
                                                <label className={`relative flex cursor-pointer rounded-lg border p-4 shadow-sm focus:outline-none ${data.shipping_method === 'inside_dhaka' ? 'border-primary-500 ring-2 ring-primary-500' : 'border-gray-300 dark:border-gray-700'}`}>
                                                    <input 
                                                        type="radio" 
                                                        name="shipping_method" 
                                                        value="inside_dhaka" 
                                                        className="sr-only" 
                                                        checked={data.shipping_method === 'inside_dhaka'}
                                                        onChange={(e) => setData("shipping_method", e.target.value)}
                                                    />
                                                    <span className="flex flex-1">
                                                        <span className="flex flex-col">
                                                            <span className="block text-sm font-medium text-gray-900 dark:text-white">Inside Dhaka</span>
                                                            <span className="mt-1 flex items-center text-sm text-gray-500 dark:text-gray-400">2-3 Days Delivery</span>
                                                        </span>
                                                    </span>
                                                    <span className="mt-0.5 ml-4 flex cursor-pointer flex-col">
                                                        <span className="text-sm font-medium text-primary-600 dark:text-primary-400">৳60</span>
                                                    </span>
                                                </label>

                                                <label className={`relative flex cursor-pointer rounded-lg border p-4 shadow-sm focus:outline-none ${data.shipping_method === 'outside_dhaka' ? 'border-primary-500 ring-2 ring-primary-500' : 'border-gray-300 dark:border-gray-700'}`}>
                                                    <input 
                                                        type="radio" 
                                                        name="shipping_method" 
                                                        value="outside_dhaka" 
                                                        className="sr-only"
                                                        checked={data.shipping_method === 'outside_dhaka'}
                                                        onChange={(e) => setData("shipping_method", e.target.value)}
                                                    />
                                                    <span className="flex flex-1">
                                                        <span className="flex flex-col">
                                                            <span className="block text-sm font-medium text-gray-900 dark:text-white">Outside Dhaka</span>
                                                            <span className="mt-1 flex items-center text-sm text-gray-500 dark:text-gray-400">3-5 Days Delivery</span>
                                                        </span>
                                                    </span>
                                                    <span className="mt-0.5 ml-4 flex cursor-pointer flex-col">
                                                        <span className="text-sm font-medium text-primary-600 dark:text-primary-400">৳120</span>
                                                    </span>
                                                </label>
                                            </div>
                                        </div>

                                        {/* Note */}
                                        <div>
                                            <InputLabel htmlFor="note" value="Order Note (Optional)" />
                                            <TextInput
                                                id="note"
                                                type="text"
                                                className="mt-1 block w-full"
                                                value={data.note}
                                                onChange={(e) => setData("note", e.target.value)}
                                            />
                                        </div>
                                    </div>
                                </Card>
                            </div>

                            {/* Right Column: Order Summary */}
                            <div className="lg:col-span-1">
                                <div className="sticky top-24 space-y-6">
                                    <Card variant="elevated" className="p-6">
                                        <h2 className="text-lg font-bold text-gray-900 dark:text-white mb-4">
                                            Order Summary
                                        </h2>
                                        
                                        {/* Product Info */}
                                        <div className="flex gap-4 mb-4 pb-4 border-b border-gray-100 dark:border-gray-700">
                                            <div className="h-16 w-12 flex-shrink-0 overflow-hidden rounded-md border border-gray-200 dark:border-gray-700">
                                                {book.cover_image ? (
                                                    <img 
                                                        src={`/storage/${book.cover_image}`} 
                                                        alt={book.title} 
                                                        className="h-full w-full object-cover object-center"
                                                    />
                                                ) : (
                                                    <div className="flex h-full w-full items-center justify-center bg-gray-100 text-xs">No Img</div>
                                                )}
                                            </div>
                                            <div className="flex flex-1 flex-col">
                                                 <div>
                                                    <div className="flex justify-between text-base font-medium text-gray-900 dark:text-white">
                                                        <h3 className="line-clamp-1">{book.title}</h3>
                                                        <p className="ml-4">৳{price}</p>
                                                    </div>
                                                </div>
                                                <div className="flex flex-1 items-end justify-between text-sm">
                                                    <p className="text-gray-500 dark:text-gray-400">Qty {data.quantity}</p>
                                                </div>
                                            </div>
                                        </div>

                                        {/* Calculations */}
                                        <div className="space-y-2">
                                            <div className="flex justify-between text-sm text-gray-600 dark:text-gray-400">
                                                <p>Subtotal</p>
                                                <p>৳{price * data.quantity}</p>
                                            </div>
                                            <div className="flex justify-between text-sm text-gray-600 dark:text-gray-400">
                                                <p>Shipping</p>
                                                <p>৳{shippingCost}</p>
                                            </div>
                                            <div className="border-t border-gray-100 dark:border-gray-700 pt-2 flex justify-between text-base font-bold text-gray-900 dark:text-white">
                                                <p>Total</p>
                                                <p>৳{total}</p>
                                            </div>
                                        </div>

                                        {/* Payment Method Info */}
                                        <div className="mt-6 rounded-md bg-gray-50 dark:bg-gray-800 p-4">
                                            <div className="flex items-center">
                                                <svg className="h-5 w-5 text-primary-600 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z" />
                                                </svg>
                                                <span className="text-sm font-medium text-gray-900 dark:text-white">Cash on Delivery</span>
                                            </div>
                                            <p className="mt-1 text-xs text-gray-500 dark:text-gray-400 ml-7">
                                                Pay comfortably when you receive your order.
                                            </p>
                                        </div>

                                        <Button
                                            variant="primary"
                                            size="lg"
                                            className="w-full mt-6 justify-center"
                                            disabled={processing}
                                        >
                                            {processing ? "Placing Order..." : "Confirm Order"}
                                        </Button>
                                    </Card>
                                </div>
                            </div>
                        </form>
                    </Container>
                </main>
                <Footer />
            </div>
        </>
    );
}
