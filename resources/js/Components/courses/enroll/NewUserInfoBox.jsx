import { Info } from "lucide-react";

export default function NewUserInfoBox() {
    return (
        <div className="bg-blue-50 dark:bg-blue-900/20 border border-blue-200 dark:border-blue-800 rounded-lg p-4">
            <div className="flex items-start gap-3">
                <Info className="w-5 h-5 text-blue-600 dark:text-blue-400 mt-0.5 shrink-0" />
                <div className="text-sm text-blue-800 dark:text-blue-200">
                    <p className="font-semibold mb-1">New Account Creation</p>
                    <p>
                        We'll automatically create an account for you and send
                        your login credentials to the email address provided
                        above. Make sure to check your inbox (and spam folder)
                        after registration.
                    </p>
                </div>
            </div>
        </div>
    );
}

