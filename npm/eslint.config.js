import js from '@eslint/js'
import globals from 'globals'
import security from 'eslint-plugin-security'
import securityNode from 'eslint-plugin-security-node'
import noSecrets from 'eslint-plugin-no-secrets'

export default [
  js.configs.recommended,
  {
    languageOptions: {
      globals: {
        ...globals.browser, // for window, document, setTimeout
        ...globals.node, // for require, module, process
        jQuery: 'readonly',
        $: 'readonly'
      }
    },
    plugins: {
      security,
      'security-node': securityNode,
      'no-secrets': noSecrets
    },
    rules: {
      ...security.configs.recommended.rules,
      ...securityNode.configs.recommended.rules,
      'no-secrets/no-secrets': 'error'
    },
    ignores: ['vendor/**', 'node_modules/**']
  }
]
