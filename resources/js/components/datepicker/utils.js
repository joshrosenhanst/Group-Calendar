export const checkMobile = {
  Android: function () {
      return (
          typeof window !== 'undefined' &&
          window.navigator.userAgent.match(/Android/i)
      )
  },
  BlackBerry: function () {
      return (
          typeof window !== 'undefined' &&
          window.navigator.userAgent.match(/BlackBerry/i)
      )
  },
  iOS: function () {
      return (
          typeof window !== 'undefined' &&
          window.navigator.userAgent.match(/iPhone|iPad|iPod/i)
      )
  },
  Opera: function () {
      return (
          typeof window !== 'undefined' &&
          window.navigator.userAgent.match(/Opera Mini/i)
      )
  },
  Windows: function () {
      return (
          typeof window !== 'undefined' &&
          window.navigator.userAgent.match(/IEMobile/i)
      )
  },
  any: function () {
    return (
        checkMobile.Android() ||
        checkMobile.BlackBerry() ||
        checkMobile.iOS() ||
        checkMobile.Opera() ||
        checkMobile.Windows()
    )
  }
}