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
    ecmaVersion: 2020
  },
  parser: 'vue-eslint-parser',
  plugins: [
    'vue',
  ],
  rules: {
    'no-console': process.env.NODE_ENV === 'production' ? 'warn' : 'off',
    'no-debugger': process.env.NODE_ENV === 'production' ? 'warn' : 'off',
    'vue/html-indent': ['error', 4],
    'camelcase': 'off',
    '@typescript-eslint/camelcase': 'off',
    '@typescript-eslint/ban-ts-ignore': 'off',
    'quotes': ['error', 'single'],
    'semi': ['error', 'always'],
    'no-trailing-spaces': ['error'],
    'no-multi-spaces': ['error'],
    'keyword-spacing': ['error'],
    'vue/html-indent': ['error', 4],
    'vue/script-indent': ['error', 4],
    'vue/eqeqeq': ['error'],
    'vue/arrow-spacing': ['error'],
    'vue/no-deprecated-scope-attribute': ['error'],
    'vue/require-prop-types': ['error'],
    'vue/require-default-prop': ['error'],
    'vue/prop-name-casing': ['error', 'snake_case'],
    'vue/order-in-components': ['error'],
    'no-console': ['error'],
    'no-empty-function': ['error'],
    'no-else-return': ['error'],
    'no-eval': ['error'],
    'no-var': ['error'],
    'no-alert': ['error'],

    'no-undef': ['off'],
    'indent': ['off'],
    'vue/no-v-html': ['off']

  }
}
