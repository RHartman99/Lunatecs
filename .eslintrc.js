module.exports = {
  env: {
    browser: true
  },
  extends: ["airbnb-base", "plugin:prettier/recommended"],
  parser: "babel-eslint",
  rules: {
    radix: "off",
    "prefer-destructuring": "off",
    "consistent-return": "off",
    "class-methods-use-this": "off",
    "import/no-unresolved": "off",
    "import/no-self-import": "off",
    "import/no-extraneous-dependencies": "off",
    "import/order": "off",
    "import/named": "off",
    "import/no-duplicates": "off",
    "import/extensions": "off",
    "import/no-cycle": "off"
  }
};
