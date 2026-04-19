import forms from "@tailwindcss/forms";

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        "./vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php",
        "./storage/framework/views/*.php",
        "./resources/views/**/*.blade.php",
        "./resources/js/**/*.jsx",
    ],

    darkMode: "class",

    theme: {
        extend: {
            fontFamily: {
                sans: [
                    '"Times New Roman"',
                    "Times",
                    "Georgia",
                    "serif",
                ],
                bengali: [
                    "SutonnyMJ",
                    "SolaimanLipi",
                    "Kalpurush",
                    "sans-serif",
                ],
            },
            colors: {
                primary: {
                    50: "#F5F4FD",
                    100: "#EBE8FB",
                    200: "#D7D1F7",
                    300: "#C3BAF3",
                    400: "#AFA3EF",
                    500: "#9B8CEB",
                    600: "#4E56C0",
                    700: "#3D4399",
                    800: "#2C3072",
                    900: "#1B1D4C",
                    DEFAULT: "#4E56C0",
                },
                secondary: {
                    50: "#F5EDFC",
                    100: "#EBDBF9",
                    200: "#D7B7F3",
                    300: "#C393ED",
                    400: "#AF6FE7",
                    500: "#9B5DE0",
                    600: "#7C4AB3",
                    700: "#5D3786",
                    800: "#3E2459",
                    900: "#1F122C",
                    DEFAULT: "#9B5DE0",
                },
                accent: {
                    50: "#FBF4FC",
                    100: "#F7E9F9",
                    200: "#EFD3F3",
                    300: "#E7BDED",
                    400: "#DFA7E7",
                    500: "#D78FEE",
                    600: "#AC72BE",
                    700: "#81558F",
                    800: "#56385F",
                    900: "#2B1B30",
                    DEFAULT: "#D78FEE",
                },
                light: {
                    50: "#FFF5FE",
                    100: "#FFEBFD",
                    200: "#FFD7FB",
                    300: "#FEC3F9",
                    400: "#FEAFD7",
                    500: "#FDCFFA",
                    600: "#CAA5C8",
                    700: "#977B96",
                    800: "#655264",
                    900: "#322932",
                    DEFAULT: "#FDCFFA",
                },
            },
        },
    },

    plugins: [forms],
};
