<?php require('template/header.php'); ?>
    <title>Login</title>
    </head>
    <body>
        <div id="app">
			<v-app>
				<v-content>
					<v-layout align-center fill-height>
                        <v-container fluid>
                            <v-row align="center" justify="center">
                                <v-col cols="12" sm="8" md="4">
                                    <v-card class="elevation-12" :disabled="loading">
                                        <v-toolbar color="blue" flat>
                                            <v-toolbar-title>Login</v-toolbar-title>
                                            <v-spacer></v-spacer>
                                            <div>
                                                <v-avatar class="mr-n4"><v-icon>mdi-login-variant</v-icon></v-avatar>
                                            </div>
                                        </v-toolbar>
                                        <v-card-text>
                                            <v-form ref="form">
                                                <v-text-field
                                                    v-model="nomor"
                                                    v-on:keyup.enter="login"
                                                    label="NIP / NIM"
                                                    :rules='rules.nomor'
                                                ></v-text-field>
                                                <v-text-field
                                                    v-model="password"
                                                    v-on:keyup.enter="login"
                                                    label="Password"
                                                    :append-icon="showPassword ? 'mdi-eye' : 'mdi-eye-off'"
                                                    :type="showPassword ? 'text' : 'password'"
                                                    @click:append="showPassword = !showPassword"
                                                    :rules='rules.password'
                                                ></v-text-field>
                                            </v-form>
                                        </v-card-text>
                                        <v-card-actions>
                                            <v-btn text color="red" style="pointer-events: none" class="mt-n7 mb-2 mr-1">
                                                <span class="body-2">{{errorMessage}}</span>
                                            </v-btn>
                                            <v-spacer></v-spacer>
                                            <v-btn color="primary" class="mt-n7 mb-2 mr-1" @click="login">
                                                <span v-if="loading">
                                                    <v-progress-circular size="20" :indeterminate="loading"></v-progress-circular>
                                                </span>
                                                <span v-else class="body-2">Login</span>
                                            </v-btn>
                                        </v-card-actions>
                                    </v-card>
                                </v-col>
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

				data() {
					return {
						nomor:'',
                        password:'',
                        loading: false,
                        snackBar: false,
                        snackBarColor: '',
                        snackBarMessage: '',
                        errorMessage: '',
                        showPassword: false,
                        logInstatus: false,
                        rules: {
                            nomor: [
                                v => !!v || 'nomor Wajib diisi',
                                v => /^[0-9]*$/.test(v) || 'nomor Harus berupa angka'
                            ],
                            password: [
                                v => !!v || 'Password Wajib diisi',
                            ]
                        }
					}
				},

				methods: {
                    login() {
                        if(this.$refs.form.validate()) {
                            this.loading = true
                            const data = new FormData()
                            data.append('nomor',this.nomor)
                            data.append('password',this.password)

                            return new Promise((resolve, reject) => {
                                axios.post('<?= base_url()?>api/User_Login', data)
                                    .then(response => {
                                        resolve(response.data)
                                    }) .catch(err => {
                                        if(err.response.status == 500) reject('Server Error')
                                        if(err.response.status == 401) reject(err.response.data)
                                    })
                            })
                            .then((response) => {
                                console.log(response.message)
                                this.errorMessage = ''
                                this.logInstatus = true
                            }) .catch(err => {
                                if(err.message == "User Not Found" || err.message == "Incorrect Password") {
                                    this.errorMessage = err.message
                                } else {
                                    this.snackBarMessage = err
                                    this.snackBarColor = 'error'
                                    this.snackBar = true
                                }
                            }) .finally(() => {
                                if(this.logInstatus) {
                                    window.location.href = '<?=base_url('home');?>'
                                } else {
                                    this.loading = false
                                }
                                
                            })
                        }
                    }
				},
				
				computed: {
					login() {

                    }
				},

			})
		</script>
    </body>