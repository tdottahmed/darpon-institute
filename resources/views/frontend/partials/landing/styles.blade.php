<style>
  :root {
    --primary-color: #1a237e;
    --secondary-color: #1565c0;
    --accent-color: #ff9800;
    --light-bg: #f5f5f5;
    --dark-text: #212121;
    --light-text: #ffffff;
    --section-bg: #e3f2fd;
  }

  /* html, body {
    font-family: 'SutonnyMJ'
  } */

  body {
    color: var(--dark-text);
    margin: 0;
    padding: 0;
  }

  /* h1, h2, h3, h4, h5, h6, p, span, a, li, td, th, label, button, input, textarea {
    font-family: 'SutonnyMJ'
  }

  .bengali-text {
    font-family: 'SutonnyMJ'
    letter-spacing: 0;
    text-rendering: optimizeLegibility;
    -webkit-font-smoothing: antialiased;
  } */

  h1 {
    font-size: 2.5rem;
  }

  h2 {
    font-size: 2rem;
  }

  h3 {
    font-size: 1.5rem;
  }

  /* Consistent Container System */
  .container {
    max-width: 1200px;
    width: 100%;
    margin: 0 auto;
    padding: 0 20px;
  }

  .container-narrow {
    max-width: 900px;
    width: 100%;
    margin: 0 auto;
    padding: 0 20px;
  }

  .container-wide {
    max-width: 1400px;
    width: 100%;
    margin: 0 auto;
    padding: 0 20px;
  }

  /* Consistent Section Spacing */
  .section {
    padding: 60px 20px;
  }

  .section-sm {
    padding: 10px 20px;
  }

  .section-lg {
    padding: 80px 20px;
  }

  @media (max-width: 768px) {
    h1 {
      font-size: 1.8rem;
    }

    h2 {
      font-size: 1.5rem;
    }

    .container,
    .container-narrow,
    .container-wide {
      padding: 0 15px;
    }

    .section {
      padding: 40px 15px;
    }

    .section-lg {
      padding: 50px 15px;
    }
  }
</style>
