<script>
    var routes = [
        { path: '/', component: '../login.php' },
        { path: '/home', component: '../home.php' }
    ]

    var router = new VueRouter({
        routes: routes,
        mode: 'history',
        base: '/'
    })
</script>