import Button from "../../ui/Button";

export default function AuthButtons({ content = {} }) {
    return (
        <>
            <Button
                href={route("login")}
                variant="text"
                size="sm"
                className="hidden xl:inline-flex text-gray-900 hover:text-gray-700 hover:bg-black/5"
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
