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
                                    <v-card @click="createNewUserDialog = !createNewUserDialog" class="elevation-12 align-center" color="blue" min-height="230" max-height="230">
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
															v-model="user.id_ketua_penguji"
															:items="listDosen"
															label="Ketua Dosen Penguji"
															chips
															dense
															:clearable="true"
                                                    		:auto-select-first="true"
															color="blue"
															item-color="blue"
															:search-input.sync="ketuaDosenPengujiInput"
															@change="ketuaDosenPengujiInput=''"
															item-text="nama"
															item-value="id"
															:readonly="user.id_ketua_penguji != null"
															@click:clear="user.id_ketua_penguji = null"
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
															v-model="user.id_dosen_penguji"
															:items="listDosen"
															label="Dosen Penguji 1"
															chips
															dense
															:clearable="true"
                                                    		:auto-select-first="true"
															color="blue"
															item-color="blue"
															:search-input.sync="dosenPengujiInput"
															@change="dosenPengujiInput=''"
															item-text="nama"
															item-value="id"
															:readonly="user.id_dosen_penguji != null"
															@click:clear="user.id_dosen_penguji = null"
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
                                    <v-card @click="listMahasiswaDialog = !listMahasiswaDialog" class="elevation-12 align-center" color="blue" min-height="230" max-height="230">
                                        <div class="d-flex flex-no-wrap justify-space-between">
											<div>
												<v-card-title class="font-weight-light">LIST MAHASISWA</v-card-title>
											</div>
											<div>
												<v-card-title class="font-weight-light"><v-icon>mdi-format-list-numbered</v-icon></v-card-title>
											</div>
										</div>
										<v-card-title class="justify-center"><v-icon class="display-4">mdi-account-group-outline</v-icon></v-card-title>
                                    </v-card>
                                </v-col>
								<v-dialog v-model="listMahasiswaDialog" fullscreen hide-overlay transition="dialog-bottom-transition">
									<v-card>
										<v-toolbar dense flat color="blue">
											<span class="title font-weight-light">List Mahasiswa</span>
											<v-btn absolute right icon @click="close"><v-icon>mdi-close</v-icon></v-btn>
										</v-toolbar>
										<v-col cols="12">
											<v-text-field
												placeholder="Cari Mahasiswa"
												:solo='true'
												:clearable='true'
												append-icon="mdi-magnify"
												class="font-regular font-weight-light mt-2 mb-n4"
												v-model="searchMahasiswa"
											/>
										</v-col>
										<v-data-table
											:headers='mahasiswaHeader'
											:items='users'
											v-if="!popUpBreakPoint"
											item-key="nama"
											:search="searchMahasiswa"
										>
											<template class="pl-n4" v-slot:item.id_dosen_pembimbing="{ item }">
												<span>{{ revealDosenPembimbing(item.id_dosen_pembimbing) }}</span>
											</template>
											<template class="pl-n4" v-slot:item.id_ketua_penguji="{ item }">
												<span>{{ revealDosenPembimbing(item.id_ketua_penguji) }}</span>
											</template>
											<template class="pl-n4" v-slot:item.id_dosen_penguji="{ item }">
												<span>{{ revealDosenPembimbing(item.id_dosen_penguji) }}</span>
											</template>
										</v-data-table>
										<v-data-table
											:headers='mahasiswaHeader'
											:items='users'
											v-else
											item-key="nama"
											:search="searchMahasiswa"
											:disable-sort="true"
											class="mt-n10"
										>
											<template v-slot:item="{ item }">
												<v-card class="mt-1 mb-3 mx-2 pa-2" outlined>
													<div class="d-flex flex-no-wrap justify-space-between align-center">
														<div>
															<v-card-title class="body-2 mt-n2">{{ item.nama }}</v-card-title>
														</div>
														<div class="mt-n2 mr-n2">
															<v-menu
																:close-on-click="true"
																:close-on-content-click="true"
																:offset-y="true"
															>
																<template v-slot:activator="{ on }">
																	<v-card-actions><v-icon v-on="on">mdi-dots-vertical</v-icon></v-card-actions>
																</template>
																<v-list>
																	<v-list-item @click.stop="">
																		<v-list-item-title>Edit</v-list-item-title>
																	</v-list-item>
																	<v-list-item @click.stop="">
																		<v-list-item-title>Hapus</v-list-item-title>
																	</v-list-item>
																</v-list>
															</v-menu>
														</div>
													</div>
													<v-divider></v-divider>
													<v-list-item two-line>
														<v-list-item-content>
															<v-list-item-title>Dosen Pembimbing</v-list-item-title>
															<v-list-item-subtitle>{{ revealDosenPembimbing(item.id_dosen_pembimbing) }}</v-list-item-subtitle>
														</v-list-item-content>
													</v-list-item>
													<v-list-item two-line class="mt-n2">
														<v-list-item-content>
															<v-list-item-title>Ketua Dosen Penguji</v-list-item-title>
															<v-list-item-subtitle>{{ revealKetuaPenguji(item.id_ketua_penguji) }}</v-list-item-subtitle>
														</v-list-item-content>
													</v-list-item>
													<v-list-item two-line class="mt-n2">
														<v-list-item-content>
															<v-list-item-title>Dosen Penguji 1</v-list-item-title>
															<v-list-item-subtitle>{{ revealDosenPenguji(item.id_dosen_penguji) }}</v-list-item-subtitle>
														</v-list-item-content>
													</v-list-item>
												</v-card>
											</template>
										</v-data-table>
									</v-card>
								</v-dialog>
								<v-col cols="12" sm="12" md="3">
                                    <v-card @click="listDosenDialog = !listDosenDialog" class="elevation-12 align-center" color="blue" min-height="230" max-height="230">
                                        <div class="d-flex flex-no-wrap justify-space-between">
											<div>
												<v-card-title class="font-weight-light">LIST DOSEN</v-card-title>
											</div>
											<div>
												<v-card-title class="font-weight-light"><v-icon>mdi-format-list-numbered</v-icon></v-card-title>
											</div>
										</div>
										<v-card-title class="justify-center"><v-icon class="display-4">mdi-teach</v-icon></v-card-title>
                                    </v-card>
                                </v-col>
								<v-dialog v-model="listDosenDialog" fullscreen hide-overlay transition="dialog-bottom-transition">
									<v-card>
										<v-toolbar dense flat color="blue">
											<span class="title font-weight-light">List Dosen</span>
											<v-btn absolute right icon @click="close"><v-icon>mdi-close</v-icon></v-btn>
										</v-toolbar>
										<v-col cols="12">
											<v-text-field
												placeholder="Cari Dosen"
												:solo='true'
												:clearable='true'
												append-icon="mdi-magnify"
												class="font-regular font-weight-light mt-2 mb-n4"
												v-model="searchDosen"
											/>
										</v-col>
										<v-data-table
											:headers='dosenHeader'
											:items='users'
											:mobile-breakpoint="1"
											:search="searchDosen"
										></v-data-table>
									</v-card>
								</v-dialog>
								<v-col cols="12" sm="12" md="3">
                                    <v-card @click="createBeritaAcaraDialog = !createBeritaAcaraDialog" class="elevation-12 align-center" color="blue" min-height="230" max-height="230">
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
								<v-dialog v-model="createBeritaAcaraDialog" persistent max-width="700px">
									<v-card>
										<v-toolbar dense flat color="blue">
											<span class="title font-weight-light">Buat Berita Acara</span>
											<v-btn absolute right icon @click="close"><v-icon>mdi-close</v-icon></v-btn>
										</v-toolbar>
										<v-form ref="form" class="px-2">
											<v-card-text>
												<v-row>
													<v-col cols="12">
														<v-autocomplete
															v-model="beritaAcara.id_mahasiswa"
															:items="listMahasiswa"
															label="NIM"
															chips
															dense
															:solo="true"
															:clearable="true"
                                                    		:auto-select-first="true"
															color="blue"
															item-color="blue"
															:search-input.sync="mahasiswaInput"
															@change="mahasiswaInput=''"
															item-text="nomor"
															item-value="id"
															:readonly="beritaAcara.id_mahasiswa != null"
															@click:clear="beritaAcara.id_mahasiswa = null"
															class="mb-n4"
														>
														<template v-slot:selection="data">
															<v-chip color="transparent" class="pa-0">
																{{data.item.nomor}}
															</v-chip>
														</template>
														</v-autocomplete>
													</v-col>
													<v-col cols="12">
													<v-menu
														ref="showDatePicker"
														v-model="showDatePicker"
														:close-on-content-click="false"
														transition="scale-transition"
														offset-y
														min-width="290px"
													>
														<template v-slot:activator="{ on }">
															<v-text-field
															color="accent"
															label="Tanggal"
															append-icon="mdi-calendar"
															:value="formatDate"
															readonly
															v-on="on"
															:solo="true"
															:clearable="true"
															@click:clear="beritaAcara.tanggal = null"
															dense
															class="mb-n4"
															></v-text-field>
														</template>
														<v-date-picker v-model="beritaAcara.tanggal"  no-title scrollable :weekday-format="dayFormat" @change="showDatePicker = false">
														</v-date-picker>
													</v-menu>
													</v-col>
													<v-col cols="12">
														<v-dialog
															ref="dialog"
															v-model="showTimePicker"
															:return-value.sync="beritaAcara.time"
															persistent
															width="290px"
															style="z-index:9999"
														>
															<template v-slot:activator="{ on }">
																<v-text-field
																:solo="true"
																dense
																v-model="beritaAcara.time"
																label="Waktu"
																append-icon="mdi-clock-outline"
																readonly
																v-on="on"
																:clearable="true"
																@click:clear="beritaAcara.time = ''"
																></v-text-field>
															</template>
															<v-time-picker
																v-if="showTimePicker"
																v-model="beritaAcara.time"
																full-width
															>
															<v-spacer></v-spacer>
																<v-btn text color="primary" @click="showTimePicker = false">Cancel</v-btn>
																<v-btn text color="primary" @click="$refs.dialog.save(beritaAcara.time)">OK</v-btn>
															</v-time-picker>
														</dialog>
													</v-col>
												</v-row>
											</v-card-text>
										</v-form>
										<v-card-actions>
											<v-container>
												<v-row justify="center">
													<v-btn class="mt-n8" color="red darken-1" text @click="close">Cancel</v-btn>
													<v-btn class="mt-n8" color="green white--text" @click="createNewBeritaAcara">Create</v-btn>
												</v-row>
											</v-container>
										</v-card-actions>
									</v-card>
								</v-dialog>
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
						listMahasiswaDialog: false,
						listDosenDialog: false,
						createBeritaAcaraDialog: false,
						showDatePicker: false,
						showTimePicker: false,
						users: [],
						listDosen: [],
						listMahasiswa: [],
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
							id_ketua_penguji:null,
							id_dosen_penguji:null
						},
						beritaAcara: {
							tanggal:'',
							time:'',
							id_mahasiswa:null
						},
						beritaAcaraDefault: {
							tanggal:'',
							time:'',
							id_mahasiswa:null
						},
						dosenPembimbingInput:'',
						searchMahasiswa:'',
						searchDosen:'',
						ketuaDosenPengujiInput:'',
						dosenPengujiInput:'',
						mahasiswaInput:'',
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
							response.forEach(user => {
								if(user.role == 0) {
									this.listMahasiswa.push(user)
								} else {
									if(user.role == 1) {
										this.listDosen.push(user)
									}
								}
							})
						})
					},
					createNewUser() {
						return new Promise((resolve, reject) => {
							axios.post('<?= base_url()?>api/User',this.user)
								.then(response => {
									resolve(response.data)
								}) .catch(err => {
									if(err.response.status == 500) reject(err.response.data)
									if(err.response.status == 401) reject(err.response.data)
								})
						})
						.then((response) => {
							this.snackBarMessage = response.message
							this.snackBarColor = 'success'
						}) .catch(err => {
							if(err.message == "NIM / NIP already exists.") {
								this.snackBarMessage = err.message
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
					createNewBeritaAcara() {
						return new Promise((resolve, reject) => {
							axios.post('<?= base_url()?>api/Berita_Acara',this.beritaAcara)
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
							this.snackBarMessage = err
							this.snackBarColor = 'error'
							this.snackBar = true
						}) .finally(() => {
							this.snackBar = true
							this.get()
							this.beritaAcara = Object.assign({},this.beritaAcaraDefault)
							this.close()
						})
					},
					close() {
						if(this.createNewUserDialog) {
							this.createNewUserDialog = false
							this.user = Object.assign({},this.userDefault)
						} else {
							if(this.listMahasiswaDialog) {
								this.listMahasiswaDialog = false
								this.searchMahasiswa = ''
							} else {
								if(this.listDosenDialog) {
									this.listDosenDialog = false
									this.searchDosen = ''
								} else {
									if(this.createBeritaAcaraDialog) {
										this.createBeritaAcaraDialog = false
										this.beritaAcara = Object.assign({},this.beritaAcaraDefault)
									}
								}
							}
						}
					},
					revealDosenPembimbing(id) {
						return _.find(this.users,['id',id]).nama
					},
					revealKetuaPenguji(id) {
						return _.find(this.users,['id',id]).nama
					},
					revealDosenPenguji(id) {
						return _.find(this.users,['id',id]).nama
					},
					dayFormat(date) {
						let i = new Date(date).getDay(date)
						var dayOftheWeek = ['Mo', 'Tu', 'We', 'Th', 'Fr', 'Sa', 'Su']
						return dayOftheWeek[i]
					},
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
					mahasiswaHeader() {
						return [
							{text:'Nama', value:'nama'},
							{value:'role', align: ' d-none', filter: value => {return value == 0}},
							{text:'Dosen Pembimbing', value:'id_dosen_pembimbing', filter: () => true},
							{text:'Ketua Dosen Penguji', value:'id_ketua_penguji', filter: () => true},
							{text:'Dosen Penguji 1', value:'id_dosen_penguji', filter: () => true}
						]
					},
					dosenHeader() {
						return [
							{text:'Nama', value:'nama'},
							{value:'role', align: ' d-none', filter: value => {return value == 1}},
						]
					},
					formatDate() {
						return this.beritaAcara.tanggal ? moment(this.beritaAcara.tanggal).format('DD MMMM YYYY') : ''
					},
				},

				watch: {
					createNewUserDialog() {
						this.$refs.form.resetValidation()
					},
				}

			})
		</script>
	</body>

</html>
