<template>
    <NavBar />
    <div class="container">
        <Ahorros />
    </div>
    <div>
        <!-- <router-view></router-view> Solo sirve para hacer -->
    </div>
</template>

<script>
import Ahorros from './Ahorros.vue';
import NavBar from './NavBar.vue';

    export default {
        components: {
    NavBar,
    Ahorros
}
    }

</script>
<style>
.container{
    margin-top: 10px;
}


</style>

