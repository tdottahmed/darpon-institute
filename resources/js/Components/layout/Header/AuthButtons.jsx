import PrimaryButton from "../../ui/PrimaryButton";
import SecondaryButton from "../../ui/SecondaryButton";

export default function AuthButtons({ content = {} }) {
    return (
        <div className="flex items-center gap-3">
            <SecondaryButton
                href={route("login")}
                className="hidden xl:inline-flex bg-transparent border-none shadow-none text-[var(--header-footer-text-light)] dark:text-[var(--header-footer-text-dark)] hover:opacity-80 hover:bg-black/5 dark:hover:bg-white/5 pl-4 pr-4 py-2"
                showIcon={false}
            >
                {content.auth_login || "Log in"}
            </SecondaryButton>
            <PrimaryButton
                href={route("register")}
                className="pl-5 pr-1 py-2 sm:pl-6 sm:pr-2 sm:py-2.5"
            >
                {content.auth_register || "Get Started"}
            </PrimaryButton>
        </div>
    );
}
