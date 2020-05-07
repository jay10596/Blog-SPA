module.exports = {
  theme: {
    extend: {
      width: {
        '96': '24rem'
      },
      height: {
        '80': '20rem'
      },
      fontSize: {
        '11xl': '9rem',
      }
    }
  },
  variants: {},
  plugins: [
    require('@tailwindcss/custom-forms')
  ]
}
