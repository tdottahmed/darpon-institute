import Button from "../../ui/Button";

export default function AuthButtons({ content = {} }) {
    return (
        <>
            <Button
                href={route("login")}
                variant="text"
                size="sm"
                className="hidden xl:inline-flex"
            >
                {content.auth_login || "Log in"}
            </Button>
            <Button href={route("register")} variant="primary" size="sm">
                {content.auth_register || "Get Started"}
            </Button>
        </>
    );
}
