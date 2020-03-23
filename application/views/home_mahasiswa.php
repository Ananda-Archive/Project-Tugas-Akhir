<?php require('template/header.php'); ?>
    <title>Home</title>
    </head>
	<body>
		<div id="app">
			<v-app>
				<?php require('template/navbar.php') ?>
				<v-content>
					<v-layout fill-height>
                        <v-container  fluid>
                            <v-row justify="center">
                                <v-avatar color="#2196F3" disabled size="200" class="mt-8"><span class="white--text display-4"><?=$nama[0]?></span></v-avatar>
                            </v-row>
                        </v-container>
                    </v-layout>
					<v-snackbar
                        v-model="snackBar"
                        multi-line
                        v-bind:color="snackBarColor"
                    >
                        {{ snackBarMessage }}
                        <v-btn
                            text
                            @click="snackBar = false"
                        >
                            <v-icon>
                                mdi-close
                            </v-icon>
                        </v-btn>
                    </v-snackbar>
				</v-content>
			</v-app>
		</div>

		<script>
			new Vue({
				el: '#app',
				vuetify: new Vuetify(),

				created() { 
					this.$vuetify.theme.dark = true
				},

				// mounted() {
				// 	this.get()
				// },

				data() {
					return {
						snackBar: false,
                        snackBarColor: '',
                        snackBarMessage: '',
					}
				},

				methods: {
				},
				
				computed: {
					//view Breakpoint
                    popUpBreakPoint() {
                        if (this.$vuetify.breakpoint.name == 'xs') {
                            return true
                        } else {
                            return false
                        }
                    },
				},

			})
		</script>
	</body>

</html>
