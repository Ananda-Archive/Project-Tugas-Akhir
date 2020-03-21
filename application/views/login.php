<?php require('template/header.php'); ?>

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
                                            <v-form>
                                                <v-text-field
                                                    v-model="nim"
                                                    v-on:keyup.enter="login"
                                                    label="NIM"
                                                    :rules='rules.nim'
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
                                            <v-spacer></v-spacer>
                                            <v-btn color="primary" class="mt-n7 mb-2 mr-1" @click="login">
                                                <span v-if="loading">
                                                    <v-progress-circular size="20" :indeterminate="{loading}"></v-progress-circular>
                                                </span>
                                                <span v-else class="body-2">Login</span>
                                            </v-btn>
                                        </v-card-actions>
                                    </v-card>
                                </v-col>
                            </v-row>
                        </v-container>
                    </v-layout>
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
                        apiEndPoint:'http://localhost:8000/',
						nim:'',
                        password:'',
                        loading: false,
                        snackBar: false,
                        snackBarColor: '',
                        snackBarMessage: '',
                        showPassword: false,
                        rules: {
                            nim: [
                                v => !!v || 'NIM Wajib diisi',
                                v => /^[0-9]*$/.test(v) || 'NIM Harus berupa angka'
                            ],
                            password: [
                                v => !!v || 'Password Wajib diisi',
                            ]
                        }
					}
				},

				methods: {
                    login() {
                        this.loading = true
                        const data = new FormData()
                        data.append('nim',this.nim)
                        data.append('password',this.password)

                        return new Promise((resolve, reject) => {
                            axios.post('http://localhost:8000/api/User', data)
                                .then(response => {
                                    (response.data.status) ? resolve(response.data) : reject("NIM atau Password Salah")
                                }) .catch(err => {
                                    console.log(err)
                                    reject('Sistem Error')
                                })
                        })
                        // .then((response) => {
                        //     if(response.status)
                        // })
                    }
				},
				
				computed: {
					login() {

                    }
				},

			})
		</script>
    </body>