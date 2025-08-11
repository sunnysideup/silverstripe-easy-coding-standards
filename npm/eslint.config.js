// ~/.config/eslint-security/eslint.config.js
import js from '@eslint/js';
import pluginSecurity from 'eslint-plugin-security';
import pluginSecurityNode from 'eslint-plugin-security-node';
import pluginNoSecrets from 'eslint-plugin-no-secrets';

export default [
  js.configs.recommended,
  {
    plugins: {
      security: pluginSecurity,
      'security-node': pluginSecurityNode,
      'no-secrets': pluginNoSecrets
    },
    rules: {
      ...pluginSecurity.configs.recommended.rules,
      ...pluginSecurityNode.configs.recommended.rules,
      'no-secrets/no-secrets': 'error'
    }
  }
];
