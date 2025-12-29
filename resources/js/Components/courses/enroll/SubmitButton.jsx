import { Loader2, CheckCircle2 } from "lucide-react";
import Button from "@/Components/ui/Button";

export default function SubmitButton({ processing, emailError }) {
    return (
        <div className="pt-6">
            <Button
                type="submit"
                variant="primary"
                size="xl"
                className="w-full justify-center text-lg font-bold py-4 shadow-xl shadow-primary-500/30 hover:shadow-primary-500/50 hover:-translate-y-1 transition-all duration-300"
                disabled={processing || !!emailError}
            >
                {processing ? (
                    <span className="flex items-center gap-2">
                        <Loader2 className="animate-spin h-5 w-5 text-white" />
                        Processing...
                    </span>
                ) : (
                    <>
                        <CheckCircle2 className="w-5 h-5 mr-2" />
                        Complete Registration
                    </>
                )}
            </Button>
            <p className="mt-4 text-center text-sm text-gray-500 dark:text-gray-400">
                By clicking "Complete Registration", you agree to our Terms of
                Service and Privacy Policy.
            </p>
        </div>
    );
}

