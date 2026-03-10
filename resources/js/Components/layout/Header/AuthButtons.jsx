import Button from "../../ui/Button";

export default function AuthButtons({ content = {} }) {
    return (
        <>
            <Button
                href={route("login")}
                variant="text"
                size="sm"
                className="hidden xl:inline-flex text-[var(--header-footer-text-light)] dark:text-[var(--header-footer-text-dark)] hover:opacity-80 hover:bg-black/5"
            >
                {content.auth_login || "Log in"}
            </Button>
            <Button
                href={route("register")}
                size="sm"
                className="bg-gray-900 text-white hover:bg-gray-800 border-none"
            >
                {content.auth_register || "Get Started"}
            </Button>
        </>
    );
}
