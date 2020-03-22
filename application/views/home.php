<?php require('template/header.php'); ?>
    <title>Home</title>
    </head>
	<body>
		<div id="app">
			<v-app>
				<?php require('template/navbar.php') ?>
				<v-content>
					<v-layout fill-height>
                        <v-container fluid>
                            <v-row align="center">
								<v-col cols="12" sm="12" md="3">
                                    <v-card @click="createNewUserPopUp" class="elevation-12 align-center" color="blue" min-height="230" max-height="230">
                                        <div class="d-flex flex-no-wrap justify-space-between">
											<div>
												<v-card-title class="font-weight-light">CREATE NEW USER</v-card-title>
											</div>
											<div>
												<v-card-title class="font-weight-light"><v-icon>mdi-account</v-icon></v-card-title>
											</div>
										</div>
										<v-card-title class="justify-center"><v-icon class="display-4">mdi-account-plus</v-icon></v-card-title>
                                    </v-card>
                                </v-col>
								<v-dialog v-model="createNewUserDialog" persistent max-width="700px">
									<v-card>
										<v-toolbar dense flat color="blue">
											<span class="title font-weight-light">Create New User</span>
											<v-btn absolute right icon @click="close"><v-icon>mdi-close</v-icon></v-btn>
										</v-toolbar>
										<v-form ref="form" class="px-2">
											<v-card-text>
												<v-row>
													<v-col cols="12">
														<v-text-field class="mb-n4" color="blue" label="NIP / NIM" v-model="user.nomor" :rules="rules.nomor"/>
													</v-col>
													<v-col cols="12">
														<v-text-field class="mb-n4" color="blue" label="Nama" v-model="user.nama" :rules="rules.nama"/>
													</v-col>
													<v-col cols="12">
														<v-select
															:items="listRole"
															v-model="user.role"
															label="Status"
															class="mb-n2"
															item-text="value"
															item-value="id"
														>
														</v-select>
													</v-col>
													<v-col cols="12">
														<v-autocomplete
															v-if="user.role == 0"
															v-model="user.id_dosen_pembimbing"
															:items="listDosen"
															label="Dosen Pembimbing"
															chips
															dense
															:clearable="true"
                                                    		:auto-select-first="true"
															color="blue"
															item-color="blue"
															sug
															:search-input.sync="dosenPembimbingInput"
															@change="dosenPembimbingInput=''"
															item-text="nama"
															item-value="id"
															:readonly="user.id_dosen_pembimbing != null"
															@click:clear="user.id_dosen_pembimbing = null"
															class="mb-n2"
														>
														<template v-slot:selection="data">
															<v-chip color="transparent" class="pa-0">
																{{data.item.nama}}
															</v-chip>
														</template>
														</v-autocomplete>
													</v-col>
													<v-col cols="12">
														<v-autocomplete
															v-if="user.role == 0"
															v-model="dosen_penguji_satu"
															:items="listDosen"
															label="Ketua Dosen Penguji"
															chips
															dense
															:clearable="true"
                                                    		:auto-select-first="true"
															color="blue"
															item-color="blue"
															sug
															:search-input.sync="ketuaDosenPengujiInput"
															@change="ketuaDosenPengujiInput=''"
															item-text="nama"
															item-value="id"
															:readonly="dosen_penguji_satu != null"
															@click:clear="dosen_penguji_satu = null"
															class="mb-n2"
														>
														<template v-slot:selection="data">
															<v-chip color="transparent" class="pa-0">
																{{data.item.nama}}
															</v-chip>
														</template>
														</v-autocomplete>
													</v-col>
													<v-col cols="12">
														<v-autocomplete
															v-if="user.role == 0"
															v-model="dosen_penguji_dua"
															:items="listDosen"
															label="Dosen Penguji 1"
															chips
															dense
															:clearable="true"
                                                    		:auto-select-first="true"
															color="blue"
															item-color="blue"
															sug
															:search-input.sync="dosenPengujiInput"
															@change="dosenPengujiInput=''"
															item-text="nama"
															item-value="id"
															:readonly="dosen_penguji_dua != null"
															@click:clear="dosen_penguji_dua = null"
															class="mb-n2"
														>
														<template v-slot:selection="data">
															<v-chip color="transparent" class="pa-0">
																{{data.item.nama}}
															</v-chip>
														</template>
														</v-autocomplete>
													</v-col>
												</v-row>
											</v-card-text>
										</v-form>
										<v-card-actions>
											<v-container>
												<v-row justify="center">
													<v-btn class="mt-n8" color="red darken-1" text @click="close">Cancel</v-btn>
													<v-btn class="mt-n8" color="green white--text" @click="createNewUser">Create</v-btn>
												</v-row>
											</v-container>
										</v-card-actions>
									</v-card>
								</v-dialog>
								<v-col cols="12" sm="12" md="3">
                                    <v-card @click="" class="elevation-12 align-center" color="blue" min-height="230" max-height="230">
                                        <div class="d-flex flex-no-wrap justify-space-between">
											<div>
												<v-card-title class="font-weight-light">MAHASISWA & DOSEN</v-card-title>
											</div>
											<div>
												<v-card-title class="font-weight-light"><v-icon>mdi-format-list-numbered</v-icon></v-card-title>
											</div>
										</div>
										<v-card-title class="justify-center"><v-icon class="display-4">mdi-account-group-outline</v-icon></v-card-title>
                                    </v-card>
                                </v-col>
								<v-col cols="12" sm="12" md="3">
                                    <v-card @click="" class="elevation-12 align-center" color="blue" min-height="230" max-height="230">
                                        <div class="d-flex flex-no-wrap justify-space-between">
											<div>
												<v-card-title class="font-weight-light">BUAT BERITA ACARA</v-card-title>
											</div>
											<div>
												<v-card-title class="font-weight-light"><v-icon>mdi-note-multiple-outline</v-icon></v-card-title>
											</div>
										</div>
										<v-card-title class="justify-center"><v-icon class="display-4">mdi-note-plus-outline</v-icon></v-card-title>
                                    </v-card>
                                </v-col>
								<v-col cols="12" sm="12" md="3">
                                    <v-card @click="" class="elevation-12 align-center" color="blue" min-height="230" max-height="230">
                                        <div class="d-flex flex-no-wrap justify-space-between">
											<div>
												<v-card-title class="font-weight-light">LIST BERITA ACARA</v-card-title>
											</div>
											<div>
												<v-card-title class="font-weight-light"><v-icon>mdi-note-multiple-outline</v-icon></v-card-title>
											</div>
										</div>
										<v-card-title class="justify-center"><v-icon class="display-4">mdi-note-text</v-icon></v-card-title>
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

				mounted() {
					this.get()
				},

				data() {
					return {
						profileImage:'',
						createNewUserDialog: false,
						users: [],
						listDosen: [],
						user: {
							id:null,
							nomor:'',
							nama:'',
							role:'',
							id_dosen_pembimbing:null,
							dosen_penguji:[]
						},
						userDefault: {
							id:null,
							nomor:'',
							nama:'',
							role:'',
							id_dosen_pembimbing:null,
							dosen_penguji:[]
						},
						dosenPembimbingInput:'',
						ketuaDosenPengujiInput:'',
						dosenPengujiInput:'',
						dosen_penguji_satu:null,
						dosen_penguji_dua:null,
						listRole: [
							{id:0, value:'Mahasiswa'},
							{id:1, value:'Dosen Penguji'},
							{id:2, value:'Admin'}
						],
						rules: {
							nomor: [
								v => !!v || 'NIP / NIM Wajib diisi',
                                v => /^[0-9]*$/.test(v) || 'NIP / NIM Harus berupa angka'
							],
							nama: [
								v => !!v || 'Nama Wajib diisi',
							]
						},
						snackBar: false,
                        snackBarColor: '',
                        snackBarMessage: '',
					}
				},

				methods: {
                    logOut() {
                        window.location.href = '<?=base_url('home/logOut');?>'
                    },
					get() {
						return new Promise((resolve, reject) => {
							axios.get('<?= base_url()?>api/User')
								.then(response => {
									resolve(response.data)
								}) .catch(err => {
									if(err.response.status == 500) reject('Server Error')
								})
						})
						.then((response) => {
							this.users = response
						})
						.then(() => {
							return new Promise((resolve, reject) => {
								axios.get('<?= base_url()?>api/Dosen')
									.then(response => {
										resolve(response.data)
									}) .catch(err => {
										if(err.response.status == 500) reject('Server Error')
									})
							})
							.then((response) => {
								this.listDosen = response
							})
						})
					},
					createNewUserPopUp() {
						this.createNewUserDialog = true
					},
					createNewUser() {
						if(this.dosen_penguji_satu != null) {
							this.user.dosen_penguji.push(this.dosen_penguji_satu)
							this.user.dosen_penguji.push(this.dosen_penguji_dua)
						}
						return new Promise((resolve, reject) => {
							axios.post('<?= base_url()?>api/User',this.user)
								.then(response => {
									resolve(response.data)
								}) .catch(err => {
									if(err.response.status == 500) reject('Server Error')
									if(err.response.status == 401) reject(err.response.data)
								})
						})
						.then((response) => {
							this.snackBarMessage = response.message
							this.snackBarColor = 'success'
						}) .catch(err => {
							if(err.message == "NIM / NIP already exists.") {
								this.errorMessage = err.message
								this.snackBarColor = 'warning'
							} else {
								this.snackBarMessage = err
								this.snackBarColor = 'error'
								this.snackBar = true
							}
						}) .finally(() => {
							this.snackBar = true
							this.get()
							this.user = Object.assign({},this.userDefault)
							this.close()
						})
					},
					close() {
						if(this.createNewUserDialog) {
							this.createNewUserDialog = false
						}
					}
				},
				
				computed: {
					//view Breakpoint
                    popUpBreakPoint() {
                        if (this.$vuetify.breakpoint.name == 'xs') {
                            return true
                        } else {
                            return false
                        }
                    }
				},

			})
		</script>
	</body>

</html>
