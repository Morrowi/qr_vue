<template>
  <div id="app">
    <Header/>
    <MainPage />
    <Footer/>
  </div>
</template>

<script>
import Header from './components/Header.vue'
import MainPage from './components/MainPage.vue'
import Footer from './components/Footer'

export default {
  name: 'App',
  components: {
    Header,
    MainPage,
    Footer
  }
}
</script>

