module.exports = {
    purge: {
        mode: 'all',
        preserveHtmlElements: false,
        content: [
            './resources/**/*.blade.php',
            './resources/**/**/*.blade.php',
            './resources/**/**/**/*.blade.php',
            './resources/**/**/**/**/*.blade.php',
        ]
    },
    darkMode: false, // or 'media' or 'class'
    theme: {
        screens: {
            'xsm': '350px',
            'sm': '500px',
            'md': '750px',
            'lg': '920px',
            'xl': '1200px',
            'xxl': '1450px'
        },
        extend: {},
    },
    variants: {
        extend: {},
    },
    plugins: [],
}
