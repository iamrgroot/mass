module.exports = {
    root: true,
    env: {
        node: true
    },
    extends: [
        'plugin:vue/essential',
        'plugin:vue/recommended',
        'eslint:recommended',
        '@vue/typescript/recommended'
    ],
    parserOptions: {
        ecmaVersion: 2020,
    },
    rules: {
        'no-console': process.env.NODE_ENV === 'production' ? 'error' : 'off',
        'no-debugger': process.env.NODE_ENV === 'production' ? 'error' : 'off',
        'vue/html-indent': ['error', 4],
        'camelcase': 'off',
        'quotes': ['error', 'single'],
        'semi': ['error', 'always'],
        'no-trailing-spaces': [process.env.NODE_ENV === 'production' ? 'error' : 'off'],
        'no-multi-spaces': ['error'],
        'keyword-spacing': ['error'],

        'vue/script-indent': ['error', 4],
        'vue/eqeqeq': ['error'],
        'vue/arrow-spacing': ['error'],
        'vue/no-deprecated-scope-attribute': ['error'],
        'vue/require-prop-types': ['error'],
        'vue/require-default-prop': ['error'],
        'vue/prop-name-casing': ['error', 'snake_case'],
        'vue/order-in-components': ['error'],
        'vue/component-tags-order': ['error', {
            'order': [ 'template', 'style', 'script' ]
        }],

        'no-empty-function': ['error'],
        'no-else-return': ['error'],
        'no-eval': ['error'],
        'no-var': ['error'],
        'no-alert': ['error'],

        '@typescript-eslint/explicit-module-boundary-types': ['error'],
        '@typescript-eslint/indent': ['error', 4],
        '@typescript-eslint/array-type': ['error', {default: 'array'}],
        '@typescript-eslint/explicit-function-return-type': ['off'],
        '@typescript-eslint/member-delimiter-style': ['error'],
        '@typescript-eslint/prefer-for-of': ['error'],
        // TODO check snake case rule?
        '@typescript-eslint/camelcase': ['off'],
        // TODO Fix error
        // '@typescript-eslint/no-confusing-non-null-assertion': ['error'],
        // '@typescript-eslint/no-unnecessary-boolean-literal-compare': ['error'],
        // '@typescript-eslint/prefer-nullish-coalescing': ['error'],
        // '@typescript-eslint/prefer-string-starts-ends-with': ['error'],

        'indent': ['off'],
    },
    'overrides': [
        {
            'files': ['*.ts', '*.tsx'],
            'rules': {
                '@typescript-eslint/explicit-function-return-type': ['error']
            }
        }
    ]
};
