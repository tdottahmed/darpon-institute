import { Link, usePage } from "@inertiajs/react";
import Avatar from "../../ui/Avatar";
import Dropdown from "../../Dropdown";

export default function UserMenu({ content = {} }) {
    const { auth } = usePage().props;
    const user = auth?.user;

    if (!user) {
        return null;
    }

    return (
        <div className="relative">
            <Dropdown>
                <Dropdown.Trigger>
                    <button
                        type="button"
                        className="flex items-center space-x-2 rounded-lg px-3 py-2 hover:bg-black/5 transition-colors focus:outline-none focus:ring-2 focus:ring-primary-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800"
                    >
                        <Avatar name={user.name} email={user.email} size="sm" />
                        <div className="hidden xl:block text-left">
                            <p className="text-sm font-medium text-[var(--header-footer-text-light)] dark:text-[var(--header-footer-text-dark)]">
                                {user.name}
                            </p>
                        </div>
                    </button>
                </Dropdown.Trigger>

                <Dropdown.Content align="right" width="56">
                    <div className="px-4 py-3 border-b border-gray-200 dark:border-gray-700 xl:hidden">
                        <p className="text-sm font-medium text-[var(--header-footer-text-light)] dark:text-[var(--header-footer-text-dark)]">
                            {user.name}
                        </p>
                        <p className="text-xs text-gray-500 dark:text-gray-400 truncate">
                            {user.email}
                        </p>
                    </div>
                    {user.user_type === "admin" && (
                        <>
                            <div className="border-t border-gray-200 dark:border-gray-700"></div>
                            <Dropdown.ExternalLink
                                href={route("admin.dashboard")}
                            >
                                Admin Dashboard
                            </Dropdown.ExternalLink>
                        </>
                    )}
                    <Dropdown.Link href={route("dashboard")}>
                        {content.auth_dashboard || "Dashboard"}
                    </Dropdown.Link>
                    <Dropdown.Link href={route("profile.edit")}>
                        {content.auth_profile || "Profile"}
                    </Dropdown.Link>
                    <div className="border-t border-gray-200 dark:border-gray-700"></div>
                    <Dropdown.Link
                        href={route("logout")}
                        method="post"
                        as="button"
                        className="text-red-600 dark:text-red-400 hover:bg-red-50 dark:hover:bg-red-900/20"
                    >
                        {content.auth_logout || "Log Out"}
                    </Dropdown.Link>
                </Dropdown.Content>
            </Dropdown>
        </div>
    );
}
