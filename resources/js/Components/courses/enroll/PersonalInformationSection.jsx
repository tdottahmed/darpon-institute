import { User, Mail, Phone, Info } from "lucide-react";
import TextInput from "@/Components/TextInput";
import InputLabel from "@/Components/InputLabel";
import InputError from "@/Components/InputError";

export default function PersonalInformationSection({
    data,
    setData,
    errors,
    emailError,
    validateEmail,
    auth,
}) {
    return (
        <div className="space-y-6 border-b border-gray-200 dark:border-gray-700 pb-6">
            <h3 className="text-lg font-bold text-gray-900 dark:text-white flex items-center gap-2">
                <User className="w-5 h-5 text-primary-600" />
                Personal Information
            </h3>

            {/* Name Field */}
            <div>
                <InputLabel
                    htmlFor="name"
                    value="Full Name *"
                    className="text-base font-semibold mb-2"
                />
                <TextInput
                    id="name"
                    type="text"
                    className="mt-2 block w-full py-3 px-4 bg-gray-50 dark:bg-gray-800 border-gray-200 dark:border-gray-700 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition-all"
                    value={data.name}
                    onChange={(e) => setData("name", e.target.value)}
                    required
                    autoFocus
                    placeholder="e.g. Tanbir Ahmed"
                />
                <InputError message={errors.name} className="mt-2" />
            </div>

            {/* Email Field - Mandatory */}
            <div>
                <InputLabel
                    htmlFor="email"
                    value="Email Address *"
                    className="text-base font-semibold mb-2"
                >
                    Email Address *
                    {!auth?.user && (
                        <span className="ml-2 text-xs font-normal text-gray-500 dark:text-gray-400">
                            (We'll send your login credentials here)
                        </span>
                    )}
                </InputLabel>
                <div className="relative">
                    <div className="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <Mail className="h-5 w-5 text-gray-400" />
                    </div>
                    <TextInput
                        id="email"
                        type="email"
                        className="mt-2 block w-full py-3 pl-10 pr-4 bg-gray-50 dark:bg-gray-800 border-gray-200 dark:border-gray-700 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition-all"
                        value={data.email}
                        onChange={(e) => {
                            setData("email", e.target.value);
                            if (emailError) validateEmail(e.target.value);
                        }}
                        onBlur={() => validateEmail(data.email)}
                        required
                        placeholder="you@email.com"
                    />
                </div>
                {(errors.email || emailError) && (
                    <InputError
                        message={errors.email || emailError}
                        className="mt-2"
                    />
                )}
                {!auth?.user && !emailError && (
                    <p className="mt-2 text-sm text-gray-500 dark:text-gray-400 flex items-center gap-1">
                        <Info className="w-4 h-4" />
                        Your account credentials will be sent to this email
                    </p>
                )}
            </div>

            {/* Phone Field */}
            <div className="grid gap-6 sm:grid-cols-2">
                <div>
                    <InputLabel
                        htmlFor="phone"
                        value="Phone Number *"
                        className="text-base font-semibold mb-2"
                    />
                    <div className="relative">
                        <div className="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <Phone className="h-5 w-5 text-gray-400" />
                        </div>
                        <TextInput
                            id="phone"
                            type="tel"
                            className="mt-2 block w-full py-3 pl-10 pr-4 bg-gray-50 dark:bg-gray-800 border-gray-200 dark:border-gray-700 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition-all"
                            value={data.phone}
                            onChange={(e) => setData("phone", e.target.value)}
                            required
                            placeholder="+880 1XXX XXXXXX"
                        />
                    </div>
                    <InputError message={errors.phone} className="mt-2" />
                </div>

                <div>
                    <InputLabel
                        htmlFor="address"
                        value="Address *"
                        className="text-base font-semibold mb-2"
                    />
                    <textarea
                        id="address"
                        className="mt-2 block w-full rounded-lg border-gray-200 bg-gray-50 dark:bg-gray-800 shadow-sm focus:border-primary-500 focus:ring-primary-500 dark:border-gray-700 dark:text-gray-300 dark:focus:border-primary-600 dark:focus:ring-primary-600 py-3 px-4 min-h-[100px] resize-none"
                        rows="3"
                        value={data.address}
                        onChange={(e) => setData("address", e.target.value)}
                        required
                        placeholder="Street, Area, City"
                    />
                    <InputError message={errors.address} className="mt-2" />
                </div>
            </div>
        </div>
    );
}

