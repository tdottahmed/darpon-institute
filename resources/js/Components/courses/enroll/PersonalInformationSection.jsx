import { useState } from "react";
import { User, Mail, Info } from "lucide-react";
import TextInput from "@/Components/TextInput";
import InputLabel from "@/Components/InputLabel";
import InputError from "@/Components/InputError";

// Formats digits-only string as 01X XXXX XXXX
function formatBDPhone(digits) {
    const d = digits.replace(/\D/g, "").slice(0, 11);
    if (d.length <= 3) return d;
    if (d.length <= 7) return `${d.slice(0, 3)} ${d.slice(3)}`;
    return `${d.slice(0, 3)} ${d.slice(3, 7)} ${d.slice(7)}`;
}

function validateBDPhone(digits) {
    const d = digits.replace(/\D/g, "");
    if (!d) return "Phone number is required";
    if (d.length !== 11) return "Must be 11 digits (e.g. 017XX XXXXXX)";
    if (!/^01[3-9]\d{8}$/.test(d)) return "Enter a valid BD mobile number";
    return "";
}

export default function PersonalInformationSection({
    data,
    setData,
    errors,
    emailError,
    validateEmail,
    auth,
}) {
    const [phoneDisplay, setPhoneDisplay] = useState(
        data.phone ? formatBDPhone(data.phone.replace(/^\+880/, "0")) : ""
    );
    const [phoneError, setPhoneError] = useState("");

    const handlePhoneChange = (e) => {
        const raw = e.target.value.replace(/\D/g, "").slice(0, 11);
        const formatted = formatBDPhone(raw);
        setPhoneDisplay(formatted);
        // Store full international number in form data
        const intl = raw.length >= 2 && raw.startsWith("0")
            ? "+880" + raw.slice(1)
            : raw ? "+880" + raw : "";
        setData("phone", intl || raw);
        if (phoneError) setPhoneError(validateBDPhone(raw));
    };

    const handlePhoneBlur = () => {
        const raw = phoneDisplay.replace(/\D/g, "");
        setPhoneError(validateBDPhone(raw));
    };

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

            {/* Email Field */}
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

            {/* Phone + Address */}
            <div className="grid gap-6 sm:grid-cols-2">
                {/* Phone with BD prefix */}
                <div>
                    <InputLabel
                        htmlFor="phone"
                        value="Phone Number *"
                        className="text-base font-semibold mb-2"
                    />
                    <div className="mt-2 flex rounded-lg shadow-sm overflow-hidden border border-gray-200 dark:border-gray-700 focus-within:ring-2 focus-within:ring-primary-500 focus-within:border-primary-500 transition-all">
                        {/* Country prefix */}
                        <div className="flex items-center gap-1.5 px-3 bg-gray-100 dark:bg-gray-700 border-r border-gray-200 dark:border-gray-600 shrink-0 select-none">
                            <span className="text-base leading-none">🇧🇩</span>
                            <span className="text-sm font-semibold text-gray-700 dark:text-gray-200">+880</span>
                        </div>
                        <input
                            id="phone"
                            type="tel"
                            inputMode="numeric"
                            className="flex-1 py-3 px-3 bg-gray-50 dark:bg-gray-800 text-gray-900 dark:text-white placeholder-gray-400 focus:outline-none text-sm"
                            value={phoneDisplay}
                            onChange={handlePhoneChange}
                            onBlur={handlePhoneBlur}
                            required
                            placeholder="01X XXXX XXXX"
                            maxLength={14}
                        />
                    </div>
                    {(errors.phone || phoneError) ? (
                        <InputError message={errors.phone || phoneError} className="mt-2" />
                    ) : (
                        <p className="mt-1.5 text-xs text-gray-400 dark:text-gray-500">
                            Enter your 11-digit Bangladeshi number
                        </p>
                    )}
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

